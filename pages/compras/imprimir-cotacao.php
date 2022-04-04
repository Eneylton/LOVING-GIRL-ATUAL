
<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Produto;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";
$total = 0;

foreach ($_SESSION['carrinho_compra'] as $id => $qtd) {

    $item = Produto::getIDCategoria($id);

    $total += $qtd;

    $res .= '
                <tr>
                
                    <td style="text-align:left;text-transform: uppercase;">' . $item->nome . '</td>
                    <td style="text-align:left;text-transform: uppercase;">' . $item->categoria . '</td>
                    <td style="text-align:center;text-transform: uppercase;">' . $qtd . '</td>
                    <td style="text-align:left;text-transform: uppercase;">R$</td>
                    <td style="text-align:right;text-transform: uppercase;">%</td>
                    <td style="text-align:left;text-transform: uppercase;">R$</td>
    
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
        @page {
            margin: 70px 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
        }

        .header {
            position: fixed;
            top: -70px;
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

        .footer {
            bottom: -27px;
            left: 0;
            width: 100%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            background: #555555;
            color: #fff;
        }

        .footer .page:after {
            content: counter(page);

        }

        table {
            width: 100%;
            border: 1px solid #555555;
            margin: 0;
            padding: 0;
        }

        th {
            text-transform: uppercase;
        }

        table,
        th,
        td {
            font-size: xx-small;
            border: 1px solid #555555;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;

        }

        tr:nth-child(2n+0) {
            background: #eeeeee;
        }

        p {
            color: #888888;
            margin: 0;
            text-align: center;
        }

        h2 {
            text-align: center;

        }
    </style>

    <title>Lista de Pedidos</title>
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


    <table>
        <tbody>
            <tr style="background-color: #000; color:#fff">

                <td style="text-align: left;">PRODUTO</td>
                <td style="text-align: left;">CATEGORIA</td>
                <td style="text-align: center; width:50px">QTD</td>
                <td style="text-align: center; width:80px">VAL.UNI</td>
                <td style="text-align: center; width:80px">DESCONTO</td>
                <td style="text-align: center; width:80px">SUBTOTAL</td>

            </tr>

            <?= $res ?>
            <tr>
                <td style="text-align: left; font-weight:600; font-size:x-small" colspan="2">
                    TOTAL
                </td>
                <td style="text-align: center;" colspan="1">
                  <span style="font-weight: 600; font-size:12px"><?= $total ?></span>
                </td>
                <td style="text-align: left;" colspan="1">
                    R$
                </td>
                <td style="text-align: right;" colspan="1">
                    %
                </td>
                <td style="text-align: left;" colspan="1">
                    R$
                </td>

            </tr>

        </tbody>
    </table>

</body>

</html>