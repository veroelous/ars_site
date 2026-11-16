<?php
declare(strict_types=1);

$page = [
    'title'       => 'Categorias de luminárias',
    'description' => 'Categorias de luminárias da ARS Iluminação: pendentes, perfis de LED, spots, arandelas, plafons e plafoniers.',
    'path'        => '/categorias-de-luminarias/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

$categories = [
    ['pendentes', 'Pendentes', '[IMAGEM — PENDENTES]'],
    ['perfis-de-led', 'Perfis de LED', '[IMAGEM — PERFIS DE LED]'],
    ['spots', 'Spots e spots para trilho', '[IMAGEM — SPOTS E TRILHOS]'],
    ['arandelas', 'Arandelas', '[IMAGEM — ARANDELAS]'],
    ['plafons', 'Plafons', '[IMAGEM — PLAFONS]'],
    ['plafoniers', 'Plafoniers', '[IMAGEM — PLAFONIERS]'],
];

site_header('solid', '/categorias-de-luminarias/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Portfólio ARS',
      'Categorias de <span>luminárias.</span>',
      'Uma estrutura visual para organizar o portfólio por aplicação, estética e especificação técnica.',
      ['title' => '[IMAGEM OU VÍDEO DE ABERTURA]', 'hint' => 'Inserir mídia oficial do portfólio']
  ); ?>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="kicker">Escolha uma categoria</div>
      <h2>Soluções organizadas para especificar melhor.</h2>
      <div class="cards cards--3">
        <?php foreach ($categories as [$id, $name, $image]): ?>
          <article class="card card--product" id="<?= e($id) ?>">
            <?= pending_media($image, '', 'light', 'card__pic') ?>
            <h3><?= e($name) ?></h3>
            <p><?= pending('[Descrição aprovada]') ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap reveal">
      <div class="kicker">Padrão de apresentação</div>
      <h2>Cada produto com informação útil para a compra.</h2>
      <div class="two-col two-col--panels">
        <div class="panel">
          <h3>Ficha técnica</h3>
          <p><?= pending('[Medidas, potência, temperatura de cor, fluxo luminoso, acabamento, instalação e garantia — preencher com material oficial]') ?></p>
          <?= pending_media('[PDF / CATÁLOGO / FICHA TÉCNICA]', '', 'light', 'pending-media--doc') ?>
        </div>
        <div class="panel">
          <h3>Aplicações e compra</h3>
          <p><?= pending('[Ambientes indicados, disponibilidade, prazo e CTA comercial — validar]') ?></p>
          <a class="btn btn--orange" href="/contato-e-orcamento/">Solicitar orientação</a>
        </div>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
