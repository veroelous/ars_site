<?php
/** Página de uma categoria de produtos: /produtos/<categoria>/ (via .htaccess). */
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/produtos.php';

$slugCat = is_string($_GET['c'] ?? null) ? $_GET['c'] : '';
$cat = ARS_CATEGORIAS[$slugCat] ?? null;
if (!$cat || empty($cat['online'])) {
    require dirname(__DIR__) . '/404.php';
    exit;
}

$grupos = ars_produtos_por_tipo($slugCat);
$total = array_sum(array_map('count', $grupos));

$page = [
    'title'       => $cat['nome'],
    'description' => $cat['descricao'] . ' Fabricante em Socorro/SP, com entrega para todo o Brasil.',
    'path'        => '/produtos/' . $slugCat . '/',
    'image'       => '/assets/img/produtos/categorias/' . $cat['imagem'],
    'breadcrumbs' => [['Produtos', '/produtos/'], [$cat['nome'], '/produtos/' . $slugCat . '/']],
    'jsonld'      => [[
        '@context' => 'https://schema.org',
        '@type'    => 'ItemList',
        'name'     => $cat['nome'] . ' ARS Iluminação',
        'itemListElement' => array_values(array_map(
            static function ($slug, $i) use ($slugCat) {
                $p = ars_produtos()[$slug];
                return ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $p['nome'], 'url' => ars_site_url() . produto_url($slug, $p)];
            },
            array_keys(array_merge(...array_values($grupos))),
            range(0, $total - 1)
        )),
    ]],
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

site_header('solid', '/produtos/');
breadcrumbs($page['breadcrumbs']);
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Linha ARS · ' . $total . ' modelos',
      e($cat['nome']) . ' <span>para cada projeto.</span>',
      $cat['descricao'],
      ['image' => '/assets/img/produtos/categorias/' . $cat['imagem'], 'alt' => $cat['nome'] . ' ARS Iluminação', 'width' => 900, 'height' => 602],
      ['href' => '#modelos', 'label' => 'Ver modelos']
  ); ?>

  <nav class="type-tabs" aria-label="Tipos de perfil">
    <div class="wrap">
      <?php foreach ($grupos as $tipo => $itens): ?>
        <a href="#<?= e($tipo) ?>"><?= e(ARS_TIPOS_PERFIL[$tipo]['nome']) ?> <small><?= count($itens) ?></small></a>
      <?php endforeach; ?>
    </div>
  </nav>

  <div id="modelos">
    <?php foreach ($grupos as $tipo => $itens): ?>
      <section class="section product-group<?= $tipo === 'embutir' || $tipo === 'piso' ? '' : ' section--white' ?>" id="<?= e($tipo) ?>">
        <div class="wrap">
          <h2><?= e(ARS_TIPOS_PERFIL[$tipo]['nome']) ?></h2>
          <p><?= e(ARS_TIPOS_PERFIL[$tipo]['uso']) ?></p>
          <div class="product-grid">
            <?php foreach ($itens as $slug => $p): ?>
              <a class="product-card" href="<?= e(produto_url($slug, $p)) ?>">
                <div class="product-card__img">
                  <img src="<?= e(produto_imagem($slug, $p)) ?>" alt="<?= e($p['nome']) ?> ARS" loading="lazy" decoding="async">
                </div>
                <h3><?= e($p['nome']) ?></h3>
                <p class="product-card__spec"><?= e($p['largura']) ?> × <?= e($p['altura']) ?> · 1, 2 e 3 m</p>
                <?php if (!empty($p['destaques'])): ?>
                  <p class="product-card__tag"><?= e($p['destaques'][0]) ?></p>
                <?php endif; ?>
                <span class="product-card__more">Ver ficha técnica <?= icon('arrow-up-right', 14) ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endforeach; ?>
  </div>

  <section class="section">
    <div class="wrap reveal">
      <div class="cta-panel">
        <div>
          <div class="eyebrow eyebrow--light">Para lojistas, instaladores e projetos</div>
          <h2>Precisa de quantidade ou de um modelo específico?</h2>
          <p>Fale com a equipe comercial da ARS para orçamento, disponibilidade e condições de revenda.</p>
          <a class="btn btn--orange" href="<?= e(produto_whatsapp('portfólio de ' . mb_strtolower($cat['nome']))) ?>" target="_blank" rel="noreferrer" data-track="whatsapp">Pedir orçamento</a>
          <a class="btn btn--ghost" href="/seja-revendedor/">Seja revendedor</a>
        </div>
        <img class="cta-panel__img" src="/assets/img/produtos/perfis-de-led/perfil-de-sobrepor-75x50.webp" alt="" loading="lazy" width="900" height="565">
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
