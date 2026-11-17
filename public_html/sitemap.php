<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

header('Content-Type: application/xml; charset=utf-8');
$base = ars_site_url();
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (ARS_PAGES as $item) {
    $file = __DIR__ . rtrim($item['href'], '/') . '/index.php';
    $lastmod = is_file($file) ? date('Y-m-d', filemtime($file)) : date('Y-m-d');
    printf(
        "  <url><loc>%s</loc><lastmod>%s</lastmod><priority>%s</priority></url>\n",
        htmlspecialchars($base . $item['href'], ENT_XML1),
        $lastmod,
        $item['priority']
    );
}
require_once __DIR__ . '/includes/produtos.php';
foreach (ars_produtos() as $slug => $p) {
    printf(
        "  <url><loc>%s</loc><lastmod>%s</lastmod><priority>0.8</priority></url>\n",
        htmlspecialchars($base . produto_url($slug, $p), ENT_XML1),
        date('Y-m-d', filemtime(__DIR__ . '/includes/produtos.php'))
    );
}
echo "</urlset>\n";
