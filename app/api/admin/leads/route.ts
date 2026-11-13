import { timingSafeEqual } from "node:crypto";
import { NextResponse } from "next/server";
import { readLeads } from "@/lib/leads";

export const runtime = "nodejs";
export const dynamic = "force-dynamic";

function safeEqual(a: string, b: string) {
  const x = Buffer.from(a);
  const y = Buffer.from(b);
  return x.length === y.length && timingSafeEqual(x, y);
}

function authorized(req: Request): boolean {
  const user = process.env.ADMIN_USER;
  const pass = process.env.ADMIN_PASSWORD;
  if (!user || !pass) return false;
  const header = req.headers.get("authorization") || "";
  if (!header.startsWith("Basic ")) return false;
  const [u, ...rest] = Buffer.from(header.slice(6), "base64").toString("utf8").split(":");
  return safeEqual(u ?? "", user) && safeEqual(rest.join(":"), pass);
}

function csvCell(value: unknown): string {
  let s = value == null ? "" : String(value);
  // Evita injeção de fórmulas ao abrir no Excel/Planilhas.
  if (/^[=+\-@\t\r]/.test(s)) s = "'" + s;
  return `"${s.replace(/"/g, '""')}"`;
}

/** Exportação CSV dos leads gravados em arquivo. Protegida por HTTP Basic. */
export async function GET(req: Request) {
  if (!process.env.ADMIN_USER || !process.env.ADMIN_PASSWORD) {
    return new NextResponse("Not found", { status: 404 });
  }
  if (!authorized(req)) {
    return new NextResponse("Autenticação necessária.", {
      status: 401,
      headers: { "WWW-Authenticate": 'Basic realm="Leads ARS", charset="UTF-8"' },
    });
  }

  const leads = await readLeads();
  const header = ["data", "origem", "nome", "whatsapp", "email", "empresa", "mensagem", "consentimento"];
  const rows = leads.map((l) =>
    [l.criadoEm, l.origem, l.nome, l.whatsapp, l.email, l.empresa, l.mensagem, l.consentimento?.em]
      .map(csvCell)
      .join(";"),
  );
  const csv = "﻿" + [header.join(";"), ...rows].join("\r\n");
  return new NextResponse(csv, {
    headers: {
      "Content-Type": "text/csv; charset=utf-8",
      "Content-Disposition": `attachment; filename="leads-ars-${new Date().toISOString().slice(0, 10)}.csv"`,
      "Cache-Control": "no-store",
      "X-Robots-Tag": "noindex",
    },
  });
}
