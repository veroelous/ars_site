import Image from "next/image";
import Link from "next/link";
import { navigation, site } from "@/config/site";
import { ArrowUpRightIcon, InstagramIcon, MailIcon, MapPinIcon } from "./Icons";

export default function SiteFooter() {
  return (
    <footer className="site-footer">
      <div className="site-footer__group">
        <Image
          src="/images/grupo-ars-iluminacao.png"
          alt="Grupo ARS Iluminação: ARS, Bonalux e RSG"
          width={1560}
          height={520}
          sizes="(max-width: 1560px) 100vw, 1560px"
        />
      </div>

      <div className="wrap">
        <div className="site-footer__main">
          <div>
            <Link href="/" aria-label="ARS Iluminação — página inicial">
              <Image
                src="/images/ars-logo-branco-transparente.png"
                alt="ARS Iluminação"
                width={1278}
                height={589}
                sizes="160px"
                className="site-footer__logo"
              />
            </Link>
            <h2 className="site-footer__title">
              É levar luz <em>às pessoas.</em>
            </h2>

            <div className="site-footer__links">
              <div>
                <div className="site-footer__label">Onde estamos</div>
                <a className="site-footer__link" href={site.address.mapsUrl} target="_blank" rel="noreferrer">
                  <MapPinIcon className="text-orange" />
                  <span>
                    {site.address.street}
                    <small>{site.address.detail}</small>
                  </span>
                </a>
              </div>
              <div>
                <div className="site-footer__label">Conecte-se</div>
                <a className="site-footer__link" href={site.instagram.url} target="_blank" rel="noreferrer">
                  <InstagramIcon className="text-orange" width={18} height={18} />
                  <span>
                    {site.instagram.handle} <ArrowUpRightIcon />
                  </span>
                </a>
              </div>
              <div>
                <div className="site-footer__label">E-mail</div>
                <a className="site-footer__link" href={`mailto:${site.email}`}>
                  <MailIcon className="text-orange" />
                  <span className="break">{site.email}</span>
                </a>
              </div>
            </div>
          </div>

          <Image
            src="/images/mascote-ars.png"
            alt=""
            width={1795}
            height={2048}
            sizes="(max-width: 980px) 480px, 500px"
            className="site-footer__mascot"
          />
        </div>

        <nav className="site-footer__nav" aria-label="Menu do rodapé">
          {navigation.map((item) => (
            <Link key={item.href} href={item.href}>
              {item.label}
            </Link>
          ))}
        </nav>

        <div className="site-footer__bottom">
          <span>© {new Date().getFullYear()} ARS Iluminação</span>
          <span>{site.footerNote}</span>
        </div>
      </div>
    </footer>
  );
}
