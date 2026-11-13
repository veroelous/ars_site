import Image from "next/image";
import { site } from "@/config/site";
import { instagramFallbackPosts } from "@/config/instagram-fallback";
import { getLatestInstagramPosts } from "@/lib/instagram";
import { ArrowUpRightIcon, InstagramIcon } from "./Icons";

function excerpt(text: string, max = 140) {
  const line = text.replace(/\s+/g, " ").trim();
  return line.length > max ? line.slice(0, max).trimEnd() + "…" : line;
}

export default async function InstagramSection() {
  const posts = await getLatestInstagramPosts(3);

  return (
    <section className="instagram" aria-labelledby="instagram-title">
      <div className="wrap">
        <div className="instagram__head">
          <div>
            <div className="section-tag">
              <InstagramIcon /> Últimas publicações
            </div>
            <h2 className="display" id="instagram-title">
              Trabalho que transforma <em>propósito em realidade.</em>
            </h2>
            <p className="instagram__copy">
              Cada projeto carrega responsabilidade. Cada entrega, compromisso. Acompanhe os bastidores da
              fábrica, os lançamentos e a presença da ARS na Expolux.
            </p>
          </div>
          <div className="instagram__brand">
            <Image
              src="/images/ars-logo-colorido-transparente.png"
              alt="ARS Iluminação"
              width={1278}
              height={589}
              sizes="240px"
            />
            <a className="btn btn--orange" href={site.instagram.url} target="_blank" rel="noreferrer">
              <InstagramIcon /> Seguir {site.instagram.handle} <ArrowUpRightIcon />
            </a>
          </div>
        </div>

        <div className="instagram__posts">
          {posts
            ? posts.map((post) => (
                <a
                  key={post.id}
                  className="ig-card"
                  href={post.permalink}
                  target="_blank"
                  rel="noreferrer"
                >
                  <div className="ig-card__media">
                    {/* Imagem servida pelo CDN do Instagram; URL renovada a cada revalidação. */}
                    {/* eslint-disable-next-line @next/next/no-img-element */}
                    <img src={post.imageUrl} alt="" loading="lazy" decoding="async" />
                    {post.mediaType === "VIDEO" ? <span className="ig-card__badge">Reels</span> : null}
                  </div>
                  <p className="ig-card__caption">{excerpt(post.caption) || "Ver publicação no Instagram"}</p>
                  <span className="ig-card__more">
                    Ver no Instagram <ArrowUpRightIcon />
                  </span>
                </a>
              ))
            : instagramFallbackPosts.map((post) => (
                <div key={post.permalink} className="ig-embed">
                  <iframe
                    src={`${post.permalink}embed/`}
                    title={`Publicação do Instagram: ${post.caption}`}
                    loading="lazy"
                    allow="encrypted-media"
                    referrerPolicy="strict-origin-when-cross-origin"
                  />
                  <a className="ig-embed__link" href={post.permalink} target="_blank" rel="noreferrer">
                    <span>{post.caption}</span>
                    <span className="ig-card__more">
                      Ver no Instagram <ArrowUpRightIcon />
                    </span>
                  </a>
                </div>
              ))}
        </div>
      </div>
    </section>
  );
}
