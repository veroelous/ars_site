import "server-only";
import { NextResponse } from "next/server";

export async function readBody(req: Request): Promise<Record<string, unknown> | null> {
  const type = req.headers.get("content-type") || "";
  try {
    if (type.includes("application/json")) {
      const body = await req.json();
      return body && typeof body === "object" ? (body as Record<string, unknown>) : null;
    }
    const form = await req.formData();
    return Object.fromEntries(form.entries());
  } catch {
    return null;
  }
}

/** Aceita apenas envios do próprio site (proteção básica contra CSRF). */
export function sameOrigin(req: Request): boolean {
  const origin = req.headers.get("origin");
  if (!origin) return true;
  const host = req.headers.get("x-forwarded-host") || req.headers.get("host");
  try {
    return new URL(origin).host === host;
  } catch {
    return false;
  }
}

export function jsonError(message: string, status: number, errors?: Record<string, string | undefined>) {
  return NextResponse.json({ ok: false, message, errors }, { status });
}
