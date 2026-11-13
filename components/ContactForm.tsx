"use client";

import { LIMITS, validateContactLead } from "@/lib/validation";
import { ConsentField, Field, Honeypot, WhatsappField } from "./FormFields";
import { useLeadForm } from "./useLeadForm";

interface ContactResponse {
  ok: boolean;
  message?: string;
  errors?: Record<string, string | undefined>;
}

export default function ContactForm() {
  const { status, errors, message, handleSubmit } = useLeadForm<ContactResponse>({
    endpoint: "/api/contato/",
    validate: validateContactLead,
  });

  if (status === "success") {
    return (
      <div className="contact-success" role="status">
        <h3>Mensagem enviada.</h3>
        <p>Recebemos seu contato. A equipe comercial da ARS retornará pelos dados informados.</p>
      </div>
    );
  }

  return (
    <form className="contact-form" onSubmit={handleSubmit} noValidate>
      <div className="contact-form__grid">
        <Field label="Nome" name="nome" autoComplete="name" placeholder="Seu nome" required maxLength={LIMITS.name} error={errors.nome} />
        <Field label="Empresa" name="empresa" autoComplete="organization" placeholder="Nome da empresa" maxLength={LIMITS.company} error={errors.empresa} />
        <WhatsappField error={errors.whatsapp} />
        <Field label="E-mail" name="email" type="email" autoComplete="email" placeholder="voce@empresa.com" required maxLength={LIMITS.email} error={errors.email} />
        <div className={`field field--full ${errors.mensagem ? "field--error" : ""}`}>
          <label htmlFor="f-mensagem">Mensagem</label>
          <textarea
            id="f-mensagem"
            name="mensagem"
            placeholder="Conte o que você precisa"
            required
            maxLength={LIMITS.message}
            aria-invalid={errors.mensagem ? true : undefined}
            aria-describedby={errors.mensagem ? "f-mensagem-err" : undefined}
          />
          {errors.mensagem ? (
            <p className="field__error" id="f-mensagem-err">
              {errors.mensagem}
            </p>
          ) : null}
        </div>
      </div>
      <ConsentField error={errors.consentimento} />
      <Honeypot />
      <button className="btn btn--orange" type="submit" disabled={status === "sending"}>
        {status === "sending" ? "Enviando…" : "Enviar solicitação"}
      </button>
      <p className="form-status" aria-live="polite">
        {message}
      </p>
    </form>
  );
}
