<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');
if (ars_noindex()) {
    echo "User-agent: *\nDisallow: /\n";
    exit;
}
$regras = "Allow: /\nDisallow: /api/\nDisallow: /admin/\n";
echo "User-agent: *\n" . $regras . "\n";
// Buscadores e assistentes de IA: acesso liberado de forma explícita.
foreach (['Googlebot', 'Bingbot', 'GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-User', 'Claude-SearchBot', 'PerplexityBot', 'Google-Extended', 'Applebot-Extended'] as $bot) {
    echo "User-agent: " . $bot . "\n";
}
echo $regras . "\n";
echo "Sitemap: " . ars_site_url() . "/sitemap.xml\n";
echo "# Resumo do site para IA: " . ars_site_url() . "/llms.txt\n";
