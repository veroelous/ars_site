import type { Metadata } from "next";
import Link from "next/link";
import PageHero from "@/components/PageHero";
import SiteHeader from "@/components/SiteHeader";
import { PendingMedia, PendingText } from "@/components/Pending";

export const metadata: Metadata = {
  title: "Categorias de luminárias",
  description: "Categorias de luminárias da ARS Iluminação: pendentes, perfis de LED, spots, arandelas, plafons e plafoniers.",
};

const categories = [
  { id: "pendentes", name: "Pendentes", image: "[IMAGEM — PENDENTES]" },
  { id: "perfis-de-led", name: "Perfis de LED", image: "[IMAGEM — PERFIS DE LED]" },
  { id: "spots", name: "Spots e spots para trilho", image: "[IMAGEM — SPOTS E TRILHOS]" },
  { id: "arandelas", name: "Arandelas", image: "[IMAGEM — ARANDELAS]" },
  { id: "plafons", name: "Plafons", image: "[IMAGEM — PLAFONS]" },
  { id: "plafoniers", name: "Plafoniers", image: "[IMAGEM — PLAFONIERS]" },
];

export default function CategoriesPage() {
  return (
    <>
      <SiteHeader current="/categorias-de-luminarias/" />
      <main id="conteudo" className="inner-page">
        <PageHero
          eyebrow="Portfólio ARS"
          title={
            <>
              Categorias de <span>luminárias.</span>
            </>
          }
          lead="Uma estrutura visual para organizar o portfólio por aplicação, estética e especificação técnica."
          media={{ title: "[IMAGEM OU VÍDEO DE ABERTURA]", hint: "Inserir mídia oficial do portfólio" }}
        />

        <section className="section section--white">
          <div className="wrap reveal">
            <div className="kicker">Escolha uma categoria</div>
            <h2>Soluções organizadas para especificar melhor.</h2>
            <div className="cards cards--3">
              {categories.map((c) => (
                <article className="card card--product" key={c.id} id={c.id}>
                  <PendingMedia title={c.image} className="card__pic" />
                  <h3>{c.name}</h3>
                  <p>
                    <PendingText>[Descrição aprovada]</PendingText>
                  </p>
                </article>
              ))}
            </div>
          </div>
        </section>

        <section className="section">
          <div className="wrap reveal">
            <div className="kicker">Padrão de apresentação</div>
            <h2>Cada produto com informação útil para a compra.</h2>
            <div className="two-col two-col--panels">
              <div className="panel">
                <h3>Ficha técnica</h3>
                <p>
                  <PendingText>
                    [Medidas, potência, temperatura de cor, fluxo luminoso, acabamento, instalação e garantia —
                    preencher com material oficial]
                  </PendingText>
                </p>
                <PendingMedia title="[PDF / CATÁLOGO / FICHA TÉCNICA]" className="pending-media--doc" />
              </div>
              <div className="panel">
                <h3>Aplicações e compra</h3>
                <p>
                  <PendingText>[Ambientes indicados, disponibilidade, prazo e CTA comercial — validar]</PendingText>
                </p>
                <Link className="btn btn--orange" href="/contato-e-orcamento/">
                  Solicitar orientação
                </Link>
              </div>
            </div>
          </div>
        </section>
      </main>
    </>
  );
}
