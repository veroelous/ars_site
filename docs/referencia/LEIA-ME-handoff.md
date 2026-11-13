# ARS Iluminação — pacote de referência para Claude Code

Captura em 13/11/2026 do site público: https://oficial.arsiluminacao.com.br/

Este pacote reúne os arquivos de mídia locais, o HTML entregue publicamente pelas cinco páginas, o CSS adicional publicado no WordPress e o código do projeto Sites anterior. Ele é uma referência de reconstrução, não um backup do banco de dados nem uma exportação editável do Elementor.

## Onde encontrar

- `publicado/home.html`, `a-ars.html`, `produtos.html`, `categorias.html`, `contato.html`: respostas HTML públicas do WordPress. Contêm a estrutura e os textos que estavam publicados no momento da coleta. Também contêm URLs e scripts do WordPress: não os use diretamente como aplicação de produção.
- `publicado/css-adicional.css`: CSS extraído do campo nativo de CSS adicional. Há regras para largura total, tipografia, cabeçalho e WhatsApp.
- `assets/`: arquivos oficiais disponíveis localmente, incluindo duas fotos da fábrica, logos, mascote e catálogo PDF. Use caminhos locais no projeto novo e preserve as proporções e versões originais.
- `referencia-original/`: `page.tsx`, `layout.tsx`, `globals.css` e `index-sites.html` do projeto anterior no Sites. Servem como contexto histórico; o WordPress publicado é a referência principal para o estado atual. `index-sites.html` é grande e contém imagens em base64.

## Páginas e navegação

| Página | URL atual | Arquivo |
|---|---|---|
| Início | `/` | `publicado/home.html` |
| A ARS | `/a-ars/` | `publicado/a-ars.html` |
| Produtos | `/produtos/` | `publicado/produtos.html` |
| Categorias | `/categorias-de-luminarias/` | `publicado/categorias.html` |
| Contato e orçamento | `/contato-e-orcamento/` | `publicado/contato.html` |

As páginas internas ainda têm campos entre colchetes para textos, fotos e vídeos a serem aprovados. Esses marcadores são parte do estado atual; não devem virar alegações comerciais inventadas.

## Contrato visual e funcional

- Base visual: azul/roxo escuro, laranja, branco; família Manrope com fallback sem serifa. Use os valores efetivos dos arquivos HTML e CSS como referência, pois há pequenas variações entre a Home e páginas internas.
- Home: hero em tela cheia com alternância das duas fotografias oficiais da fábrica; logo ARS, Instagram, menu, título “Ir além de iluminar espaços.”, texto institucional e cartão do catálogo.
- Formulário do catálogo: nome, WhatsApp e e-mail, validação antes do download. No WordPress, Contact Form 7 e Flamingo cuidam do fluxo e armazenamento. O HTML público não contém configurações internas desses plugins. Uma recriação funcional precisa implementar armazenamento seguro, consentimento, validação e entrega do PDF; não considere suficiente apenas imitar o formulário.
- Faixa laranja do propósito, seção das três publicações recentes do Instagram, rodapé com endereço, Instagram, marcas do Grupo ARS e mascote. O feed atual depende do plugin gratuito Smash Balloon e da conexão da conta; dados do feed no HTML são uma captura, não um mecanismo de atualização.
- WhatsApp flutuante: link atual está no HTML da Home; círculo verde de 60 px no desktop e 56 px no celular, com ícone branco. O telefone do link deve ser validado com a ARS antes de migrar para outro domínio.
- Responsividade: conferir largura total e ausência de rolagem horizontal em desktop, tablet e celular. No Elementor, o widget HTML necessitou `width:100vw` e margens `calc(50% - 50vw)`. Não aplique essa regra ao próprio botão flutuante.
- Animações: transição suave das duas imagens da Hero e entradas discretas nas páginas internas; respeitar `prefers-reduced-motion`.
- A Expolux terminou. Não devolver à Hero chamada, data, local ou link do evento. Referências antigas ainda existentes fora da Hero devem ser revisadas editorialmente antes da publicação em novo domínio.

## Restrições e decisões de migração

Preserve logotipos, fotos, catálogo e textos oficiais. Não crie resultados comerciais, endereço, contatos, descrições técnicas ou categorias além do material aprovado. O endereço atual e contatos constam no HTML público, mas confirme-os com o responsável antes da troca de domínio. O e-mail `comercial@arsiluminacao.com.br` foi aprovado para manutenção; o telefone antigo `(19) 98304-7385` e o endereço antigo da Rua São João, 33 foram explicitamente descartados.

O site atual usa WordPress, Hello Elementor, Elementor gratuito, Contact Form 7, Flamingo e Instagram Feed gratuito. Não é necessário comprar Elementor Pro para reproduzir o layout. Se o destino continuar em WordPress, prefira componentes reutilizáveis e CSS compartilhado; evite duplicar cabeçalho e rodapé em cada página.

## Instrução inicial para o Claude Code

> Leia este LEIA-ME e inspecione `publicado/` e `assets/`. Reconstrua as cinco páginas responsivas, tomando o WordPress público como fonte do estado atual. Reutilize os arquivos locais, preserve os textos existentes e represente honestamente os campos pendentes. Implemente o formulário com validação, persistência e download condicionado ao envio válido; crie integração dinâmica de três posts do Instagram com configuração separada. Não dependa de URLs de mídia do WordPress ou do Sites no produto final. Compare visualmente desktop e celular com o site atual e documente o que exigir credenciais, configuração de conta ou aprovação editorial.

## Limites desta coleta

Não há exportação do banco WordPress, JSON do Elementor, configuração privada dos formulários, histórico dos leads nem credenciais de Instagram neste pacote. Nunca copie dados de contatos recebidos para um repositório. Os HTMLs públicos podem conter identificadores de versão e URLs absolutas do ambiente temporário; substitua-os na implementação.
