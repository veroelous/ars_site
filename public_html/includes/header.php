<?php
/** Cabeçalho do site. "overlay" = sobre a Hero da Home; "solid" = barra azul das páginas internas. */
declare(strict_types=1);

function site_header(string $variant = 'solid', string $current = ''): void
{
    ?>
<header class="site-header site-header--<?= e($variant) ?>">
  <div class="site-header__inner wrap">
    <a href="/" class="site-header__brand" aria-label="ARS Iluminação — página inicial">
      <img src="/assets/img/ars-logo-branco.webp" alt="ARS Iluminação" width="480" height="221" class="site-header__logo">
    </a>
    <nav class="site-nav" aria-label="Menu principal">
      <?php foreach (ARS_NAV as $item): ?>
        <a href="<?= e($item['href']) ?>"<?= $current === $item['href'] ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
      <?php endforeach; ?>
    </nav>
    <a class="pill-link" href="<?= e(ARS_SITE['instagram']['url']) ?>" target="_blank" rel="noreferrer">
      <?= icon('instagram', 16, 'text-orange') ?>
      <span class="pill-link__text"><?= e(ARS_SITE['instagram']['handle']) ?></span>
      <?= icon('arrow-up-right', 14) ?>
    </a>
  </div>
</header>
    <?php
}

/** Abertura padrão das páginas internas (Hero azul + mídia pendente). */
function page_hero(string $eyebrow, string $titleHtml, string $lead, array $media, ?array $cta = null): void
{
    ?>
<section class="page-hero">
  <div class="wrap page-hero__inner reveal">
    <div>
      <div class="eyebrow eyebrow--light"><?= e($eyebrow) ?></div>
      <h1><?= $titleHtml ?></h1>
      <p class="page-hero__lead"><?= e($lead) ?></p>
      <?php if ($cta): ?>
        <a class="btn btn--orange" href="<?= e($cta['href']) ?>"><?= e($cta['label']) ?></a>
      <?php endif; ?>
    </div>
    <?= pending_media($media['title'], $media['hint'] ?? '', 'dark') ?>
  </div>
</section>
    <?php
}
