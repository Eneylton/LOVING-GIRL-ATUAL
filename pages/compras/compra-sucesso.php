<?php

require __DIR__.'../../../vendor/autoload.php';
session_start();

$_SESSION['carrinho_compra'];

if (isset($_SESSION['carrinho_compra'])) {
    unset($_SESSION['carrinho_compra']);
}



define('TITLE', '');
define('BRAND', 'Lista de Compras');

use   \App\Session\Login;

Login::requireLogin();
$usuariologado = Login:: getUsuarioLogado();
$usuario_id = $usuariologado['id'];


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/pedido/pedido-form-sucesso.php';
include __DIR__ . '../../../includes/layout/footer.php';
