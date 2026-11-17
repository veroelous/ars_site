<?php
/**
 * Formulários: validação, proteção, gravação dos contatos e aviso por e-mail.
 * Os contatos ficam em <pasta privada>/leads/leads.jsonl (um por linha), nunca no Git.
 */
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

const ARS_LIMITS = ['name' => 120, 'company' => 120, 'email' => 160, 'message' => 3000];

function wants_json(): bool
{
    return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
}

/** Responde em JSON (envio por JavaScript) ou redireciona (navegador sem JavaScript). */
function respond(bool $ok, array $payload, string $redirect, int $status = 200): never
{
    if (wants_json()) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode(['ok' => $ok] + $payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
    header('Location: ' . $redirect, true, 303);
    exit;
}

/** Aceita apenas envios do próprio site (proteção básica contra CSRF). */
function same_origin(): bool
{
    $source = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
    if ($source === '') {
        return true;
    }
    $host = parse_url($source, PHP_URL_HOST);
    $own = preg_replace('/:\d+$/', '', strtolower($_SERVER['HTTP_HOST'] ?? ''));
    return is_string($host) && strtolower($host) === $own;
}

/** Limite de envios por IP, em arquivo. */
function rate_limited(string $bucket, int $max = 6, int $window = 600): bool
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconhecido';
    $file = ars_private_path('ratelimit') . '/' . $bucket . '-' . hash('sha256', $ip) . '.json';
    $now = time();
    $hits = is_file($file) ? (json_decode((string) file_get_contents($file), true) ?: []) : [];
    $hits = array_values(array_filter($hits, static fn($t) => is_int($t) && $t > $now - $window));
    $hits[] = $now;
    @file_put_contents($file, json_encode($hits), LOCK_EX);
    return count($hits) > $max;
}

function clean_line(mixed $value, int $max): string
{
    if (!is_string($value)) {
        return '';
    }
    $value = trim((string) preg_replace('/\s+/u', ' ', $value));
    return mb_substr($value, 0, $max);
}

/** Celular ou fixo brasileiro com DDD, com ou sem +55. Retorna só dígitos. */
function normalize_whatsapp(mixed $value): ?string
{
    $digits = preg_replace('/\D+/', '', is_string($value) ? $value : '');
    if (strlen($digits) >= 12 && str_starts_with($digits, '55')) {
        $digits = substr($digits, 2);
    }
    $len = strlen($digits);
    if ($len !== 10 && $len !== 11) {
        return null;
    }
    $ddd = (int) substr($digits, 0, 2);
    if ($ddd < 11 || $ddd > 99) {
        return null;
    }
    if ($len === 11 && $digits[2] !== '9') {
        return null;
    }
    return $digits;
}

function format_cnpj(string $d): string
{
    return strlen($d) === 14
        ? sprintf('%s.%s.%s/%s-%s', substr($d, 0, 2), substr($d, 2, 3), substr($d, 5, 3), substr($d, 8, 4), substr($d, 12))
        : $d;
}

function format_whatsapp(string $digits): string
{
    return strlen($digits) === 11
        ? sprintf('(%s) %s-%s', substr($digits, 0, 2), substr($digits, 2, 5), substr($digits, 7))
        : sprintf('(%s) %s-%s', substr($digits, 0, 2), substr($digits, 2, 4), substr($digits, 6));
}

const ARS_UFS = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];

const ARS_PERFIS = [
    'lojista'      => 'Loja de iluminação ou materiais elétricos',
    'distribuidor' => 'Distribuidor ou atacadista',
    'especificador'=> 'Arquiteto, designer ou lighting designer',
    'instalador'   => 'Eletricista, instalador ou construtora',
    'outro'        => 'Outro',
];

/** CNPJ com dígitos verificadores válidos. Retorna só os dígitos, ou null. */
function normalize_cnpj(mixed $value): ?string
{
    $d = preg_replace('/\D+/', '', is_string($value) ? $value : '');
    if (strlen($d) !== 14 || preg_match('/^(\d)\1{13}$/', $d)) {
        return null;
    }
    foreach ([12, 13] as $len) {
        $sum = 0;
        $weight = $len - 7;
        for ($i = 0; $i < $len; $i++) {
            $sum += (int) $d[$i] * $weight--;
            if ($weight < 2) {
                $weight = 9;
            }
        }
        $digit = $sum % 11 < 2 ? 0 : 11 - $sum % 11;
        if ((int) $d[$len] !== $digit) {
            return null;
        }
    }
    return $d;
}

/**
 * Valida os campos de cada formulário: "catalogo", "contato" ou "revendedor".
 * Retorna [dados, erros].
 */
function validate_lead(array $in, string $kind): array
{
    $errors = [];
    $data = [
        'nome'     => clean_line($in['nome'] ?? '', ARS_LIMITS['name']),
        'email'    => strtolower(clean_line($in['email'] ?? '', ARS_LIMITS['email'])),
        'whatsapp' => normalize_whatsapp($in['whatsapp'] ?? ''),
    ];
    $consent = in_array($in['consentimento'] ?? '', ['on', 'true', '1', true], true);

    if (mb_strlen($data['nome']) < 2) {
        $errors['nome'] = 'Informe seu nome.';
    }
    if ($data['whatsapp'] === null) {
        $errors['whatsapp'] = 'Informe um WhatsApp válido com DDD.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Informe um e-mail válido.';
    }

    if ($kind === 'contato' || $kind === 'revendedor') {
        $data['empresa'] = clean_line($in['empresa'] ?? '', ARS_LIMITS['company']);
        $msg = is_string($in['mensagem'] ?? null) ? trim($in['mensagem']) : '';
        $data['mensagem'] = mb_substr($msg, 0, ARS_LIMITS['message']);
    }
    if ($kind === 'contato' && mb_strlen($data['mensagem']) < 5) {
        $errors['mensagem'] = 'Conte brevemente o que você precisa.';
    }

    if ($kind === 'revendedor') {
        if (mb_strlen($data['empresa']) < 2) {
            $errors['empresa'] = 'Informe o nome da empresa.';
        }
        $cnpjRaw = clean_line($in['cnpj'] ?? '', 20);
        $data['cnpj'] = '';
        if ($cnpjRaw !== '') {
            $cnpj = normalize_cnpj($cnpjRaw);
            if ($cnpj === null) {
                $errors['cnpj'] = 'Confira o CNPJ (14 números).';
            } else {
                $data['cnpj'] = $cnpj;
            }
        }
        $data['cidade'] = clean_line($in['cidade'] ?? '', 80);
        if (mb_strlen($data['cidade']) < 2) {
            $errors['cidade'] = 'Informe a cidade.';
        }
        $data['uf'] = strtoupper(clean_line($in['uf'] ?? '', 2));
        if (!in_array($data['uf'], ARS_UFS, true)) {
            $errors['uf'] = 'Selecione o estado.';
        }
        $data['perfil'] = clean_line($in['perfil'] ?? '', 20);
        if (!array_key_exists($data['perfil'], ARS_PERFIS)) {
            $errors['perfil'] = 'Selecione o tipo de negócio.';
        }
    }

    if (!$consent) {
        $errors['consentimento'] = match ($kind) {
            'catalogo' => 'É preciso autorizar o contato para liberar o catálogo.',
            'revendedor' => 'É preciso autorizar o contato para enviar o cadastro.',
            default => 'É preciso autorizar o contato para enviar a mensagem.',
        };
    }
    return [$data, $errors];
}

/** Lê o corpo do envio (formulário comum ou JSON). */
function request_input(): array
{
    if (str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
        $json = json_decode((string) file_get_contents('php://input'), true);
        return is_array($json) ? $json : [];
    }
    return $_POST;
}

/** Grava o contato e retorna o registro salvo. */
function store_lead(string $origin, array $data, string $pagePath): array
{
    $now = gmdate('c');
    $lead = [
        'id'            => bin2hex(random_bytes(8)),
        'criadoEm'      => $now,
        'origem'        => $origin,
        'nome'          => $data['nome'],
        'whatsapp'      => $data['whatsapp'],
        'email'         => $data['email'],
        'empresa'       => $data['empresa'] ?? '',
        'mensagem'      => $data['mensagem'] ?? '',
        'cnpj'          => $data['cnpj'] ?? '',
        'cidade'        => $data['cidade'] ?? '',
        'uf'            => $data['uf'] ?? '',
        'perfil'        => $data['perfil'] ?? '',
        'pagina'        => $pagePath,
        'consentimento' => ['aceito' => true, 'texto' => ARS_SITE['consent'], 'em' => $now],
    ];
    $dir = ars_private_path('leads');
    $file = $dir . '/leads.jsonl';
    $line = json_encode($lead, JSON_UNESCAPED_UNICODE) . "\n";
    if (file_put_contents($file, $line, FILE_APPEND | LOCK_EX) === false) {
        throw new RuntimeException('Não foi possível gravar o contato.');
    }
    @chmod($file, 0600);
    return $lead;
}

/** Envia o aviso de novo contato para o e-mail da ARS. Falha no e-mail não perde o contato. */
function notify_lead(array $lead): void
{
    $config = ars_config();
    $to = ARS_SITE['email'];
    $origin = match ($lead['origem']) {
        'catalogo'   => 'Download do catálogo',
        'revendedor' => 'Cadastro de revendedor',
        default      => 'Formulário de contato',
    };
    $subject = '=?UTF-8?B?' . base64_encode('Novo contato pelo site: ' . $lead['nome'] . ' (' . $origin . ')') . '?=';
    $body = implode("\n", array_filter([
        'Novo contato recebido pelo site da ARS Iluminação.',
        '',
        'Origem: ' . $origin,
        'Nome: ' . $lead['nome'],
        $lead['empresa'] !== '' ? 'Empresa: ' . $lead['empresa'] : null,
        $lead['cnpj'] !== '' ? 'CNPJ: ' . format_cnpj($lead['cnpj']) : null,
        $lead['cidade'] !== '' ? 'Cidade: ' . $lead['cidade'] . '/' . $lead['uf'] : null,
        $lead['perfil'] !== '' ? 'Perfil: ' . (ARS_PERFIS[$lead['perfil']] ?? $lead['perfil']) : null,
        'WhatsApp: ' . format_whatsapp($lead['whatsapp']) . ' — https://wa.me/55' . $lead['whatsapp'],
        'E-mail: ' . $lead['email'],
        $lead['mensagem'] !== '' ? "\nMensagem:\n" . $lead['mensagem'] : null,
        '',
        'Recebido em: ' . date('d/m/Y H:i', strtotime($lead['criadoEm'])),
    ], static fn($l) => $l !== null));

    $from = (string) $config['mail_from'];
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'From: =?UTF-8?B?' . base64_encode('Site ARS Iluminação') . '?= <' . $from . '>',
        'Reply-To: ' . str_replace(["\r", "\n"], '', $lead['email']),
    ];
    if (!@mail($to, $subject, $body, implode("\r\n", $headers), '-f' . $from)) {
        error_log('[ars] falha ao enviar aviso de contato ' . $lead['id']);
    }
}

/* ---------- Link temporário do catálogo ---------- */

const ARS_TOKEN_TTL = 1800; // 30 minutos

function catalog_secret(): string
{
    $secret = (string) ars_config()['catalog_secret'];
    if (strlen($secret) < 32) {
        throw new RuntimeException('catalog_secret ausente ou curto na configuração privada.');
    }
    return $secret;
}

function b64url(string $data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function create_catalog_token(string $leadId): string
{
    $payload = b64url(json_encode(['l' => $leadId, 'e' => time() + ARS_TOKEN_TTL]));
    return $payload . '.' . b64url(hash_hmac('sha256', $payload, catalog_secret(), true));
}

function verify_catalog_token(string $token): bool
{
    if ($token === '' || strlen($token) > 512 || !str_contains($token, '.')) {
        return false;
    }
    [$payload, $signature] = explode('.', $token, 2);
    $expected = b64url(hash_hmac('sha256', $payload, catalog_secret(), true));
    if (!hash_equals($expected, $signature)) {
        return false;
    }
    $data = json_decode((string) base64_decode(strtr($payload, '-_', '+/')), true);
    return is_array($data) && is_int($data['e'] ?? null) && $data['e'] > time();
}
