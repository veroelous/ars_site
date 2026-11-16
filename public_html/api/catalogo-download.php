<?php
/** Entrega o PDF do catálogo apenas com um link válido (assinado e dentro do prazo). */
declare(strict_types=1);

require dirname(__DIR__) . '/includes/leads.php';

header('X-Robots-Tag: noindex');

$token = is_string($_GET['token'] ?? null) ? $_GET['token'] : '';
try {
    $valid = verify_catalog_token($token);
} catch (Throwable $err) {
    error_log('[ars] download: ' . $err->getMessage());
    $valid = false;
}
if (!$valid) {
    header('Location: /?catalogo=expirado#catalogo', true, 303);
    exit;
}

$file = ars_private_dir() . '/' . ARS_SITE['catalog']['fileName'];
if (!is_file($file)) {
    error_log('[ars] catálogo não encontrado em ' . $file);
    http_response_code(500);
    exit('Catálogo indisponível no momento.');
}

header('Content-Type: application/pdf');
header('Content-Length: ' . filesize($file));
header('Content-Disposition: attachment; filename="' . ARS_SITE['catalog']['fileName'] . '"');
header('Cache-Control: private, no-store');
readfile($file);
