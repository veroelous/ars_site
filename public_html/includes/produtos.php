<?php
/**
 * Catálogo de produtos do site.
 *
 * Fonte: Catálogo ARS (PDF oficial, 68 páginas). Medidas, códigos e acessórios foram
 * transcritos das páginas indicadas em 'pagina'. Revisão pela ARS pendente — ver
 * docs/PENDENCIAS.md. Para corrigir um produto, altere só o item dele aqui.
 */
declare(strict_types=1);

/** Acabamentos usados no catálogo (sigla → nome). */
const ARS_ACABAMENTOS = ['BR' => 'Branco', 'CB' => 'Cobre', 'PT' => 'Preto', 'AL' => 'Alumínio'];

/** Acabamentos dos perfis de LED (os códigos seguem esta ordem). */
const ARS_ACABAMENTOS_PERFIL = ['BR' => 'Branco', 'PT' => 'Preto', 'AL' => 'Alumínio'];

/**
 * Categorias, na ordem do sumário do catálogo.
 * 'online' = já tem páginas de produto no site; as demais aparecem com o catálogo em PDF.
 */
const ARS_CATEGORIAS = [
    'perfis-de-led' => [
        'nome'      => 'Perfis de LED',
        'resumo'    => 'Perfis de alumínio para fita de LED: sobrepor, embutir, canto e piso.',
        'descricao' => 'Perfis de alumínio para fita de LED nas versões de sobrepor, embutir, canto e piso, nos acabamentos branco, preto e alumínio, com comprimentos de 1, 2 e 3 metros.',
        'imagem'    => 'perfis-de-led.webp',
        'pagina'    => 3,
        'online'    => true,
    ],
    'colecao-bonalux' => ['nome' => 'Coleção Bonalux', 'resumo' => 'Linhas decorativas da coleção Bonalux, do Grupo ARS.', 'imagem' => 'colecao-bonalux.webp', 'pagina' => 13, 'online' => false],
    'arandelas'       => ['nome' => 'Arandelas', 'resumo' => 'Arandelas para parede em diversos modelos e acabamentos.', 'imagem' => 'arandelas.webp', 'pagina' => 22, 'online' => false],
    'pendentes'       => ['nome' => 'Pendentes', 'resumo' => 'Pendentes em diversos modelos, tamanhos e acabamentos.', 'imagem' => 'pendentes.webp', 'pagina' => 27, 'online' => false],
    'embutidos'       => ['nome' => 'Embutidos', 'resumo' => 'Luminárias de embutir simples e múltiplas.', 'imagem' => 'embutidos.webp', 'pagina' => 45, 'online' => false],
    'modulos-de-sobrepor' => ['nome' => 'Módulos de sobrepor', 'resumo' => 'Módulos e cilindros de sobrepor.', 'imagem' => 'modulos-de-sobrepor.webp', 'pagina' => 47, 'online' => false],
    'spots' => [
        'nome'      => 'Spots',
        'resumo'    => 'Spots de sobrepor de 1 a 4 focos, com base redonda ou trilho.',
        'descricao' => 'Spots de sobrepor em versões de 1 a 4 focos, com base redonda ou trilho, para soquete E27, GU10 ou E27/PAR20, em acabamentos branco, cobre, preto e alumínio (conforme o modelo).',
        'imagem'    => 'spots.webp',
        'pagina'    => 49,
        'online'    => true,
    ],
    'jardim'          => ['nome' => 'Jardim', 'resumo' => 'Espetos, balizadores e arandelas para áreas externas.', 'imagem' => 'jardim.webp', 'pagina' => 61, 'online' => false],
    'vidros'          => ['nome' => 'Vidros', 'resumo' => 'Peças com vidro decorado em diversos padrões.', 'imagem' => 'vidros.webp', 'pagina' => 66, 'online' => false],
];

/** Grupos de produtos dentro de cada categoria, na ordem em que aparecem na página da categoria. */
const ARS_TIPOS = [
    'perfis-de-led' => [
        'sobrepor' => ['nome' => 'Perfis de sobrepor', 'uso' => 'Instalados diretamente sobre a superfície.'],
        'embutir'  => ['nome' => 'Perfis de embutir', 'uso' => 'Instalados dentro de forro, gesso ou marcenaria, com a aba rente à superfície.'],
        'canto'    => ['nome' => 'Perfil de canto', 'uso' => 'Para instalação em cantos a 90°.'],
        'piso'     => ['nome' => 'Perfil de piso', 'uso' => 'Para aplicação no piso, com lente difusora em policarbonato.'],
    ],
    'spots' => [
        'e27'   => ['nome' => 'Spots para soquete E27', 'uso' => 'Spots de sobrepor para lâmpadas com base E27, em base redonda ou trilho.'],
        'gu10'  => ['nome' => 'Spots para soquete GU10', 'uso' => 'Para lâmpadas dicroicas e LED GU10.'],
        'par20' => ['nome' => 'Spots para E27 / PAR20', 'uso' => 'Corpo maior, para lâmpadas PAR20 com base E27.'],
    ],
];

/**
 * Códigos de um perfil no padrão do catálogo: prefixo + comprimento (1, 2 ou 3) + [infixo] + acabamento (1 BR, 2 PT, 3 AL).
 * Ex.: prefixo "1211" → 121111 (1 m, branco) … 121133 (3 m, alumínio).
 *      prefixo "177" e infixo "0" → 177101 (1 m, branco) … 177303.
 */
function perfil_codigos(string $prefixo, string $infixo = ''): array
{
    $out = [];
    foreach (['BR' => 1, 'PT' => 2, 'AL' => 3] as $sigla => $f) {
        foreach ([1, 2, 3] as $m) {
            $out[$sigla][$m . ' m'] = $prefixo . $m . $infixo . $f;
        }
    }
    return $out;
}

/** Monta um perfil no formato padrão. */
function perfil(string $tipo, string $medida, string $largura, string $altura, string $base, int $pagina, array $codigos, array $acessorios, array $extra = []): array
{
    $tipoNome = ['sobrepor' => 'Perfil de sobrepor', 'embutir' => 'Perfil de embutir', 'canto' => 'Perfil de canto', 'piso' => 'Perfil de piso'][$tipo];
    $nome = $tipoNome . ' ' . $medida;
    return [
        'categoria'    => 'perfis-de-led',
        'tipo'         => $tipo,
        'nome'         => $nome,
        'medida'       => $medida,
        'largura'      => $largura,
        'altura'       => $altura,
        'base'         => $base,
        'comprimentos' => ['1 m', '2 m', '3 m'],
        'codigos'      => $codigos,
        'acessorios'   => $acessorios,
        'pagina'       => $pagina,
    ] + $extra;
}

/**
 * Monta uma família de spots. Cada versão: [nome, código, trilho (ou null), focos, imagem].
 */
function spot(string $familia, string $grupo, int $pagina, string $soquete, array $acabamentos, array $versoes, array $extra = []): array
{
    $lista = [];
    foreach ($versoes as [$nome, $codigo, $trilho, $focos, $imagem]) {
        $lista[] = ['nome' => $nome, 'codigo' => $codigo, 'trilho' => $trilho, 'focos' => $focos, 'imagem' => $imagem];
    }
    $focos = array_column($lista, 'focos');
    return [
        'categoria'   => 'spots',
        'tipo'        => $grupo,
        'nome'        => 'Spot ' . $familia,
        'familia'     => $familia,
        'soquete'     => $soquete,
        'acabamentos' => $acabamentos,
        'versoes'     => $lista,
        'focos'       => min($focos) === max($focos) ? (string) min($focos) : min($focos) . ' a ' . max($focos),
        'imagem'      => $lista[0]['imagem'],
        'pagina'      => $pagina,
    ] + $extra;
}

/** Produtos por slug (o slug é a URL: /produtos/<categoria>/<slug>/). */
function ars_produtos(): array
{
    static $produtos = null;
    if ($produtos !== null) {
        return $produtos;
    }
    $produtos = [
        'perfil-de-sobrepor-12x11'   => perfil('sobrepor', '12x11', '12,5 mm', '11,3 mm', '1 mm', 3, perfil_codigos('1211'), ['1211', '12112', '201100']),
        'perfil-de-embutir-20x11'    => perfil('embutir', '20x11', '20 mm', '11,3 mm', '1 mm', 3, perfil_codigos('2011'), ['20111', '20112', '201100']),
        'perfil-de-sobrepor-17x7'    => perfil('sobrepor', '17x7', '17,6 mm', '7,1 mm', '1 mm', 4, perfil_codigos('177', '0'), ['17701', '17702', '6468', '7425']),
        'perfil-de-embutir-24x7'     => perfil('embutir', '24x7', '24,4 mm', '7,1 mm', '1 mm', 4, perfil_codigos('247', '0'), ['24701', '24702', '6468', '7425']),
        'perfil-de-sobrepor-17x10'   => perfil('sobrepor', '17x10', '17,6 mm', '10 mm', '1 mm', 5, perfil_codigos('1710'), ['171001', '171002', '6468', '7425']),
        'perfil-de-embutir-28x10'    => perfil('embutir', '28x10', '28 mm', '10 mm', '1 mm', 5, perfil_codigos('2810'), ['281001', '281002', '6468', '7425']),
        'perfil-de-sobrepor-17x14'   => perfil('sobrepor', '17x14', '17,6 mm', '15 mm', '1,1 mm', 6, perfil_codigos('1714'), ['171401', '171402', '6468', '7425']),
        'perfil-de-embutir-24x14'    => perfil('embutir', '24x14', '24,3 mm', '15 mm', '1,1 mm', 6, perfil_codigos('2414'), ['241401', '241402', '6468', '7425']),
        'perfil-de-sobrepor-27x12'   => perfil('sobrepor', '27x12', '27,8 mm', '11,93 mm', '1,2 mm', 7, perfil_codigos('2712'), ['271201', '271202', '6780']),
        'perfil-de-embutir-39x12'    => perfil('embutir', '39x12', '38,92 mm', '11,93 mm', '1,2 mm', 7, perfil_codigos('3912'), ['391201', '391202', '5938']),
        'perfil-de-sobrepor-35x35'   => perfil('sobrepor', '35x35', '35 mm', '35 mm', '1,4 mm', 8, perfil_codigos('3535'), ['353501', '353502', '6779']),
        'perfil-de-embutir-50x35'    => perfil('embutir', '50x35', '49,27 mm', '34,95 mm', '1,4 mm', 8, perfil_codigos('5035'), ['503501', '503502', '503599']),
        'perfil-de-sobrepor-50x20'   => perfil('sobrepor', '50x20', '50,6 mm', '20,8 mm', '1,4 mm', 9, perfil_codigos('5020'), ['502001', '502002', '6779']),
        'perfil-de-embutir-65x20'    => perfil('embutir', '65x20', '65 mm', '20,8 mm', '1,4 mm', 9, perfil_codigos('6520'), ['652001', '652002', '503599']),
        'perfil-de-sobrepor-35x20'   => perfil('sobrepor', '35x20', '35 mm', '20 mm', '1,2 mm', 10, perfil_codigos('3520'), ['352001', '352002', '6779']),
        'perfil-de-sobrepor-36x40'   => perfil('sobrepor', '36x40', '35,7 mm', '40 mm', '1,4 mm', 11, perfil_codigos('3640'), ['364001', '364002', '6779']),
        'perfil-de-sobrepor-75x50'   => perfil('sobrepor', '75x50', '75,2 mm', '50 mm', '1,1 mm', 11, perfil_codigos('7550'), ['755001', '755002', '7418'], [
            'destaques' => ['Iluminação indireta', 'Abertura central de 32 mm'],
        ]),
        'perfil-de-canto-16x16'      => perfil('canto', '16x16', '16 mm', '16 mm', '1 mm', 10, [], ['161701', '161702', '161601', '161602', '7417'], [
            'destaques'      => ['Lente reta ou curva'],
            'codigosVariantes' => ['Lente reta' => perfil_codigos('1617'), 'Lente curva' => perfil_codigos('1616')],
        ]),
        'perfil-de-piso-25x18'       => perfil('piso', '25x18', '25 mm', '18 mm', '1,4 mm', 12, perfil_codigos('2518'), [], [
            'destaques' => ['Lente difusora em policarbonato'],
        ]),
        'perfil-de-embutir-no-frame' => perfil('embutir', 'No Frame', '88 mm', '55 mm', '1,2 mm', 12, perfil_codigos('8555'), ['855501', '855502', '6267'], [
            'destaques' => ['Iluminação indireta', 'Abertura de 35 mm'],
        ]),

        // ---------- Spots (catálogo, páginas 49 a 60) ----------
        'spot-omega' => spot('Ômega', 'e27', 49, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['Ômega 1', 'ARS-44', null, 1, 'omega-1'],
            ['Ômega 2', 'ARS-44', '330 mm', 2, 'omega-2'],
            ['Ômega 3', 'ARS-44', '500 mm', 3, 'omega-3'],
        ]),
        'spot-new' => spot('New', 'e27', 50, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['New 1', 'ARS-4208', null, 1, 'new-1'],
            ['New 2', 'ARS-4202', null, 2, 'new-2'],
            ['New 3', 'ARS-4233', '330 mm', 3, 'new-3'],
            ['New 4', 'ARS-4224', '500 mm', 4, 'new-4'],
        ]),
        'spot-tubo' => spot('Tubo', 'gu10', 51, 'GU10', ['BR', 'CB', 'PT', 'AL'], [
            ['Tubo.1', 'ARS-3601', null, 1, 'tubo-1'],
            ['Tubo.2', 'ARS-3702', '300 mm', 2, 'tubo-2'],
            ['Tubo.3', 'ARS-3613', '330 mm', 3, 'tubo-3'],
            ['Tubo.4', 'ARS-3624', '500 mm', 4, 'tubo-4'],
        ], ['observacao' => 'Não acompanha lâmpada.']),
        'spot-tubo-20' => spot('Tubo 20', 'par20', 52, 'E27 / PAR20', ['BR', 'CB', 'PT', 'AL'], [
            ['Tubo 20.1', 'ARS-2401', null, 1, 'tubo-20-1'],
            ['Tubo 20.2', 'ARS-2422', '300 mm', 2, 'tubo-20-2'],
            ['Tubo 20.3', 'ARS-2423', '330 mm', 3, 'tubo-20-3'],
            ['Tubo 20.4', 'ARS-2414', '500 mm', 4, 'tubo-20-4'],
        ], ['observacao' => 'Não acompanha lâmpada.']),
        'spot-old' => spot('Old', 'e27', 53, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['Old 1', 'ARS-1801', null, 1, 'old-1'],
            ['Old 2', 'ARS-1802', null, 2, 'old-2'],
            ['Old 3', 'ARS-1813', '330 mm', 3, 'old-3'],
            ['Old 4', 'ARS-1824', '500 mm', 4, 'old-4'],
        ], ['observacao' => 'Não acompanha lâmpada.']),
        'spot-soft' => spot('Soft', 'e27', 54, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['Soft 1', 'ARS-3301', null, 1, 'soft-1'],
            ['Soft 2', 'ARS-3202', null, 2, 'soft-2'],
            ['Soft 3', 'ARS-3213', '330 mm', 3, 'soft-3'],
            ['Soft 4', 'ARS-3224', '500 mm', 4, 'soft-4'],
        ]),
        'spot-caneca' => spot('Caneca', 'e27', 55, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['Caneca 1', 'ARS-2201', null, 1, 'caneca-1'],
            ['Caneca 2', 'ARS-2202', null, 2, 'caneca-2'],
            ['Caneca 3', 'ARS-2223', '330 mm', 3, 'caneca-3'],
            ['Caneca 4', 'ARS-2224', '500 mm', 4, 'caneca-4'],
        ], ['observacao' => 'Não acompanha lâmpada.']),
        'spot-tela' => spot('Tela', 'e27', 56, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['Tela 1', 'ARS-3001', null, 1, 'tela-1'],
            ['Tela 2', 'ARS-3004', null, 2, 'tela-2'],
            ['Tela 3', 'ARS-3023', '500 mm', 3, 'tela-3'],
            ['Tela 4', 'ARS-3024', '600 mm', 4, 'tela-4'],
        ]),
        'spot-vintage' => spot('Vintage', 'e27', 57, 'E27', ['BR', 'CB', 'PT'], [
            ['Vintage 1', 'ARS-441/1', null, 1, 'vintage-1'],
            ['Vintage 2', 'ARS-441/2', null, 2, 'vintage-2'],
            ['Vintage 3', 'ARS-TR441/3', '500 mm', 3, 'vintage-3'],
        ]),
        'spot-sino-227' => spot('Sino 227', 'e27', 58, 'E27', ['BR', 'CB', 'PT', 'AL'], [
            ['Sino 227.1', 'ARS-227/1', null, 1, 'sino-227-1'],
            ['Sino 227.2', 'ARS-227/2', null, 2, 'sino-227-2'],
        ]),
        'spot-407' => spot('407', 'e27', 58, 'E27', ['BR', 'PT'], [
            ['407.1', 'ARS-407/1', null, 1, '407-1'],
            ['407.2', 'ARS-407/2', null, 2, '407-2'],
        ]),
        'spot-tubo-liso' => spot('Tubo Liso', 'e27', 59, 'E27', ['BR', 'PT'], [
            ['Tubo Liso.1', 'ARS-205/1', null, 1, 'tubo-liso-1'],
            ['Tubo Liso.2', 'ARS-206/2', null, 2, 'tubo-liso-2'],
            ['Trilho Tubo Liso.2', 'ARS-TR206/2', '250 mm', 2, 'trilho-tubo-liso-2'],
            ['Trilho Tubo Liso.3', 'ARS-TR206/3', '330 mm', 3, 'trilho-tubo-liso-3'],
        ]),
        'spot-pop' => spot('Pop', 'e27', 60, 'E27', ['BR', 'PT'], [
            ['Pop.1', 'ARS-3801', null, 1, 'pop-1'],
            ['Pop.2', 'ARS-3902', null, 2, 'pop-2'],
        ]),
        'spot-plastic-209' => spot('Plastic 209', 'e27', 60, 'E27', ['BR', 'PT'], [
            ['Plastic 209.1', 'ARS-209/1', null, 1, 'plastic-209-1'],
            ['Plastic 209.2', 'ARS-209/2', null, 2, 'plastic-209-2'],
            ['Plastic 209.3', 'ARS-209/3', '500 mm', 3, 'plastic-209-3'],
        ]),
    ];
    return $produtos;
}

function ars_produto(string $categoria, string $slug): ?array
{
    $p = ars_produtos()[$slug] ?? null;
    return $p && $p['categoria'] === $categoria ? $p : null;
}

/** Produtos de uma categoria, agrupados por tipo na ordem de ARS_TIPOS_PERFIL. */
function ars_produtos_por_tipo(string $categoria): array
{
    $grupos = [];
    foreach (ars_produtos() as $slug => $p) {
        if ($p['categoria'] === $categoria) {
            $grupos[$p['tipo']][$slug] = $p;
        }
    }
    $ordem = array_keys(ARS_TIPOS[$categoria] ?? []);
    uksort($grupos, static fn($a, $b) => array_search($a, $ordem, true) <=> array_search($b, $ordem, true));
    return $grupos;
}

function produto_url(string $slug, array $p): string
{
    return '/produtos/' . $p['categoria'] . '/' . $slug . '/';
}

function produto_imagem(string $slug, array $p): string
{
    return '/assets/img/produtos/' . $p['categoria'] . '/' . ($p['imagem'] ?? $slug) . '.webp';
}

/** Linha curta com as principais especificações (cards e listas). */
function produto_resumo(array $p): string
{
    if ($p['categoria'] === 'spots') {
        return 'Soquete ' . $p['soquete'] . ' · ' . $p['focos'] . ($p['focos'] === '1' ? ' foco' : ' focos');
    }
    return $p['largura'] . ' × ' . $p['altura'] . ' · 1, 2 e 3 m';
}

function produto_whatsapp(string $nome): string
{
    return 'https://wa.me/' . ARS_SITE['whatsapp']['number'] . '?text=' . rawurlencode('Olá! Quero um orçamento do ' . $nome . ' da ARS Iluminação.');
}
