<?php
/**
 * Abertura da página: <head> completo + link de pular para o conteúdo.
 * Antes de incluir, defina $page = ['title' => ..., 'description' => ..., 'path' => '/...'].
 */
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/icons.php';

$page = $page ?? [];
$pageTitle = isset($page['title']) && $page['title'] !== ''
    ? $page['title'] . ' | ' . ARS_SITE['name']
    : ARS_SITE['name'] . ' | ' . ARS_SITE['tagline'];
$pageDescription = $page['description'] ?? ARS_SITE['description'];
$base = ars_site_url();
$canonical = $base . ($page['path'] ?? '/');
$ogImage = $base . '/assets/img/hero-ars-fachada-frontal.jpg';

$orgJsonLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',
    'name'     => ARS_SITE['name'],
    'url'      => $base . '/',
    'logo'     => $base . '/assets/img/ars-logo-colorido.webp',
    'email'    => ARS_SITE['email'],
    'sameAs'   => [ARS_SITE['instagram']['url']],
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => ARS_SITE['address']['street'],
        'addressLocality' => ARS_SITE['address']['locality'],
        'addressRegion'   => ARS_SITE['address']['region'],
        'postalCode'      => ARS_SITE['address']['postalCode'],
        'addressCountry'  => 'BR',
    ],
];
?><!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDescription) ?>">
<?php if (ars_noindex()): ?>
<meta name="robots" content="noindex, nofollow">
<?php endif; ?>
<link rel="canonical" href="<?= e($canonical) ?>">
<meta name="theme-color" content="#1a1660">
<meta property="og:type" content="website">
<meta property="og:locale" content="pt_BR">
<meta property="og:site_name" content="<?= e(ARS_SITE['name']) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="preload" href="/assets/fonts/manrope-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
<?php if (!empty($page['preload'])): foreach ($page['preload'] as $pre): ?>
<link rel="preload" as="image" href="<?= e($pre['href']) ?>"<?= isset($pre['srcset']) ? ' imagesrcset="' . e($pre['srcset']) . '" imagesizes="100vw"' : '' ?>>
<?php endforeach; endif; ?>
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
<script type="application/ld+json"><?= json_encode($orgJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
</head>
<body>
<a class="skip-link" href="#conteudo">Ir para o conteúdo</a>
