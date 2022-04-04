<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Compra;
use App\Session\Login;

define('TITLE', 'Receber Compras');
define('BRAND', 'Compras');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

if ($buscar == null) {

    $and = "";
} else {

    $and = " AND";
}


$condicoes = [
    strlen($buscar) ? 'c.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
                       or 
                       f.nome  LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       c.barra LIKE "%' . str_replace(' ', '%', $buscar) . '%" ' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Compra::getQtd($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 1000);

$produtos = Compra::getList(' c.id as id,c.produtos_id as produtos_id,
c.barra as barra,
f.nome as fornecedor,
c.nome as nome,
c.qtd as qtd,
c.subtotal as compra,
c.valor_compra as valor','compras AS c
INNER JOIN
fornecedor AS f ON (f.id = c.fornecedor_id)',$where . $and .' status = 1');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/pedido/pedido-form-receber.php';
include __DIR__ . '../../../includes/layout/footer.php';
