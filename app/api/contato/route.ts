import { NextResponse } from "next/server";
import { validateContactLead } from "@/lib/validation";
import { storeLead } from "@/lib/leads";
import { clientIp, rateLimit } from "@/lib/rate-limit";
import { jsonError, readBody, sameOrigin } from "@/lib/api";
import { CONSENT_TEXT } from "@/lib/consent";

export const runtime = "nodejs";

export async function POST(req: Request) {
  if (!sameOrigin(req)) return jsonError("Origem não permitida.", 403);
  if (!rateLimit(`contato:${clientIp(req.headers)}`, 5)) {
    return jsonError("Muitas tentativas. Aguarde alguns minutos e tente novamente.", 429);
  }

  const body = await readBody(req);
  if (!body) return jsonError("Requisição inválida.", 400);
  if (typeof body.site === "string" && body.site.trim() !== "") return NextResponse.json({ ok: true });

  const result = validateContactLead(body);
  if (!result.ok || !result.data) return jsonError("Confira os campos destacados.", 422, result.errors);

  try {
    await storeLead({
      origem: "contato",
      nome: result.data.nome,
      whatsapp: result.data.whatsapp,
      email: result.data.email,
      empresa: result.data.empresa || undefined,
      mensagem: result.data.mensagem,
      consentimentoTexto: CONSENT_TEXT,
      pagina: "/contato-e-orcamento/",
    });
    return NextResponse.json({ ok: true });
  } catch (err) {
    console.error("[contato] falha ao registrar lead", err);
    return jsonError("Não foi possível enviar agora. Tente novamente ou use o e-mail comercial.", 500);
  }
}
