<?php
/**
 * Últimas publicações do Instagram pela Instagram API (Instagram Login).
 * O token fica só no servidor (config privada). Resposta guardada em cache.
 * Sem token, ou em caso de falha, retorna null e a página usa os embeds fixos.
 */
declare(strict_types=1);

function instagram_posts(int $limit = 3): ?array
{
    $config = ars_config();
    $token = trim((string) $config['instagram_token']);
    if ($token === '') {
        return null;
    }

    $cacheFile = ars_private_path('cache') . '/instagram.json';
    $ttl = max(300, (int) $config['instagram_ttl']);
    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached)) {
            return $cached ?: null;
        }
    }

    $url = 'https://graph.instagram.com/me/media?' . http_build_query([
        'fields'       => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
        'limit'        => $limit,
        'access_token' => $token,
    ]);
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 6, CURLOPT_CONNECTTIMEOUT => 4]);
    $body = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($body === false || $status !== 200) {
        error_log('[ars] Instagram API respondeu ' . $status);
        // Mantém o cache anterior, se houver, para não perder o feed por uma falha momentânea.
        if (is_file($cacheFile)) {
            $old = json_decode((string) file_get_contents($cacheFile), true);
            return is_array($old) && $old ? $old : null;
        }
        return null;
    }

    $posts = [];
    foreach ((json_decode($body, true)['data'] ?? []) as $m) {
        $image = ($m['media_type'] ?? '') === 'VIDEO' ? ($m['thumbnail_url'] ?? '') : ($m['media_url'] ?? '');
        if ($image === '' || empty($m['permalink'])) {
            continue;
        }
        $posts[] = [
            'permalink' => (string) $m['permalink'],
            'caption'   => (string) ($m['caption'] ?? ''),
            'image'     => (string) $image,
            'video'     => ($m['media_type'] ?? '') === 'VIDEO',
        ];
    }
    $posts = array_slice($posts, 0, $limit);
    @file_put_contents($cacheFile, json_encode($posts), LOCK_EX);
    return $posts ?: null;
}

function excerpt(string $text, int $max = 140): string
{
    $line = trim((string) preg_replace('/\s+/u', ' ', $text));
    return mb_strlen($line) > $max ? rtrim(mb_substr($line, 0, $max)) . '…' : $line;
}
