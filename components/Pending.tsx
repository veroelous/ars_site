import type { ReactNode } from "react";

/**
 * Marca um conteúdo ainda não aprovado pela ARS (texto, foto ou vídeo).
 * Mantém visível o mesmo marcador entre colchetes do site atual, para não
 * inventar alegações comerciais. Ver docs/PENDENCIAS.md.
 */
export function PendingText({ children }: { children: ReactNode }) {
  return <span className="pending-text">{children}</span>;
}

export function PendingMedia({
  title,
  hint,
  tone = "light",
  className = "",
}: {
  title: string;
  hint?: string;
  tone?: "light" | "dark";
  className?: string;
}) {
  return (
    <div className={`pending-media pending-media--${tone} ${className}`} role="img" aria-label={`Mídia pendente: ${title}`}>
      <span>
        {title}
        {hint ? <small>{hint}</small> : null}
      </span>
    </div>
  );
}
