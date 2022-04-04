<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Deposito;
use App\Session\Login;


$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

$hoje = date('Y-m-d');


if(isset($_POST['valor'])){

        $vl1            = $_POST['valor'];
        $vl2            = str_replace(".", "", $vl1);
        $vl3            = str_replace(",", ".",$vl2);

        $item = new Deposito;
        $item->valor = $vl3;
        $item->data = $hoje;
        $item->forma_pagamento_id = $_POST['forma_pagamento_id'];
        $item->banco_id = $_POST['banco_id'];
        $item->cadastar();

      

        header('location: deposito-list.php?status=success');
        exit;
    }
  
   