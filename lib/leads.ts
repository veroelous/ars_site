import "server-only";
import { appendFile, mkdir, readFile } from "node:fs/promises";
import path from "node:path";
import { randomUUID } from "node:crypto";

export type LeadSource = "catalogo" | "contato";

export interface LeadRecord {
  id: string;
  criadoEm: string;
  origem: LeadSource;
  nome: string;
  whatsapp: string;
  email: string;
  empresa?: string;
  mensagem?: string;
  consentimento: {
    aceito: true;
    texto: string;
    em: string;
  };
  pagina?: string;
}

type Storage = "file" | "webhook" | "both";

function storageMode(): Storage {
  const v = (process.env.LEADS_STORAGE || "file").toLowerCase();
  return v === "webhook" || v === "both" ? v : "file";
}

function leadsFile(): string {
  const dir = process.env.LEADS_DIR || "./data";
  return path.resolve(process.cwd(), dir, "leads.jsonl");
}

async function saveToFile(lead: LeadRecord) {
  const file = leadsFile();
  await mkdir(path.dirname(file), { recursive: true, mode: 0o700 });
  // JSON Lines: um lead por linha. Permissão 600 — legível só pelo usuário do servidor.
  await appendFile(file, JSON.stringify(lead) + "\n", { encoding: "utf8", mode: 0o600 });
}

async function sendToWebhook(lead: LeadRecord) {
  const url = process.env.LEADS_WEBHOOK_URL;
  if (!url) throw new Error("LEADS_WEBHOOK_URL não configurada.");
  const headers: Record<string, string> = { "Content-Type": "application/json" };
  if (process.env.LEADS_WEBHOOK_SECRET) headers["X-Webhook-Secret"] = process.env.LEADS_WEBHOOK_SECRET;
  const res = await fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(lead),
    signal: AbortSignal.timeout(10_000),
  });
  if (!res.ok) throw new Error(`Webhook respondeu ${res.status}`);
}

export async function storeLead(
  input: Omit<LeadRecord, "id" | "criadoEm" | "consentimento"> & { consentimentoTexto: string },
): Promise<LeadRecord> {
  const now = new Date().toISOString();
  const { consentimentoTexto, ...rest } = input;
  const lead: LeadRecord = {
    id: randomUUID(),
    criadoEm: now,
    ...rest,
    consentimento: { aceito: true, texto: consentimentoTexto, em: now },
  };

  const mode = storageMode();
  if (mode === "file" || mode === "both") await saveToFile(lead);
  if (mode === "webhook" || mode === "both") await sendToWebhook(lead);
  return lead;
}

export async function readLeads(): Promise<LeadRecord[]> {
  try {
    const content = await readFile(leadsFile(), "utf8");
    return content
      .split("\n")
      .filter(Boolean)
      .map((line) => JSON.parse(line) as LeadRecord);
  } catch (err) {
    if ((err as NodeJS.ErrnoException).code === "ENOENT") return [];
    throw err;
  }
}
