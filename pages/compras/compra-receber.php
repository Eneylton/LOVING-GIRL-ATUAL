<?php
require __DIR__ . '/vendor/autoload.php';

use  \App\Db\Pagination;
use   \App\Entidy\Compra;
use     \App\Session\Login;

define('TITLE', 'Receber Mercadoria');
define('BRAND', 'Receber Mercadoria');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'p.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
                       or 
                       p.codigo LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       p.barra LIKE "%' . str_replace(' ', '%', $buscar) . '%" ' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Compra::getQtd($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 40);

$produtos = Compra::getReceber($where , 'nome ASC', $pagination->getLimit());


include __DIR__ . '/includes/layout/header.php';
include __DIR__ . '/includes/layout/top.php';
include __DIR__ . '/includes/layout/menu.php';
include __DIR__ . '/includes/layout/content.php';
include __DIR__ . '/includes/pedido/pedido-form-receber.php';
include __DIR__ . '/includes/layout/footer.php';
