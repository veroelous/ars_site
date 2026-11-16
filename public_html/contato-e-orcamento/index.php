<?php
declare(strict_types=1);

$page = [
    'title'       => 'Contato e orçamento',
    'description' => 'Conte o que você precisa para seu projeto e a equipe comercial da ARS Iluminação retornará com as orientações adequadas.',
    'path'        => '/contato-e-orcamento/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

$sent = ($_GET['enviado'] ?? '') === '1';
$formError = ($_GET['erro'] ?? '') === '1';

site_header('solid', '/contato-e-orcamento/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Atendimento ARS',
      'Fale com a <span>ARS.</span>',
      'Conte o que você precisa para seu projeto e nossa equipe comercial retornará com as orientações adequadas.',
      ['title' => '[IMAGEM DE ATENDIMENTO, PRODUTO OU APLICAÇÃO]', 'hint' => 'Inserir mídia oficial']
  ); ?>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="kicker">Solicite um orçamento</div>
      <h2>Vamos conversar sobre o seu projeto.</h2>
      <div class="contact-grid">
        <div class="panel panel--form">
          <p><?= pending('[Texto comercial aprovado: público atendido, prazo de retorno e canais oficiais]') ?></p>

          <div class="contact-success" role="status"<?= $sent ? '' : ' hidden' ?>>
            <h3>Mensagem enviada.</h3>
            <p>Recebemos seu contato. A equipe comercial da ARS retornará pelos dados informados.</p>
          </div>

          <form class="contact-form js-lead-form" action="/api/contato.php" method="post" novalidate data-kind="contato"<?= $sent ? ' hidden' : '' ?>>
            <div class="contact-form__grid">
              <div class="field">
                <label for="f-nome">Nome</label>
                <input id="f-nome" name="nome" autocomplete="name" placeholder="Seu nome" required maxlength="120">
              </div>
              <div class="field">
                <label for="f-empresa">Empresa</label>
                <input id="f-empresa" name="empresa" autocomplete="organization" placeholder="Nome da empresa" maxlength="120">
              </div>
              <div class="field">
                <label for="f-whatsapp">WhatsApp</label>
                <input id="f-whatsapp" name="whatsapp" type="tel" inputmode="numeric" autocomplete="tel-national" placeholder="(00) 00000-0000" required maxlength="15">
              </div>
              <div class="field">
                <label for="f-email">E-mail</label>
                <input id="f-email" name="email" type="email" autocomplete="email" placeholder="voce@empresa.com" required maxlength="160">
              </div>
              <div class="field field--full">
                <label for="f-mensagem">Mensagem</label>
                <textarea id="f-mensagem" name="mensagem" placeholder="Conte o que você precisa" required maxlength="3000"></textarea>
              </div>
            </div>
            <div class="consent">
              <input id="f-consentimento" name="consentimento" type="checkbox" required>
              <label for="f-consentimento"><?= e(ARS_SITE['consent']) ?></label>
            </div>
            <div class="hp" aria-hidden="true">
              <label for="f-site">Não preencha este campo</label>
              <input id="f-site" name="site" type="text" tabindex="-1" autocomplete="off">
            </div>
            <button class="btn btn--orange" type="submit">Enviar solicitação</button>
            <p class="form-status" aria-live="polite"><?= $formError ? 'Confira os dados e tente novamente.' : '' ?></p>
          </form>
        </div>

        <div class="panel">
          <div class="kicker">Canais oficiais</div>
          <h3>Atendimento comercial</h3>
          <ul class="channels">
            <li><?= icon('mail', 18, 'text-orange') ?><a href="mailto:<?= e(ARS_SITE['email']) ?>"><?= e(ARS_SITE['email']) ?></a></li>
            <li><?= icon('whatsapp', 18, 'text-orange') ?><a href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noreferrer" data-track="whatsapp"><?= e(ARS_SITE['whatsapp']['display']) ?></a></li>
            <li><?= icon('instagram', 18, 'text-orange') ?><a href="<?= e(ARS_SITE['instagram']['url']) ?>" target="_blank" rel="noreferrer"><?= e(ARS_SITE['instagram']['handle']) ?> <?= icon('arrow-up-right', 14) ?></a></li>
            <li><?= icon('map-pin', 18, 'text-orange') ?><a href="<?= e(ARS_SITE['address']['mapsUrl']) ?>" target="_blank" rel="noreferrer"><?= e(ARS_SITE['address']['street']) ?><small><?= e(ARS_SITE['address']['detail']) ?></small></a></li>
          </ul>
          <p class="note">WhatsApp e endereço conforme o site publicado — confirmar com a ARS antes da troca de domínio.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap reveal">
      <div class="cta-panel">
        <div>
          <div class="eyebrow eyebrow--light">Próximo passo</div>
          <h2>Tenha uma equipe para orientar sua especificação.</h2>
          <p><?= pending('[Texto comercial aprovado para conversão]') ?></p>
          <a class="btn btn--orange" href="mailto:<?= e(ARS_SITE['email']) ?>">Enviar e-mail</a>
        </div>
        <?= pending_media('[IMAGEM OU VÍDEO DE PROJETO]', '', 'dark') ?>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
