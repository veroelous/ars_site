<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/produtos.php';

$page = [
    'title'       => 'Produtos',
    'description' => 'Portfólio da ARS Iluminação: perfis de LED, coleção Bonalux, arandelas, pendentes, embutidos, módulos de sobrepor, spots, jardim e vidros. Fabricante em Socorro/SP.',
    'path'        => '/produtos/',
    'image'       => '/assets/img/produtos/categorias/perfis-de-led.webp',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

$totais = [];
foreach (ars_produtos() as $prod) {
    $totais[$prod['categoria']] = ($totais[$prod['categoria']] ?? 0) + produto_modelos($prod);
}

site_header('solid', '/produtos/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Portfólio ARS',
      'Luminárias para <span>projetos que pedem mais.</span>',
      'Nove linhas de produtos para lojas, especificadores e instaladores: de perfis de LED a pendentes, spots e iluminação de jardim.',
      ['image' => '/assets/img/produtos/categorias/pendentes.webp', 'alt' => 'Pendente ARS Iluminação', 'width' => 700, 'height' => 987],
      ['href' => '/produtos/perfis-de-led/', 'label' => 'Ver perfis de LED']
  ); ?>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="kicker">Linhas de produto</div>
      <h2>Encontre sua solução.</h2>
      <div class="category-grid">
        <?php foreach (ARS_CATEGORIAS as $slug => $cat): ?>
          <?php $online = !empty($cat['online']); ?>
          <a class="category-card<?= $online ? '' : ' category-card--catalog' ?>" href="<?= $online ? '/produtos/' . e($slug) . '/' : '/#catalogo' ?>">
            <div class="category-card__img">
              <img src="/assets/img/produtos/categorias/<?= e($cat['imagem']) ?>" alt="<?= e($cat['nome']) ?> ARS Iluminação" loading="lazy" decoding="async">
            </div>
            <div class="category-card__body">
              <h3><?= e($cat['nome']) ?></h3>
              <p><?= e($cat['resumo']) ?></p>
              <span class="category-card__more">
                <?= $online ? 'Ver ' . (int) ($totais[$slug] ?? 0) . ' modelos' : 'Ver no catálogo em PDF' ?>
                <?= icon($online ? 'arrow-up-right' : 'arrow-down', 14) ?>
              </span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap reveal">
      <div class="cta-panel">
        <div>
          <div class="eyebrow eyebrow--light">Atendimento comercial</div>
          <h2>Precisa de orientação para o seu projeto?</h2>
          <p>A equipe da ARS ajuda a escolher modelos, acabamentos e quantidades para lojas, obras e projetos de iluminação.</p>
          <a class="btn btn--orange" href="/contato-e-orcamento/">Falar com a ARS</a>
          <a class="btn btn--ghost" href="/seja-revendedor/">Seja revendedor</a>
        </div>
        <img class="cta-panel__img" src="/assets/img/produtos/categorias/spots.webp" alt="" loading="lazy" width="423" height="170">
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
