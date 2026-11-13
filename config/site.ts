/**
 * Dados institucionais da ARS Iluminação.
 *
 * Fonte: HTML público de https://oficial.arsiluminacao.com.br/ capturado em 13/11/2026
 * (ver docs/referencia/). Antes de trocar o domínio, confirmar com o responsável da ARS
 * os itens marcados como "validar" — ver docs/PENDENCIAS.md.
 */
export const site = {
  name: "ARS Iluminação",
  tagline: "Ir além de iluminar espaços.",
  description:
    "ARS Iluminação: fabricante de soluções de iluminação em Socorro/SP, com entrega para todo o Brasil. Baixe o catálogo e fale com a equipe comercial.",

  /** Aprovado para manutenção pelo responsável (LEIA-ME do handoff). */
  email: "comercial@arsiluminacao.com.br",

  instagram: {
    handle: "@ars.iluminacao",
    url: "https://www.instagram.com/ars.iluminacao/",
  },

  /** validar: número do link wa.me publicado na Home atual. */
  whatsapp: {
    number: "5519996965662",
    message: "Olá! Vim pelo site da ARS Iluminação e gostaria de mais informações.",
  },

  /** validar: endereço publicado no rodapé atual. */
  address: {
    street: "Estrada de Joaquim de Souza Siqueira, 2099",
    detail: "Oratório · Socorro/SP · CEP 13960-000",
    mapsUrl:
      "https://www.google.com/maps/search/?api=1&query=Estrada+Joaquim+de+Souza+Siqueira%2C+2099%2C+Orat%C3%B3rio%2C+Socorro%2C+SP%2C+13960-000",
  },

  catalog: {
    label: "Catálogo ARS 2026",
    fileName: "catalogo-ars-iluminacao.pdf",
  },

  footerNote: "Fabricado em Socorro/SP · Entregue para todo o Brasil",
} as const;

export const whatsappUrl = `https://wa.me/${site.whatsapp.number}?text=${encodeURIComponent(
  site.whatsapp.message,
)}`;

export const navigation = [
  { href: "/", label: "Início" },
  { href: "/a-ars/", label: "A ARS" },
  { href: "/produtos/", label: "Produtos" },
  { href: "/categorias-de-luminarias/", label: "Categorias" },
  { href: "/contato-e-orcamento/", label: "Contato e orçamento" },
] as const;
