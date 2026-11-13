import Image from "next/image";
import Link from "next/link";
import { navigation, site } from "@/config/site";
import { ArrowUpRightIcon, InstagramIcon } from "./Icons";

interface Props {
  /** "overlay": transparente sobre a Hero da Home. "solid": barra azul das páginas internas. */
  variant?: "overlay" | "solid";
  current?: string;
}

export default function SiteHeader({ variant = "solid", current }: Props) {
  return (
    <header className={`site-header site-header--${variant}`}>
      <div className="site-header__inner wrap">
        <Link href="/" className="site-header__brand" aria-label="ARS Iluminação — página inicial">
          <Image
            src="/images/ars-logo-branco-transparente.png"
            alt="ARS Iluminação"
            width={1278}
            height={589}
            priority
            sizes="160px"
            className="site-header__logo"
          />
        </Link>

        <nav className="site-nav" aria-label="Menu principal">
          {navigation.map((item) => (
            <Link
              key={item.href}
              href={item.href}
              aria-current={current === item.href ? "page" : undefined}
            >
              {item.label}
            </Link>
          ))}
        </nav>

        <a className="pill-link" href={site.instagram.url} target="_blank" rel="noreferrer">
          <InstagramIcon className="text-orange" />
          <span className="pill-link__text">{site.instagram.handle}</span>
          <ArrowUpRightIcon />
        </a>
      </div>
    </header>
  );
}
