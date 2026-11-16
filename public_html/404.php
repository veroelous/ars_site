<?php
declare(strict_types=1);

http_response_code(404);
$page = [
    'title'       => 'Página não encontrada',
    'description' => 'O endereço pode ter mudado com o novo site da ARS Iluminação.',
    'path'        => '/',
];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
site_header('solid');
?>
<main id="conteudo" class="inner-page">
  <section class="page-hero page-hero--simple">
    <div class="wrap">
      <div class="eyebrow eyebrow--light">Página não encontrada</div>
      <h1>Este caminho <span>não existe.</span></h1>
      <p class="page-hero__lead">O endereço pode ter mudado com o novo site da ARS.</p>
      <a class="btn btn--orange" href="/">Voltar ao início</a>
    </div>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
