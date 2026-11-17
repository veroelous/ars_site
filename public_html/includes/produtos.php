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
const ARS_ACABAMENTOS = ['BR' => 'Branco', 'PT' => 'Preto', 'AL' => 'Alumínio'];

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
    'spots'           => ['nome' => 'Spots', 'resumo' => 'Spots simples, duplos, triplos e quádruplos, de trilho e de sobrepor.', 'imagem' => 'spots.webp', 'pagina' => 49, 'online' => false],
    'jardim'          => ['nome' => 'Jardim', 'resumo' => 'Espetos, balizadores e arandelas para áreas externas.', 'imagem' => 'jardim.webp', 'pagina' => 61, 'online' => false],
    'vidros'          => ['nome' => 'Vidros', 'resumo' => 'Peças com vidro decorado em diversos padrões.', 'imagem' => 'vidros.webp', 'pagina' => 66, 'online' => false],
];

/** Tipos de perfil, na ordem em que aparecem na página da categoria. */
const ARS_TIPOS_PERFIL = [
    'sobrepor' => ['nome' => 'Perfis de sobrepor', 'uso' => 'Instalados diretamente sobre a superfície.'],
    'embutir'  => ['nome' => 'Perfis de embutir', 'uso' => 'Instalados dentro de forro, gesso ou marcenaria, com a aba rente à superfície.'],
    'canto'    => ['nome' => 'Perfil de canto', 'uso' => 'Para instalação em cantos a 90°.'],
    'piso'     => ['nome' => 'Perfil de piso', 'uso' => 'Para aplicação no piso, com lente difusora em policarbonato.'],
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
    $ordem = array_keys(ARS_TIPOS_PERFIL);
    uksort($grupos, static fn($a, $b) => array_search($a, $ordem, true) <=> array_search($b, $ordem, true));
    return $grupos;
}

function produto_url(string $slug, array $p): string
{
    return '/produtos/' . $p['categoria'] . '/' . $slug . '/';
}

function produto_imagem(string $slug, array $p): string
{
    return '/assets/img/produtos/' . $p['categoria'] . '/' . $slug . '.webp';
}

function produto_whatsapp(string $nome): string
{
    return 'https://wa.me/' . ARS_SITE['whatsapp']['number'] . '?text=' . rawurlencode('Olá! Quero um orçamento do ' . $nome . ' da ARS Iluminação.');
}
