<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Fornecedor;
use App\Session\Login;

Login::requireLogin();

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Fornecedor:: getID('*','fornecedor',$_GET['id'],null,null);


if(!$value instanceof Fornecedor){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['nome'])){
    
    $value->nome       = $_GET['nome'];
    $value->telefone   = $_GET['telefone'];
    $value->email      = $_GET['email'];
    $value-> atualizar();

    header('location: fornecedor-list.php?status=edit');

    exit;
}


