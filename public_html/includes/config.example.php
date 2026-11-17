<?php
/**
 * MODELO de configuração. NÃO coloque valores reais neste arquivo.
 *
 * No servidor, copie para:
 *   /home/USUARIO/ars_private/config.php   (recomendado: fora do public_html)
 *   ou public_html/private/config.php      (protegido pelo .htaccess)
 * e preencha os valores. O config.php real nunca vai para o Git.
 */
return [
    // URL pública, sem barra no final. Em branco = detecta pelo endereço acessado.
    'site_url' => 'https://www.arsiluminacao.com.br',

    // true = pede ao Google para não indexar. Endereços que começam com "dev." já são bloqueados.
    'noindex' => false,

    // Segredo do link temporário do catálogo (mínimo 32 caracteres).
    // Gere em: Terminal do cPanel → openssl rand -hex 32
    'catalog_secret' => '',

    // Remetente dos avisos de novo contato (precisa ser um e-mail do domínio).
    // O destinatário é o e-mail da ARS em includes/site.php.
    'mail_from' => 'site@arsiluminacao.com.br',

    // Acesso à exportação dos contatos em /admin/leads.php (deixe em branco para desativar).
    // Gere o hash em: php -r "echo password_hash('SUA-SENHA', PASSWORD_DEFAULT);"
    'admin_user'      => '',
    'admin_pass_hash' => '',

    // Token de longa duração da Instagram API (conta @ars.iluminacao). Em branco = embeds fixos.
    'instagram_token' => '',
    'instagram_ttl'   => 3600,

    // ID do Google Analytics 4 (ex.: G-XXXXXXXXXX). Em branco = sem Analytics.
    'ga4_id' => '',
];
