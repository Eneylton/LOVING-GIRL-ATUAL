<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

use App\Entidy\Movimentacao;
use App\Session\Login;


Login::requireLogin();

if (!isset($_GET['id3']) or !is_numeric($_GET['id3'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Movimentacao:: getID('*','movimentacoes',$_GET['id3'],null,null);


if (!$value instanceof Movimentacao) {
    header('location: index.php?status=error');

    exit;
}

if(isset($_GET['caixa_id'])){

    $idcaixa = $_GET['caixa_id'];
 
} 

if (isset($_GET['forma_pagamento_id3'])) {
    date_default_timezone_set('America/Sao_Paulo');

    $val1              = $_GET['valor3'];
    $preco             = str_replace(",", ".",$val1);

    $value->status = $_GET['status3'];
    $value->tipo   = $_GET['tipo3'];
    $value->data = date('Y-m-d');
    $value->forma_pagamento_id = $_GET['forma_pagamento_id3'];
    $value->descricao = $_GET['descricao3'];
    $value->valor =  $preco;
    $value->atualizar();

    header('location: movimentacao-list.php?id='.$idcaixa);

    exit;
}
