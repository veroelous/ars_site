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

$isSpot = $p['categoria'] === 'spots';
$isFamilia = isset($p['versoes']);
$url = produto_url($slug, $p);
$img = produto_imagem($slug, $p);
$tipoInfo = ARS_TIPOS[$slugCat][$p['tipo']];

if ($isFamilia) {
    $acab = array_map(static fn($s) => ARS_ACABAMENTOS[$s], $p['acabamentos']);
    $n = count($p['versoes']);
    if ($isSpot) {
        $trilhos = array_values(array_unique(array_filter(array_column($p['versoes'], 'trilho'))));
        $descricao = sprintf(
            '%s ARS: spot de sobrepor com %s, soquete %s, acabamentos %s.%s Fabricante em Socorro/SP.',
            $p['nome'],
            $p['focos'] === '1' ? '1 foco' : $p['focos'] . ' focos',
            $p['soquete'],
            mb_strtolower(implode(', ', $acab)),
            $trilhos ? ' Versões em trilho de ' . implode(', ', $trilhos) . '.' : ''
        );
    } else {
        $descricao = trim(sprintf(
            '%s ARS%s. %s Soquete %s, %d %s de acabamento. Fabricante em Socorro/SP.',
            $p['nome'],
            $n > 1 ? ' com ' . $n . ' modelos' : '',
            $p['descricao'] ?? '',
            $p['soquete'],
            count($acab),
            count($acab) > 1 ? 'opções' : 'opção'
        ));
    }
    $codigos = [];
    foreach ($p['versoes'] as $v) {
        array_push($codigos, ...array_values((array) $v['codigo']));
    }
    $props = [];
    foreach ($p['ficha'] as $k => $v) {
        $props[] = ['@type' => 'PropertyValue', 'name' => $k, 'value' => $v];
    }
    $props[] = ['@type' => 'PropertyValue', 'name' => 'Acabamentos', 'value' => implode(', ', $acab)];
} else {
    $acab = array_values(ARS_ACABAMENTOS_PERFIL);
    $tabelas = $p['codigosVariantes'] ?? ['' => $p['codigos']];
    $codigos = [];
    foreach ($tabelas as $t) {
        foreach ($t as $porComprimento) {
            array_push($codigos, ...array_values($porComprimento));
        }
    }
    $descricao = sprintf(
        '%s ARS para fita de LED: %s × %s, comprimentos de 1, 2 e 3 m, acabamentos %s.%s Fabricante em Socorro/SP.',
        $p['nome'],
        $p['largura'],
        $p['altura'],
        mb_strtolower(implode(', ', $acab)),
        !empty($p['destaques']) ? ' ' . implode('. ', $p['destaques']) . '.' : ''
    );
    $props = [
        ['@type' => 'PropertyValue', 'name' => 'Largura', 'value' => $p['largura']],
        ['@type' => 'PropertyValue', 'name' => 'Altura', 'value' => $p['altura']],
        ['@type' => 'PropertyValue', 'name' => 'Comprimentos', 'value' => '1 m, 2 m, 3 m'],
        ['@type' => 'PropertyValue', 'name' => 'Acabamentos', 'value' => implode(', ', $acab)],
    ];
}

// Outros produtos do mesmo grupo (até 4).
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
        '@context'     => 'https://schema.org',
        '@type'        => 'Product',
        'name'         => $p['nome'],
        'description'  => $descricao,
        'image'        => ars_site_url() . $img,
        'brand'        => ['@type' => 'Brand', 'name' => 'ARS Iluminação'],
        'manufacturer' => ['@type' => 'Organization', 'name' => 'ARS Iluminação'],
        'category'     => $cat['nome'],
        'mpn'          => $codigos[0] ?? null,
        'additionalProperty' => $props,
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
        <img src="<?= e($img) ?>" alt="<?= e($p['nome']) ?> ARS Iluminação" fetchpriority="high">
      </div>
      <div class="product-hero__info">
        <div class="kicker"><?= e($cat['nome']) ?> · <?= e($isFamilia ? 'Soquete ' . $p['soquete'] : ucfirst($p['tipo'])) ?></div>
        <h1><?= e($p['nome']) ?></h1>
        <p class="product-hero__lead"><?= e($p['descricao'] ?? $tipoInfo['uso']) ?></p>
        <ul class="spec-chips">
          <?php if ($isSpot): ?>
            <li><strong><?= e($p['soquete']) ?></strong> soquete</li>
            <li><strong><?= e($p['focos']) ?></strong> <?= $p['focos'] === '1' ? 'foco' : 'focos' ?></li>
            <li><strong><?= count($p['versoes']) ?></strong> versões</li>
          <?php elseif ($isFamilia): ?>
            <li><strong><?= e($p['soquete']) ?></strong> soquete</li>
            <?php if ($n > 1): ?>
              <li><strong><?= $n ?></strong> modelos</li>
            <?php else: foreach (array_slice(array_diff_key($p['versoes'][0]['specs'], ['Tipo' => 1, 'Acabamentos' => 1, 'Soquete' => 1]), 0, 2, true) as $k => $v): ?>
              <li><strong><?= e($v) ?></strong> <?= e(mb_strtolower($k)) ?></li>
            <?php endforeach; endif; ?>
            <li><strong><?= count($acab) ?></strong> <?= count($acab) > 1 ? 'acabamentos' : 'acabamento' ?></li>
          <?php else: ?>
            <li><strong><?= e($p['largura']) ?></strong> largura</li>
            <li><strong><?= e($p['altura']) ?></strong> altura</li>
            <li><strong>1, 2 e 3 m</strong> comprimentos</li>
          <?php endif; ?>
        </ul>
        <?php $tags = array_merge($p['destaques'] ?? [], isset($p['observacao']) ? [$p['observacao']] : []); ?>
        <?php if ($tags): ?>
          <ul class="highlights">
            <?php foreach ($tags as $d): ?><li><?= e($d) ?></li><?php endforeach; ?>
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

  <?php if ($isFamilia): ?>
  <section class="section section--white">
    <div class="wrap">
      <h2><?= $isSpot ? 'Versões' : ($n > 1 ? 'Modelos da linha' : 'Especificações') ?></h2>
      <div class="variant-grid">
        <?php foreach ($p['versoes'] as $v): ?>
          <article class="variant-card">
            <div class="product-card__img"><img src="/assets/img/produtos/<?= e($p['categoria']) ?>/<?= e($v['imagem']) ?>.webp" alt="<?= e($v['nome']) ?> ARS" loading="lazy" decoding="async"></div>
            <?php if (isset($v['tipo'])): ?><div class="variant-type"><?= e($v['tipo']) ?></div><?php endif; ?>
            <h3><?= e($v['nome']) ?></h3>
            <dl class="variant-specs">
              <?php foreach ((array) $v['codigo'] as $rotulo => $cod): ?>
                <div><dt>Código<?= is_string($rotulo) ? ' ' . e($rotulo) : '' ?></dt><dd><?= e($cod) ?></dd></div>
              <?php endforeach; ?>
              <?php foreach (array_diff_key($v['specs'], ['Tipo' => 1]) as $k => $val): ?>
                <div><dt><?= e($k) ?></dt><dd><?= e($val) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="spec-layout spec-layout--spot">
        <div>
          <h2>Ficha técnica</h2>
          <table class="spec-table">
            <tbody>
              <?php foreach ($p['ficha'] as $k => $val): ?>
                <tr><th scope="row"><?= e($k) ?></th><td><?= e($val) ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div>
          <h2>Acabamentos</h2>
          <ul class="finish-list">
            <?php foreach ($p['acabamentos'] as $sigla): ?>
              <li><span class="finish finish--<?= e(strtolower($sigla)) ?>" aria-hidden="true"></span><?= str_starts_with(ARS_ACABAMENTOS[$sigla], '[') ? pending(ARS_ACABAMENTOS[$sigla]) : e(ARS_ACABAMENTOS[$sigla]) ?></li>
            <?php endforeach; ?>
          </ul>
          <p class="note">Fonte: Catálogo ARS, página <?= (int) $p['pagina'] ?>. Confirme códigos, acabamentos e disponibilidade com a equipe comercial.</p>
        </div>
      </div>
    </div>
  </section>
  <?php else: ?>
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
            <tr><th scope="row">Acabamentos</th><td><?= e(implode(', ', $acab)) ?></td></tr>
            <?php foreach ($p['destaques'] ?? [] as $d): ?>
              <tr><th scope="row">Destaque</th><td><?= e($d) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div>
        <h2>Códigos para pedido</h2>
        <?php foreach ($tabelas as $variante => $tabela): ?>
          <?php if ($variante !== ''): ?><h3 class="spec-variant"><?= e($variante) ?></h3><?php endif; ?>
          <div class="table-scroll">
            <table class="code-table">
              <thead><tr><th scope="col">Acabamento</th><?php foreach ($p['comprimentos'] as $c): ?><th scope="col"><?= e($c) ?></th><?php endforeach; ?></tr></thead>
              <tbody>
                <?php foreach ($tabela as $sigla => $porComprimento): ?>
                  <tr>
                    <th scope="row"><span class="finish finish--<?= e(strtolower($sigla)) ?>" aria-hidden="true"></span><?= e(ARS_ACABAMENTOS_PERFIL[$sigla]) ?></th>
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
  <?php endif; ?>

  <?php if ($relacionados): ?>
  <section class="section">
    <div class="wrap">
      <h2>Outros <?= e(mb_strtolower($isFamilia ? $cat['nome'] : $tipoInfo['nome'])) ?></h2>
      <div class="product-grid">
        <?php foreach ($relacionados as $rs => $r): ?>
          <a class="product-card" href="<?= e(produto_url($rs, $r)) ?>">
            <div class="product-card__img"><img src="<?= e(produto_imagem($rs, $r)) ?>" alt="<?= e($r['nome']) ?> ARS" loading="lazy" decoding="async"></div>
            <h3><?= e($r['nome']) ?></h3>
            <p class="product-card__spec"><?= e(produto_resumo($r)) ?></p>
            <span class="product-card__more"><?= $isSpot ? 'Ver versões' : ($isFamilia ? 'Ver detalhes' : 'Ver ficha técnica') ?> <?= icon('arrow-up-right', 14) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
      <p><a class="btn btn--orange" href="/produtos/<?= e($slugCat) ?>/">Ver todos os <?= e(mb_strtolower($cat['nome'])) ?></a></p>
    </div>
  </section>
  <?php endif; ?>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
