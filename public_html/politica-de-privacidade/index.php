<?php
declare(strict_types=1);

$page = [
    'title'       => 'Política de privacidade',
    'description' => 'Como a ARS Iluminação trata os dados pessoais enviados pelo site, conforme a Lei Geral de Proteção de Dados (LGPD).',
    'path'        => '/politica-de-privacidade/',
];
require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';

$analytics = (string) ars_config()['ga4_id'] !== '';

site_header('solid');
?>
<main id="conteudo" class="inner-page">
  <section class="page-hero page-hero--simple">
    <div class="wrap">
      <div class="eyebrow eyebrow--light">LGPD · Lei nº 13.709/2018</div>
      <h1>Política de <span>privacidade.</span></h1>
      <p class="page-hero__lead">Como a ARS Iluminação trata os dados pessoais enviados por este site.</p>
    </div>
  </section>

  <section class="section section--white">
    <div class="wrap prose">
      <p class="note">Última atualização: 17 de novembro de 2026.</p>

      <h2>1. Quem é responsável pelos seus dados</h2>
      <p>O controlador dos dados é a <strong>ARS Iluminação</strong>, CNPJ <?= pending('[CNPJ — confirmar com a ARS]') ?>, com sede na <?= e(ARS_SITE['address']['street']) ?>, <?= e(str_replace(' · ', ', ', ARS_SITE['address']['detail'])) ?>.</p>
      <p>Para qualquer assunto sobre seus dados, fale com a gente pelo e-mail <a href="mailto:<?= e(ARS_SITE['email']) ?>"><?= e(ARS_SITE['email']) ?></a>.</p>

      <h2>2. Quais dados coletamos</h2>
      <ul>
        <li><strong>Formulário do catálogo:</strong> nome, WhatsApp e e-mail.</li>
        <li><strong>Formulário de contato e orçamento:</strong> nome, empresa, WhatsApp, e-mail e a mensagem que você escrever.</li>
        <li><strong>Cadastro de revendedor:</strong> nome, empresa, CNPJ (opcional), tipo de negócio, cidade, estado, WhatsApp, e-mail e a mensagem que você escrever.</li>
        <li><strong>Dados técnicos de segurança:</strong> uma versão cifrada do endereço IP, usada apenas para limitar envios repetidos e proteger os formulários contra abuso.</li>
      </ul>
      <p>Registramos também a data e o texto da autorização que você marcou em cada formulário.</p>

      <h2>3. Para que usamos</h2>
      <ul>
        <li>Liberar o download do catálogo.</li>
        <li>Responder ao seu contato, enviar orçamentos e informações comerciais sobre os produtos da ARS.</li>
        <li>Avaliar cadastros de revenda e falar sobre condições comerciais.</li>
        <li>Manter a segurança do site.</li>
      </ul>
      <p>As bases legais são o seu <strong>consentimento</strong> (art. 7º, I, da LGPD), dado ao marcar a caixa de autorização, e o <strong>legítimo interesse</strong> da ARS em proteger o site (art. 7º, IX).</p>

      <h2>4. Com quem compartilhamos</h2>
      <p>Não vendemos nem alugamos seus dados. Eles são acessados apenas pela equipe da ARS e pelos serviços necessários para o site funcionar:</p>
      <ul>
        <li><strong>Hospedagem do site</strong>, onde os dados ficam armazenados em área protegida.</li>
        <li><strong>Serviço de e-mail</strong> usado para avisar a equipe da ARS sobre cada novo contato.</li>
        <li><strong>Instagram (Meta)</strong>: a página inicial exibe publicações do Instagram da ARS. Ao carregá-las, o Instagram pode coletar dados de navegação conforme a política de privacidade dele.</li>
        <?php if ($analytics): ?>
        <li><strong>Google Analytics</strong>: usamos estatísticas de visita (páginas acessadas, origem do acesso, dispositivo) para entender e melhorar o site.</li>
        <?php endif; ?>
      </ul>

      <h2>5. Por quanto tempo guardamos</h2>
      <p>Pelo tempo necessário para o atendimento comercial ou até você pedir a exclusão, o que vier primeiro. <?= pending('[Prazo máximo de guarda — definir com a ARS]') ?></p>

      <h2>6. Seus direitos</h2>
      <p>Você pode, a qualquer momento e sem custo, pedir pelo e-mail <a href="mailto:<?= e(ARS_SITE['email']) ?>"><?= e(ARS_SITE['email']) ?></a>:</p>
      <ul>
        <li>confirmação de que tratamos seus dados e acesso a eles;</li>
        <li>correção de dados incompletos ou desatualizados;</li>
        <li>exclusão dos dados tratados com base no seu consentimento;</li>
        <li>revogação do consentimento para novos contatos comerciais;</li>
        <li>informações sobre com quem os dados foram compartilhados.</li>
      </ul>
      <p>Você também pode registrar reclamação na Autoridade Nacional de Proteção de Dados (ANPD).</p>

      <h2>7. Cookies</h2>
      <p>O site não usa cookies próprios de publicidade ou rastreamento.<?= $analytics ? ' O Google Analytics usa cookies para gerar estatísticas de visita.' : '' ?> Conteúdos de terceiros, como as publicações do Instagram, podem usar cookies próprios.</p>

      <h2>8. Segurança</h2>
      <p>Os dados enviados pelos formulários trafegam com criptografia (HTTPS) e ficam em área do servidor sem acesso público, consultada apenas pela equipe autorizada da ARS.</p>

      <h2>9. Alterações</h2>
      <p>Esta política pode ser atualizada. A data da última versão fica sempre no topo desta página.</p>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
