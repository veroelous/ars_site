<?php
declare(strict_types=1);

$page = [
    'title'       => 'A ARS',
    'description' => 'A ARS Iluminação foi fundada em 2014, em Socorro/SP, para criar e fabricar soluções de iluminação para diferentes projetos.',
    'path'        => '/a-ars/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

$pillars = [
    ['Desenvolvimento', '[TEXTO APROVADO SOBRE DESIGN, ENGENHARIA E DESENVOLVIMENTO DE PRODUTOS]'],
    ['Processo produtivo', '[TEXTO APROVADO SOBRE MATERIAIS, ACABAMENTOS E CONTROLE DE QUALIDADE]'],
    ['Fabricação', '[TEXTO APROVADO SOBRE FABRICAÇÃO E PINTURA ELETROSTÁTICA]'],
];

site_header('solid', '/a-ars/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Sobre a ARS',
      'Iluminação com <span>propósito.</span>',
      'A ARS Iluminação foi fundada em 2014, em Socorro/SP, para criar e fabricar soluções de iluminação para diferentes projetos.',
      ['title' => '[IMAGEM OU VÍDEO INSTITUCIONAL]', 'hint' => 'Inserir mídia oficial da fábrica, equipe ou processo'],
      ['href' => '/contato-e-orcamento/', 'label' => 'Falar com a equipe comercial']
  ); ?>

  <section class="section section--white">
    <div class="wrap two-col reveal">
      <div>
        <div class="kicker">Nossa história</div>
        <h2>Uma trajetória feita de luz, produto e parceria.</h2>
        <p><?= pending('[TEXTO APROVADO SOBRE A FUNDAÇÃO, EVOLUÇÃO E MOMENTOS IMPORTANTES DA ARS]') ?></p>
        <p class="note">Campo reservado para o texto institucional aprovado.</p>
      </div>
      <?= pending_media('[IMAGEM HISTÓRICA]', 'Arquivo oficial / linha do tempo') ?>
    </div>
  </section>

  <section class="section">
    <div class="wrap reveal">
      <div class="kicker">Qualidade e fabricação</div>
      <h2>Do desenvolvimento ao projeto.</h2>
      <p>Apresente aqui os diferenciais técnicos e produtivos com informações oficiais da ARS.</p>
      <div class="cards cards--3">
        <?php foreach ($pillars as [$title, $text]): ?>
          <article class="card">
            <h3><?= e($title) ?></h3>
            <p><?= pending($text) ?></p>
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
          <p><?= pending('[TEXTO COMERCIAL APROVADO PARA LOJISTAS, ESPECIFICADORES, ARQUITETOS E DISTRIBUIDORES]') ?></p>
          <a class="btn btn--orange" href="/contato-e-orcamento/">Solicitar atendimento</a>
        </div>
        <?= pending_media('[VÍDEO OU IMAGEM DE PROCESSO]', 'Inserir mídia oficial', 'dark') ?>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
