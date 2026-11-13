import type { MetadataRoute } from "next";
import { navigation } from "@/config/site";

export default function sitemap(): MetadataRoute.Sitemap {
  const base = process.env.SITE_URL || "http://localhost:3000";
  return navigation.map((item) => ({
    url: `${base}${item.href}`,
    changeFrequency: "monthly",
    priority: item.href === "/" ? 1 : 0.7,
  }));
}
