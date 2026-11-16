<?php
/** Rodapé compartilhado, botão do WhatsApp e scripts. Fecha <body> e <html>. */
declare(strict_types=1);
?>
<footer class="site-footer">
  <div class="site-footer__group">
    <img src="/assets/img/grupo-ars-iluminacao.webp" alt="Grupo ARS Iluminação: ARS, Bonalux e RSG" width="1560" height="520" loading="lazy" decoding="async">
  </div>
  <div class="wrap">
    <div class="site-footer__main">
      <div>
        <a href="/" aria-label="ARS Iluminação — página inicial">
          <img src="/assets/img/ars-logo-branco.webp" alt="ARS Iluminação" width="480" height="221" class="site-footer__logo" loading="lazy">
        </a>
        <h2 class="site-footer__title">É levar luz <em>às pessoas.</em></h2>
        <div class="site-footer__links">
          <div>
            <div class="site-footer__label">Onde estamos</div>
            <a class="site-footer__link" href="<?= e(ARS_SITE['address']['mapsUrl']) ?>" target="_blank" rel="noreferrer">
              <?= icon('map-pin', 18, 'text-orange') ?>
              <span><?= e(ARS_SITE['address']['street']) ?><small><?= e(ARS_SITE['address']['detail']) ?></small></span>
            </a>
          </div>
          <div>
            <div class="site-footer__label">Conecte-se</div>
            <a class="site-footer__link" href="<?= e(ARS_SITE['instagram']['url']) ?>" target="_blank" rel="noreferrer">
              <?= icon('instagram', 18, 'text-orange') ?>
              <span><?= e(ARS_SITE['instagram']['handle']) ?> <?= icon('arrow-up-right', 14) ?></span>
            </a>
          </div>
          <div>
            <div class="site-footer__label">E-mail</div>
            <a class="site-footer__link" href="mailto:<?= e(ARS_SITE['email']) ?>">
              <?= icon('mail', 18, 'text-orange') ?>
              <span class="break"><?= e(ARS_SITE['email']) ?></span>
            </a>
          </div>
        </div>
      </div>
      <img src="/assets/img/mascote-ars.webp" alt="" width="900" height="1027" class="site-footer__mascot" loading="lazy" decoding="async">
    </div>
    <nav class="site-footer__nav" aria-label="Menu do rodapé">
      <?php foreach (ARS_NAV as $item): ?>
        <a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="site-footer__bottom">
      <span>© <?= date('Y') ?> ARS Iluminação</span>
      <span><?= e(ARS_SITE['footerNote']) ?></span>
    </div>
  </div>
</footer>
<a class="whatsapp-float" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noreferrer" aria-label="Falar com a ARS Iluminação pelo WhatsApp" data-track="whatsapp">
  <?= icon('whatsapp', 32) ?>
</a>
<script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
</body>
</html>
