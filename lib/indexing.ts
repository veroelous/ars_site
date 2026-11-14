/** SITE_NOINDEX=true bloqueia indexação (ambientes de teste como dev.arsiluminacao.com.br). */
export const noIndex = ["1", "true", "sim", "yes"].includes((process.env.SITE_NOINDEX || "").toLowerCase());
