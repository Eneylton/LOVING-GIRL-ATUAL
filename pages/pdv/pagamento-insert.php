<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Movimentacao;
use App\Entidy\Produto;
use App\Entidy\Prodvenda;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

$usuariologado = Login::getUsuarioLogado();

$usuarios_id = $usuariologado['id'];
$usuarios_nome = $usuariologado['nome'];

$total_estoque = 0;
$check = 0;
$venda = 0;

$codigo = substr(uniqid(rand()), 0, 6);

if (isset($_POST['troco'])) {

    $troco                  =   $_POST['troco'];
    $clienteId              =   $_POST['clienteId'];
    $clienteNome            =   $_POST['clienteNome'];
    $clienteEmail           =   $_POST['clienteEmail'];
    $clienteTelefone        =   $_POST['clienteTelefone'];
    $clienteLogradouro      =   $_POST['clienteLogradouro'];
    $clienteBairro          =   $_POST['clienteBairro'];
    $clienteNumero          =   $_POST['clienteNumero'];
    $clienteLocalidade      =   $_POST['clienteLocalidade'];
    $clienteUF              =   $_POST['clienteUF'];
}

if (isset($_SESSION['dados-rodape'])) {

    foreach ($_SESSION['dados-rodape'] as $item) {


        $recebido           = $item['recebido'];
        $troco              = $item['troco'];
    }
}

if (isset($_SESSION['dados-adicionais'])) {

    foreach ($_SESSION['dados-adicionais'] as $item) {


        $cliente           = $item['cliente'];
        $pagamento         = $item['pagamento'];
    }
}

if (isset($_SESSION['caixa'])) {

    foreach ($_SESSION['caixa'] as $item) {


        $caixa_id           = $item['caixa_id'];
        $data               = $item['data'];
    }
}

if (isset($_SESSION['pagamento-insert'])) {

    foreach ($_SESSION['pagamento-insert'] as $item) {


        $produto_id         = $item['produtos_id'];
        $total_desconto     = $item['total_desconto'];
        $qtd                = $item['qtd'];
        $subtotal           = $item['subtotal'];

        $value = Produto::getID('*', 'produtos', $produto_id, null, null);

        $venda = $value->valor_venda;

        $estoque = $value->estoque;

        $total_estoque = ($estoque - $qtd);

        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y-m-d H:i');

        $value->data = $hoje;
        $value->estoque = $total_estoque;
        $value->atualizar();


        $codigo = substr(uniqid(rand()), 0, 6);

        switch ($pagamento) {

            case '2':
                $check = "Dinheiro";
                break;
    
            case '3':
                $check = "Cartão de Crédito 1x";
                break;
    
            case '4':
                $check = "Cartão de Crédito 2x";
                break;
    
            case '5':
                $check = "Cartão de Crédito 3x";
                break;
            case '6':
                $check = "Cartão de Crédito 4x";
                break;
            case '7':
                $check = "Cartão de Débito";
                break;
    
            default:
                $check = "Pix";
                break;
        }
    
    
        $moviment = new Movimentacao;
    
        $moviment->valor                   = $venda;
        $moviment->troco                   = $troco;
        $moviment->descricao               = 'Venda de produdo pago no... '.$check;
        $moviment->tipo                    = 1;
        $moviment->status                  = 1;
        $moviment->usuarios_id             = $usuarios_id;
        $moviment->catdespesas_id          = 15;
        $moviment->forma_pagamento_id      = $pagamento;
        $moviment->caixa_id                = $caixa_id;
        $moviment->data                    = $data;
        $moviment->cadastar();
    
        $id_mov = $moviment->id;
    
    
    
        $item = new Prodvenda;
    
        $item->data                    = $hoje;
        $item->qtd                     = $qtd;
        $item->valor                   = $venda;
        $item->codigo                  = $codigo;
        $item->produtos_id             = $produto_id;
        $item->movimentacoes_id        = $id_mov;
        $item->clientes_id             = $cliente;
        $item->forma_pagamento_id      = $pagamento;
        $item->cadastar();
    
    

       
    }

   
    if (isset($_POST['submit'])) {

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        ob_start();

        if (isset($_GET['dataInicio'])) {

            $nome = $_GET['nome'];
            $barra = $_GET['barra'];
            $dataFim = $_GET['dataFim'];
            $dataInicio = $_GET['dataInicio'];
            $categorias_id = $_GET['categorias_id'];
        }

        require __DIR__ . "/recibo-pdf.php";

        $dompdf->loadHtml(ob_get_clean());

        // echo $pdf;

        $dompdf->setPaper("A7", "landscape");

        $dompdf->render();

        $dompdf->stream("recibo.pdf", ["Attachment" => false]);
    }

    unset($_SESSION['carrinho']);
    unset($_SESSION['dados-venda']);
    unset($_SESSION['pagamento-insert']);

    header('location: pdv.php?caixa_id=' . $caixa_id);

    exit;
}
