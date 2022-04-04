<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Compra;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Compra::getID('*','compras',$_GET['id'],null,null);

if(!$value instanceof Compra){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: receber-pedido.php?status=del');

    exit;
}

