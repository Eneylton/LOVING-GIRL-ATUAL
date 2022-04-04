<?php

require __DIR__ . '../../../vendor/autoload.php';
session_start();

use App\Entidy\Fornecedor;
use App\Entidy\Produto;
use App\Session\Login;

define('TITLE', 'Meus Pedidos');
define('BRAND', 'Compras');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';

Login::requireLogin();
$res = "";

if (!isset($_SESSION['carrinho_compra'])) {

    $_SESSION['carrinho_compra'] = array();
}

if (isset($_POST['submit'])) {

    if (isset($_POST['id'])) {

        foreach ($_POST['id'] as $id) {

            if (isset($_POST['id'])) {

                $id  = intval($id);

                if (!isset($_SESSION['carrinho_compra'][$id])) {

                    $_SESSION['carrinho_compra'][$id] = 1;
                } else {

                    $_SESSION['carrinho_compra'][$id] += 1;
                }
            }
        }
    }
}

if (isset($_GET['acao'])) {

    if ($_GET['acao'] == 'add') {

        $id = intval($_GET['id']);

        if (!isset($_SESSION['carrinho_compra'][$id])) {

            $_SESSION['carrinho_compra'][$id] = 1;
        } else {
            $_SESSION['carrinho_compra'][$id] += 1;
        }
    }

    if ($_GET['acao'] == 'del') {
        $id = intval($_GET['id']);

        if (isset($_SESSION['carrinho_compra'][$id])) {
            unset($_SESSION['carrinho_compra'][$id]);
        }
    }

    if ($_GET['acao'] == 'up') {

        if (is_array($_POST['prod'])) {

            foreach ($_POST['prod'] as $id => $qtd) {

                $id = intval($id);
                $qtd = intval($qtd);

                if (!empty($qtd) || $qtd != 0) {

                    $_SESSION['carrinho_compra'][$id] = $qtd;
                } else {

                    unset($_SESSION['carrinho_compra'][$id]);
                }
            }
        }

        if (is_array($_POST['val'])) {

            foreach ($_POST['val'] as $id => $valor) {

                $item = Produto::getID('*', 'produtos', $id, null, null);
                $val1              = $valor;
                $val2              = str_replace(".", "", $val1);
                $preco             = str_replace(",", ".",  $val2);

                $item->valor_compra = $preco;

                $item->atualizar();
            }
        }
    }
}

$fornecedores = Fornecedor::getList('*', 'fornecedor', null, 'nome ASC');

foreach ($fornecedores as $item) {
    $res .= '<option style="text-transform:uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
}

echo '
<div class="card card-purple" style="margin-top: 0px;">
               <div class="card-header">

                  <form action="compra-finalizar.php" method="GET">
                     <div class="row">

                     <select class="form-control select" style="width: 30%;" name="fornecedor_id" required>
                     <option value=""> Selecione um fornecedor </option>
                     
                      ' . $res . '

                     </select>
                    
                        <div class="col-12">
                     
                        <button style="margin-left:20px" type="submit" class="btn btn-warning float-right"> <i class="fas fa-plus"></i> &nbsp; Finalizar Pedidos</button>
                         
                        <a href="compra-list.php">
                        
                         <button type="submit" class="btn btn-danger float-right"> <i class="fas fa-plus"></i> &nbsp; Add produtos</button>
                        </a>
                      
                      
                        </div>


                     </div>

                  </form>

               </div>

<div>
<form action="?acao=up" method="post">
<table class="table table-dark table-bordered table-hover table-striped">
   <thead>
  
      <tr>
      <th> PRODUTO </th>
      <th> NOME </th>
      <th> QTD </th>
      <th> VALOR </th>
      <th> SUBTOTAL </th>
      <th style="text-align:center"> REMOVER </th>
      </tr>
   </thead>
   
   <tbody>
      ';

if (count($_SESSION['carrinho_compra']) == 0) {
    echo '<tr>
        <td colspan="6" style="text-align:center">
        Nenhum produto adicionado.....
        </td>
        </tr>';
} else {

    $_SESSION['compras'] = array();

    $total = 0;
    foreach ($_SESSION['carrinho_compra'] as $id => $qtd) {

        if (empty($item->foto)) {
            $foto = './imgs/sem-foto.jpg';
        } else {
            $foto = $item->foto;
        }

        $item = Produto::getID('*', 'produtos', $id, null, null);

        $valor1 = $item->valor_compra;

        $valor2 = str_replace(".", ",", $valor1);

        $sub = $qtd * $valor1;

        $total += $sub;

        echo '

            <tr>
            <td style="display:none">' . $item->id . '</td>
            <td>
           
            <img style="width:30px; heigth:30px;object-fit: contain;" src="../.' . $foto . '" class="img-thumbnail">
            </a>
            </td>
           
            <td style="text-transform:uppercase">' . $item->nome . '</td>
            <td>

            <input type="text" size="3" name="prod[' . $id . ']" value="' . $qtd . '" />

            <input type="submit" value="Atualizar" style="color:#ff0000" />
            </td>
            <td>R$

            <input type="text" size="3" name="val[' . $id . ']" value="' . $valor2 . '" id="dinheiro" />
            <input type="submit" value="Atualizar" style="color:#ff0000" />
            </td>


            <td> R$ ' . number_format($qtd * $item->valor_compra, "2", ",", ".") . '</td>
            <td style="text-align:center"> <a href="?acao=del&id=' . $id . '" style="color:#ff0000; font-size:20px"><i class="fa fa-times" aria-hidden="true"></i> </a></td>
            </tr>


            ';

        array_push(
            $_SESSION['compras'],

            array(
                'nome'               => $item->nome,
                'codigo'             => $item->codigo,
                'barra'              => $item->barra,
                'qtd'                => $qtd,
                'valor_compra'       => $item->valor_compra,
                'subtotal'           => $sub,
                'produtos_id'        => $id
            )
        );
    }
}

echo '
        <tr>
        <td colspan="4">TOTAL</td>

        <td colspan="2">

        <button type="submit" class="btn btn-success btn-lg" >';

if (isset($total)) {
    echo ' R$ ' . number_format($total, "2", ",", ".") . '';
}

echo '
        </button>
        </td>
        </tr>
        </tbody>
       
        </table>
        </form>

        <?=$paginacao?>


';

include __DIR__ . '../../../includes/layout/footer.php';
