import type { Metadata } from "next";
import ContactForm from "@/components/ContactForm";
import PageHero from "@/components/PageHero";
import SiteHeader from "@/components/SiteHeader";
import { PendingMedia, PendingText } from "@/components/Pending";
import { ArrowUpRightIcon, InstagramIcon, MailIcon, MapPinIcon, WhatsAppIcon } from "@/components/Icons";
import { site, whatsappUrl } from "@/config/site";
import { formatWhatsapp } from "@/lib/validation";

export const metadata: Metadata = {
  title: "Contato e orçamento",
  description:
    "Conte o que você precisa para seu projeto e a equipe comercial da ARS Iluminação retornará com as orientações adequadas.",
};

export default function ContactPage() {
  return (
    <>
      <SiteHeader current="/contato-e-orcamento/" />
      <main id="conteudo" className="inner-page">
        <PageHero
          eyebrow="Atendimento ARS"
          title={
            <>
              Fale com a <span>ARS.</span>
            </>
          }
          lead="Conte o que você precisa para seu projeto e nossa equipe comercial retornará com as orientações adequadas."
          media={{ title: "[IMAGEM DE ATENDIMENTO, PRODUTO OU APLICAÇÃO]", hint: "Inserir mídia oficial" }}
        />

        <section className="section section--white">
          <div className="wrap reveal">
            <div className="kicker">Solicite um orçamento</div>
            <h2>Vamos conversar sobre o seu projeto.</h2>
            <div className="contact-grid">
              <div className="panel panel--form">
                <p>
                  <PendingText>[Texto comercial aprovado: público atendido, prazo de retorno e canais oficiais]</PendingText>
                </p>
                <ContactForm />
              </div>

              <div className="panel">
                <div className="kicker">Canais oficiais</div>
                <h3>Atendimento comercial</h3>
                <ul className="channels">
                  <li>
                    <MailIcon className="text-orange" />
                    <a href={`mailto:${site.email}`}>{site.email}</a>
                  </li>
                  <li>
                    <WhatsAppIcon className="text-orange" width={18} height={18} />
                    <a href={whatsappUrl} target="_blank" rel="noreferrer">
                      {formatWhatsapp(site.whatsapp.number.slice(2))}
                    </a>
                  </li>
                  <li>
                    <InstagramIcon className="text-orange" width={18} height={18} />
                    <a href={site.instagram.url} target="_blank" rel="noreferrer">
                      {site.instagram.handle} <ArrowUpRightIcon />
                    </a>
                  </li>
                  <li>
                    <MapPinIcon className="text-orange" />
                    <a href={site.address.mapsUrl} target="_blank" rel="noreferrer">
                      {site.address.street}
                      <small>{site.address.detail}</small>
                    </a>
                  </li>
                </ul>
                <p className="note">
                  WhatsApp e endereço conforme o site publicado — confirmar com a ARS antes da troca de domínio.
                </p>
              </div>
            </div>
          </div>
        </section>

        <section className="section">
          <div className="wrap reveal">
            <div className="cta-panel">
              <div>
                <div className="eyebrow eyebrow--light">Próximo passo</div>
                <h2>Tenha uma equipe para orientar sua especificação.</h2>
                <p>
                  <PendingText>[Texto comercial aprovado para conversão]</PendingText>
                </p>
                <a className="btn btn--orange" href={`mailto:${site.email}`}>
                  Enviar e-mail
                </a>
              </div>
              <PendingMedia tone="dark" title="[IMAGEM OU VÍDEO DE PROJETO]" />
            </div>
          </div>
        </section>
      </main>
    </>
  );
}
