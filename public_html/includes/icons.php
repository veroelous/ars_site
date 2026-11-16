<?php
/** Ícones SVG inline (sem dependências externas). */
declare(strict_types=1);

function icon(string $name, int $size = 16, string $class = ''): string
{
    $cls = $class !== '' ? ' class="' . e($class) . '"' : '';
    $stroke = 'fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"';
    $open = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false"' . $cls . ' ';
    switch ($name) {
        case 'instagram':
            return $open . $stroke . '><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.6" fill="currentColor"/></svg>';
        case 'arrow-up-right':
            return $open . $stroke . '><path d="M7 17 17 7M8 7h9v9"/></svg>';
        case 'arrow-down':
            return $open . $stroke . '><path d="M12 5v14M6 13l6 6 6-6"/></svg>';
        case 'map-pin':
            return $open . $stroke . '><path d="M12 21s-7-6.1-7-11.5a7 7 0 0 1 14 0C19 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.5"/></svg>';
        case 'mail':
            return $open . $stroke . '><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>';
        case 'bulb':
            return $open . 'fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6M10 21h4"/><path d="M12 3a6 6 0 0 0-3.6 10.8c.7.5 1.1 1.3 1.1 2.2h5c0-.9.4-1.7 1.1-2.2A6 6 0 0 0 12 3Z"/></svg>';
        case 'whatsapp':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 64 64" aria-hidden="true" focusable="false"' . $cls . '><path fill="currentColor" d="M32 5C17.1 5 5 17.1 5 32c0 4.8 1.3 9.3 3.6 13.2L5 59l14.3-3.4A26.9 26.9 0 0 0 32 59c14.9 0 27-12.1 27-27S46.9 5 32 5zm0 49c-4.1 0-8.1-1.1-11.6-3.2l-.8-.5-8.5 2 2.1-8.3-.5-.8A21.8 21.8 0 1 1 32 54z"/><path fill="currentColor" d="M43.4 36.8c-.6-.3-3.7-1.8-4.3-2s-1-.3-1.5.3-1.7 2-2.1 2.4-.8.5-1.4.2c-.6-.3-2.6-1-5-3.2-1.8-1.6-3-3.6-3.4-4.2-.4-.7 0-1 .3-1.3l1-1.2c.3-.4.4-.7.6-1.1.2-.4.1-.8-.1-1.2-.2-.3-1.5-3.5-2-4.8-.5-1.2-1-1-1.4-1l-1.2 0c-.4 0-1.1.2-1.7.8-.6.6-2.2 2.1-2.2 5.2s2.2 6 2.5 6.4c.3.4 4.3 6.6 10.5 9.2 1.5.7 2.7 1.1 3.6 1.4 1.5.5 2.9.4 4 .2 1.2-.2 3.7-1.5 4.2-2.9.5-1.4.5-2.6.3-2.9-.1-.3-.5-.4-1.1-.7z"/></svg>';
    }
    return '';
}
