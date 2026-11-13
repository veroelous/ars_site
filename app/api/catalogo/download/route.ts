import { createReadStream } from "node:fs";
import { stat } from "node:fs/promises";
import path from "node:path";
import { Readable } from "node:stream";
import { NextResponse } from "next/server";
import { verifyCatalogToken } from "@/lib/catalog-token";
import { site } from "@/config/site";

export const runtime = "nodejs";
export const dynamic = "force-dynamic";

export async function GET(req: Request) {
  const token = new URL(req.url).searchParams.get("token");
  if (!verifyCatalogToken(token)) {
    // Link ausente, adulterado ou expirado: volta ao formulário.
    return NextResponse.redirect(new URL("/?catalogo=expirado#catalogo", req.url), 303);
  }

  const file = path.join(process.cwd(), "private", site.catalog.fileName);
  try {
    const info = await stat(file);
    const stream = Readable.toWeb(createReadStream(file)) as ReadableStream;
    return new Response(stream, {
      headers: {
        "Content-Type": "application/pdf",
        "Content-Length": String(info.size),
        "Content-Disposition": `attachment; filename="${site.catalog.fileName}"`,
        "Cache-Control": "private, no-store",
        "X-Robots-Tag": "noindex",
      },
    });
  } catch (err) {
    console.error("[catalogo] arquivo não encontrado", err);
    return new NextResponse("Catálogo indisponível no momento.", { status: 500 });
  }
}
