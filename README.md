# ARS Iluminação — site institucional

Reconstrução do site público `oficial.arsiluminacao.com.br` (WordPress + Elementor) em **Next.js**, a partir do pacote de handoff de 13/11/2026 (`docs/referencia/`).

## Páginas

| Página | URL | Arquivo |
|---|---|---|
| Início | `/` | `app/page.tsx` |
| A ARS | `/a-ars/` | `app/a-ars/page.tsx` |
| Produtos | `/produtos/` | `app/produtos/page.tsx` |
| Categorias | `/categorias-de-luminarias/` | `app/categorias-de-luminarias/page.tsx` |
| Contato e orçamento | `/contato-e-orcamento/` | `app/contato-e-orcamento/page.tsx` |

As URLs (com barra final) são as mesmas do WordPress, então links já divulgados continuam funcionando.

## Rodar localmente

Requer Node.js 20 ou superior.

```bash
npm install
cp .env.example .env.local   # ajuste os valores
npm run dev                  # http://localhost:3000
```

Para produção:

```bash
npm run build
npm start
```

## Onde editar

- **Contatos, endereço, WhatsApp, Instagram e menu:** `config/site.ts`. Esse arquivo alimenta cabeçalho, rodapé, botão do WhatsApp e página de contato.
- **Publicações do Instagram sem token:** `config/instagram-fallback.ts`.
- **Visual:** `app/globals.css`. As cores ficam no topo, como variáveis, com os valores do site publicado.
- **Imagens:** `public/images/`.
- **Catálogo PDF:** `private/catalogo-ars-iluminacao.pdf`. Para trocar o catálogo, substitua o arquivo mantendo o nome ou ajuste `catalog.fileName` em `config/site.ts`.
- **Conteúdo pendente:** os campos entre colchetes usam os componentes `PendingText` e `PendingMedia`. Ao receber o material aprovado, substitua o componente pelo texto ou imagem final. A lista completa está em `docs/PENDENCIAS.md`.

## Formulário do catálogo (Home)

1. O visitante informa nome, WhatsApp e e-mail e marca o consentimento (LGPD).
2. O navegador valida os campos e o servidor (`/api/catalogo/`) valida de novo.
3. O lead é gravado (veja "Armazenamento") com data e texto do consentimento.
4. O servidor devolve um link assinado (HMAC), válido por 30 minutos, e o download começa.
5. O PDF fica fora da pasta pública. Sem um link válido não há download, e um link expirado volta ao formulário.

Proteções: honeypot contra robôs, limite de envios por IP, verificação de origem e validação dupla.

## Formulário de contato

Disponível em `/contato-e-orcamento/`. Os campos são nome, empresa, WhatsApp, e-mail, mensagem e consentimento. Usa o mesmo armazenamento, com `origem: "contato"`.

## Armazenamento dos leads

O destino é escolhido pela variável `LEADS_STORAGE`:

- **`file`:** grava em `LEADS_DIR/leads.jsonl` (padrão `./data`), com permissão 600. Use em servidor Node ou VPS com disco persistente.
- **`webhook`:** envia cada lead em JSON para `LEADS_WEBHOOK_URL` (Make, Zapier, n8n, Google Apps Script para Planilhas...). Opcionalmente envia `X-Webhook-Secret`. Obrigatório em hospedagem sem disco persistente, como a Vercel.
- **`both`:** usa os dois destinos.

Para exportar em CSV, acesse `/api/admin/leads/` com o usuário e a senha de `ADMIN_USER` e `ADMIN_PASSWORD`. Sem essas variáveis, a rota fica desativada.

> A pasta `data/` está no `.gitignore`. **Nunca** versione dados de contato.

## Instagram (3 publicações mais recentes)

- **Com `INSTAGRAM_ACCESS_TOKEN`:** busca as 3 últimas publicações pela Instagram API (Instagram Login), com cache de `INSTAGRAM_REVALIDATE_SECONDS` (padrão: 1 h).
- **Sem token, ou se a API falhar:** mostra os embeds oficiais das publicações listadas em `config/instagram-fallback.ts`.

O token de longa duração expira em 60 dias e precisa ser renovado. Veja `docs/PENDENCIAS.md`.

## Hospedagem

O site precisa de um servidor Node.js, por causa das rotas de formulário e de download. Opções:

- **Vercel:** importe o repositório e configure as variáveis. Use `LEADS_STORAGE=webhook`.
- **VPS ou hospedagem Node (por exemplo, Hostinger com Node.js):** `npm ci && npm run build && npm start`, atrás de um proxy HTTPS. Pode usar `LEADS_STORAGE=file` com `LEADS_DIR` apontando para uma pasta persistente fora do diretório publicado.

Variáveis obrigatórias em produção: `SITE_URL` e `CATALOG_TOKEN_SECRET`. A lista completa está em `.env.example`.

## Estrutura

```
app/            páginas, layout, estilos e rotas de API
components/     cabeçalho, rodapé, formulários, Instagram, marcadores de pendência
config/         dados institucionais e fallback do Instagram
lib/            validação, leads, token do catálogo, Instagram, limite de envios
private/        catálogo PDF (servido apenas com link assinado)
public/images/  logos, fotos da fábrica, mascote, marcas do grupo
docs/           pendências e material de referência do handoff
```
