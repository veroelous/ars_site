import { whatsappUrl } from "@/config/site";
import { WhatsAppIcon } from "./Icons";

export default function WhatsAppButton() {
  return (
    <a
      className="whatsapp-float"
      href={whatsappUrl}
      target="_blank"
      rel="noreferrer"
      aria-label="Falar com a ARS Iluminação pelo WhatsApp"
    >
      <WhatsAppIcon />
    </a>
  );
}
