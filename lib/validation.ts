/** Validação compartilhada entre navegador e servidor. */

export type FieldErrors = Partial<Record<string, string>>;

export const LIMITS = {
  name: 120,
  company: 120,
  email: 160,
  message: 3000,
} as const;

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

export function onlyDigits(value: string): string {
  return value.replace(/\D+/g, "");
}

/** Aceita celular/fixo brasileiro com DDD, com ou sem +55. */
export function normalizeWhatsapp(value: string): string | null {
  let digits = onlyDigits(value);
  if (digits.length >= 12 && digits.startsWith("55")) digits = digits.slice(2);
  if (digits.length !== 10 && digits.length !== 11) return null;
  const ddd = Number(digits.slice(0, 2));
  if (ddd < 11 || ddd > 99) return null;
  if (digits.length === 11 && digits[2] !== "9") return null;
  return digits;
}

/** Máscara de digitação: (00) 00000-0000 */
export function maskWhatsapp(value: string): string {
  const d = onlyDigits(value).slice(0, 11);
  if (d.length <= 2) return d.length ? `(${d}` : "";
  if (d.length <= 6) return `(${d.slice(0, 2)}) ${d.slice(2)}`;
  if (d.length <= 10) return `(${d.slice(0, 2)}) ${d.slice(2, 6)}-${d.slice(6)}`;
  return `(${d.slice(0, 2)}) ${d.slice(2, 7)}-${d.slice(7)}`;
}

export function formatWhatsapp(digits: string): string {
  return maskWhatsapp(digits);
}

function clean(value: unknown, max: number): string {
  return typeof value === "string" ? value.replace(/\s+/g, " ").trim().slice(0, max) : "";
}

export interface CatalogLeadInput {
  nome: string;
  whatsapp: string;
  email: string;
  consentimento: boolean;
}

export interface ContactLeadInput extends CatalogLeadInput {
  empresa: string;
  mensagem: string;
}

export function validateCatalogLead(raw: Record<string, unknown>) {
  const errors: FieldErrors = {};
  const nome = clean(raw.nome, LIMITS.name);
  const email = clean(raw.email, LIMITS.email).toLowerCase();
  const whatsapp = normalizeWhatsapp(typeof raw.whatsapp === "string" ? raw.whatsapp : "");
  const consentimento = raw.consentimento === true || raw.consentimento === "on" || raw.consentimento === "true";

  if (nome.length < 2) errors.nome = "Informe seu nome.";
  if (!whatsapp) errors.whatsapp = "Informe um WhatsApp válido com DDD.";
  if (!EMAIL_RE.test(email)) errors.email = "Informe um e-mail válido.";
  if (!consentimento) errors.consentimento = "É preciso autorizar o contato para liberar o catálogo.";

  const ok = Object.keys(errors).length === 0;
  return {
    ok,
    errors,
    data: ok ? ({ nome, whatsapp: whatsapp!, email, consentimento } satisfies CatalogLeadInput) : null,
  };
}

export function validateContactLead(raw: Record<string, unknown>) {
  const base = validateCatalogLead(raw);
  const errors: FieldErrors = { ...base.errors };
  const empresa = clean(raw.empresa, LIMITS.company);
  const mensagem =
    typeof raw.mensagem === "string" ? raw.mensagem.trim().slice(0, LIMITS.message) : "";

  if (errors.consentimento) errors.consentimento = "É preciso autorizar o contato para enviar a mensagem.";
  if (mensagem.length < 5) errors.mensagem = "Conte brevemente o que você precisa.";

  const ok = Object.keys(errors).length === 0;
  return {
    ok,
    errors,
    data: ok ? ({ ...base.data!, empresa, mensagem } satisfies ContactLeadInput) : null,
  };
}
