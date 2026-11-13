import "server-only";
import { createHmac, randomBytes, timingSafeEqual } from "node:crypto";

/** Validade do link de download liberado após o cadastro. */
const TTL_SECONDS = 30 * 60;

let devSecret: string | null = null;

function secret(): string {
  const s = process.env.CATALOG_TOKEN_SECRET;
  if (s && s.length >= 16) return s;
  if (process.env.NODE_ENV === "production") {
    throw new Error("CATALOG_TOKEN_SECRET ausente ou curto demais (mínimo 16 caracteres).");
  }
  // Desenvolvimento: segredo aleatório por processo.
  devSecret ??= randomBytes(32).toString("hex");
  return devSecret;
}

function sign(payload: string): string {
  return createHmac("sha256", secret()).update(payload).digest("base64url");
}

export function createCatalogToken(leadId: string): string {
  const exp = Math.floor(Date.now() / 1000) + TTL_SECONDS;
  const payload = Buffer.from(JSON.stringify({ l: leadId, e: exp })).toString("base64url");
  return `${payload}.${sign(payload)}`;
}

export function verifyCatalogToken(token: string | null | undefined): boolean {
  if (!token || token.length > 512) return false;
  const [payload, signature] = token.split(".");
  if (!payload || !signature) return false;
  const expected = Buffer.from(sign(payload));
  const given = Buffer.from(signature);
  if (expected.length !== given.length || !timingSafeEqual(expected, given)) return false;
  try {
    const { e } = JSON.parse(Buffer.from(payload, "base64url").toString("utf8")) as { e: number };
    return typeof e === "number" && e > Math.floor(Date.now() / 1000);
  } catch {
    return false;
  }
}
