<?php

require __DIR__.'../../../vendor/autoload.php';
session_start();

use App\Entidy\Compra;
use App\Session\Login;

$valor = 0;
$resultado = 0;
$valor_base = 0;

Login::requireLogin();
$usuariologado = Login:: getUsuarioLogado();
$usuario_id = $usuariologado['id'];

if(isset($_GET['fornecedor_id'])){

    $fornecedor = $_GET['fornecedor_id'];
}

foreach ($_SESSION['compras'] as $key) {
        
        $valor_base = 40;
        $valor = $key['valor_compra'];
        $resultado = ($valor / $valor_base) * 100;
  
        $item = new Compra;
        $item->nome          = $key['nome'];
        $item->codigo        = $key['codigo'];
        $item->barra         = $key['barra'];
        $item->qtd           = $key['qtd'];
        $item->valor_compra  = $resultado;
        $item->subtotal      = $key['subtotal'];
        $item->usuarios_id   = $usuario_id;
        $item->produtos_id   = $key['produtos_id'];
        $item->fornecedor_id = $fornecedor;
        $item->status        = 1;
        $item-> cadastar();
    
    }    
    
    header('location:compra-sucesso.php?status=success');
    



