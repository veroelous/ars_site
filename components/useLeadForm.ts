"use client";

import { useState } from "react";
import type { FieldErrors } from "@/lib/validation";

export type FormStatus = "idle" | "sending" | "success" | "error";

interface Options<T> {
  endpoint: string;
  validate: (data: Record<string, unknown>) => { ok: boolean; errors: FieldErrors };
  onSuccess?: (response: T) => void;
}

/** Envio com validação no navegador + servidor, mensagens acessíveis e foco no primeiro erro. */
export function useLeadForm<T extends { ok: boolean; message?: string; errors?: FieldErrors }>({
  endpoint,
  validate,
  onSuccess,
}: Options<T>) {
  const [status, setStatus] = useState<FormStatus>("idle");
  const [errors, setErrors] = useState<FieldErrors>({});
  const [message, setMessage] = useState("");

  function focusFirstError(form: HTMLFormElement, errs: FieldErrors) {
    const first = Object.keys(errs)[0];
    if (first) (form.elements.namedItem(first) as HTMLElement | null)?.focus();
  }

  async function handleSubmit(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    const form = event.currentTarget;
    const fd = new FormData(form);
    const data: Record<string, unknown> = Object.fromEntries(fd.entries());
    data.consentimento = fd.get("consentimento") === "on";

    const local = validate(data);
    if (!local.ok) {
      setErrors(local.errors);
      setStatus("error");
      setMessage("Confira os campos destacados.");
      focusFirstError(form, local.errors);
      return;
    }

    setErrors({});
    setStatus("sending");
    setMessage("");
    try {
      const res = await fetch(endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body: JSON.stringify(data),
      });
      const json = (await res.json().catch(() => ({ ok: false }))) as T;
      if (!res.ok || !json.ok) {
        setErrors(json.errors ?? {});
        setStatus("error");
        setMessage(json.message || "Não foi possível enviar agora. Tente novamente.");
        if (json.errors) focusFirstError(form, json.errors);
        return;
      }
      setStatus("success");
      onSuccess?.(json);
    } catch {
      setStatus("error");
      setMessage("Não foi possível enviar agora. Verifique sua conexão e tente novamente.");
    }
  }

  return { status, errors, message, setMessage, handleSubmit };
}
