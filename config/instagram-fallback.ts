/**
 * Publicações exibidas quando a integração com a API do Instagram não está configurada
 * (INSTAGRAM_ACCESS_TOKEN ausente) ou falha temporariamente.
 *
 * São as três publicações que o feed do WordPress mostrava na captura de 13/11/2026.
 * Exibidas via embed oficial do Instagram, sem copiar imagens de CDN (que expiram).
 * Atualize esta lista se a integração dinâmica não for ativada.
 */
export const instagramFallbackPosts = [
  {
    permalink: "https://www.instagram.com/reel/DfpAN-NmgTn/",
    caption: "Precisando de perfis de LED? Na ARS tem pronta entrega!",
  },
  {
    permalink: "https://www.instagram.com/reel/DfmkQ0njdiJ/",
    caption: "Perfil de LED a pronta entrega, direto de quem fabrica.",
  },
  {
    permalink: "https://www.instagram.com/reel/Dfj3nkLiGKP/",
    caption: "Qualidade de alto padrão com um preço que surpreende!",
  },
] as const;
