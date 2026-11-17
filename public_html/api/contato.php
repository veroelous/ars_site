<?php
/** Recebe o formulário de contato e orçamento. */
declare(strict_types=1);

require dirname(__DIR__) . '/includes/leads.php';

header('X-Robots-Tag: noindex');

$back = '/contato-e-orcamento/';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $back, true, 303);
    exit;
}
if (!same_origin()) {
    respond(false, ['message' => 'Origem não permitida.'], $back . '?erro=1', 403);
}
if (rate_limited('contato', 5)) {
    respond(false, ['message' => 'Muitas tentativas. Aguarde alguns minutos e tente novamente.'], $back . '?erro=1', 429);
}

$in = request_input();
if (is_string($in['site'] ?? null) && trim($in['site']) !== '') {
    respond(true, [], $back . '?enviado=1');
}

[$data, $errors] = validate_lead($in, 'contato');
if ($errors) {
    respond(false, ['message' => 'Confira os campos destacados.', 'errors' => $errors], $back . '?erro=1', 422);
}

try {
    $lead = store_lead('contato', $data, $back);
    notify_lead($lead);
    respond(true, [], $back . '?enviado=1');
} catch (Throwable $err) {
    error_log('[ars] contato: ' . $err->getMessage());
    respond(false, ['message' => 'Não foi possível enviar agora. Tente novamente ou use o e-mail comercial.'], $back . '?erro=1', 500);
}
