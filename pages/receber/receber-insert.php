<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Pedido');
define('BRAND', 'Pedido');

use App\Entidy\Compra;
use App\Entidy\Produto;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

Login::requireLogin();

if(isset($_POST['enviar'])){

$dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true);
$options-> set ('isHtml5ParserEnabled', true);

ob_start();

require __DIR__."/receber-pdf.php";

$dompdf->loadHtml(ob_get_clean());

// echo $pdf;

$dompdf->setPaper("A4");

$dompdf->render();

$dompdf->stream("pedido.pdf", ["Attachment"=> false]);

}

if(isset($_POST['submit'])){
    if(isset($_POST['id'])){
        
        foreach ($_POST['id'] as $id) {
            $item   =  Compra::getReceberID('*','compras',$id,null,null);
            $prod = Produto::getID('*','produtos',$id,null,null);
            $soma = $prod->estoque + $item->qtd;
            $prod->estoque = $soma; 
            $prod->valor_compra = $item->subtotal; 
            $prod->valor_venda = $item->valor_compra; 
            $prod->atualizar();

            $item->status = 0;
            $item->excluir();

            header('location: receber-pedido.php?status=success');
           
        }
    }
}

