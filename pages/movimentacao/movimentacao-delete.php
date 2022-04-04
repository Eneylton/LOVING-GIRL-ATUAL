<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Movimentacao;
use App\Entidy\Produto;
use App\Entidy\Prodvenda;
use App\Session\Login;


Login::requireLogin();

$id = 0;

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Movimentacao::getID('*','movimentacoes',$_GET['id'],null,null);

$id  = $value->id;

$result = Prodvenda::getMovID('*','produto_venda',$id,null,null);

$id_prod = $result->id; 

$prod_id = $result->produtos_id;

$qtd_prodvenda = $result->qtd;

$buscar_prod = Produto::getID('*','produtos',$prod_id,null,null);

$produtos = Prodvenda::getID('*','produto_venda',$id_prod,null,null);

$calculo = ($buscar_prod->estoque + $qtd_prodvenda);

$buscar_prod->estoque = $calculo;

$buscar_prod->atualizar();

if(!$value instanceof Movimentacao){
    header('location: index.php?status=error');

    exit;
}

if(!isset($_POST['excluir'])){
    
 
   $value->excluir();
   $produtos->excluir();

   header('location: movimentacao-list.php?id='.$_GET['caixa_id']);

   exit;

}

