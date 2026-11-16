<?php
/** Exportação dos contatos em CSV (abre no Excel). Protegida por usuário e senha da configuração privada. */
declare(strict_types=1);

require dirname(__DIR__) . '/includes/bootstrap.php';

header('X-Robots-Tag: noindex');
header('Cache-Control: no-store');

$config = ars_config();
if ($config['admin_user'] === '' || $config['admin_pass_hash'] === '') {
    http_response_code(404);
    exit('Não encontrado.');
}

// Credenciais via HTTP Basic. Em alguns servidores o cabeçalho chega por HTTP_AUTHORIZATION.
$user = $_SERVER['PHP_AUTH_USER'] ?? '';
$pass = $_SERVER['PHP_AUTH_PW'] ?? '';
$auth = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
if ($user === '' && str_starts_with($auth, 'Basic ')) {
    [$user, $pass] = array_pad(explode(':', (string) base64_decode(substr($auth, 6)), 2), 2, '');
}
if (!hash_equals((string) $config['admin_user'], (string) $user) || !password_verify((string) $pass, (string) $config['admin_pass_hash'])) {
    usleep(500000);
    header('WWW-Authenticate: Basic realm="Contatos ARS", charset="UTF-8"');
    http_response_code(401);
    exit('Autenticação necessária.');
}

$file = ars_private_dir() . '/leads/leads.jsonl';
$rows = is_file($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

function csv_cell(mixed $value): string
{
    $s = (string) ($value ?? '');
    if ($s !== '' && str_contains("=+-@\t\r", $s[0])) {
        $s = "'" . $s; // evita fórmulas ao abrir no Excel
    }
    return '"' . str_replace('"', '""', $s) . '"';
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="contatos-ars-' . date('Y-m-d') . '.csv"');
echo "\xEF\xBB\xBF" . implode(';', ['data', 'origem', 'nome', 'whatsapp', 'email', 'empresa', 'mensagem', 'consentimento']) . "\r\n";
foreach ($rows as $line) {
    $l = json_decode($line, true);
    if (!is_array($l)) {
        continue;
    }
    echo implode(';', array_map('csv_cell', [
        $l['criadoEm'] ?? '', $l['origem'] ?? '', $l['nome'] ?? '', $l['whatsapp'] ?? '',
        $l['email'] ?? '', $l['empresa'] ?? '', $l['mensagem'] ?? '', $l['consentimento']['em'] ?? '',
    ])) . "\r\n";
}
