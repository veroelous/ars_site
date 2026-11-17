# Pendências antes da publicação

Itens que dependem de **aprovação da ARS**, de **credenciais** ou de **configuração de conta**. O código já está pronto para recebê-los.

## 1. Validar com o responsável da ARS (antes da troca de domínio)

| Item | Valor atual | Onde alterar |
|---|---|---|
| WhatsApp (botão flutuante e página de contato) | `+55 19 99696-5662` (link `wa.me` da Home atual e bio do Instagram) | `public_html/includes/site.php` → `whatsapp` |
| Endereço | Estrada de Joaquim de Souza Siqueira, 2099, Oratório, Socorro/SP, CEP 13960-000 | `public_html/includes/site.php` → `address` |
| E-mail de contato e avisos de leads | `arsiluminacao@gmail.com` (**definido pela ARS em 17/11/2026**; o `comercial@` foi descartado) | `public_html/includes/site.php` → `email` |
| Texto do consentimento LGPD | Baseado no aviso de privacidade do formulário atual | `public_html/includes/site.php` → `consent` |

Descartados explicitamente e **não usados**: o telefone `(19) 98304-7385` e o endereço da Rua São João, 33.

## 2. Revisão editorial: Expolux

A Expolux terminou. No novo site:

- A Hero não tem chamada, data, local nem link do evento.
- O rodapé trocou a coluna "Expolux 2026 · 15 a 18 de setembro" pela coluna **E-mail**, como já era nas páginas internas.
- **Falta revisar:** o texto da seção do Instagram na Home ainda diz *"…os lançamentos e a presença da ARS na Expolux."* O texto oficial foi mantido de propósito, até a ARS decidir. Arquivo: `public_html/index.php`.

## 3. Conteúdo marcado como pendente (`[ ... ]`)

O conteúdo segue o site atual: os campos ainda sem material aprovado aparecem com o mesmo marcador entre colchetes, destacado em laranja claro. Nada foi inventado.

**A ARS** (`public_html/a-ars/index.php`)
- Mídia institucional da Hero (fábrica, equipe ou processo)
- Texto da história (fundação, evolução, marcos) e imagem histórica
- Textos dos cards Desenvolvimento, Processo produtivo e Fabricação
- Texto comercial para lojistas, especificadores, arquitetos e distribuidores, e a mídia de processo

**Produtos** (`public_html/produtos/index.php`)
- Mídia de abertura
- Imagem e descrição de cada categoria: Pendentes, Perfis de LED, Spots, Spots para trilho, Arandelas, Plafons e plafoniers
- Conteúdo da ficha técnica, do PDF por produto e de aplicações e compra
- Texto comercial e mídia de aplicação
- No WordPress, "Ver categoria" apontava para `/pendentes/`, `/spots/` e outras páginas que **não existem**. Aqui o botão leva à categoria correspondente em `/categorias-de-luminarias/` até essas páginas serem criadas.

**Categorias** (`public_html/categorias-de-luminarias/index.php`)
- Mídia de abertura, mais imagem e descrição de: Pendentes, Perfis de LED, Spots e spots para trilho, Arandelas, Plafons, Plafoniers
- Ficha técnica e aplicações e compra

**Contato e orçamento** (`public_html/contato-e-orcamento/index.php`)
- Mídia da Hero
- Texto comercial (público atendido, prazo de retorno, canais)
- Texto de conversão e mídia do bloco final
- O formulário, que no WordPress era só um modelo ("configurar Contact Form 7"), **agora funciona**.

## 3b. Fase 1 (17/11/2026): itens para validar

**Home** (`public_html/index.php`): o texto "Enquanto nosso novo site ganha forma…" foi trocado por "Desde 2014, a ARS cria e fabrica em Socorro/SP soluções de iluminação com pronta entrega para todo o Brasil.", montado com afirmações já publicadas pela ARS (página A ARS e Instagram). Também foram adicionados os botões "Seja revendedor" e "Ver produtos".

**Seja revendedor** (`public_html/seja-revendedor/index.php`)
- Os três diferenciais (produção própria, pronta entrega, entrega para todo o Brasil) foram extraídos das legendas oficiais do Instagram. Falta validar a redação.
- `[Pedido mínimo, prazos de entrega, formas de pagamento, tabela de preços e materiais de PDV]`
- Mídia da abertura (foto da fábrica, estoque ou expedição).

**Onde comprar** (`public_html/onde-comprar/index.php`)
- Lista de revendas autorizadas, para preencher em `ARS_RESELLERS` (`includes/site.php`). Lojas que já exibem a marca na internet (VitaLuz, São Pedro Shopping) **não** foram incluídas sem confirmação da ARS.

**Política de privacidade** (`public_html/politica-de-privacidade/index.php`)
- CNPJ do controlador. O cadastro público mostra 23.654.084/0001-82 com outro endereço; confirmar qual exibir.
- Prazo máximo de guarda dos dados.

## 4. Credenciais e configuração de conta

Tudo fica no `config.php` privado do servidor (modelo em `public_html/includes/config.example.php`), nunca no Git.

| O quê | Para quê | Chave no config.php |
|---|---|---|
| Segredo do link do catálogo | Assinar o download (obrigatório) | `catalog_secret` |
| Remetente dos avisos | Os avisos vão para `arsiluminacao@gmail.com` (fixo em `includes/site.php`) | `mail_from` |
| Google Analytics 4 | Medir visitas e conversões (download, formulários, WhatsApp) | `ga4_id` |
| Usuário e senha da exportação | Baixar os contatos em `/admin/leads.php` | `admin_user`, `admin_pass_hash` |
| Token do Instagram | Feed dinâmico das 3 últimas publicações | `instagram_token` |
| URL do domínio final | SEO, Open Graph, sitemap | `site_url` |
| Acesso FTP da Host4 | Publicação automática pelo GitHub | segredos `FTP_*` no GitHub |

### Instagram: como obter e renovar o token

1. A conta `@ars.iluminacao` precisa ser **profissional** (Empresa ou Criador).
2. Em developers.facebook.com, crie um app do tipo *Empresa* e adicione o produto **Instagram → API com login do Instagram**.
3. Adicione a conta como testadora ou gere o token pelo painel, com a permissão `instagram_business_basic`.
4. Troque o token curto por um de **longa duração** (60 dias) e coloque-o em `instagram_token` no `config.php`.
5. Renove antes de vencer, com `GET https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=TOKEN`. O ideal é automatizar com uma tarefa agendada mensal.

Enquanto não houver token, o site mostra os embeds definidos em `ARS_INSTAGRAM_FALLBACK` (`public_html/includes/site.php`).

## 5. Migração dos leads antigos

Os leads já recebidos pelo Contact Form 7 e pelo Flamingo **não** estão neste pacote, que é só uma captura pública. Para mantê-los, exporte pelo painel do WordPress (Flamingo → Mensagens recebidas → Exportar) e guarde **fora do repositório**.

## 6. Conferência visual

Conferido em desktop (1440 px), tablet (820 px) e celular (390 px), sem rolagem horizontal nas 5 páginas. Antes de publicar, vale comparar lado a lado com o site atual no domínio final, com o token do Instagram ativo.
