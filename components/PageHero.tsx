import Link from "next/link";
import type { ReactNode } from "react";
import { PendingMedia } from "./Pending";

interface Props {
  eyebrow: string;
  title: ReactNode;
  lead: ReactNode;
  cta?: { href: string; label: string };
  media: { title: string; hint?: string };
}

export default function PageHero({ eyebrow, title, lead, cta, media }: Props) {
  return (
    <section className="page-hero">
      <div className="wrap page-hero__inner reveal">
        <div>
          <div className="eyebrow eyebrow--light">{eyebrow}</div>
          <h1>{title}</h1>
          <p className="page-hero__lead">{lead}</p>
          {cta ? (
            <Link className="btn btn--orange" href={cta.href}>
              {cta.label}
            </Link>
          ) : null}
        </div>
        <PendingMedia tone="dark" title={media.title} hint={media.hint} />
      </div>
    </section>
  );
}
