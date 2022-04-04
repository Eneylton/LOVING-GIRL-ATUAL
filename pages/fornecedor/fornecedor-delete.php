<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Fornecedor;
use App\Session\Login;

Login::requireLogin();

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Fornecedor::getID('*','fornecedor',$_GET['id'],null,null);

if(!$value instanceof Fornecedor){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: fornecedor-list.php?status=del');

    exit;
}

