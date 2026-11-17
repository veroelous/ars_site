# CLAUDE.md — Site ARS Iluminação

Contexto para qualquer sessão do Claude que trabalhe neste repositório. Leia antes de mudar algo.

## O projeto

Site institucional e canal de aquisição de clientes B2B da **ARS Iluminação**, fabricante de luminárias e perfis de LED em Socorro/SP (desde 2014). Os públicos são lojistas e distribuidores (principal), arquitetos e especificadores, instaladores e consumidor final (este é direcionado para "Onde comprar").

- **Teste:** https://dev.arsiluminacao.com.br. Fica fora do Google: qualquer host que começa com `dev.` recebe `noindex` automático.
- **Produção:** `arsiluminacao.com.br`, ainda não migrado. Hoje roda um WordPress em `oficial.arsiluminacao.com.br`.
- **Plano estratégico** (gaps, SEO, fases): artifact "Plano de Aquisição ARS". **Pendências:** `docs/PENDENCIAS.md`.

## Regras de infraestrutura (Host4) — obrigatórias

Hospedagem cPanel com Apache, PHP 8.2, MySQL e `.htaccess`. Regras definidas pela Host4:

- Use **HTML5, CSS3 e JavaScript puro**. **Sem** Node.js, npm, build tools ou frameworks.
- Biblioteca externa só via CDN e só se for realmente necessária. Prefira não usar.
- **PHP só onde há processamento no servidor:** formulários, e-mail, autenticação, APIs com chave secreta, gravação de dados. Hoje o PHP também inclui cabeçalho e rodapé compartilhados.
- **MySQL só com necessidade real.** Hoje não é usado: os contatos ficam em arquivo JSONL. Se for usado, sempre com PDO e prepared statements.
- **Segurança:** valide toda entrada, proteja contra XSS (use `e()`) e CSRF (verificação de origem), e nunca exponha segredos no JavaScript.
- O projeto precisa funcionar só copiando `public_html/` para a hospedagem.

## Estrutura

```
public_html/                 tudo que vai para o servidor
  index.php, a-ars/, produtos/, seja-revendedor/, onde-comprar/,
  contato-e-orcamento/, politica-de-privacidade/, 404.php
  produtos/categoria.php     /produtos/<categoria>/ (rewrite no .htaccess)
  produtos/produto.php       /produtos/<categoria>/<produto>/
  includes/site.php          dados da empresa, menu (ARS_NAV), páginas (ARS_PAGES), revendas
  includes/produtos.php      catálogo: categorias, grupos, perfis e spots
  includes/bootstrap.php     config privada, helpers (e(), asset(), pending(), consent_field())
  includes/head.php          <head>, SEO, JSON-LD (Organization, Breadcrumb, Product), GA4 opcional
  includes/leads.php         validação, gravação de contatos, aviso por e-mail, token do catálogo
  api/*.php                  catalogo, catalogo-download, contato, revendedor
  admin/leads.php            exportação CSV (HTTP Basic, credenciais na config)
  private/                   catálogo PDF, config.php e leads (bloqueado pelo .htaccess)
  assets/css|js|img|fonts    style.css, main.js, imagens WebP, fonte Manrope local
docs/                        PENDENCIAS.md, REVISAO-*.md (conferência pela ARS), referencia/
.github/workflows/deploy.yml publicação automática por FTP
```

## Publicação

- **Fluxo:** cada `git push` na branch `claude/wonderful-planck-dkgcrz` (alterando `public_html/`) dispara o GitHub Actions. Ele confere a sintaxe do PHP e envia por FTPS para o subdomínio `dev.`.
- **Segredos:** `FTP_SERVER`, `FTP_USERNAME` e `FTP_PASSWORD` ficam no GitHub. Nunca coloque credenciais no repositório nem no chat.
- **O deploy nunca envia nem apaga** `private/config.php`, `private/leads/`, `cache/` e `ratelimit/`.
- **Configuração no servidor:** fica em `private/config.php`, com modelo em `includes/config.example.php`. Não está no Git.
- **Cache nginx da Host4:** o servidor guarda as páginas. As páginas PHP mandam `Cache-Control: no-cache` e `X-Accel-Expires: 0`. Se uma página continuar antiga depois do deploy, peça para limpar o cache em cPanel → NGINX Caching.
- **Depois de publicar,** confira no ar com `curl` (status das páginas e conteúdo novo). Para testar sem o cache, acrescente `?x=123` à URL.

## Testar localmente

```bash
php -S 127.0.0.1:8080 -t public_html
```

O servidor embutido do PHP não lê o `.htaccess`, então as rotas de produto e o `robots.txt`/`sitemap.xml` não funcionam por ele. Para testar essas rotas, use um router que imite o `.htaccess`. Para cada mudança:
- rode `php -l` nos arquivos alterados e `node --check public_html/assets/js/main.js`;
- teste as páginas em 1440 px e 390 px com Playwright e confira que não há rolagem horizontal;
- teste os formulários: inválido, válido, sem JavaScript e honeypot.

Nunca deixe um `private/config.php` de teste nem leads de teste no commit.

## Regras de conteúdo (importantes)

- **Não invente** alegações comerciais, números, clientes, prazos, condições, endereço ou contatos. Use só material oficial da ARS: catálogo PDF, Instagram, site antigo e o que o cliente enviar.
- **Conteúdo ainda não aprovado** aparece com o marcador visível `[ENTRE COLCHETES]`, usando `pending()` e `pending_media()`. Registre cada um em `docs/PENDENCIAS.md`.
- **E-mail oficial do site e dos avisos de lead:** `arsiluminacao@gmail.com`. **O `comercial@arsiluminacao.com.br` foi descartado.**
- **Dados fora do site:** o endereço antigo (Rua São João, 33) e o telefone (19) 98304-7385 foram descartados. O 2º telefone do catálogo, (19) 99935-9225, ainda não foi aprovado para o site.
- **Expolux:** o evento terminou. Não use mais o Expolux como chamada.
- **Tom:** direto e técnico, em português do Brasil. O público é B2B.

## Catálogo online (como adicionar uma linha)

A fonte é `public_html/private/catalogo-ars-iluminacao.pdf` (68 páginas, texto em curvas, sem texto selecionável). Sumário: Perfis de LED p.3 · Coleção Bonalux p.13 · Arandelas p.22 · Pendentes p.27 · Embutidos p.45 · Módulos de sobrepor p.47 · Spots p.49 · Jardim p.61 · Vidros p.66.

1. **Ler as páginas:** `pdftoppm -r 100 -png -f N -l M <pdf> pg`, depois leia as imagens e transcreva nome, medidas, códigos, acabamentos, soquete e trilho.
2. **Fotos:** `pdfimages -png -p -f N -l M <pdf> x` e `pdfimages -list …` para mapear. A foto principal tem um `smask` logo depois (combine os dois em RGBA). Gere um contact sheet para identificar cada foto, recorte pelo alfa e salve em WebP (≤ 900 px) em `assets/img/produtos/<categoria>/`.
3. **Dados:** cadastre em `includes/produtos.php`, ligue `'online' => true` na categoria e defina os grupos em `ARS_TIPOS`. Os perfis usam `perfil()` e `perfil_codigos()`; os spots usam `spot()` (família com versões).
4. **Layout novo:** se o formato for diferente (nem perfil nem spot), crie o ramo em `produto.php` e `produto_resumo()`.
5. **Conferência:** gere `docs/REVISAO-<LINHA>.md` com tabela ☐ por produto e pontos de atenção (códigos repetidos, siglas ambíguas). Atualize `docs/PENDENCIAS.md`.
6. **Resultado:** o sitemap inclui os produtos automaticamente. Teste local e no ar.

**Feito:** Perfis de LED (20), Spots (14 famílias, 47 versões), Pendentes (32 páginas, 67 modelos; usam `linha()`, com tipo de peça, specs por versão e paleta própria) e Arandelas (14 modelos; `linha()` com `'categoria' => 'arandelas'` no `$base`). **Próximos:** Embutidos, Módulos de sobrepor, Jardim, Vidros, Coleção Bonalux.

A skill reutilizável **catalogo-pdf-para-site** tem os scripts de extração de fotos, de gravação em WebP e da lista de conferência.

**Siglas de acabamento:** BR branco, PT preto, AL alumínio, CB cobre (por confirmar), DR dourado, CH/CP champagne. A paleta de 8 cores (Bronze AVL, Verde AVL, Preto, Pedra, Dourado, Champagne, Branco, Off White) usa as chaves internas BZ, VD, PT, PD, DR, CP, BR e OW. Cores extras da Iris: AZ Azul Bebê, RS Rosa, AB Abacate.

## Commits

Mensagens em português, descrevendo o que muda para o site. Trabalhe na branch `claude/wonderful-planck-dkgcrz`. Não abra PR sem pedido do usuário.
