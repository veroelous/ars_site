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
- O texto da seção do Instagram na Home terminava com *"…e a presença da ARS na Expolux."*; em 18/11/2026 passou a ser *"Acompanhe os bastidores da fábrica e os lançamentos."*

## 3. Páginas institucionais completadas sem resposta da ARS (18/11/2026)

Para o site poder ir ao ar mesmo sem retorno, as caixas pendentes das páginas institucionais foram preenchidas **só com material oficial**: as duas fotos da fábrica, as fotos do catálogo, os dados do PDF (linhas, materiais, acabamentos, Grupo ARS), a bio e as legendas do Instagram e o site atual. Nenhum número, prazo, condição ou marco novo foi criado. **Tudo abaixo continua valendo a validação da redação pela ARS.**

**A ARS** (`public_html/a-ars/index.php`)
- Hero e "Nossa história" com as fotos da fábrica (fachada frontal e lateral).
- História: fundação em 2014 em Socorro/SP, fabricante com produção própria, entrega para todo o Brasil, catálogo com 9 linhas e mais de 200 modelos, Grupo ARS Iluminação (ARS, Bonalux e RSG).
- Cards: Desenvolvimento (linhas com desenho próprio e coleção Bonalux), Processo produtivo (alumínio, ABS com tratamento UV, vidro, paleta de 8 cores) e Fabricação (produção própria em Socorro/SP, pronta entrega, envio para todo o Brasil). A "pintura eletrostática" do marcador antigo **não** foi usada, porque não aparece em nenhum material oficial.
- Texto comercial para lojistas, distribuidores, arquitetos e instaladores, com foto de produto.
- **Se a ARS enviar:** texto próprio da história, marcos, fotos da equipe e do processo.

**Contato e orçamento** (`public_html/contato-e-orcamento/index.php`)
- Hero e bloco final com fotos do catálogo.
- Texto do formulário: público atendido e retorno pelo WhatsApp ou e-mail, **sem prazo de retorno** (não informado pela ARS).
- Saiu da página pública a nota "WhatsApp e endereço conforme o site publicado — confirmar com a ARS"; a confirmação continua pendente na seção 1.

**Produtos** (`public_html/produtos/index.php`): as 9 linhas têm páginas próprias e foto. Saiu o aviso "As demais linhas ganham páginas próprias em breve". A antiga página `/categorias-de-luminarias/` redireciona para `/produtos/`.

**Catálogo:** o botão dizia "Catálogo ARS 2026", mas a capa do PDF mostra 2027. Passou a dizer "Baixar catálogo ARS", sem ano.

## 3b. Fase 1 (17/11/2026): itens para validar

**Home** (`public_html/index.php`): o texto "Enquanto nosso novo site ganha forma…" foi trocado por "Desde 2014, a ARS cria e fabrica em Socorro/SP soluções de iluminação com pronta entrega para todo o Brasil.", montado com afirmações já publicadas pela ARS (página A ARS e Instagram). Também foram adicionados os botões "Seja revendedor" e "Ver produtos".

**Seja revendedor** (`public_html/seja-revendedor/index.php`)
- Os três diferenciais (produção própria, pronta entrega, entrega para todo o Brasil) foram extraídos das legendas oficiais do Instagram. Falta validar a redação.
- "Como funciona" virou um passo a passo (cadastro → contato da equipe comercial → condições apresentadas no atendimento). **Quando a ARS enviar** pedido mínimo, prazos, pagamento, tabela e materiais de PDV, eles entram nesse bloco.
- Abertura com a foto da fábrica; a lista de linhas para revenda passou a ser a das 9 linhas do catálogo.

**Onde comprar** (`public_html/onde-comprar/index.php`)
- Lista de revendas autorizadas, para preencher em `ARS_RESELLERS` (`includes/site.php`). Enquanto estiver vazia, a página mostra "A lista de revendas está sendo organizada" com o botão do WhatsApp; ao cadastrar a primeira loja, a seção "Revendas por estado" aparece sozinha. A abertura usa foto do catálogo. Lojas que já exibem a marca na internet (VitaLuz, São Pedro Shopping) **não** foram incluídas sem confirmação da ARS.

**Política de privacidade** (`public_html/politica-de-privacidade/index.php`)
- CNPJ do controlador. O cadastro público mostra 23.654.084/0001-82 com outro endereço; confirmar qual exibir.
- Prazo máximo de guarda dos dados.

## 3c. Catálogo online (17/11/2026)

- **Perfis de LED no ar:** a linha tem 20 produtos com página própria (`/produtos/perfis-de-led/…`). Medidas, códigos e acessórios foram transcritos do catálogo PDF. Falta a ARS conferir, usando **`docs/REVISAO-PERFIS-DE-LED.md`**. Os dados ficam em `public_html/includes/produtos.php`.
- **Categorias corrigidas:** passaram a seguir o sumário do catálogo (Perfis de LED, Coleção Bonalux, Arandelas, Pendentes, Embutidos, Módulos de sobrepor, Spots, Jardim, Vidros). `/categorias-de-luminarias/` redireciona para `/produtos/`.
- **Spots no ar:** a linha tem 14 famílias e 47 versões (`/produtos/spots/…`). Falta a ARS conferir, usando **`docs/REVISAO-SPOTS.md`**.
- **Pendentes no ar:** a linha tem 67 modelos em 32 páginas, com 10 linhas e coleções e 22 modelos avulsos. Os textos de apresentação das linhas são os oficiais do catálogo. Falta a ARS conferir, usando **`docs/REVISAO-PENDENTES.md`**, que tem 8 pontos de atenção.
- **Arandelas no ar:** a linha tem 14 modelos (`/produtos/arandelas/…`). Falta a ARS conferir, usando **`docs/REVISAO-ARANDELAS.md`** (7 pontos de atenção; a Iris está sem código no catálogo).
- **Embutidos no ar:** a linha tem 13 modelos em 5 páginas (`/produtos/embutidos/…`): spots de embutir ABS (MR11, MR16, AR70/PAR20, simples e duplos) e alumínio Axis 16 e 20 (1 a 4 focos). Falta a ARS conferir, usando **`docs/REVISAO-EMBUTIDOS.md`** (7 pontos de atenção, entre eles códigos fora do padrão nos duplos ABS e o Axis com um só código para branco e preto).
- **Módulos de sobrepor no ar:** a linha tem 12 modelos em 6 páginas (`/produtos/modulos-de-sobrepor/…`): Kube 16, Tube 16, Tube 70, Tube 20 e alumínio Apex 16 e 70 (1 a 4 focos). Falta a ARS conferir, usando **`docs/REVISAO-MODULOS-DE-SOBREPOR.md`** (8 pontos de atenção). O acabamento **CF** não tem nome no catálogo e aparece como `[CF: NOME A CONFIRMAR]`.
- **Jardim no ar:** a linha tem 17 modelos em 8 páginas (`/produtos/jardim/…`): Garden (espeto e embutido de solo), balizadores Oak, Alloy e Aris, Arandela G9, Tartaruga e Plafonier. Falta a ARS conferir, usando **`docs/REVISAO-JARDIM.md`** (10 pontos de atenção). Garden, Alloy e Aris aparecem com `[ACABAMENTOS A CONFIRMAR]`.
- **Vidros no ar:** a linha tem 16 modelos em 11 páginas (`/produtos/vidros/…`): 6 arandelas e 5 plafons de vidro (cada plafon em 2 tamanhos). Falta a ARS conferir, usando **`docs/REVISAO-VIDROS.md`** (7 pontos de atenção).
- **Coleção Bonalux no ar:** 31 modelos (63 combinações de tamanho) em 21 páginas (`/produtos/colecao-bonalux/…`): linhas Dritto, Piazza e Tuono, pendentes, plafons e arandelas com LED integrado. Falta a ARS conferir, usando **`docs/REVISAO-COLECAO-BONALUX.md`** (10 pontos de atenção, entre eles códigos repetidos em Stellare e Stella).
- **Catálogo completo online:** as 9 categorias do sumário têm páginas próprias.
- **Dados da contracapa do catálogo:**
  - O endereço (Estrada Joaquim de Souza Siqueira, 2099, Bairro Oratório, Socorro/SP) confirma o que o site usa.
  - Aparece um segundo telefone, (19) 99935-9225; falta definir se entra no site.
  - O e-mail impresso no catálogo é o `comercial@`, que foi descartado. Atualizar na próxima edição do PDF.

## 3d. SEO técnico (19/11/2026)

Feito no código; vale para o domínio final automaticamente.

- **Títulos com palavra-chave** em todas as páginas (≤ 60 caracteres) e **meta descriptions** com até 158 caracteres (`seo_desc()`).
- **Endereço único:** HTTP → HTTPS, `www` → sem `www`, `/index.php` → `/` e `produto.php?c=…` → URL amigável, todos com 301.
- **Dados estruturados:** Organization (com fundação, contato comercial, marcas ARS e Bonalux), WebSite, BreadcrumbList, ItemList nas categorias, Product em cada produto (marca Bonalux na coleção) e **FAQPage** na Home.
- **Links internos:** Home com as 9 linhas e perguntas frequentes; categorias com "Outras linhas"; cada produto liga aos 4 seguintes da linha (todo produto recebe ao menos 5 links); A ARS, Seja revendedor e Contato ligam às linhas.
- **Imagens:** todas com `width`/`height` (sem salto de layout) e sitemap de imagens.
- **IA:** `/llms.txt` com o resumo da empresa e a lista completa de produtos; `robots.txt` libera explicitamente GPTBot, ClaudeBot, PerplexityBot, Google-Extended e outros.
- **Validar com a ARS:** as respostas das perguntas frequentes da Home (montadas só com informações já publicadas).

**Para fazer na troca de domínio (precisa de acesso às contas):**
1. Cadastrar `arsiluminacao.com.br` no **Google Search Console** e no **Bing Webmaster Tools** e enviar `/sitemap.xml`.
2. Criar ou atualizar o **Perfil da Empresa no Google** (Google Meu Negócio) com o mesmo endereço, telefone e site. É o que mais pesa na busca local.
3. Conferir que `site_url` no `config.php` é `https://arsiluminacao.com.br` (sem `www`).
4. Redirecionar com 301 as URLs antigas do WordPress que tenham tráfego (ver relatório do Search Console do domínio antigo).

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
