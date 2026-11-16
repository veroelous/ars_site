<?php
/**
 * Dados institucionais da ARS Iluminação (sem segredos).
 *
 * Fonte: site publicado em oficial.arsiluminacao.com.br, capturado em 13/11/2026.
 * Itens marcados "validar" precisam de confirmação da ARS (ver docs/PENDENCIAS.md).
 */
declare(strict_types=1);

const ARS_SITE = [
    'name'        => 'ARS Iluminação',
    'tagline'     => 'Ir além de iluminar espaços.',
    'description' => 'ARS Iluminação: fabricante de soluções de iluminação em Socorro/SP, com entrega para todo o Brasil. Baixe o catálogo e fale com a equipe comercial.',
    // Aprovado para manutenção pelo responsável.
    'email'       => 'comercial@arsiluminacao.com.br',
    'instagram'   => [
        'handle' => '@ars.iluminacao',
        'url'    => 'https://www.instagram.com/ars.iluminacao/',
    ],
    // validar: número do link wa.me da Home atual.
    'whatsapp'    => [
        'number'  => '5519996965662',
        'display' => '(19) 99696-5662',
        'message' => 'Olá! Vim pelo site da ARS Iluminação e gostaria de mais informações.',
    ],
    // validar: endereço do rodapé atual.
    'address'     => [
        'street'     => 'Estrada de Joaquim de Souza Siqueira, 2099',
        'detail'     => 'Oratório · Socorro/SP · CEP 13960-000',
        'locality'   => 'Socorro',
        'region'     => 'SP',
        'postalCode' => '13960-000',
        'mapsUrl'    => 'https://www.google.com/maps/search/?api=1&query=Estrada+Joaquim+de+Souza+Siqueira%2C+2099%2C+Orat%C3%B3rio%2C+Socorro%2C+SP%2C+13960-000',
    ],
    'catalog'     => [
        'label'    => 'Catálogo ARS 2026',
        'fileName' => 'catalogo-ars-iluminacao.pdf',
    ],
    'footerNote'  => 'Fabricado em Socorro/SP · Entregue para todo o Brasil',
    'consent'     => 'Autorizo a ARS Iluminação a usar meus dados para contato comercial. Meus dados não serão vendidos a terceiros.',
];

const ARS_NAV = [
    ['href' => '/', 'label' => 'Início'],
    ['href' => '/a-ars/', 'label' => 'A ARS'],
    ['href' => '/produtos/', 'label' => 'Produtos'],
    ['href' => '/categorias-de-luminarias/', 'label' => 'Categorias'],
    ['href' => '/contato-e-orcamento/', 'label' => 'Contato e orçamento'],
];

/**
 * Publicações do Instagram exibidas sem token da API (via embed oficial).
 * Capturadas do feed do site atual em 13/11/2026.
 */
const ARS_INSTAGRAM_FALLBACK = [
    ['permalink' => 'https://www.instagram.com/reel/DfpAN-NmgTn/', 'caption' => 'Precisando de perfis de LED? Na ARS tem pronta entrega!'],
    ['permalink' => 'https://www.instagram.com/reel/DfmkQ0njdiJ/', 'caption' => 'Perfil de LED a pronta entrega, direto de quem fabrica.'],
    ['permalink' => 'https://www.instagram.com/reel/Dfj3nkLiGKP/', 'caption' => 'Qualidade de alto padrão com um preço que surpreende!'],
];

function whatsapp_url(): string
{
    return 'https://wa.me/' . ARS_SITE['whatsapp']['number'] . '?text=' . rawurlencode(ARS_SITE['whatsapp']['message']);
}
