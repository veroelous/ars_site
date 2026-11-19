<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

header('Content-Type: application/xml; charset=utf-8');
$base = ars_site_url();
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
foreach (ARS_PAGES as $item) {
    $file = __DIR__ . rtrim($item['href'], '/') . '/index.php';
    // Páginas de categoria (/produtos/<linha>/) não têm arquivo próprio: usam a data do catálogo.
    $lastmod = date('Y-m-d', is_file($file) ? filemtime($file) : filemtime(__DIR__ . '/includes/produtos.php'));
    printf(
        "  <url><loc>%s</loc><lastmod>%s</lastmod><priority>%s</priority></url>\n",
        htmlspecialchars($base . $item['href'], ENT_XML1),
        $lastmod,
        $item['priority']
    );
}
require_once __DIR__ . '/includes/produtos.php';
$lastmodProdutos = date('Y-m-d', max(filemtime(__DIR__ . '/includes/produtos.php'), filemtime(__DIR__ . '/produtos/produto.php')));
foreach (ars_produtos() as $slug => $p) {
    // Imagens do produto (foto principal + versões) no sitemap de imagens do Google.
    $imgs = [produto_imagem($slug, $p)];
    foreach ($p['versoes'] ?? [] as $v) {
        $imgs[] = '/assets/img/produtos/' . $p['categoria'] . '/' . $v['imagem'] . '.webp';
    }
    $xmlImgs = '';
    foreach (array_unique($imgs) as $img) {
        $xmlImgs .= '<image:image><image:loc>' . htmlspecialchars($base . $img, ENT_XML1) . '</image:loc></image:image>';
    }
    printf(
        "  <url><loc>%s</loc><lastmod>%s</lastmod><priority>0.8</priority>%s</url>\n",
        htmlspecialchars($base . produto_url($slug, $p), ENT_XML1),
        $lastmodProdutos,
        $xmlImgs
    );
}
echo "</urlset>\n";
