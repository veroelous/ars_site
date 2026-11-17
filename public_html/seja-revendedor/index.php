<?php
declare(strict_types=1);

$page = [
    'title'       => 'Seja revendedor',
    'description' => 'Revenda os produtos da ARS Iluminação: fabricação própria em Socorro/SP, estoque para pronta entrega e envio para todo o Brasil. Cadastre sua loja ou distribuidora.',
    'path'        => '/seja-revendedor/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/leads.php';

$sent = ($_GET['enviado'] ?? '') === '1';
$formError = ($_GET['erro'] ?? '') === '1';

/*
 * Diferenciais extraídos das publicações oficiais da ARS no Instagram (capturadas em 13/11/2026).
 * Validar redação final com a ARS — ver docs/PENDENCIAS.md.
 */
$reasons = [
    ['Produção própria', 'A ARS fabrica em Socorro/SP desde 2014. A produção é nossa, e o estoque fica pronto para reposição.'],
    ['Pronta entrega', 'Estoque abastecido para atender lojistas, distribuidores e profissionais que precisam de qualidade, variedade e agilidade.'],
    ['Entrega para todo o Brasil', 'O pedido sai rápido e chega a qualquer lugar do país, sem esperar semanas para repor a loja ou fechar a obra.'],
];

$whatsRevenda = 'https://wa.me/' . ARS_SITE['whatsapp']['number'] . '?text=' . rawurlencode('Olá! Tenho uma loja/empresa e quero revender produtos ARS.');

site_header('solid', '/seja-revendedor/');
?>
<main id="conteudo" class="inner-page">
  <?php page_hero(
      'Para lojistas e distribuidores',
      'Revenda ARS: <span>fabricante nacional, pronta entrega.</span>',
      'A ARS Iluminação fabrica em Socorro/SP desde 2014 e atende lojas, distribuidores e profissionais de iluminação em todo o Brasil.',
      ['title' => '[FOTO DA FÁBRICA, ESTOQUE OU EXPEDIÇÃO]', 'hint' => 'Inserir mídia oficial'],
      ['href' => '#cadastro', 'label' => 'Quero revender']
  ); ?>

  <section class="section section--white">
    <div class="wrap reveal">
      <div class="kicker">Por que revender ARS</div>
      <h2>Quem fabrica, entrega.</h2>
      <div class="cards cards--3">
        <?php foreach ($reasons as [$title, $text]): ?>
          <article class="card">
            <h3><?= e($title) ?></h3>
            <p><?= e($text) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap two-col two-col--panels reveal">
      <div class="panel">
        <div class="kicker">Linhas para revenda</div>
        <h3>Portfólio</h3>
        <p>Pendentes, perfis de LED, spots, spots para trilho, arandelas, plafons e plafoniers.</p>
        <a class="btn btn--orange" href="/produtos/">Ver produtos</a>
      </div>
      <div class="panel">
        <div class="kicker">Condições comerciais</div>
        <h3>Como funciona</h3>
        <p><?= pending('[Pedido mínimo, prazos de entrega, formas de pagamento, tabela de preços e materiais de PDV — validar com a ARS]') ?></p>
      </div>
    </div>
  </section>

  <section class="section section--white" id="cadastro">
    <div class="wrap reveal">
      <div class="kicker">Cadastro de revenda</div>
      <h2>Cadastre sua empresa.</h2>
      <div class="contact-grid">
        <div class="panel panel--form">
          <p>Preencha os dados abaixo. A equipe comercial da ARS entra em contato pelo WhatsApp ou e-mail informado.</p>

          <div class="contact-success" role="status"<?= $sent ? '' : ' hidden' ?>>
            <h3>Cadastro enviado.</h3>
            <p>Recebemos os dados da sua empresa. A equipe comercial da ARS vai entrar em contato.</p>
          </div>

          <form class="contact-form js-lead-form" action="/api/revendedor.php" method="post" novalidate data-kind="revendedor"<?= $sent ? ' hidden' : '' ?>>
            <div class="contact-form__grid">
              <div class="field">
                <label for="f-nome">Seu nome</label>
                <input id="f-nome" name="nome" autocomplete="name" placeholder="Seu nome" required maxlength="120">
              </div>
              <div class="field">
                <label for="f-empresa">Empresa</label>
                <input id="f-empresa" name="empresa" autocomplete="organization" placeholder="Nome da loja ou empresa" required maxlength="120">
              </div>
              <div class="field">
                <label for="f-cnpj">CNPJ <span class="optional">(opcional)</span></label>
                <input id="f-cnpj" name="cnpj" inputmode="numeric" placeholder="00.000.000/0000-00" maxlength="18">
              </div>
              <div class="field">
                <label for="f-perfil">Tipo de negócio</label>
                <select id="f-perfil" name="perfil" required>
                  <option value="">Selecione</option>
                  <?php foreach (ARS_PERFIS as $value => $label): ?>
                    <option value="<?= e($value) ?>"><?= e($label) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label for="f-cidade">Cidade</label>
                <input id="f-cidade" name="cidade" autocomplete="address-level2" placeholder="Sua cidade" required maxlength="80">
              </div>
              <div class="field">
                <label for="f-uf">Estado</label>
                <select id="f-uf" name="uf" autocomplete="address-level1" required>
                  <option value="">UF</option>
                  <?php foreach (ARS_UFS as $uf): ?>
                    <option value="<?= e($uf) ?>"><?= e($uf) ?></option>
                  <?php endforeach; ?>
                </select>
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
                <label for="f-mensagem">Quais linhas interessam? <span class="optional">(opcional)</span></label>
                <textarea id="f-mensagem" name="mensagem" placeholder="Ex.: perfis de LED e spots para trilho" maxlength="3000"></textarea>
              </div>
            </div>
            <?= consent_field() ?>
            <div class="hp" aria-hidden="true">
              <label for="f-site">Não preencha este campo</label>
              <input id="f-site" name="site" type="text" tabindex="-1" autocomplete="off">
            </div>
            <button class="btn btn--orange" type="submit">Enviar cadastro</button>
            <p class="form-status" aria-live="polite"><?= $formError ? 'Confira os dados e tente novamente.' : '' ?></p>
          </form>
        </div>

        <div class="panel">
          <div class="kicker">Prefere conversar agora?</div>
          <h3>Fale com o comercial</h3>
          <ul class="channels">
            <li><?= icon('whatsapp', 18, 'text-orange') ?><a href="<?= e($whatsRevenda) ?>" target="_blank" rel="noreferrer" data-track="whatsapp"><?= e(ARS_SITE['whatsapp']['display']) ?></a></li>
            <li><?= icon('mail', 18, 'text-orange') ?><a href="mailto:<?= e(ARS_SITE['email']) ?>"><?= e(ARS_SITE['email']) ?></a></li>
          </ul>
          <p class="note">Já é cliente final e procura uma loja? Veja <a href="/onde-comprar/">onde comprar</a>.</p>
        </div>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
