<?php
declare(strict_types=1);

$page = [
    'title'       => 'Onde comprar',
    'description' => 'Encontre uma loja que vende produtos ARS Iluminação perto de você, ou fale com a ARS para receber a indicação da revenda mais próxima.',
    'path'        => '/onde-comprar/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

// Revendas agrupadas por estado e ordenadas por cidade.
$byUf = [];
foreach (ARS_RESELLERS as $r) {
    $byUf[$r['uf']][] = $r;
}
ksort($byUf);
foreach ($byUf as &$list) {
    usort($list, static fn($a, $b) => strcmp($a['cidade'] . $a['nome'], $b['cidade'] . $b['nome']));
}
unset($list);

$whatsOnde = 'https://wa.me/' . ARS_SITE['whatsapp']['number'] . '?text=' . rawurlencode('Olá! Gostaria de saber onde comprar produtos ARS na minha cidade: ');

site_header('solid', '/onde-comprar/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Revendas ARS',
      'Onde comprar <span>produtos ARS.</span>',
      'Encontre uma loja parceira perto de você ou fale com a ARS para receber a indicação da revenda mais próxima.',
      ['image' => '/assets/img/produtos/colecao-bonalux/pendente-siena.webp', 'alt' => 'Pendente Siena, coleção Bonalux', 'width' => 613, 'height' => 386]
  ); ?>

  <?php if ($byUf): ?>
  <section class="section section--white">
    <div class="wrap reveal">
      <div class="kicker">Lojas parceiras</div>
      <h2>Revendas por estado.</h2>

        <div class="field resellers-filter">
          <label for="f-filtro-uf">Filtrar por estado</label>
          <select id="f-filtro-uf" class="js-uf-filter">
            <option value="">Todos os estados</option>
            <?php foreach (array_keys($byUf) as $uf): ?>
              <option value="<?= e($uf) ?>"><?= e($uf) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <?php foreach ($byUf as $uf => $list): ?>
          <div class="resellers" data-uf="<?= e($uf) ?>">
            <h3><?= e($uf) ?></h3>
            <div class="cards cards--3">
              <?php foreach ($list as $r): ?>
                <article class="card">
                  <h3><?= e($r['nome']) ?></h3>
                  <p><?= e($r['cidade']) ?>/<?= e($r['uf']) ?><?php if (!empty($r['endereco'])): ?><br><?= e($r['endereco']) ?><?php endif; ?></p>
                  <?php if (!empty($r['telefone'])): ?><p><?= e($r['telefone']) ?></p><?php endif; ?>
                  <?php if (!empty($r['site'])): ?><a class="btn btn--orange btn--sm" href="<?= e($r['site']) ?>" target="_blank" rel="noreferrer">Visitar loja</a><?php endif; ?>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="section">
    <div class="wrap two-col two-col--panels reveal">
      <div class="panel">
        <?php if ($byUf): ?>
          <div class="kicker">Não encontrou uma loja?</div>
          <h3>A ARS indica a revenda mais próxima</h3>
          <p>Envie sua cidade pelo WhatsApp e a equipe comercial indica onde encontrar os produtos.</p>
        <?php else: ?>
          <div class="kicker">Lojas parceiras</div>
          <h3>A lista de revendas está sendo organizada</h3>
          <p>Enquanto isso, envie sua cidade pelo WhatsApp e a equipe comercial indica a loja mais próxima com produtos ARS.</p>
        <?php endif; ?>
        <a class="btn btn--orange" href="<?= e($whatsOnde) ?>" target="_blank" rel="noreferrer" data-track="whatsapp">Perguntar pelo WhatsApp</a>
      </div>
      <div class="panel">
        <div class="kicker">É lojista ou distribuidor?</div>
        <h3>Revenda produtos ARS</h3>
        <p>Cadastre sua empresa e fale com a equipe comercial sobre as linhas e condições para revenda.</p>
        <a class="btn btn--orange" href="/seja-revendedor/">Seja revendedor</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
