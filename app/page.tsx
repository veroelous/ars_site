import Image from "next/image";
import CatalogForm from "@/components/CatalogForm";
import InstagramSection from "@/components/InstagramSection";
import SiteHeader from "@/components/SiteHeader";
import { LightbulbIcon } from "@/components/Icons";

export const revalidate = 3600;

export default function HomePage() {
  return (
    <>
      <section className="hero">
        <div className="hero__bg" aria-hidden="true">
          <Image
            src="/images/hero-ars-fachada-frontal.jpg"
            alt=""
            fill
            priority
            sizes="100vw"
            className="hero__slide hero__slide--a"
          />
          <Image
            src="/images/hero-ars-fachada-lateral.jpg"
            alt=""
            fill
            sizes="100vw"
            className="hero__slide hero__slide--b"
          />
        </div>
        <div className="hero__overlay" aria-hidden="true" />
        <div className="hero__grid" aria-hidden="true" />

        <SiteHeader variant="overlay" current="/" />

        <main id="conteudo" className="wrap hero__content">
          <div>
            <div className="eyebrow">ARS Iluminação</div>
            <h1 className="hero__title">
              Ir além de iluminar <em>espaços.</em>
            </h1>
            <p className="hero__lead">
              É levar luz às pessoas. Enquanto nosso novo site ganha forma, a ARS segue criando e fabricando
              soluções de iluminação para todo o Brasil.
            </p>
          </div>
          <CatalogForm />
        </main>
      </section>

      <section className="purpose" aria-label="Propósito da ARS">
        <div className="wrap purpose__inner">
          <div>
            <div className="purpose__bulb" aria-hidden="true">
              <LightbulbIcon />
            </div>
            <p className="purpose__label">Levar luz, com propósito</p>
          </div>
          <p className="purpose__quote">
            Luz que orienta, traz clareza, revela caminhos e transforma a forma como os espaços são vividos.
          </p>
        </div>
      </section>

      <InstagramSection />
    </>
  );
}
