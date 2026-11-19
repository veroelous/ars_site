<?php
/**
 * /llms.txt — resumo do site em Markdown para assistentes de IA (padrão llmstxt.org).
 * Gerado a partir dos mesmos dados do site: ao cadastrar um produto, ele aparece aqui sozinho.
 */
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/produtos.php';

header('Content-Type: text/plain; charset=utf-8');
if (ars_noindex()) {
    header('X-Robots-Tag: noindex, nofollow');
}
$base = ars_site_url();
$a = ARS_SITE['address'];

$out = "# ARS Iluminação\n\n";
$out .= "> Fabricante de luminárias e perfis de LED em Socorro/SP, Brasil, desde 2014. Produção própria, estoque para pronta entrega e envio para todo o Brasil. Atende lojistas, distribuidores, arquitetos, especificadores e instaladores; o consumidor final compra nas revendas.\n\n";
$out .= "- Endereço: {$a['street']}, {$a['detail']}\n";
$out .= '- WhatsApp comercial: ' . ARS_SITE['whatsapp']['display'] . "\n";
$out .= '- E-mail: ' . ARS_SITE['email'] . "\n";
$out .= '- Instagram: ' . ARS_SITE['instagram']['url'] . "\n";
$out .= "- Marcas do Grupo ARS Iluminação: ARS, Bonalux e RSG\n\n";

$out .= "## Páginas principais\n\n";
$out .= "- [Produtos]({$base}/produtos/): as nove linhas do catálogo, com ficha técnica, códigos e acabamentos de cada modelo\n";
$out .= "- [Seja revendedor]({$base}/seja-revendedor/): cadastro de lojas e distribuidores\n";
$out .= "- [Onde comprar]({$base}/onde-comprar/): indicação de revendas para o consumidor final\n";
$out .= "- [Contato e orçamento]({$base}/contato-e-orcamento/): formulário e canais da equipe comercial\n";
$out .= "- [A ARS]({$base}/a-ars/): história, fabricação e Grupo ARS\n\n";

foreach (ARS_CATEGORIAS as $slug => $cat) {
    $out .= "## {$cat['nome']}\n\n";
    $out .= ($cat['descricao'] ?? $cat['resumo']) . " Página: {$base}/produtos/{$slug}/\n\n";
    foreach (ars_produtos_por_tipo($slug) as $itens) {
        foreach ($itens as $s => $p) {
            $out .= "- [{$p['nome']}]({$base}" . produto_url($s, $p) . "): " . produto_resumo($p) . "\n";
        }
    }
    $out .= "\n";
}

$out .= "## Observações\n\n";
$out .= "- Preços, pedido mínimo e prazos são informados pela equipe comercial; o site não publica preços.\n";
$out .= "- Os dados técnicos vêm do catálogo oficial da ARS. O catálogo completo em PDF é liberado no formulário da página inicial: {$base}/#catalogo\n";
echo $out;
