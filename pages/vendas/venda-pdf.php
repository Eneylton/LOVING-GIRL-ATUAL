<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Deposito;
use \App\Session\Login;

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];


$dataInicio;
$dataFim;

$consulta = "pv.data between '" . $dataInicio . "' AND '" . $dataFim . "'";

$result = "";

$listar = Deposito::getList(' pv.id as id,
pv.data as data,
pv.codigo as codigo,
pv.qtd as qtd,
p.nome as produto,
f.nome as pagamento,
pv.valor as valor', ' produto_venda AS pv
INNER JOIN
produtos AS p ON (p.id = pv.produtos_id)
INNER JOIN
forma_pagamento AS f ON (f.id = pv.forma_pagamento_id)', $consulta, null, null);

$contador = 0;
$soma = 0;
$total = 0;
$qtd = 0;
$valor = 0;
foreach ($listar as $item) {

    $contador += 1;
    $valor = $item->valor;
    $qtd = $item->qtd; 
    $total += $valor;

    $result .= '   <tr>
    <td>' . $contador . '</td>
    <td>' . $item->codigo . '</td>
    <td style="text-transform:uppercase">' . date('d/m/Y', strtotime($item->data)) . '</td>
    <td>' . $item->produto. '</td>
    <td>' . $item->qtd . '</td>
    <td>' . $item->pagamento . '</td>
    <td> R$ ' .number_format($item->valor,"2",",",".") . '</td>
   
                    
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
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">

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

    <title>Depositos</title>
</head>

<body>

    <table style="margin-top:-40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Lovingirl </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../01.png">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">**** MINHAS VENDAS ****</td>
                <td style="text-align:right; border:1px solid #fff;margin-left:-10">
                    <?php echo "Data: " . date('d/m/Y', strtotime($dataInicio));
                    echo " á " . date('d/m/Y', strtotime($dataFim))  ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#fb9ada; border:1px solid #fb9ada; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="7">HISTÓRICO</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

            <th> Nª </th>
                           <th> CÓDIGO </th>
                           <th> DATA </th>
                           <th> PRODUTO </th>            
                           <th> QTD </th>
                           <th> PAGAMENTO </th>
                           <th> VALOR </th>
                       



            </tr>

            <?= $result ?>

            <tr style="background-color:#9a2771; color:#fff">
                <td colspan="6" style="text-align: right;">
                    <span style="font-size: 16px; font-weight:bold"> TOTAL &nbsp; &nbsp;</span>
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 22px; font-weight:bold;text-align:center;">R$ <?= number_format($total, "2", ",", "."); ?></span>
                </td>
            </tr>


        </tbody>
    </table>

</body>

</html>