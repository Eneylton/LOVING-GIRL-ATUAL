<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Compra;
use App\Entidy\Pedido;
use \App\Session\Login;

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

$pedidos = Compra::getList('*','compras');

$res = "";
$total = 0;
foreach ($pedidos as $item) {
$total += $item->subtotal;
    $res .= '
<tr>

<td>' . date('d/m/Y à\s H:i:s ', strtotime($item->data)) . '</td>
<td style="text-align:left;text-transform: uppercase;">' . $item->nome . '</td>
<td>' . $item->qtd . '</td>
<td> R$ ' . number_format($item->valor_compra, "2",",",".") . '</td>
<td style="text-align:left"> R$ ' . number_format($item->subtotal, "2", ",", ".") . '</td>
</tr>
';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @page{
            margin: 70px 0;
        }

        body{
            margin:0;
            padding: 0;
            font-family:"Open Sans", sans-serif;
        }

        .header{
            position: fixed;
            top:-70px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            background-color: #555555;
            padding: 10px;
        }

        .header img {
            width: 160px;
        }

        .footer{
            bottom: -27px;
            left: 0;
            width: 100%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            background: #555555;
            color: #fff;
            }

            .footer .page:after{
                content: counter(page);
                
            }

            table{
                width: 100%;
                border: 1px solid #555555;
                margin: 0;
                padding: 0;
            }

            th{
                text-transform: uppercase;
            }

            table, th, td {
                font-size: xx-small;
                border: 1px solid #555555;
                border-collapse:collapse;
                text-align: center;
                padding: 5px;

            }

            tr:nth-child(2n+0){
                background: #eeeeee;
            }

            p{
                color:#888888;
                margin: 0;
                text-align: center;
            }

            h2{
                text-align: center;
                
            }

    </style>

    <title>Meus Pedidos</title>
</head>

<body>

<table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Lojão do Carro </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../01.png">
                    <br />
                    <br />
                    
                </td>
                <td style="text-align:center; font-weight:600; font-size:x-large; border:1px solid #fff;">LISTA DE COMPRAS</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>

    <!--  -->

    <table>
        <tbody>
        <tr style="background-color: darkorange; color:#000">
            <td colspan="5">
            <span style="font-size: x-small;font-weight:600">AGUARDANDO AUTORIZAÇÃO</SPan>
            </td>
            </tr>
            <tr style="background-color: #000; color:#fff">
               
                <td>DATA</td>
                <td>NOME</td>
                <td>QTD</td>
                <td>VALOR COMPRA</td>
                <td>SUBTOTAL</td>
            </tr>

            <?=$res?>
           <tr>
           <td colspan="4" style="text-align:right;font-size: 14px;background-color:#ff0000; color:#eeeeee">TOTAL</td>
           <td style="text-align:left;font-size:15px;background-color:#ff0000; color:#eeeeee">R$ <?= number_format($total,"2",",",".")?></td>
           </tr>
        </tbody>
    </table>

</body>

</html>