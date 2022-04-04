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




$consulta = "c.data between '" . $dataInicio . "' AND '" . $dataFim . "'";



$result = "";

$listar = Deposito::getList(' c.id AS id,
c.data AS data,
c.forma_pagamento_id AS forma_pagamento_id,
b.nome as banco,
c.valor AS valor,
f.nome AS pagamento,
c.banco_id AS banco_id', ' deposito AS c
INNER JOIN
forma_pagamento AS f ON (f.id = c.forma_pagamento_id)
INNER JOIN
banco AS b ON (b.id = c.banco_id)', $consulta, null, null);

$contador = 0;
$total = 0;

foreach ($listar as $item) {

    $contador += 1;
    $total += $item->valor;

    $result .= '   <tr>
                           <td>' . $contador . '</td>
                   

                        <td>' . date('d/m/Y à\s H:i:s ', strtotime($item->data)) . '</td>

                        <td style="text-transform: uppercase; font-weight:100; text-align:left">'. $item->banco . '</td>
                        <td style="text-transform: uppercase; text-align:left ">' . $item->pagamento . '</td>
                        <td style="text-transform: uppercase; font-weight:200; text-align:left;font-size:12px"> R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
                    
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
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">**** DEPOSITOS FINANCEIRO ****</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#fb9ada; border:1px solid #fb9ada; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="5">HISTÓRICO</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align:center; font-size:x-small; width:20px"> Nª</td>
           
                <td style="text-align:center;  width:120px"> DATA </td>
                <td style="text-align:left;  width:130px"> BANCO</td>
                <td style="text-align:left;  width:100px"> F. DE PAGAMENTO </td>
                
                <td style="text-align:left;  width:155px"> VALOR</td>




            </tr>

            <?= $result ?>

            <tr style="background-color: #fb9ada; color:#000">
                <td colspan="4" style="text-align: right;">
                    <span style="font-size: 16px; font-weight:600"> TOTAL &nbsp; &nbsp;</span>
                </td>
                <td style="text-align: left;">
                    <span style="font-size: 16px; font-weight:600;text-align:left;">R$ <?= number_format($total, "2", ",", "."); ?></span>
                </td>
            </tr>


        </tbody>
    </table>

</body>

</html>