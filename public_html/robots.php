<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');
if (ars_noindex()) {
    echo "User-agent: *\nDisallow: /\n";
    exit;
}
echo "User-agent: *\nAllow: /\nDisallow: /api/\nDisallow: /admin/\n\nSitemap: " . ars_site_url() . "/sitemap.xml\n";
