import type { Metadata } from "next";
import Link from "next/link";
import PageHero from "@/components/PageHero";
import SiteHeader from "@/components/SiteHeader";
import { PendingMedia, PendingText } from "@/components/Pending";

export const metadata: Metadata = {
  title: "A ARS",
  description:
    "A ARS Iluminação foi fundada em 2014, em Socorro/SP, para criar e fabricar soluções de iluminação para diferentes projetos.",
};

const pillars = [
  { title: "Desenvolvimento", pending: "[TEXTO APROVADO SOBRE DESIGN, ENGENHARIA E DESENVOLVIMENTO DE PRODUTOS]" },
  { title: "Processo produtivo", pending: "[TEXTO APROVADO SOBRE MATERIAIS, ACABAMENTOS E CONTROLE DE QUALIDADE]" },
  { title: "Fabricação", pending: "[TEXTO APROVADO SOBRE FABRICAÇÃO E PINTURA ELETROSTÁTICA]" },
];

export default function AboutPage() {
  return (
    <>
      <SiteHeader current="/a-ars/" />
      <main id="conteudo" className="inner-page">
        <PageHero
          eyebrow="Sobre a ARS"
          title={
            <>
              Iluminação com <span>propósito.</span>
            </>
          }
          lead="A ARS Iluminação foi fundada em 2014, em Socorro/SP, para criar e fabricar soluções de iluminação para diferentes projetos."
          cta={{ href: "/contato-e-orcamento/", label: "Falar com a equipe comercial" }}
          media={{ title: "[IMAGEM OU VÍDEO INSTITUCIONAL]", hint: "Inserir mídia oficial da fábrica, equipe ou processo" }}
        />

        <section className="section section--white">
          <div className="wrap two-col reveal">
            <div>
              <div className="kicker">Nossa história</div>
              <h2>Uma trajetória feita de luz, produto e parceria.</h2>
              <p>
                <PendingText>[TEXTO APROVADO SOBRE A FUNDAÇÃO, EVOLUÇÃO E MOMENTOS IMPORTANTES DA ARS]</PendingText>
              </p>
              <p className="note">Campo reservado para o texto institucional aprovado.</p>
            </div>
            <PendingMedia title="[IMAGEM HISTÓRICA]" hint="Arquivo oficial / linha do tempo" />
          </div>
        </section>

        <section className="section">
          <div className="wrap reveal">
            <div className="kicker">Qualidade e fabricação</div>
            <h2>Do desenvolvimento ao projeto.</h2>
            <p>Apresente aqui os diferenciais técnicos e produtivos com informações oficiais da ARS.</p>
            <div className="cards cards--3">
              {pillars.map((p) => (
                <article className="card" key={p.title}>
                  <h3>{p.title}</h3>
                  <p>
                    <PendingText>{p.pending}</PendingText>
                  </p>
                </article>
              ))}
            </div>
          </div>
        </section>

        <section className="section section--white">
          <div className="wrap reveal">
            <div className="cta-panel">
              <div>
                <div className="eyebrow eyebrow--light">Para especificar e comprar</div>
                <h2>Uma parceira para transformar projetos em ambientes iluminados.</h2>
                <p>
                  <PendingText>
                    [TEXTO COMERCIAL APROVADO PARA LOJISTAS, ESPECIFICADORES, ARQUITETOS E DISTRIBUIDORES]
                  </PendingText>
                </p>
                <Link className="btn btn--orange" href="/contato-e-orcamento/">
                  Solicitar atendimento
                </Link>
              </div>
              <PendingMedia tone="dark" title="[VÍDEO OU IMAGEM DE PROCESSO]" hint="Inserir mídia oficial" />
            </div>
          </div>
        </section>
      </main>
    </>
  );
}
