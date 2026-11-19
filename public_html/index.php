<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/site.php';
require_once __DIR__ . '/includes/produtos.php';

/*
 * Perguntas frequentes: respostas só com informações já publicadas pela ARS (site, catálogo e
 * Instagram). Também vão no JSON-LD FAQPage, que ajuda buscadores e assistentes de IA.
 */
$faq = [
    ['Onde fica a ARS Iluminação?',
     'A fábrica fica na ' . e(ARS_SITE['address']['street']) . ', ' . e(ARS_SITE['address']['detail']) . '. A ARS fabrica soluções de iluminação em Socorro/SP desde 2014. <a href="/a-ars/">Conheça a ARS</a>.'],
    ['Quais produtos a ARS fabrica?',
     'O catálogo tem nove linhas: ' . linhas_links(true) . '. <a href="/produtos/">Ver todos os produtos</a>.'],
    ['A ARS entrega para todo o Brasil?',
     'Sim. A ARS envia para todo o Brasil, com estoque para pronta entrega. Para orçamento, use a página de <a href="/contato-e-orcamento/">contato e orçamento</a> ou o WhatsApp.'],
    ['Como revender produtos ARS na minha loja?',
     'Lojistas e distribuidores fazem o cadastro na página <a href="/seja-revendedor/">Seja revendedor</a>. A equipe comercial entra em contato e apresenta as condições.'],
    ['Onde comprar produtos ARS como consumidor final?',
     'Na página <a href="/onde-comprar/">Onde comprar</a>, ou enviando sua cidade pelo WhatsApp para a equipe comercial indicar a loja mais próxima.'],
    ['Como baixar o catálogo da ARS?',
     'Preencha nome, WhatsApp e e-mail no formulário <a href="#catalogo">Catálogo ARS</a>, no topo desta página, e o download do PDF é liberado.'],
];

$page = [
    'title'       => '',
    'seo_title'   => 'ARS Iluminação | Fabricante de luminárias e perfis de LED',
    'description' => 'ARS Iluminação: fabricante de soluções de iluminação em Socorro/SP, com entrega para todo o Brasil. Baixe o catálogo e fale com a equipe comercial.',
    'path'        => '/',
    'jsonld'      => [[
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(static fn($q) => [
            '@type' => 'Question',
            'name'  => $q[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => html_entity_decode(strip_tags($q[1]), ENT_QUOTES, 'UTF-8')],
        ], $faq),
    ]],
    'preload'     => [[
        'href'   => '/assets/img/hero-ars-fachada-frontal.webp',
        'srcset' => '/assets/img/hero-ars-fachada-frontal-768.webp 768w, /assets/img/hero-ars-fachada-frontal.webp 1920w',
    ]],
];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/instagram.php';

$expired = ($_GET['catalogo'] ?? '') === 'expirado';
$formError = ($_GET['erro'] ?? '') === '1';
$igPosts = instagram_posts(3);
?>
<section class="hero">
  <div class="hero__bg" aria-hidden="true">
    <img class="hero__slide hero__slide--a" src="/assets/img/hero-ars-fachada-frontal.webp"
         srcset="/assets/img/hero-ars-fachada-frontal-768.webp 768w, /assets/img/hero-ars-fachada-frontal.webp 1920w"
         sizes="100vw" alt="" width="1920" height="1080" fetchpriority="high">
    <img class="hero__slide hero__slide--b" src="/assets/img/hero-ars-fachada-lateral.webp"
         srcset="/assets/img/hero-ars-fachada-lateral-768.webp 768w, /assets/img/hero-ars-fachada-lateral.webp 1920w"
         sizes="100vw" alt="" width="1920" height="1080" loading="lazy">
  </div>
  <div class="hero__overlay" aria-hidden="true"></div>
  <div class="hero__grid" aria-hidden="true"></div>

  <?php site_header('overlay', '/'); ?>

  <main id="conteudo" class="wrap hero__content">
    <div>
      <div class="eyebrow">ARS Iluminação</div>
      <h1 class="hero__title">Ir além de iluminar <em>espaços.</em></h1>
      <p class="hero__lead">É levar luz às pessoas. Desde 2014, a ARS cria e fabrica em Socorro/SP soluções de iluminação com pronta entrega para todo o Brasil.</p>
      <div class="hero__actions">
        <a class="btn btn--orange" href="/seja-revendedor/">Seja revendedor</a>
        <a class="btn btn--ghost" href="/produtos/">Ver produtos</a>
      </div>
    </div>

    <div class="catalog-card" id="catalogo">
      <p class="catalog-card__tag">Catálogo ARS</p>
      <h2>Conheça nossas soluções.</h2>
      <div class="catalog-card__success" role="status" hidden>
        <p>Dados enviados. O download do catálogo começou.</p>
        <a class="btn btn--orange btn--block js-download-again" href="#">Baixar catálogo novamente <?= icon('arrow-down') ?></a>
        <p class="catalog-card__fine">O link fica disponível por 30 minutos.</p>
      </div>
      <div class="catalog-card__form">
        <p class="catalog-card__copy">Preencha seus dados para liberar o download.</p>
        <form class="catalog-form js-lead-form" action="/api/catalogo.php" method="post" novalidate data-kind="catalogo">
          <div class="field">
            <label for="f-nome">Nome</label>
            <input id="f-nome" name="nome" type="text" autocomplete="name" placeholder="Seu nome" required maxlength="120">
          </div>
          <div class="catalog-form__two">
            <div class="field">
              <label for="f-whatsapp">WhatsApp</label>
              <input id="f-whatsapp" name="whatsapp" type="tel" inputmode="numeric" autocomplete="tel-national" placeholder="(00) 00000-0000" required maxlength="15">
            </div>
            <div class="field">
              <label for="f-email">E-mail</label>
              <input id="f-email" name="email" type="email" autocomplete="email" placeholder="voce@empresa.com.br" required maxlength="160">
            </div>
          </div>
          <?= consent_field() ?>
          <div class="hp" aria-hidden="true">
            <label for="f-site">Não preencha este campo</label>
            <input id="f-site" name="site" type="text" tabindex="-1" autocomplete="off">
          </div>
          <button class="btn btn--orange btn--block btn--square" type="submit"><?= e(ARS_SITE['catalog']['label']) ?> <?= icon('arrow-down') ?></button>
          <p class="form-status" aria-live="polite"><?php
            if ($expired) echo 'O link de download expirou. Envie seus dados novamente para liberar o catálogo.';
            elseif ($formError) echo 'Confira os dados e tente novamente.';
          ?></p>
        </form>
      </div>
    </div>
  </main>
</section>

<section class="purpose" aria-label="Propósito da ARS">
  <div class="wrap purpose__inner">
    <div>
      <div class="purpose__bulb" aria-hidden="true"><?= icon('bulb', 34) ?></div>
      <p class="purpose__label">Levar luz, com propósito</p>
    </div>
    <p class="purpose__quote">Luz que orienta, traz clareza, revela caminhos e transforma a forma como os espaços são vividos.</p>
  </div>
</section>

<section class="section section--white" aria-labelledby="linhas-title">
  <div class="wrap">
    <div class="kicker">Linhas de produto</div>
    <h2 id="linhas-title">Luminárias e perfis de LED de fabricação própria.</h2>
    <p>Nove linhas para lojas, especificadores e instaladores, com ficha técnica, códigos e acabamentos de cada modelo.</p>
    <div class="category-grid">
      <?php foreach (ARS_CATEGORIAS as $slug => $cat): ?>
        <a class="category-card" href="/produtos/<?= e($slug) ?>/">
          <div class="category-card__img">
            <img src="/assets/img/produtos/categorias/<?= e($cat['imagem']) ?>" alt="<?= e($cat['nome']) ?> ARS Iluminação"<?= img_dim('/assets/img/produtos/categorias/' . $cat['imagem']) ?> loading="lazy" decoding="async">
          </div>
          <div class="category-card__body">
            <h3><?= e($cat['nome']) ?></h3>
            <p><?= e($cat['resumo']) ?></p>
            <span class="category-card__more">Ver <?= e(mb_strtolower($cat['nome'])) ?> <?= icon('arrow-up-right', 14) ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="instagram" aria-labelledby="instagram-title">
  <div class="wrap">
    <div class="instagram__head">
      <div>
        <div class="section-tag"><?= icon('instagram') ?> Últimas publicações</div>
        <h2 class="display" id="instagram-title">Trabalho que transforma <em>propósito em realidade.</em></h2>
        <p class="instagram__copy">Cada projeto carrega responsabilidade. Cada entrega, compromisso. Acompanhe os bastidores da fábrica e os lançamentos.</p>
      </div>
      <div class="instagram__brand">
        <img src="/assets/img/ars-logo-colorido.webp" alt="ARS Iluminação" width="480" height="221" loading="lazy">
        <a class="btn btn--orange" href="<?= e(ARS_SITE['instagram']['url']) ?>" target="_blank" rel="noreferrer">
          <?= icon('instagram') ?> Seguir <?= e(ARS_SITE['instagram']['handle']) ?> <?= icon('arrow-up-right', 14) ?>
        </a>
      </div>
    </div>

    <div class="instagram__posts">
      <?php if ($igPosts): foreach ($igPosts as $post): ?>
        <a class="ig-card" href="<?= e($post['permalink']) ?>" target="_blank" rel="noreferrer">
          <div class="ig-card__media">
            <img src="<?= e($post['image']) ?>" alt="" loading="lazy" decoding="async">
            <?php if ($post['video']): ?><span class="ig-card__badge">Reels</span><?php endif; ?>
          </div>
          <p class="ig-card__caption"><?= e(excerpt($post['caption']) ?: 'Ver publicação no Instagram') ?></p>
          <span class="ig-card__more">Ver no Instagram <?= icon('arrow-up-right', 14) ?></span>
        </a>
      <?php endforeach; else: foreach (ARS_INSTAGRAM_FALLBACK as $post): ?>
        <div class="ig-embed">
          <iframe src="<?= e($post['permalink']) ?>embed/" title="Publicação do Instagram: <?= e($post['caption']) ?>" loading="lazy" allow="encrypted-media" referrerpolicy="strict-origin-when-cross-origin"></iframe>
          <a class="ig-embed__link" href="<?= e($post['permalink']) ?>" target="_blank" rel="noreferrer">
            <span><?= e($post['caption']) ?></span>
            <span class="ig-card__more">Ver no Instagram <?= icon('arrow-up-right', 14) ?></span>
          </a>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<section class="section section--white" aria-labelledby="faq-title">
  <div class="wrap faq">
    <div class="kicker">Perguntas frequentes</div>
    <h2 id="faq-title">Dúvidas sobre a ARS.</h2>
    <?php foreach ($faq as [$pergunta, $resposta]): ?>
      <details class="faq__item">
        <summary><?= e($pergunta) ?></summary>
        <p><?= $resposta ?></p>
      </details>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
