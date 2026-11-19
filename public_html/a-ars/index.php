<?php
declare(strict_types=1);

$page = [
    'title'       => 'A ARS',
    'seo_title'   => 'Sobre a ARS Iluminação | Fabricante em Socorro/SP',
    'description' => 'A ARS Iluminação foi fundada em 2014, em Socorro/SP, para criar e fabricar soluções de iluminação para diferentes projetos.',
    'path'        => '/a-ars/',
];
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/produtos.php';
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

/*
 * Textos montados só com informações já publicadas pela ARS: catálogo 2027 (linhas, materiais,
 * acabamentos, Grupo ARS), bio e legendas do Instagram (fabricante, pronta entrega, entregas para
 * todo o Brasil) e o site atual (fundação em 2014, Socorro/SP). Validar a redação com a ARS.
 */
$pillars = [
    ['Desenvolvimento', 'Linhas com desenho próprio, como Essenza, Vernazza e Fênix, e a coleção Bonalux, de pendentes, plafons e arandelas com LED integrado.'],
    ['Processo produtivo', 'Peças em alumínio, ABS com tratamento UV e vidro decorado, com acabamentos na paleta de oito cores: Bronze AVL, Verde AVL, Preto, Pedra, Dourado, Champagne, Branco e Off White.'],
    ['Fabricação', 'Produção própria em Socorro/SP e estoque para pronta entrega, com envio para todo o Brasil.'],
];

site_header('solid', '/a-ars/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Sobre a ARS',
      'Iluminação com <span>propósito.</span>',
      'A ARS Iluminação foi fundada em 2014, em Socorro/SP, para criar e fabricar soluções de iluminação para diferentes projetos.',
      ['photo' => 'frontal', 'alt' => 'Fábrica da ARS Iluminação em Socorro/SP'],
      ['href' => '/contato-e-orcamento/', 'label' => 'Falar com a equipe comercial']
  ); ?>

  <section class="section section--white">
    <div class="wrap two-col reveal">
      <div>
        <div class="kicker">Nossa história</div>
        <h2>Uma trajetória feita de luz, produto e parceria.</h2>
        <p>A ARS Iluminação foi fundada em 2014, em Socorro/SP, como fabricante de luminárias e perfis de LED. A produção é própria, e os produtos saem da fábrica com entrega para todo o Brasil.</p>
        <p>Hoje o catálogo reúne nove linhas (<?= linhas_links(true) ?>), com mais de 200 modelos. A ARS faz parte do Grupo ARS Iluminação, ao lado das marcas Bonalux e RSG.</p>
        <a class="btn btn--orange" href="/produtos/">Ver as linhas de produto</a>
      </div>
      <figure class="photo-frame"><?= photo('lateral', 'Vista lateral da fábrica da ARS Iluminação') ?></figure>
    </div>
  </section>

  <section class="section">
    <div class="wrap reveal">
      <div class="kicker">Qualidade e fabricação</div>
      <h2>Do desenvolvimento ao projeto.</h2>
      <p>O que está por trás de cada peça do catálogo.</p>
      <div class="cards cards--3">
        <?php foreach ($pillars as [$title, $text]): ?>
          <article class="card">
            <h3><?= e($title) ?></h3>
            <p><?= e($text) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="cta-panel">
        <div>
          <div class="eyebrow eyebrow--light">Para especificar e comprar</div>
          <h2>Uma parceira para transformar projetos em ambientes iluminados.</h2>
          <p>Para lojistas, distribuidores, arquitetos e instaladores: envie o projeto ou a lista de produtos, e a equipe comercial orienta a escolha de modelos, acabamentos e quantidades.</p>
          <a class="btn btn--orange" href="/contato-e-orcamento/">Solicitar atendimento</a>
          <a class="btn btn--ghost" href="/seja-revendedor/">Seja revendedor</a>
        </div>
        <img class="cta-panel__img" src="/assets/img/produtos/colecao-bonalux/pendente-ferrara.webp" alt=""<?= img_dim('/assets/img/produtos/colecao-bonalux/pendente-ferrara.webp') ?> loading="lazy">
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
