<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Deposito;
use   \App\Session\Login;

Login::requireLogin();


if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Deposito::getID('*','deposito',$_GET['id'],null,null);

if(!$value instanceof Deposito){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: deposito-list.php?status=del');

    exit;
}

