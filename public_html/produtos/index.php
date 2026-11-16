<?php
declare(strict_types=1);

$page = [
    'title'       => 'Produtos',
    'description' => 'Explore o portfólio da ARS Iluminação por categoria e encontre soluções de iluminação para diferentes ambientes e aplicações.',
    'path'        => '/produtos/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

// No WordPress, "Ver categoria" apontava para páginas que ainda não existem (/pendentes/ etc.).
// Até elas serem aprovadas, o botão leva à seção da página Categorias.
$categories = [
    ['Pendentes', '[IMAGEM — PENDENTES]', '[Descrição comercial aprovada]', 'pendentes'],
    ['Perfis de LED', '[IMAGEM — PERFIS DE LED]', '[Descrição técnica e aplicações aprovadas]', 'perfis-de-led'],
    ['Spots', '[IMAGEM — SPOTS]', '[Descrição comercial aprovada]', 'spots'],
    ['Spots para trilho', '[IMAGEM — SPOTS PARA TRILHO]', '[Descrição técnica e aplicações aprovadas]', 'spots'],
    ['Arandelas', '[IMAGEM — ARANDELAS]', '[Descrição comercial aprovada]', 'arandelas'],
    ['Plafons e plafoniers', '[IMAGEM — PLAFONS]', '[Descrição comercial aprovada]', 'plafons'],
];

site_header('solid', '/produtos/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'ARS Iluminação',
      'Luminárias para <span>projetos que pedem mais.</span>',
      'Explore o portfólio da ARS por categoria e encontre soluções de iluminação para diferentes ambientes e aplicações.',
      ['title' => '[IMAGEM OU VÍDEO DE ABERTURA]', 'hint' => 'Inserir mídia oficial do portfólio']
  ); ?>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="kicker">Portfólio</div>
      <h2>Encontre sua solução.</h2>
      <p>Escolha uma categoria para apresentar produtos, aplicações e fichas técnicas.</p>
      <div class="cards cards--3">
        <?php foreach ($categories as [$name, $image, $text, $anchor]): ?>
          <article class="card card--product">
            <?= pending_media($image, '', 'light', 'card__pic') ?>
            <h3><?= e($name) ?></h3>
            <p><?= pending($text) ?></p>
            <a class="btn btn--orange btn--sm" href="/categorias-de-luminarias/#<?= e($anchor) ?>">Ver categoria</a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap reveal">
      <div class="kicker">Informação para especificar</div>
      <h2>Produto apresentado com clareza.</h2>
      <div class="two-col two-col--panels">
        <div class="panel">
          <h3>Ficha técnica</h3>
          <p><?= pending('[Medidas, potência, temperatura de cor, fluxo luminoso, acabamento, instalação e garantia — preencher com material oficial]') ?></p>
          <?= pending_media('[PDF / CATÁLOGO / FICHA TÉCNICA]', '', 'light', 'pending-media--doc') ?>
        </div>
        <div class="panel">
          <h3>Aplicações e compra</h3>
          <p><?= pending('[Ambientes indicados, disponibilidade, prazo e orientação comercial — validar]') ?></p>
          <a class="btn btn--orange" href="/contato-e-orcamento/">Solicitar orçamento</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="cta-panel">
        <div>
          <div class="eyebrow eyebrow--light">Atendimento comercial</div>
          <h2>Precisa de orientação para o seu projeto?</h2>
          <p><?= pending('[Texto comercial aprovado para lojistas, especificadores, arquitetos e distribuidores]') ?></p>
          <a class="btn btn--orange" href="/contato-e-orcamento/">Falar com a ARS</a>
        </div>
        <?= pending_media('[IMAGEM OU VÍDEO DE APLICAÇÃO]', '', 'dark') ?>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
