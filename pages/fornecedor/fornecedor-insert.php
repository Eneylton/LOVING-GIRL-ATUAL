<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Fornecedor;
use App\Session\Login;

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if(isset($_POST['nome'])){

        $item = new Fornecedor;
        $item->nome = $_POST['nome'];
        $item->telefone = $_POST['telefone'];
        $item->email = $_POST['email'];
        $item->cadastar();

        header('location: fornecedor-list.php?status=success');
        exit;
    }
  
   




include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/usuario/usuario-form-insert.php';
include __DIR__.'../../../includes/layout/footer.php';