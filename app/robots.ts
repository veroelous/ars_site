import type { MetadataRoute } from "next";
import { noIndex } from "@/lib/indexing";

export const dynamic = "force-dynamic";

export default function robots(): MetadataRoute.Robots {
  const base = process.env.SITE_URL || "http://localhost:3000";
  if (noIndex) return { rules: [{ userAgent: "*", disallow: "/" }] };
  return {
    rules: [{ userAgent: "*", allow: "/", disallow: ["/api/"] }],
    sitemap: `${base}/sitemap.xml`,
  };
}
