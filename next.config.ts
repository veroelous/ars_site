import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  // O catálogo PDF fica em /private e é lido em tempo de execução pela rota de download.
  outputFileTracingIncludes: {
    "/api/catalogo/download": ["./private/**/*"],
  },
  // Mantém o padrão de URLs do WordPress atual (/a-ars/, /produtos/ ...).
  trailingSlash: true,
  poweredByHeader: false,
  async headers() {
    return [
      {
        source: "/(.*)",
        headers: [
          { key: "X-Content-Type-Options", value: "nosniff" },
          { key: "Referrer-Policy", value: "strict-origin-when-cross-origin" },
          { key: "X-Frame-Options", value: "SAMEORIGIN" },
          { key: "Permissions-Policy", value: "camera=(), microphone=(), geolocation=()" },
        ],
      },
    ];
  },
};

export default nextConfig;
