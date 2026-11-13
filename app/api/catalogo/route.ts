import { NextResponse } from "next/server";
import { validateCatalogLead } from "@/lib/validation";
import { storeLead } from "@/lib/leads";
import { createCatalogToken } from "@/lib/catalog-token";
import { clientIp, rateLimit } from "@/lib/rate-limit";
import { jsonError, readBody, sameOrigin } from "@/lib/api";
import { CONSENT_TEXT } from "@/lib/consent";

export const runtime = "nodejs";

export async function POST(req: Request) {
  if (!sameOrigin(req)) return jsonError("Origem não permitida.", 403);
  if (!rateLimit(`catalogo:${clientIp(req.headers)}`, 8)) {
    return jsonError("Muitas tentativas. Aguarde alguns minutos e tente novamente.", 429);
  }

  const body = await readBody(req);
  if (!body) return jsonError("Requisição inválida.", 400);

  // Honeypot: campo invisível para pessoas; robôs costumam preenchê-lo.
  if (typeof body.site === "string" && body.site.trim() !== "") {
    return NextResponse.json({ ok: true, downloadUrl: null });
  }

  const result = validateCatalogLead(body);
  if (!result.ok || !result.data) return jsonError("Confira os campos destacados.", 422, result.errors);

  try {
    const lead = await storeLead({
      origem: "catalogo",
      nome: result.data.nome,
      whatsapp: result.data.whatsapp,
      email: result.data.email,
      consentimentoTexto: CONSENT_TEXT,
      pagina: "/",
    });
    const token = createCatalogToken(lead.id);
    return NextResponse.json({
      ok: true,
      downloadUrl: `/api/catalogo/download/?token=${encodeURIComponent(token)}`,
    });
  } catch (err) {
    console.error("[catalogo] falha ao registrar lead", err);
    return jsonError("Não foi possível enviar agora. Tente novamente.", 500);
  }
}
