<?php
/**
 * Carregado por todas as páginas e endpoints PHP.
 * Lê a configuração privada e define funções utilitárias.
 */
declare(strict_types=1);

require_once __DIR__ . '/site.php';

/**
 * Pasta privada (contatos, catálogo, cache, configuração).
 * Preferência: fora do public_html (../ars_private). Se não existir,
 * usa public_html/private, bloqueada pelo .htaccess.
 */
function ars_private_dir(): string
{
    $outside = dirname(__DIR__, 2) . '/ars_private';
    return is_dir($outside) ? $outside : dirname(__DIR__) . '/private';
}

/** Configuração com segredos. Modelo em includes/config.example.php. */
function ars_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }
    $defaults = [
        'site_url'          => '',
        'noindex'           => false,
        'catalog_secret'    => '',
        'mail_from'         => 'site@arsiluminacao.com.br',
        'admin_user'        => '',
        'admin_pass_hash'   => '',
        'instagram_token'   => '',
        'instagram_ttl'     => 3600,
        'ga4_id'            => '',
    ];
    $file = ars_private_dir() . '/config.php';
    $loaded = is_file($file) ? require $file : [];
    $config = array_merge($defaults, is_array($loaded) ? $loaded : []);
    return $config;
}

function ars_site_url(): string
{
    $url = rtrim((string) ars_config()['site_url'], '/');
    if ($url !== '') {
        return $url;
    }
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $host = preg_replace('/[^a-z0-9.\-:]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
    return ($https ? 'https' : 'http') . '://' . $host;
}

/** Ambiente de teste (dev.*) ou noindex na configuração: não indexar. */
function ars_noindex(): bool
{
    $host = strtolower($_SERVER['HTTP_HOST'] ?? '');
    return (bool) ars_config()['noindex'] || str_starts_with($host, 'dev.');
}

/** Escapa texto para HTML. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** URL de arquivo estático com versão para cache. */
function asset(string $path): string
{
    $file = dirname(__DIR__) . '/' . ltrim($path, '/');
    $v = is_file($file) ? substr((string) filemtime($file), -6) : '1';
    return '/' . ltrim($path, '/') . '?v=' . $v;
}

/** Garante que uma subpasta privada exista, com permissão restrita. */
function ars_private_path(string $sub): string
{
    $dir = ars_private_dir() . '/' . trim($sub, '/');
    if (!is_dir($dir)) {
        @mkdir($dir, 0700, true);
    }
    return $dir;
}

/** Caixa de consentimento LGPD com link para a Política de Privacidade. */
function consent_field(): string
{
    return '<div class="consent">'
        . '<input id="f-consentimento" name="consentimento" type="checkbox" required>'
        . '<label for="f-consentimento">' . e(ARS_SITE['consent'])
        . ' <a href="/politica-de-privacidade/" target="_blank">Política de Privacidade</a>.</label>'
        . '</div>';
}

/** Marcador de conteúdo pendente de aprovação da ARS (texto). */
function pending(string $text): string
{
    return '<span class="pending-text">' . e($text) . '</span>';
}

/** Marcador de mídia pendente de aprovação da ARS. */
function pending_media(string $title, string $hint = '', string $tone = 'light', string $class = ''): string
{
    $small = $hint !== '' ? '<small>' . e($hint) . '</small>' : '';
    return '<div class="pending-media pending-media--' . e($tone) . ' ' . e($class) . '" role="img" aria-label="Mídia pendente: ' . e($title) . '"><span>' . e($title) . $small . '</span></div>';
}
