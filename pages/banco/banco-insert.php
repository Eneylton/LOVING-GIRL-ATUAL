<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Banco;
use App\Session\Login;

define('TITLE','Abrir Caixa');
define('BRAND','Caixa');

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if(isset($_POST['nome'])){

      
        $item = new Banco;
        $item->nome = $_POST['nome'];
        $item->cadastar();

        header('location: banco-list.php?status=success');
        exit;
    }
  
   