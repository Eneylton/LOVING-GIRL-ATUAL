<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar');
define('BRAND','Editar ');

use App\Entidy\Banco;
use App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Banco:: getID('*','banco',$_GET['id'],null,null);


if(!$value instanceof Banco){
    header('location: index.php?status=error');

    exit;
}





if(isset($_GET['nome'])){

    $value->nome = $_GET['nome'];
    $value-> atualizar();

    header('location: banco-list.php?status=edit');

    exit;
}


