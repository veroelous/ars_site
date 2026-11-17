<?php
/** Página de produto: /produtos/<categoria>/<produto>/ (via .htaccess). */
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/produtos.php';

$slugCat = is_string($_GET['c'] ?? null) ? $_GET['c'] : '';
$slug = is_string($_GET['p'] ?? null) ? $_GET['p'] : '';
$cat = ARS_CATEGORIAS[$slugCat] ?? null;
$p = $cat ? ars_produto($slugCat, $slug) : null;
if (!$p) {
    require dirname(__DIR__) . '/404.php';
    exit;
}

$url = produto_url($slug, $p);
$img = produto_imagem($slug, $p);
$tipoInfo = ARS_TIPOS_PERFIL[$p['tipo']];
$acabamentos = implode(', ', array_map('mb_strtolower', ARS_ACABAMENTOS));
$tabelas = $p['codigosVariantes'] ?? ['' => $p['codigos']];
$todosCodigos = [];
foreach ($tabelas as $t) {
    foreach ($t as $porComprimento) {
        array_push($todosCodigos, ...array_values($porComprimento));
    }
}

$descricao = sprintf(
    '%s ARS para fita de LED: %s × %s, comprimentos de 1, 2 e 3 m, acabamentos %s.%s Fabricante em Socorro/SP.',
    $p['nome'],
    $p['largura'],
    $p['altura'],
    $acabamentos,
    !empty($p['destaques']) ? ' ' . implode('. ', $p['destaques']) . '.' : ''
);

// Outros modelos do mesmo tipo (até 4).
$relacionados = array_slice(array_filter(
    ars_produtos(),
    static fn($r, $s) => $s !== $slug && $r['categoria'] === $p['categoria'] && $r['tipo'] === $p['tipo'],
    ARRAY_FILTER_USE_BOTH
), 0, 4, true);

$page = [
    'title'       => $p['nome'],
    'description' => $descricao,
    'path'        => $url,
    'image'       => $img,
    'breadcrumbs' => [['Produtos', '/produtos/'], [$cat['nome'], '/produtos/' . $slugCat . '/'], [$p['nome'], $url]],
    'jsonld'      => [[
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $p['nome'],
        'description' => $descricao,
        'image'       => ars_site_url() . $img,
        'brand'       => ['@type' => 'Brand', 'name' => 'ARS Iluminação'],
        'manufacturer' => ['@type' => 'Organization', 'name' => 'ARS Iluminação'],
        'category'    => $cat['nome'],
        'mpn'         => $todosCodigos[0] ?? null,
        'additionalProperty' => [
            ['@type' => 'PropertyValue', 'name' => 'Largura', 'value' => $p['largura']],
            ['@type' => 'PropertyValue', 'name' => 'Altura', 'value' => $p['altura']],
            ['@type' => 'PropertyValue', 'name' => 'Comprimentos', 'value' => '1 m, 2 m, 3 m'],
            ['@type' => 'PropertyValue', 'name' => 'Acabamentos', 'value' => implode(', ', ARS_ACABAMENTOS)],
        ],
    ]],
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

site_header('solid', '/produtos/');
breadcrumbs($page['breadcrumbs']);
?>
<main id="conteudo" class="inner-page">
  <section class="product-hero">
    <div class="wrap product-hero__inner">
      <div class="product-hero__img">
        <img src="<?= e($img) ?>" alt="<?= e($p['nome']) ?> ARS Iluminação" width="900" height="600" fetchpriority="high">
      </div>
      <div class="product-hero__info">
        <div class="kicker"><?= e($cat['nome']) ?> · <?= e(ucfirst($p['tipo'])) ?></div>
        <h1><?= e($p['nome']) ?></h1>
        <p class="product-hero__lead"><?= e($tipoInfo['uso']) ?></p>
        <ul class="spec-chips">
          <li><strong><?= e($p['largura']) ?></strong> largura</li>
          <li><strong><?= e($p['altura']) ?></strong> altura</li>
          <li><strong>1, 2 e 3 m</strong> comprimentos</li>
        </ul>
        <?php if (!empty($p['destaques'])): ?>
          <ul class="highlights">
            <?php foreach ($p['destaques'] as $d): ?><li><?= e($d) ?></li><?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <div class="product-hero__actions">
          <a class="btn btn--orange" href="<?= e(produto_whatsapp($p['nome'])) ?>" target="_blank" rel="noreferrer" data-track="whatsapp"><?= icon('whatsapp', 18) ?> Pedir orçamento</a>
          <a class="btn btn--outline" href="/#catalogo">Baixar catálogo completo</a>
        </div>
        <p class="note">Vende para lojas e distribuidores? <a href="/seja-revendedor/">Seja revendedor ARS</a>.</p>
      </div>
    </div>
  </section>

  <section class="section section--white">
    <div class="wrap spec-layout">
      <div>
        <h2>Ficha técnica</h2>
        <table class="spec-table">
          <tbody>
            <tr><th scope="row">Tipo</th><td><?= e(ucfirst($p['tipo'])) ?></td></tr>
            <tr><th scope="row">Largura</th><td><?= e($p['largura']) ?></td></tr>
            <tr><th scope="row">Altura</th><td><?= e($p['altura']) ?></td></tr>
            <tr><th scope="row">Espessura da base</th><td><?= e($p['base']) ?></td></tr>
            <tr><th scope="row">Comprimentos</th><td>1 m, 2 m e 3 m</td></tr>
            <tr><th scope="row">Acabamentos</th><td><?= e(implode(', ', ARS_ACABAMENTOS)) ?></td></tr>
            <?php foreach ($p['destaques'] ?? [] as $d): ?>
              <tr><th scope="row">Destaque</th><td><?= e($d) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div>
        <h2>Códigos para pedido</h2>
        <?php foreach ($tabelas as $variante => $codigos): ?>
          <?php if ($variante !== ''): ?><h3 class="spec-variant"><?= e($variante) ?></h3><?php endif; ?>
          <div class="table-scroll">
            <table class="code-table">
              <thead><tr><th scope="col">Acabamento</th><?php foreach ($p['comprimentos'] as $c): ?><th scope="col"><?= e($c) ?></th><?php endforeach; ?></tr></thead>
              <tbody>
                <?php foreach ($codigos as $sigla => $porComprimento): ?>
                  <tr>
                    <th scope="row"><span class="finish finish--<?= e(strtolower($sigla)) ?>" aria-hidden="true"></span><?= e(ARS_ACABAMENTOS[$sigla]) ?></th>
                    <?php foreach ($porComprimento as $codigo): ?><td><?= e($codigo) ?></td><?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endforeach; ?>

        <?php if ($p['acessorios']): ?>
          <h3 class="spec-variant">Acessórios</h3>
          <p class="refs"><?php foreach ($p['acessorios'] as $ref): ?><span>Ref. <?= e($ref) ?></span><?php endforeach; ?></p>
        <?php endif; ?>
        <p class="note">Fonte: Catálogo ARS, página <?= (int) $p['pagina'] ?>. Confirme códigos e disponibilidade com a equipe comercial.</p>
      </div>
    </div>
  </section>

  <?php if ($relacionados): ?>
  <section class="section">
    <div class="wrap">
      <h2>Outros <?= e(mb_strtolower($tipoInfo['nome'])) ?></h2>
      <div class="product-grid">
        <?php foreach ($relacionados as $rs => $r): ?>
          <a class="product-card" href="<?= e(produto_url($rs, $r)) ?>">
            <div class="product-card__img"><img src="<?= e(produto_imagem($rs, $r)) ?>" alt="<?= e($r['nome']) ?> ARS" loading="lazy" decoding="async"></div>
            <h3><?= e($r['nome']) ?></h3>
            <p class="product-card__spec"><?= e($r['largura']) ?> × <?= e($r['altura']) ?></p>
            <span class="product-card__more">Ver ficha técnica <?= icon('arrow-up-right', 14) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
      <p><a class="btn btn--orange" href="/produtos/<?= e($slugCat) ?>/">Ver todos os <?= e(mb_strtolower($cat['nome'])) ?></a></p>
    </div>
  </section>
  <?php endif; ?>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
