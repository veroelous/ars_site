"use client";

import { useEffect, useState } from "react";
import { site } from "@/config/site";
import { validateCatalogLead } from "@/lib/validation";
import { ArrowDownIcon } from "./Icons";
import { ConsentField, Field, Honeypot, WhatsappField } from "./FormFields";
import { useLeadForm } from "./useLeadForm";

interface CatalogResponse {
  ok: boolean;
  message?: string;
  downloadUrl?: string | null;
  errors?: Record<string, string | undefined>;
}

export default function CatalogForm() {
  const [downloadUrl, setDownloadUrl] = useState<string | null>(null);
  const { status, errors, message, setMessage, handleSubmit } = useLeadForm<CatalogResponse>({
    endpoint: "/api/catalogo/",
    validate: validateCatalogLead,
    onSuccess: (res) => {
      if (res.downloadUrl) {
        setDownloadUrl(res.downloadUrl);
        window.location.assign(res.downloadUrl);
      }
    },
  });

  useEffect(() => {
    if (new URLSearchParams(window.location.search).get("catalogo") === "expirado") {
      setMessage("O link de download expirou. Envie seus dados novamente para liberar o catálogo.");
    }
  }, [setMessage]);

  return (
    <div className="catalog-card" id="catalogo">
      <p className="catalog-card__tag">Catálogo ARS</p>
      <h2>Conheça nossas soluções.</h2>

      {status === "success" ? (
        <div className="catalog-card__success" role="status">
          <p>Dados enviados. O download do catálogo começou.</p>
          {downloadUrl ? (
            <a className="btn btn--orange btn--block" href={downloadUrl}>
              Baixar catálogo novamente <ArrowDownIcon />
            </a>
          ) : null}
          <p className="catalog-card__fine">O link fica disponível por 30 minutos.</p>
        </div>
      ) : (
        <>
          <p className="catalog-card__copy">Preencha seus dados para liberar o download.</p>
          <form className="catalog-form" onSubmit={handleSubmit} noValidate>
            <Field
              label="Nome"
              name="nome"
              type="text"
              autoComplete="name"
              placeholder="Seu nome"
              required
              maxLength={120}
              error={errors.nome}
            />
            <div className="catalog-form__two">
              <WhatsappField error={errors.whatsapp} />
              <Field
                label="E-mail"
                name="email"
                type="email"
                autoComplete="email"
                placeholder="voce@empresa.com.br"
                required
                maxLength={160}
                error={errors.email}
              />
            </div>
            <ConsentField error={errors.consentimento} />
            <Honeypot />
            <button className="btn btn--orange btn--block btn--square" type="submit" disabled={status === "sending"}>
              {status === "sending" ? "Enviando…" : (
                <>
                  {site.catalog.label} <ArrowDownIcon />
                </>
              )}
            </button>
            <p className="form-status" aria-live="polite">
              {message}
            </p>
          </form>
        </>
      )}
    </div>
  );
}
