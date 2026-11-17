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
echo "</urlset>\n";
