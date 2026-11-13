import Link from "next/link";
import SiteHeader from "@/components/SiteHeader";

export default function NotFound() {
  return (
    <>
      <SiteHeader />
      <main id="conteudo" className="inner-page">
        <section className="page-hero page-hero--simple">
          <div className="wrap">
            <div className="eyebrow eyebrow--light">Página não encontrada</div>
            <h1>
              Este caminho <span>não existe.</span>
            </h1>
            <p className="page-hero__lead">O endereço pode ter mudado com o novo site da ARS.</p>
            <Link className="btn btn--orange" href="/">
              Voltar ao início
            </Link>
          </div>
        </section>
      </main>
    </>
  );
}
