import type { Metadata } from "next";
import Link from "next/link";
import PageHero from "@/components/PageHero";
import SiteHeader from "@/components/SiteHeader";
import { PendingMedia, PendingText } from "@/components/Pending";

export const metadata: Metadata = {
  title: "Produtos",
  description:
    "Explore o portfólio da ARS Iluminação por categoria e encontre soluções de iluminação para diferentes ambientes e aplicações.",
};

/**
 * No WordPress, "Ver categoria" apontava para páginas (/pendentes/, /spots/...) que ainda não existem.
 * Aqui os links levam à seção correspondente da página Categorias até as páginas próprias serem aprovadas.
 */
const categories = [
  { name: "Pendentes", image: "[IMAGEM — PENDENTES]", text: "[Descrição comercial aprovada]", anchor: "pendentes" },
  { name: "Perfis de LED", image: "[IMAGEM — PERFIS DE LED]", text: "[Descrição técnica e aplicações aprovadas]", anchor: "perfis-de-led" },
  { name: "Spots", image: "[IMAGEM — SPOTS]", text: "[Descrição comercial aprovada]", anchor: "spots" },
  { name: "Spots para trilho", image: "[IMAGEM — SPOTS PARA TRILHO]", text: "[Descrição técnica e aplicações aprovadas]", anchor: "spots" },
  { name: "Arandelas", image: "[IMAGEM — ARANDELAS]", text: "[Descrição comercial aprovada]", anchor: "arandelas" },
  { name: "Plafons e plafoniers", image: "[IMAGEM — PLAFONS]", text: "[Descrição comercial aprovada]", anchor: "plafons" },
];

export default function ProductsPage() {
  return (
    <>
      <SiteHeader current="/produtos/" />
      <main id="conteudo" className="inner-page">
        <PageHero
          eyebrow="ARS Iluminação"
          title={
            <>
              Luminárias para <span>projetos que pedem mais.</span>
            </>
          }
          lead="Explore o portfólio da ARS por categoria e encontre soluções de iluminação para diferentes ambientes e aplicações."
          media={{ title: "[IMAGEM OU VÍDEO DE ABERTURA]", hint: "Inserir mídia oficial do portfólio" }}
        />

        <section className="section section--white">
          <div className="wrap reveal">
            <div className="kicker">Portfólio</div>
            <h2>Encontre sua solução.</h2>
            <p>Escolha uma categoria para apresentar produtos, aplicações e fichas técnicas.</p>
            <div className="cards cards--3">
              {categories.map((c) => (
                <article className="card card--product" key={c.name}>
                  <PendingMedia title={c.image} className="card__pic" />
                  <h3>{c.name}</h3>
                  <p>
                    <PendingText>{c.text}</PendingText>
                  </p>
                  <Link className="btn btn--orange btn--sm" href={`/categorias-de-luminarias/#${c.anchor}`}>
                    Ver categoria
                  </Link>
                </article>
              ))}
            </div>
          </div>
        </section>

        <section className="section">
          <div className="wrap reveal">
            <div className="kicker">Informação para especificar</div>
            <h2>Produto apresentado com clareza.</h2>
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
                  <PendingText>[Ambientes indicados, disponibilidade, prazo e orientação comercial — validar]</PendingText>
                </p>
                <Link className="btn btn--orange" href="/contato-e-orcamento/">
                  Solicitar orçamento
                </Link>
              </div>
            </div>
          </div>
        </section>

        <section className="section section--white">
          <div className="wrap reveal">
            <div className="cta-panel">
              <div>
                <div className="eyebrow eyebrow--light">Atendimento comercial</div>
                <h2>Precisa de orientação para o seu projeto?</h2>
                <p>
                  <PendingText>
                    [Texto comercial aprovado para lojistas, especificadores, arquitetos e distribuidores]
                  </PendingText>
                </p>
                <Link className="btn btn--orange" href="/contato-e-orcamento/">
                  Falar com a ARS
                </Link>
              </div>
              <PendingMedia tone="dark" title="[IMAGEM OU VÍDEO DE APLICAÇÃO]" />
            </div>
          </div>
        </section>
      </main>
    </>
  );
}
