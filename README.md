# ARS Iluminação — site institucional

Site da ARS Iluminação em **HTML, CSS, JavaScript puro e PHP 8.2**, feito para hospedagem cPanel convencional (Host4). Não usa Node.js, npm, build nem banco de dados: publicar é copiar a pasta `public_html/`.

## Páginas

| Página | URL | Arquivo |
|---|---|---|
| Início | `/` | `public_html/index.php` |
| A ARS | `/a-ars/` | `public_html/a-ars/index.php` |
| Produtos | `/produtos/` | `public_html/produtos/index.php` |
| Categorias | `/categorias-de-luminarias/` | `public_html/categorias-de-luminarias/index.php` |
| Contato e orçamento | `/contato-e-orcamento/` | `public_html/contato-e-orcamento/index.php` |

As URLs são as mesmas do WordPress atual.

## Estrutura

```
public_html/
  index.php, a-ars/, produtos/ ...   páginas (PHP só para incluir cabeçalho e rodapé)
  assets/css/style.css               visual completo (cores da marca no topo)
  assets/js/main.js                  máscara do WhatsApp, validação e envio dos formulários
  assets/img/, assets/fonts/         imagens otimizadas (WebP) e fonte Manrope local
  includes/site.php                  contatos, endereço, WhatsApp, menu — edite aqui
  includes/                          cabeçalho, rodapé, formulários, Instagram (bloqueada ao público)
  api/catalogo.php                   formulário do catálogo → grava contato e libera o PDF
  api/catalogo-download.php          entrega o PDF só com link assinado (30 min)
  api/contato.php                    formulário de contato
  admin/leads.php                    exportação dos contatos em CSV (usuário e senha)
  private/                           catálogo PDF, configuração e contatos (bloqueada ao público)
  .htaccess, robots.php, sitemap.php, 404.php
```

## Configuração no servidor (uma vez)

1. Copie `public_html/includes/config.example.php` para **`/home/USUARIO/ars_private/config.php`**, fora do public_html (recomendado), ou para `public_html/private/config.php`.
2. Preencha:
   - `catalog_secret`: gere no Terminal do cPanel com `openssl rand -hex 32`;
   - `notify_email`: quem recebe o aviso de cada contato;
   - `mail_from`: um e-mail do domínio;
   - `admin_user` e `admin_pass_hash`: usuário e senha da exportação de contatos;
   - `instagram_token`: opcional.
3. Se usar `ars_private/` fora do public_html, mova também o `catalogo-ars-iluminacao.pdf` para lá.
4. No cPanel, em Domínios, ative **"Forçar redirecionamento HTTPS"**.

O `config.php` real e os contatos recebidos **nunca** vão para o Git (ver `.gitignore`).

## Publicação automática (GitHub → Host4)

O arquivo `.github/workflows/deploy.yml` envia `public_html/` por FTP seguro a cada atualização da branch de desenvolvimento. Configure uma vez, no GitHub:
- **Settings → Secrets and variables → Actions → Secrets:** `FTP_SERVER`, `FTP_USERNAME` e `FTP_PASSWORD`.
- **Variáveis (opcional):** `FTP_SERVER_DIR`, a pasta de destino, caso a conta FTP não abra direto na raiz do site.

A publicação nunca apaga `config.php`, os contatos nem o cache. Também dá para publicar à mão, enviando a pasta `public_html/` pelo Gerenciador de Arquivos.

## Formulários e contatos

- **Validação:** feita no navegador e repetida no servidor, com consentimento LGPD, campo-armadilha contra robôs, limite de envios por IP e verificação de origem.
- **Sem JavaScript:** os formulários funcionam também com o JavaScript desligado.
- **Gravação e aviso:** cada contato é gravado em `private/leads/leads.jsonl` e avisado por e-mail para `notify_email`.
- **Exportação:** acesse `/admin/leads.php` com o usuário e a senha da configuração; abre direto no Excel.

## Instagram

Com `instagram_token`, as 3 últimas publicações são buscadas no servidor e guardadas em cache, então o token não aparece no navegador. Sem token, aparecem os embeds definidos em `ARS_INSTAGRAM_FALLBACK` (`includes/site.php`). O token de longa duração vence em 60 dias; veja `docs/PENDENCIAS.md`.

## SEO

O site já tem:
- título, descrição e canonical por página;
- Open Graph;
- dados estruturados da empresa;
- `sitemap.xml` e `robots.txt` gerados conforme o domínio.

Endereços que começam com `dev.` recebem automaticamente `noindex` e `robots.txt` bloqueado, para o site de teste não concorrer com o oficial.

## Testar localmente

```bash
php -S 127.0.0.1:8080 -t public_html
```

O servidor embutido do PHP não lê o `.htaccess`, então use as URLs com barra final (`/a-ars/`).
