<?php
/**
 * Abertura da página: <head> completo + link de pular para o conteúdo.
 * Antes de incluir, defina $page = ['title' => ..., 'description' => ..., 'path' => '/...'].
 */
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/icons.php';

$page = $page ?? [];
// Título: 'seo_title' (completo) tem prioridade; senão "Título | ARS Iluminação".
$pageTitle = $page['seo_title'] ?? (isset($page['title']) && $page['title'] !== ''
    ? $page['title'] . ' | ' . ARS_SITE['name']
    : ARS_SITE['name'] . ' | ' . ARS_SITE['tagline']);
$pageDescription = seo_desc($page['description'] ?? ARS_SITE['description']);
$base = ars_site_url();
$canonical = $base . ($page['path'] ?? '/');
$ogImage = $base . ($page['image'] ?? '/assets/img/hero-ars-fachada-frontal.jpg');
$ogImageAlt = $page['image_alt'] ?? ($page['title'] ?? ARS_SITE['name']);

$orgJsonLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',
    '@id'      => $base . '/#organizacao',
    'name'     => ARS_SITE['name'],
    'url'      => $base . '/',
    'logo'     => $base . '/assets/img/ars-logo-colorido.webp',
    'image'    => $base . '/assets/img/hero-ars-fachada-frontal.jpg',
    'description' => 'Fabricante de luminárias e perfis de LED em Socorro/SP desde 2014, com entrega para todo o Brasil.',
    'foundingDate' => '2014',
    'email'    => ARS_SITE['email'],
    'telephone' => '+' . ARS_SITE['whatsapp']['number'],
    'contactPoint' => [
        '@type'       => 'ContactPoint',
        'contactType' => 'sales',
        'telephone'   => '+' . ARS_SITE['whatsapp']['number'],
        'email'       => ARS_SITE['email'],
        'areaServed'  => 'BR',
        'availableLanguage' => 'Portuguese',
    ],
    'areaServed' => ['@type' => 'Country', 'name' => 'Brasil'],
    'brand'    => [['@type' => 'Brand', 'name' => 'ARS Iluminação'], ['@type' => 'Brand', 'name' => 'Bonalux']],
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
$jsonLd = [$orgJsonLd];
$path = $page['path'] ?? '/';
if ($path === '/') {
    $jsonLd[] = [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        '@id'      => $base . '/#site',
        'name'     => ARS_SITE['name'],
        'url'      => $base . '/',
        'inLanguage' => 'pt-BR',
        'publisher' => ['@id' => $base . '/#organizacao'],
    ];
} elseif (!empty($page['title'])) {
    // Trilha: $page['breadcrumbs'] = [['Nome', '/caminho/'], ...] (sem o Início). Padrão: só a página atual.
    $trail = $page['breadcrumbs'] ?? [[$page['title'], $path]];
    $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Início', 'item' => $base . '/']];
    foreach (array_values($trail) as $i => [$crumbName, $crumbPath]) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $crumbName, 'item' => $base . $crumbPath];
    }
    $jsonLd[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
}
foreach ($page['jsonld'] ?? [] as $extraLd) {
    $jsonLd[] = $extraLd;
}
$ga4 = preg_replace('/[^A-Z0-9\-]/', '', strtoupper((string) ars_config()['ga4_id']));
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
<meta property="og:type" content="<?= e($page['og_type'] ?? 'website') ?>">
<meta property="og:locale" content="pt_BR">
<meta property="og:site_name" content="<?= e(ARS_SITE['name']) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:image:alt" content="<?= e($ogImageAlt) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDescription) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">
<link rel="alternate" type="text/plain" title="Resumo do site para assistentes de IA" href="/llms.txt">
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="preload" href="/assets/fonts/manrope-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
<?php if (!empty($page['preload'])): foreach ($page['preload'] as $pre): ?>
<link rel="preload" as="image" href="<?= e($pre['href']) ?>"<?= isset($pre['srcset']) ? ' imagesrcset="' . e($pre['srcset']) . '" imagesizes="100vw"' : '' ?>>
<?php endforeach; endif; ?>
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
<?php foreach ($jsonLd as $ld): ?>
<script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<?php endforeach; ?>
<?php if ($ga4 !== '' && !ars_noindex()): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($ga4) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($ga4) ?>');</script>
<?php endif; ?>
</head>
<body>
<a class="skip-link" href="#conteudo">Ir para o conteúdo</a>
