import "server-only";

export interface InstagramPost {
  id: string;
  permalink: string;
  caption: string;
  mediaType: "IMAGE" | "VIDEO" | "CAROUSEL_ALBUM";
  imageUrl: string;
  timestamp: string;
}

interface GraphMedia {
  id: string;
  caption?: string;
  media_type: InstagramPost["mediaType"];
  media_url?: string;
  thumbnail_url?: string;
  permalink: string;
  timestamp: string;
}

/**
 * Busca as publicações mais recentes pela Instagram API (Instagram Login).
 * Retorna null quando não configurado ou em caso de erro — o componente usa o fallback.
 */
export async function getLatestInstagramPosts(limit = 3): Promise<InstagramPost[] | null> {
  const token = process.env.INSTAGRAM_ACCESS_TOKEN;
  if (!token) return null;

  const revalidate = Number(process.env.INSTAGRAM_REVALIDATE_SECONDS) || 3600;
  const url = new URL("https://graph.instagram.com/me/media");
  url.searchParams.set("fields", "id,caption,media_type,media_url,thumbnail_url,permalink,timestamp");
  url.searchParams.set("limit", String(limit));
  url.searchParams.set("access_token", token);

  try {
    const res = await fetch(url, {
      next: { revalidate, tags: ["instagram"] },
      signal: AbortSignal.timeout(8000),
    });
    if (!res.ok) {
      console.error(`[instagram] API respondeu ${res.status}`);
      return null;
    }
    const json = (await res.json()) as { data?: GraphMedia[] };
    const posts = (json.data ?? [])
      .map((m) => ({
        id: m.id,
        permalink: m.permalink,
        caption: m.caption ?? "",
        mediaType: m.media_type,
        imageUrl: (m.media_type === "VIDEO" ? m.thumbnail_url : m.media_url) ?? "",
        timestamp: m.timestamp,
      }))
      .filter((p) => p.imageUrl)
      .slice(0, limit);
    return posts.length ? posts : null;
  } catch (err) {
    console.error("[instagram] falha ao buscar feed", err);
    return null;
  }
}
