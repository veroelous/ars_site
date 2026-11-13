"use client";

import { useState, type InputHTMLAttributes } from "react";
import { maskWhatsapp } from "@/lib/validation";
import { CONSENT_TEXT } from "@/lib/consent";

interface FieldProps extends InputHTMLAttributes<HTMLInputElement> {
  label: string;
  name: string;
  error?: string;
}

export function Field({ label, name, error, className = "", ...rest }: FieldProps) {
  const id = `f-${name}`;
  return (
    <div className={`field ${error ? "field--error" : ""} ${className}`}>
      <label htmlFor={id}>{label}</label>
      <input
        id={id}
        name={name}
        aria-invalid={error ? true : undefined}
        aria-describedby={error ? `${id}-err` : undefined}
        {...rest}
      />
      {error ? (
        <p className="field__error" id={`${id}-err`}>
          {error}
        </p>
      ) : null}
    </div>
  );
}

export function WhatsappField({ error, label = "WhatsApp" }: { error?: string; label?: string }) {
  const [value, setValue] = useState("");
  return (
    <Field
      label={label}
      name="whatsapp"
      type="tel"
      inputMode="numeric"
      autoComplete="tel-national"
      placeholder="(00) 00000-0000"
      required
      maxLength={15}
      value={value}
      onChange={(e) => setValue(maskWhatsapp(e.target.value))}
      error={error}
    />
  );
}

export function ConsentField({ error }: { error?: string }) {
  return (
    <div className={`consent ${error ? "field--error" : ""}`}>
      <input
        id="f-consentimento"
        name="consentimento"
        type="checkbox"
        required
        aria-invalid={error ? true : undefined}
        aria-describedby={error ? "f-consentimento-err" : undefined}
      />
      <label htmlFor="f-consentimento">{CONSENT_TEXT}</label>
      {error ? (
        <p className="field__error" id="f-consentimento-err">
          {error}
        </p>
      ) : null}
    </div>
  );
}

/** Campo-armadilha para robôs: oculto para pessoas e leitores de tela. */
export function Honeypot() {
  return (
    <div className="hp" aria-hidden="true">
      <label htmlFor="f-site">Não preencha este campo</label>
      <input id="f-site" name="site" type="text" tabIndex={-1} autoComplete="off" />
    </div>
  );
}
