<?php

require __DIR__.'../../../vendor/autoload.php';
session_start();

use App\Entidy\Compra;
use App\Entidy\Pedido;
use App\Session\Login;

Login::requireLogin();
$usuariologado = Login:: getUsuarioLogado();
$usuario_id = $usuariologado['id'];

if(isset($_GET['fornecedor_id'])){

    $fornecedor = $_GET['fornecedor_id'];
}

foreach ($_SESSION['compras'] as $key) {
  
        $item = new Compra;
        $item->nome          = $key['nome'];
        $item->codigo        = $key['codigo'];
        $item->barra         = $key['barra'];
        $item->qtd           = $key['qtd'];
        $item->valor_compra  = $key['valor_compra'];
        $item->subtotal      = $key['subtotal'];
        $item->usuarios_id   = $usuario_id;
        $item->produtos_id   = $key['produtos_id'];
        $item->fornecedor_id = $fornecedor;
        $item->status        = 1;
        $item-> cadastar();
    
    }    
    
    header('location:compra-sucesso.php?status=success');
    



