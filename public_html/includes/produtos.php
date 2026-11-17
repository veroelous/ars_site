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
const ARS_ACABAMENTOS = [
    'BR' => 'Branco', 'CB' => 'Cobre', 'PT' => 'Preto', 'AL' => 'Alumínio',
    // Paleta das linhas Essenza, Nimbo, Kube, Orbe e Vernazza (legenda impressa no catálogo).
    'BZ' => 'Bronze AVL', 'VD' => 'Verde AVL', 'PD' => 'Pedra', 'DR' => 'Dourado', 'CP' => 'Champagne', 'OW' => 'Off White',
    // Cores extras da Arandela Iris.
    'AZ' => 'Azul Bebê', 'RS' => 'Rosa', 'AB' => 'Abacate',
    // Módulos de sobrepor: sigla impressa sem o nome (cor marrom na bolinha).
    'CF' => '[CF: NOME A CONFIRMAR]',
];

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
    'arandelas' => [
        'nome'      => 'Arandelas',
        'resumo'    => 'Arandelas para parede em diversos modelos e acabamentos.',
        'descricao' => 'Arandelas de parede com globo, cúpula ou lâmpada aparente, para soquetes E27, G9 e GU10, em diversos acabamentos.',
        'imagem'    => 'arandelas.webp',
        'pagina'    => 22,
        'online'    => true,
    ],
    'pendentes' => [
        'nome'      => 'Pendentes',
        'resumo'    => 'Pendentes, trilhos e arandelas em linhas com desenho próprio.',
        'descricao' => 'Pendentes, trilhos e arandelas organizados em linhas com desenho próprio, para soquetes E27, G9 e GU10, em diversos acabamentos.',
        'imagem'    => 'pendentes.webp',
        'pagina'    => 27,
        'online'    => true,
    ],
    'embutidos' => [
        'nome'      => 'Embutidos',
        'resumo'    => 'Spots de embutir em ABS e alumínio, de 1 a 4 focos.',
        'descricao' => 'Spots de embutir em ABS com tratamento UV e em alumínio (linha Axis), de 1 a 4 focos, para lâmpadas MR11, MR16, AR70 e PAR20, nos acabamentos preto e branco.',
        'imagem'    => 'embutidos.webp',
        'pagina'    => 45,
        'online'    => true,
    ],
    'modulos-de-sobrepor' => [
        'nome'      => 'Módulos de sobrepor',
        'resumo'    => 'Módulos quadrados e cilíndricos de sobrepor, de 1 a 4 focos.',
        'descricao' => 'Módulos de sobrepor quadrados (Kube), cilíndricos (Tube) e em alumínio com 1 a 4 focos (linha Apex), para lâmpadas MR16, AR70 e PAR20, em três acabamentos.',
        'imagem'    => 'modulos-de-sobrepor.webp',
        'pagina'    => 47,
        'online'    => true,
    ],
    'spots' => [
        'nome'      => 'Spots',
        'resumo'    => 'Spots de sobrepor de 1 a 4 focos, com base redonda ou trilho.',
        'descricao' => 'Spots de sobrepor em versões de 1 a 4 focos, com base redonda ou trilho, para soquete E27, GU10 ou E27/PAR20, em acabamentos branco, cobre, preto e alumínio (conforme o modelo).',
        'imagem'    => 'spots.webp',
        'pagina'    => 49,
        'online'    => true,
    ],
    'jardim' => [
        'nome'      => 'Jardim',
        'resumo'    => 'Espetos, balizadores e arandelas para áreas externas.',
        'descricao' => 'Espetos e embutidos de solo IP65 (Garden), balizadores em alumínio (Oak, Alloy e Aris), arandelas e plafonier para jardins, caminhos e áreas externas.',
        'imagem'    => 'jardim.webp',
        'pagina'    => 61,
        'online'    => true,
    ],
    'vidros' => [
        'nome'      => 'Vidros',
        'resumo'    => 'Peças com vidro decorado em diversos padrões.',
        'descricao' => 'Arandelas e plafons de vidro decorado, em padrões como Bamboo, Risk, Cadence e Orion, para soquete E27.',
        'imagem'    => 'vidros.webp',
        'pagina'    => 66,
        'online'    => true,
    ],
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
    'arandelas' => [
        'globo'    => ['nome' => 'Arandelas com globo', 'uso' => 'Globo difusor para luz suave no ambiente.'],
        'cupula'   => ['nome' => 'Arandelas com cúpula', 'uso' => 'Cúpula de alumínio ou tecido.'],
        'aparente' => ['nome' => 'Lâmpada aparente e foco', 'uso' => 'Modelos com a lâmpada à mostra ou com foco direcionado.'],
    ],
    'embutidos' => [
        'abs'  => ['nome' => 'Spots de embutir ABS', 'uso' => 'Em ABS com tratamento UV, que não amarela. Acabamentos preto e branco.'],
        'axis' => ['nome' => 'Spots de embutir em alumínio Axis', 'uso' => 'Em alumínio, de 1 a 4 focos, para GU10 / MR16 (Axis 16) ou E27 / PAR20 (Axis 20).'],
    ],
    'modulos-de-sobrepor' => [
        'focos-unicos' => ['nome' => 'Kube e Tube', 'uso' => 'Módulos de 1 foco: quadrado (Kube) ou cilíndricos (Tube).'],
        'apex'         => ['nome' => 'Módulos de sobrepor em alumínio Apex', 'uso' => 'Em alumínio, de 1 a 4 focos, para GU10 / MR16 (Apex 16) ou GU10 / AR70 (Apex 70).'],
    ],
    'jardim' => [
        'garden'      => ['nome' => 'Espetos e embutidos de solo', 'uso' => 'Linha Garden: IP65, com anti-ofuscante, para lâmpadas MR11 e MR16.'],
        'balizadores' => ['nome' => 'Balizadores', 'uso' => 'Peças em alumínio para jardins, caminhos e áreas externas.'],
        'parede'      => ['nome' => 'Arandelas e plafonier', 'uso' => 'Peças de parede e de teto.'],
    ],
    'vidros' => [
        'arandelas' => ['nome' => 'Arandelas de vidro', 'uso' => 'Vidro curvo decorado sobre base de parede, 100 × 180 mm, soquete E27.'],
        'plafons'   => ['nome' => 'Plafons de vidro', 'uso' => 'Redondos ou quadrados, em dois tamanhos: 1 ou 2 lâmpadas E27.'],
    ],
    'pendentes' => [
        'linhas'  => ['nome' => 'Linhas e coleções', 'uso' => 'Famílias de peças com o mesmo desenho: pendentes, trilhos e arandelas.'],
        'avulsos' => ['nome' => 'Pendentes', 'uso' => 'Modelos individuais da coleção ARS.'],
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
        $lista[] = [
            'nome' => $nome, 'codigo' => $codigo, 'trilho' => $trilho, 'focos' => $focos, 'imagem' => $imagem,
            'specs' => ['Focos' => (string) $focos, 'Base' => $trilho ? 'Trilho ' . $trilho : 'Redonda'],
        ];
    }
    $focos = array_column($lista, 'focos');
    $faixa = min($focos) === max($focos) ? (string) min($focos) : min($focos) . ' a ' . max($focos);
    $trilhos = array_values(array_unique(array_filter(array_column($lista, 'trilho'))));
    $ficha = ['Tipo' => 'Spot de sobrepor', 'Soquete' => $soquete, 'Focos' => $faixa];
    if ($trilhos) {
        $ficha['Trilhos'] = implode(', ', $trilhos);
    }
    if (isset($extra['observacao'])) {
        $ficha['Lâmpada'] = $extra['observacao'];
    }
    return [
        'ficha'       => $ficha,
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

/**
 * Monta uma linha/modelo de pendentes. $base: soquete, material, tensao, uso, acabamentos, descricao, cabos, observacao,
 * categoria (padrão: pendentes) e destaques.
 * Cada item: [tipo, nome, código, specs (rótulo => valor), imagem, opcional: ['acabamentos' => [...], 'soquete' => '...']].
 * O código pode ser uma lista (rótulo => código) quando muda com o acabamento ou a lâmpada.
 */
function linha(string $nome, string $grupo, int $pagina, array $base, array $itens): array
{
    $versoes = [];
    $todos = [];
    foreach ($itens as $item) {
        [$tipo, $vnome, $codigo, $specs, $imagem] = $item;
        $over = $item[5] ?? [];
        $acab = $over['acabamentos'] ?? $base['acabamentos'];
        $todos = array_merge($todos, $acab);
        $specs = ['Tipo' => $tipo] + $specs;
        if (isset($over['soquete'])) {
            $specs['Soquete'] = $over['soquete'];
        }
        if (isset($over['acabamentos'])) {
            $specs['Acabamentos'] = implode(', ', array_map(static fn($a) => ARS_ACABAMENTOS[$a], $acab));
        }
        $versoes[] = ['nome' => $vnome, 'codigo' => $codigo, 'imagem' => $imagem, 'specs' => $specs, 'tipo' => $tipo];
    }
    $ficha = ['Soquete' => $base['soquete']];
    foreach (['material' => 'Material', 'tensao' => 'Tensão', 'uso' => 'Uso'] as $k => $rotulo) {
        if (!empty($base[$k])) {
            $ficha[$rotulo] = $base[$k];
        }
    }
    if (!empty($base['cabos'])) {
        $ficha['Cabo'] = 'Cabos em tecido, em várias cores';
    }
    if (!empty($base['observacao'])) {
        $ficha['Lâmpada'] = $base['observacao'];
    }
    return [
        'categoria'   => $base['categoria'] ?? 'pendentes',
        'tipo'        => $grupo,
        'nome'        => $nome,
        'descricao'   => $base['descricao'] ?? null,
        'soquete'     => $base['soquete'],
        'acabamentos' => array_values(array_unique($todos)),
        'versoes'     => $versoes,
        'ficha'       => $ficha,
        'imagem'      => $versoes[0]['imagem'],
        'pagina'      => $pagina,
        'observacao'  => $base['observacao'] ?? null,
    ] + (isset($base['destaques']) ? ['destaques' => $base['destaques']] : []);
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

        // ---------- Pendentes (catálogo, páginas 27 a 44) ----------
    ];
    $P3 = ['BR', 'CB', 'PT'];
    $P8 = ['BZ', 'VD', 'PT', 'PD', 'DR', 'CP', 'BR', 'OW'];
    $tec = ['material' => 'Alumínio', 'tensao' => '127 V ~ 220 V', 'uso' => 'Interno'];
    $NAL = 'Não acompanha lâmpada.';
    $D = static fn(?int $a = null, ?int $d = null, ?int $l = null, ?int $t = null): array => array_filter([
        'Altura' => $a ? $a . ' mm' : null, 'Diâmetro' => $d ? $d . ' mm' : null,
        'Largura' => $l ? $l . ' mm' : null, 'Trilho' => $t ? $t . ' mm' : null,
    ]);
    $avulso = static fn(string $nome, int $pag, string $codigo, array $specs, string $img, array $base, string $tipo = 'Pendente')
        => linha($nome, 'avulsos', $pag, $base, [[$tipo, $nome, $codigo, $specs, $img]]);

    $produtos += [
        'linha-essenza' => linha('Linha Essenza', 'linhas', 27, $tec + [
            'descricao' => 'Com formas circulares e design contemporâneo, combina volumes suaves e iluminação funcional, criando peças versáteis e elegantes.',
            'soquete' => 'G9', 'acabamentos' => $P8,
        ], [
            ['Pendente', 'Pendente Nero', 'ARS-NR380', $D(195, 380), 'nero'],
            ['Arandela', 'Arandela Luna', 'ARS-LN300', $D(null, 300), 'luna'],
            ['Arandela', 'Arandela Ágape', 'ARS-AGAPE33', $D(null, 280), 'agape'],
        ]),
        'linha-melbourne' => linha('Linha Melbourne', 'linhas', 28, $tec + [
            'descricao' => 'Com inspiração industrial e traços robustos, combina formas clássicas com detalhes metálicos marcantes. Uma coleção de personalidade urbana.',
            'soquete' => 'E27', 'acabamentos' => $P3,
        ], [
            ['Pendente', 'Pendente Melbourne', 'ARS-188', $D(150, 280), 'melbourne'],
            ['Trilho', 'Melbourne B2', 'ARS-TR188', $D(150, 280, null, 500), 'melbourne-b2'],
            ['Arandela', 'Arandela Melbourne', 'ARS-AR188', $D(120, 230), 'melbourne-arandela'],
        ]),
        'linha-impiricus' => linha('Linha Impiricus', 'linhas', 29, $tec + [
            'descricao' => 'Com inspiração industrial e presença marcante, combina formas robustas com detalhes metálicos que ressaltam sua personalidade.',
            'soquete' => 'E27', 'acabamentos' => $P3,
        ], [
            ['Pendente', 'Pendente Impiricus', 'ARS-187', $D(250, 150), 'impiricus'],
            ['Trilho', 'Impiricus B2', 'ARS-TR187', $D(250, 150, null, 400), 'impiricus-b2'],
            ['Arandela', 'Arandela Impiricus', 'ARS-AR187', $D(250, 150), 'impiricus-arandela'],
        ]),
        'linha-sino' => linha('Linha Sino', 'linhas', 30, $tec + [
            'descricao' => 'Com inspiração industrial e traços robustos, combina formas clássicas com detalhes metálicos marcantes. Uma coleção de personalidade urbana.',
            'soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL,
        ], [
            ['Pendente', 'Pendente Sino', 'ARS-180', $D(200, 260), 'sino'],
            ['Trilho', 'Sino B2', 'ARS-TR181', $D(200, 260, null, 400), 'sino-b2'],
            ['Arandela', 'Arandela Sino', 'ARS-AR180', $D(200, 260), 'sino-arandela'],
        ]),
        'pendente-nimbo' => $avulso('Pendente Nimbo', 31, 'ARS-NB50', $D(400, 500), 'nimbo', [
            'descricao' => 'Com curvas suaves e lente de acrílico, proporciona uma iluminação uniforme, confortável e sem lâmpada aparente.',
            'soquete' => 'E27', 'material' => 'Alumínio e acrílico', 'tensao' => '127 V ~ 220 V', 'uso' => 'Interno', 'acabamentos' => $P8, 'cabos' => true,
        ]),
        'pendente-kube' => $avulso('Pendente Kube', 31, 'ARS-PDKB20', ['Altura' => '200 mm', 'Largura' => '60 mm'], 'kube', $tec + [
            'descricao' => 'Com linhas retas e formato vertical, traz uma presença minimalista e contemporânea.',
            'soquete' => 'GU10 / MR16', 'acabamentos' => $P8, 'cabos' => true,
        ]),
        'pendente-aladim' => $avulso('Pendente Aladim', 32, 'ARS-75', $D(280, 470), 'aladim', $tec + [
            'descricao' => 'Com formas amplas e curvas suaves, apresenta um design marcante e elegante. Sua cúpula generosa proporciona uma iluminação ampla e acolhedora.',
            'soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL,
        ]),
        'pendente-monaco' => $avulso('Pendente Mônaco', 32, 'ARS-991', $D(190, 430), 'monaco', $tec + [
            'descricao' => 'Com perfil baixo e linhas fluidas, combina leveza e sofisticação. Os detalhes criam um contraste elegante e de presença.',
            'soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL,
        ]),
        'pendente-gomo'   => $avulso('Pendente Gomo', 33, 'ARS-99', $D(300, 370), 'gomo', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-zeus'   => $avulso('Pendente Zeus', 33, 'ARS-100', $D(190, 400), 'zeus', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-chines' => $avulso('Pendente Chinês', 33, 'ARS-121', $D(160, 380), 'chines', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-domo'   => $avulso('Pendente Domo', 33, 'ARS-120', $D(320, 310), 'domo', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-kim' => linha('Pendente Kim', 'avulsos', 34, ['soquete' => 'E27', 'acabamentos' => $P3], [
            ['Pendente', 'Kim P', 'ARS-80', $D(200, 215), 'kim-p'],
            ['Pendente', 'Kim G', 'ARS-97', $D(200, 400), 'kim-g'],
        ]),
        'pendente-meia-lua' => $avulso('Pendente Meia Lua', 34, 'ARS-73', $D(210, 330), 'meia-lua', ['soquete' => 'E27', 'acabamentos' => $P3]),
        'pendente-mini-lua' => $avulso('Pendente Mini Lua', 34, 'ARS-197', $D(130, 210), 'mini-lua', ['soquete' => 'E27', 'acabamentos' => $P3]),
        'pendente-moon'     => $avulso('Pendente Moon', 34, 'ARS-1057', $D(210, 320), 'moon', ['soquete' => 'E27', 'acabamentos' => $P3]),
        'linha-italia' => linha('Linha Itália', 'linhas', 35, $tec + [
            'descricao' => 'Com formas cônicas e proporções marcantes, a Linha Itália explora diferentes silhuetas em um design elegante e atemporal.',
            'soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL,
        ], [
            ['Pendente', 'Pendente Roma', 'ARS-133', $D(345, 220), 'roma'],
            ['Pendente', 'Pendente Veneza', 'ARS-131', $D(150, 175), 'veneza'],
            ['Pendente', 'Pendente Milão', 'ARS-132', $D(310, 180), 'milao'],
        ]),
        'linha-vernazza' => linha('Linha Vernazza', 'linhas', 36, $tec + [
            'descricao' => 'Design escandinavo com acabamento interno metalizado que valoriza a luz e o ambiente.',
            'soquete' => 'E27', 'acabamentos' => $P8,
        ], [
            ['Pendente', 'Arcanas 106', 'ARS-106', $D(450, 400), 'arcanas-106'],
            ['Pendente', 'Arcanas 107', 'ARS-107', $D(250, 300), 'arcanas-107'],
            ['Pendente', 'Delfos', 'ARS-103', $D(250, 120), 'delfos', ['acabamentos' => $P3]],
            ['Pendente', 'Halandri', 'ARS-105', $D(250, 250), 'halandri'],
        ]),
        'pendente-alfa' => linha('Pendente Alfa', 'avulsos', 37, ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL], [
            ['Pendente', 'Alfa G', 'ARS-210', $D(230, 370), 'alfa-g'],
            ['Pendente', 'Alfa P', 'ARS-110', $D(190, 240), 'alfa-p'],
        ]),
        'pendente-gotao'     => $avulso('Pendente Gotão', 37, 'ARS-88', $D(245, 230), 'gotao', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-bala'      => $avulso('Pendente Bala', 37, 'ARS-61', $D(200, 150), 'bala', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-mega-mini' => $avulso('Pendente Mega Mini', 37, 'ARS-101', $D(240, 280), 'mega-mini', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'colecao-paris' => linha('Coleção Paris', 'linhas', 38, ['soquete' => 'E27', 'acabamentos' => $P3], [
            ['Pendente', 'Cone Paris P', 'ARS-90', $D(250, 150), 'cone-paris-p'],
            ['Pendente', 'Taça Paris P', 'ARS-91', $D(280, 120), 'taca-paris-p'],
            ['Pendente', 'Mog Paris P', 'ARS-92', $D(220, 200), 'mog-paris-p'],
            ['Pendente', 'Cone Paris G', 'ARS-85', $D(360, 180), 'cone-paris-g'],
            ['Pendente', 'Taça Paris G', 'ARS-86', $D(300, 160), 'taca-paris-g'],
            ['Pendente', 'Mog Paris G', 'ARS-87', $D(240, 280), 'mog-paris-g'],
        ]),
        'pendente-orbe' => $avulso('Pendente Orbe', 39, 'ARS-OB60', $D(160, 60), 'orbe', $tec + [
            'descricao' => 'Com formas geométricas que se entrelaçam, traz personalidade e sofisticação ao ambiente.',
            'soquete' => 'E27 ou GU10 / MR11', 'acabamentos' => $P8, 'cabos' => true, 'observacao' => $NAL,
        ]),
        'pendente-coquinho' => $avulso('Pendente Coquinho', 39, 'ARS-62', $D(110, 100), 'coquinho', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-lucci'    => $avulso('Pendente Lucci', 39, 'ARS-123', $D(270, 165), 'lucci', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'pendente-copo'     => $avulso('Pendente Copo', 39, 'ARS-83', $D(50, 38), 'copo', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'colecao-tubo' => linha('Coleção Tubo', 'linhas', 40, ['soquete' => 'GU10 / MR11', 'acabamentos' => ['BR', 'CB', 'PT', 'DR', 'CP'], 'observacao' => $NAL], [
            ['Pendente', 'Tubo 100', 'ARS-711', $D(100, 35), 'tubo-curto'],
            ['Pendente', 'Tubo 200', 'ARS-712', $D(200, 35), 'tubo-curto'],
            ['Pendente', 'Tubo 300', 'ARS-713', $D(300, 35), 'tubo-curto'],
            ['Pendente', 'Tubo 400', 'ARS-714', $D(400, 35), 'tubo-longo'],
            ['Pendente', 'Tubo 500', 'ARS-715', $D(500, 35), 'tubo-longo'],
        ]),
        'linha-fenix' => linha('Linha Fênix', 'linhas', 41, $tec + [
            'descricao' => 'Com estruturas geométricas que se sobrepõem, seus volumes vazados valorizam a luz e conferem personalidade e dinamismo.',
            'soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL,
        ], [
            ['Pendente', 'Fênix G', 'ARS-831', $D(150, null, 150), 'fenix-g'],
            ['Pendente', 'Fênix P', 'ARS-841', $D(200, null, 200), 'fenix-p'],
            ['Pendente', 'Fênix Duo', 'ARS-838', $D(200, null, 400), 'fenix-duo'],
        ]),
        'plafon-copo-6' => $avulso('Plafon Copo 6', 42, 'ARS-673', $D(255, null, 490), 'copo-6', $tec + [
            'descricao' => 'Com braços distribuídos em diferentes direções, cria uma composição dinâmica e equilibrada.',
            'soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL,
        ], 'Plafon'),
        'pendente-cubo' => linha('Pendente Cubo', 'avulsos', 42, ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL], [
            ['Pendente', 'Cubo', 'ARS-13', $D(150, null, 150), 'cubo'],
            ['Pendente', 'Cubo 3D', 'ARS-14', $D(240, null, 440), 'cubo-3d'],
        ]),
        'colecao-aramados' => linha('Coleção Aramados', 'linhas', 43, ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL], [
            ['Pendente', 'Status', 'ARS-191', ['Dimensões' => '420 × 150 mm'], 'status'],
            ['Pendente', 'Wind', 'ARS-204', ['Dimensões' => '420 × 160 mm'], 'wind'],
            ['Pendente', 'Spider', 'ARS-190', ['Dimensões' => '200 × 250 mm'], 'spider'],
            ['Pendente', 'Barril', 'ARS-193', ['Dimensões' => '170 × 320 mm'], 'barril'],
            ['Pendente', 'Atrani', 'ARS-201', ['Dimensões' => '430 × 340 mm'], 'atrani'],
            ['Pendente', 'Estrela', 'ARS-125', ['Dimensões' => '495 × 150 mm'], 'estrela'],
            ['Pendente', 'Kim P (aramado)', 'ARS-153', ['Dimensões' => '235 × 160 mm'], 'kim-p-aramado'],
            ['Pendente', 'Diamante P', 'ARS-155', ['Dimensões' => '160 × 180 mm'], 'diamante-p'],
            ['Pendente', 'Diamante G', 'ARS-156', ['Dimensões' => '210 × 260 mm'], 'diamante-g'],
        ]),
    ];

    // Arandelas: catálogo p. 22–26. Uma página por modelo.
    $ar = static fn(string $nome, string $grupo, int $pag, string $codigo, array $specs, string $img, array $base)
        => linha($nome, $grupo, $pag, $base + ['categoria' => 'arandelas'], [['Arandela', $nome, $codigo, $specs, $img]]);
    $IO = ['Interruptor' => 'Opcional'];
    $produtos += [
        'arandela-iris' => $ar('Arandela Iris', 'globo', 22, '[CÓDIGO A CONFIRMAR]', ['Dimensões' => '160 × 210 mm', 'Globo' => 'Ø 100 mm'], 'iris', $tec + [
            'descricao' => 'Com formas orgânicas e delicadas, combina a suavidade do globo com uma base de contornos fluidos, criando uma peça elegante e de presença sofisticada.',
            'soquete' => 'G9', 'acabamentos' => array_merge($P8, ['AZ', 'RS', 'AB']),
        ]),
        'arandela-alva' => $ar('Arandela Alva', 'globo', 23, 'ARS-ALVA', ['Diâmetro' => '120 mm'], 'alva', $tec + [
            'descricao' => 'Com formas circulares, esta peça combina a suavidade do globo com uma base marcante, criando um visual elegante.',
            'soquete' => 'G9', 'acabamentos' => $P8,
        ]),
        'arandela-duetto' => $ar('Arandela Duetto', 'globo', 24, 'ARS-DUETTO', ['Dimensões' => '200 × 180 mm', 'Globo' => 'Ø 100 mm', 'Articulada' => 'Sim'], 'duetto', $tec + [
            'descricao' => 'Une luz difusa e iluminação direcionável em uma única peça, combinando funcionalidade e design contemporâneo.',
            'soquete' => 'G9 / GU10 · MR16', 'acabamentos' => $P8, 'observacao' => $NAL,
        ]),
        'arandela-nexo' => $ar('Arandela Nexo', 'globo', 24, 'ARS-NEXO', ['Diâmetro' => '120 mm'], 'nexo', $tec + [
            'descricao' => 'Com formas sobrepostas e globo difusor, cria uma iluminação suave em um design compacto, elegante e marcante.',
            'soquete' => 'G9', 'acabamentos' => $P8, 'observacao' => $NAL,
        ]),
        'arandela-miami' => $ar('Arandela Miami', 'cupula', 23, 'ARS-766', $D(190, 165), 'miami', ['soquete' => 'E27', 'acabamentos' => $P8, 'observacao' => $NAL]),
        'arandela-cora' => $ar('Arandela Cora', 'cupula', 25, 'ARS-CORA', ['Dimensões' => '130 × 140 mm', 'Cúpula' => 'Alumínio'], 'cora', ['soquete' => 'E27', 'acabamentos' => $P8]),
        'arandela-cora-due' => $ar('Arandela Cora Due', 'cupula', 25, 'ARS-CORADUE', ['Dimensões' => '280 × 280 mm', 'Cúpula' => 'Alumínio'] + $IO, 'cora-due', ['soquete' => 'E27', 'acabamentos' => $P8]),
        'arandela-aura-i' => $ar('Arandela Aura I', 'cupula', 25, 'ARS-AURA1', ['Dimensões' => '240 × 250 mm', 'Cúpula' => 'Tecido, 3 opções de cor'] + $IO, 'aura-1', ['soquete' => 'E27', 'acabamentos' => $P8]),
        'arandela-aura-ii' => $ar('Arandela Aura II', 'cupula', 25, 'ARS-AURA2', ['Dimensões' => '240 × 290 mm', 'Cúpula' => 'Tecido, 3 opções de cor'] + $IO, 'aura-2', ['soquete' => 'E27', 'acabamentos' => $P8]),
        'arandela-focco' => $ar('Arandela Focco', 'aparente', 23, 'ARS-FOCCO', $D(210, 50), 'focco', ['soquete' => 'GU10 · MR11', 'acabamentos' => $P8, 'observacao' => $NAL]),
        'arandela-copo' => $ar('Arandela Copo', 'aparente', 26, 'ARS-830', [], 'copo', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'arandela-copo-u' => $ar('Arandela Copo U', 'aparente', 26, 'ARS-730', [], 'copo-u', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
        'arandela-vello' => $ar('Arandela Vello', 'aparente', 26, 'ARS-VL260', ['Dimensões' => '260 × 200 mm'], 'vello', ['soquete' => 'E27', 'acabamentos' => $P8, 'observacao' => $NAL]),
        'arandela-eclipse' => $ar('Arandela Eclipse', 'aparente', 26, 'ARS-933', [], 'eclipse', ['soquete' => 'E27', 'acabamentos' => $P3, 'observacao' => $NAL]),
    ];

    // Embutidos: catálogo p. 45 (ABS) e 46 (alumínio Axis). Uma página por lâmpada/linha, com as versões de 1 a 4 focos.
    $abs = ['categoria' => 'embutidos', 'material' => 'ABS com tratamento UV', 'acabamentos' => ['PT', 'BR'], 'destaques' => ['Tratamento UV: não amarela']];
    $axs = ['categoria' => 'embutidos', 'material' => 'Alumínio', 'acabamentos' => ['BR', 'PT']];
    $F = static fn(string $dim, int $focos, array $extra = []): array => ['Dimensões' => $dim] + $extra + ['Focos' => (string) $focos];
    $produtos += [
        'spot-de-embutir-abs-mr11' => linha('Spot de embutir ABS MR11', 'abs', 45, $abs + [
            'descricao' => 'Spot de embutir quadrado em ABS com tratamento UV, que não amarela, para lâmpada MR11 com soquete GU10.',
            'soquete' => 'GU10',
        ], [
            ['Simples', 'ABS MR11', ['preto' => '71802', 'branco' => '71801'], $F('74 × 74 mm', 1, ['Lâmpada' => 'MR11']), 'abs-mr11'],
        ]),
        'spot-de-embutir-abs-mr16' => linha('Spot de embutir ABS MR16', 'abs', 45, $abs + [
            'descricao' => 'Spot de embutir em ABS com tratamento UV, que não amarela, para lâmpada MR16 com soquete GU10. Versões simples e dupla.',
            'soquete' => 'GU10',
        ], [
            ['Simples', 'ABS MR16', ['preto' => '71602', 'branco' => '71601'], $F('100 × 100 mm', 1, ['Lâmpada' => 'MR16']), 'abs-mr16'],
            ['Duplo', 'ABS Duplo MR16', ['preto' => '31802-PT', 'branco' => '31802-BR'], $F('100 × 180 mm', 2, ['Lâmpada' => 'MR16']), 'abs-duplo-mr16'],
        ]),
        'spot-de-embutir-abs-ar70-par20' => linha('Spot de embutir ABS AR70 / PAR20', 'abs', 45, $abs + [
            'descricao' => 'Spot de embutir em ABS com tratamento UV, que não amarela, para lâmpada AR70 (soquete GU10) ou PAR20 (soquete E27). Versões simples e dupla.',
            'soquete' => 'GU10 ou E27',
        ], [
            ['Simples', 'ABS AR70 / PAR20', ['AR70 preto' => '71702', 'AR70 branco' => '71701', 'PAR20 preto' => '71902', 'PAR20 branco' => '71901'],
                $F('130 × 130 mm', 1, ['Lâmpada' => 'AR70 (GU10) ou PAR20 (E27)']), 'abs-ar70-par20'],
            ['Duplo', 'ABS Duplo AR70 / PAR20', ['AR70 preto' => '700211-PT', 'AR70 branco' => '700211-BR', 'PAR20 preto' => '71012-PT', 'PAR20 branco' => '71012-BR'],
                $F('130 × 234 mm', 2, ['Lâmpada' => 'AR70 (GU10) ou PAR20 (E27)']), 'abs-duplo-ar70-par20'],
        ]),
        'spot-de-embutir-axis-16' => linha('Spot de embutir Axis 16', 'axis', 46, $axs + [
            'descricao' => 'Spot de embutir em alumínio para lâmpada GU10 / MR16, em versões de 1 a 4 focos.',
            'soquete' => 'GU10 / MR16',
        ], [
            ['Simples', 'Axis 16.1', 'AXS161', $F('90 × 90 mm', 1), 'axis-16-1'],
            ['Duplo', 'Axis 16.2', 'AXS162', $F('160 × 90 mm', 2), 'axis-16-2'],
            ['Triplo', 'Axis 16.3', 'AXS163', $F('230 × 90 mm', 3), 'axis-16-3'],
            ['Quádruplo', 'Axis 16.4', 'AXS164', $F('160 × 160 mm', 4), 'axis-16-4'],
        ]),
        'spot-de-embutir-axis-20' => linha('Spot de embutir Axis 20', 'axis', 46, $axs + [
            'descricao' => 'Spot de embutir em alumínio para lâmpada PAR20 com soquete E27, em versões de 1 a 4 focos.',
            'soquete' => 'E27 / PAR20',
        ], [
            ['Simples', 'Axis 20.1', 'AXS201', $F('105 × 105 mm', 1), 'axis-20-1'],
            ['Duplo', 'Axis 20.2', 'AXS202', $F('195 × 105 mm', 2), 'axis-20-2'],
            ['Triplo', 'Axis 20.3', 'AXS203', $F('275 × 105 mm', 3), 'axis-20-3'],
            ['Quádruplo', 'Axis 20.4', 'AXS204', $F('195 × 195 mm', 4), 'axis-20-4'],
        ]),
    ];

    // Módulos de sobrepor: catálogo p. 47 (Kube e Tube) e 48 (alumínio Apex).
    $mod = ['categoria' => 'modulos-de-sobrepor', 'acabamentos' => ['BR', 'PT', 'CF']];
    $um = static fn(string $nome, string $codigo, array $specs, string $img, string $soquete, string $descricao)
        => linha('Módulo de sobrepor ' . $nome, 'focos-unicos', 47, $mod + ['soquete' => $soquete, 'descricao' => $descricao], [['Módulo de sobrepor', $nome, $codigo, $specs + ['Focos' => '1'], $img]]);
    $apx = $mod + ['material' => 'Alumínio', 'observacao' => $NAL];
    $produtos += [
        'modulo-de-sobrepor-kube-16' => $um('Kube 16', 'ARS-KB80', ['Largura' => '60 mm', 'Altura' => '80 mm'], 'kube-16', 'GU10 / MR16',
            'Módulo de sobrepor quadrado para lâmpada MR16 com soquete GU10.'),
        'modulo-de-sobrepor-tube-16' => $um('Tube 16', 'ARS-TB16', ['Diâmetro' => '56 mm', 'Altura' => '80 mm'], 'tube-16', 'GU10 / MR16',
            'Módulo de sobrepor cilíndrico para lâmpada MR16 com soquete GU10.'),
        'modulo-de-sobrepor-tube-70' => $um('Tube 70', 'ARS-TB70', ['Diâmetro' => '75 mm', 'Altura' => '80 mm'], 'tube-70', 'GU10 / AR70',
            'Módulo de sobrepor cilíndrico para lâmpada AR70 com soquete GU10.'),
        'modulo-de-sobrepor-tube-20' => $um('Tube 20', 'ARS-TB20', ['Diâmetro' => '75 mm', 'Altura' => '110 mm'], 'tube-20', 'E27 / PAR20',
            'Módulo de sobrepor cilíndrico para lâmpada PAR20 com soquete E27.'),
        'modulo-de-sobrepor-apex-16' => linha('Módulo de sobrepor Apex 16', 'apex', 48, $apx + [
            'descricao' => 'Módulo de sobrepor em alumínio para lâmpada MR16 com soquete GU10, em versões de 1 a 4 focos.',
            'soquete' => 'GU10 / MR16',
        ], [
            ['Simples', 'Apex 16.1', 'APX161', ['Dimensões' => '90 × 90 × 80 mm', 'Focos' => '1'], 'apex-16-1'],
            ['Duplo', 'Apex 16.2', 'APX162', ['Dimensões' => '180 × 90 × 80 mm', 'Focos' => '2'], 'apex-16-2'],
            ['Triplo', 'Apex 16.3', 'APX163', ['Dimensões' => '260 × 90 × 80 mm', 'Focos' => '3'], 'apex-16-3'],
            ['Quádruplo', 'Apex 16.4', 'APX164', ['Dimensões' => '180 × 180 × 80 mm', 'Focos' => '4'], 'apex-16-4'],
        ]),
        'modulo-de-sobrepor-apex-70' => linha('Módulo de sobrepor Apex 70', 'apex', 48, $apx + [
            'descricao' => 'Módulo de sobrepor em alumínio para lâmpada AR70 com soquete GU10, em versões de 1 a 4 focos.',
            'soquete' => 'GU10 / AR70',
        ], [
            ['Simples', 'Apex 70.1', 'APX701', ['Dimensões' => '110 × 110 × 80 mm', 'Focos' => '1'], 'apex-70-1'],
            ['Duplo', 'Apex 70.2', 'APX702', ['Dimensões' => '210 × 110 × 80 mm', 'Focos' => '2'], 'apex-70-2'],
            ['Triplo', 'Apex 70.3', 'APX703', ['Dimensões' => '310 × 110 × 80 mm', 'Focos' => '3'], 'apex-70-3'],
            ['Quádruplo', 'Apex 70.4', 'APX704', ['Dimensões' => '210 × 210 × 80 mm', 'Focos' => '4'], 'apex-70-4'],
        ]),
    ];

    // Jardim: catálogo p. 61 a 65 (a p. 65 tem cabeçalho "Coleção ARS", mas está na seção Jardim do sumário).
    $jd = ['categoria' => 'jardim'];
    $ext = $jd + ['material' => 'Alumínio', 'tensao' => '127 V ~ 220 V', 'uso' => 'Externo'];
    $garden = $jd + ['soquete' => 'GU10', 'acabamentos' => [], 'destaques' => ['IP65', 'Anti-ofuscante']];
    $aris = static fn(string $dim): array => ['Dimensões' => $dim, 'Difusor' => 'Acrílico ou vidro'];
    $produtos += [
        'garden-espeto' => linha('Garden Espeto', 'garden', 61, $garden + [
            'descricao' => 'Espeto de jardim IP65 com anti-ofuscante, para lâmpada MR11 ou MR16 com soquete GU10.',
        ], [
            ['Espeto', 'Garden 11 Espeto', 'ARS-GES11', ['Altura' => '300 mm', 'Diâmetro' => '45 mm', 'Lâmpada' => 'MR11'], 'garden-11-espeto'],
            ['Espeto', 'Garden 16 Espeto', 'ARS-GES16', ['Altura' => '300 mm', 'Diâmetro' => '60 mm', 'Lâmpada' => 'MR16'], 'garden-16-espeto'],
        ]),
        'garden-embutido' => linha('Garden Embutido', 'garden', 61, $garden + [
            'descricao' => 'Embutido de solo IP65 com anti-ofuscante, para lâmpada MR11 ou MR16 com soquete GU10.',
        ], [
            ['Embutido de solo', 'Garden 11 Embutido', 'ARS-GEM11', ['Altura' => '100 mm', 'Diâmetro' => '55 mm', 'Lâmpada' => 'MR11'], 'garden-11-embutido'],
            ['Embutido de solo', 'Garden 16 Embutido', 'ARS-GEM16', ['Altura' => '100 mm', 'Diâmetro' => '70 mm', 'Lâmpada' => 'MR16'], 'garden-16-embutido'],
        ]),
        'linha-oak' => linha('Linha Oak', 'balizadores', 62, $ext + [
            'descricao' => 'Balizadores em alumínio com haste curva, para lâmpada MR16 com soquete GU10. A Oak Art tem foco articulado.',
            'soquete' => 'GU10 / MR16', 'acabamentos' => ['BR', 'PT', 'CF', 'PD'],
        ], [
            ['Balizador', 'Oak Bell', 'OAK-BLL', ['Altura' => '900 mm (700 mm instalado)', 'Diâmetro' => '50 mm'], 'oak-bell'],
            ['Balizador', 'Oak', 'OAK', ['Altura' => '900 mm (700 mm instalado)', 'Diâmetro' => '50 mm'], 'oak'],
            ['Balizador', 'Oak Art', 'OAK-ART', ['Altura' => '900 mm (700 mm instalado)', 'Diâmetro' => '50 mm', 'Articulado' => 'Sim'], 'oak-art'],
        ]),
        'linha-jardim-alloy' => linha('Linha Jardim Alloy', 'balizadores', 63, $ext + [
            'descricao' => 'Com design minimalista e estrutura vertical, utiliza luz rebatida para criar uma iluminação suave e confortável, ideal para valorizar jardins, caminhos e áreas externas.',
            'soquete' => 'GU10 / MR16 / MR11', 'acabamentos' => [], 'observacao' => $NAL,
        ], [
            ['Balizador', 'Alloy.20', 'ARS-ALLOY20', ['Largura' => '90 mm', 'Altura' => '200 mm'], 'alloy-20'],
            ['Balizador', 'Alloy.40', 'ARS-ALLOY40', ['Largura' => '90 mm', 'Altura' => '400 mm'], 'alloy-40'],
        ]),
        'linha-aris' => linha('Linha Aris', 'balizadores', 64, $ext + [
            'descricao' => 'Arandela, balizadores e poste de seção quadrada em alumínio, com difusor em acrílico ou vidro.',
            'soquete' => 'E27 (Aris 100: G13)', 'acabamentos' => [],
        ], [
            ['Arandela', 'Arandela Aris', ['acrílico' => 'ARA20', 'vidro' => 'ARV20'], $aris('90 × 90 × 200 mm'), 'arandela-aris', ['soquete' => 'E27']],
            ['Balizador', 'Aris 30', ['acrílico' => 'BLA30', 'vidro' => 'BLV30'], $aris('90 × 90 × 300 mm'), 'aris-balizador', ['soquete' => 'E27']],
            ['Balizador', 'Aris 50', ['acrílico' => 'BLA50', 'vidro' => 'BLV50'], $aris('90 × 90 × 500 mm'), 'aris-balizador', ['soquete' => 'E27']],
            ['Balizador', 'Aris 70', ['acrílico' => 'BLA70', 'vidro' => 'BLV70'], $aris('90 × 90 × 700 mm'), 'aris-balizador', ['soquete' => 'E27']],
            ['Poste', 'Aris 100', ['acrílico' => 'PSA100', 'vidro' => 'PSV100'], $aris('90 × 90 × 1000 mm'), 'aris-100', ['soquete' => 'G13']],
        ]),
        'arandela-g9' => linha('Arandela G9', 'parede', 65, $jd + [
            'material' => 'ABS', 'uso' => 'Externo', 'soquete' => 'G9', 'acabamentos' => ['BR', 'PT', 'CF'],
        ], [['Arandela', 'Arandela G9', 'ARS-531', ['Dimensões' => '110 × 110 mm'], 'arandela-g9']]),
        'tartaruga' => linha('Tartaruga', 'parede', 65, $jd + [
            'material' => 'ABS', 'soquete' => 'E27', 'acabamentos' => ['BR', 'PT'],
        ], [['Arandela', 'Tartaruga', ['branco' => 'ARS-5104 BR', 'preto' => 'ARS-5105 PT'], [], 'tartaruga']]),
        'plafonier' => linha('Plafonier', 'parede', 65, $jd + [
            'material' => 'Alumínio', 'soquete' => 'E27', 'acabamentos' => ['BR', 'CB', 'PT', 'AL'],
        ], [['Plafonier', 'Plafonier', 'ARS-20', [], 'plafonier']]),
    ];

    // Vidros: catálogo p. 66 (arandelas) e 67 (plafons redondos e quadrados).
    $vd = ['categoria' => 'vidros', 'material' => 'Vidro', 'soquete' => 'E27', 'acabamentos' => []];
    $arv = static fn(string $nome, string $codigo, string $img)
        => linha('Arandela de vidro ' . $nome, 'arandelas', 66, $vd, [['Arandela', $nome, $codigo, ['Dimensões' => '100 × 180 mm'], $img]]);
    $plv = static function (string $nome, string $forma, array $codigos, string $img) use ($vd): array {
        $redondo = $forma === 'redondo';
        $versoes = [];
        foreach ([[250, '1'], [300, '2']] as $i => [$mm, $lamp]) {
            $medida = $redondo ? ['Diâmetro' => $mm . ' mm'] : ['Dimensões' => $mm . ' × ' . $mm . ' mm'];
            $versoes[] = ['Plafon', $nome . ' ' . $mm, $codigos[$i], $medida + ['Lâmpadas' => $lamp], $img];
        }
        return linha('Plafon de vidro ' . $nome, 'plafons', 67, $vd + [
            'descricao' => 'Plafon ' . ($redondo ? 'redondo' : 'quadrado') . ' de vidro decorado, em dois tamanhos: ' . ($redondo ? 'Ø 250 mm' : '250 × 250 mm') . ' para 1 lâmpada e ' . ($redondo ? 'Ø 300 mm' : '300 × 300 mm') . ' para 2 lâmpadas E27.',
        ], $versoes);
    };
    $produtos += [
        'arandela-de-vidro-bamboo'         => $arv('Bamboo', '687-BA', 'arandela-bamboo'),
        'arandela-de-vidro-rio-de-janeiro' => $arv('Rio de Janeiro', '619-RJ', 'arandela-rio-de-janeiro'),
        'arandela-de-vidro-cadence'        => $arv('Cadence', '688-CA', 'arandela-cadence'),
        'arandela-de-vidro-risk'           => $arv('Risk', '616-RIS', 'arandela-risk'),
        'arandela-de-vidro-fosca'          => $arv('Fosca', '5004', 'arandela-fosca'),
        'arandela-de-vidro-xadrez'         => $arv('Xadrez', '615-XAD', 'arandela-xadrez'),
        'plafon-de-vidro-risk-redondo'     => $plv('Risk Redondo', 'redondo', ['901P-RED-RIS', '901-RED-RIS'], 'plafon-risk-redondo'),
        'plafon-de-vidro-cadence'          => $plv('Cadence', 'redondo', ['901P-RED-CA', '901-RED-CA'], 'plafon-cadence'),
        'plafon-de-vidro-orion'            => $plv('Orion', 'quadrado', ['946P-OR-PTBR', '946-OR-PTBR'], 'plafon-orion'),
        'plafon-de-vidro-bamboo'           => $plv('Bamboo', 'quadrado', ['945P-BA-BR', '945-BA-BR'], 'plafon-bamboo'),
        'plafon-de-vidro-risk-quadrado'    => $plv('Risk Quadrado', 'quadrado', ['900P-QUAD-RIS', '900-QUAD-RIS'], 'plafon-risk-quadrado'),
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
    if (isset($p['versoes'])) {
        $n = count($p['versoes']);
        if ($n > 1) {
            return $n . ' modelos · ' . $p['soquete'];
        }
        $s = $p['versoes'][0]['specs'];
        unset($s['Tipo'], $s['Acabamentos'], $s['Soquete']);
        $partes = array_slice(array_map(static fn($k, $v) => $k . ' ' . $v, array_keys($s), $s), 0, 2);
        return implode(' · ', array_merge($partes, ['Soquete ' . $p['soquete']]));
    }
    return $p['largura'] . ' × ' . $p['altura'] . ' · 1, 2 e 3 m';
}

function produto_whatsapp(string $nome): string
{
    return 'https://wa.me/' . ARS_SITE['whatsapp']['number'] . '?text=' . rawurlencode('Olá! Quero um orçamento do ' . $nome . ' da ARS Iluminação.');
}
