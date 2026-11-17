<?php
/** Recebe o formulário do catálogo, grava o contato e libera o download. */
declare(strict_types=1);

require dirname(__DIR__) . '/includes/leads.php';

header('X-Robots-Tag: noindex');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /#catalogo', true, 303);
    exit;
}
if (!same_origin()) {
    respond(false, ['message' => 'Origem não permitida.'], '/?erro=1#catalogo', 403);
}
if (rate_limited('catalogo', 8)) {
    respond(false, ['message' => 'Muitas tentativas. Aguarde alguns minutos e tente novamente.'], '/?erro=1#catalogo', 429);
}

$in = request_input();

// Campo-armadilha: preenchido só por robôs. Finge sucesso e não grava.
if (is_string($in['site'] ?? null) && trim($in['site']) !== '') {
    respond(true, ['downloadUrl' => null], '/#catalogo');
}

[$data, $errors] = validate_lead($in, 'catalogo');
if ($errors) {
    respond(false, ['message' => 'Confira os campos destacados.', 'errors' => $errors], '/?erro=1#catalogo', 422);
}

try {
    $lead = store_lead('catalogo', $data, '/');
    notify_lead($lead);
    $url = '/api/catalogo-download.php?token=' . rawurlencode(create_catalog_token($lead['id']));
    respond(true, ['downloadUrl' => $url], $url);
} catch (Throwable $err) {
    error_log('[ars] catálogo: ' . $err->getMessage());
    respond(false, ['message' => 'Não foi possível enviar agora. Tente novamente.'], '/?erro=1#catalogo', 500);
}
