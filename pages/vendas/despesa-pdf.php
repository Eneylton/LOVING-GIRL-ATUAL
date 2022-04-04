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

$consulta = "m.data between '" . $dataInicio . "' AND '" . $dataFim . "'";

$result = "";

$listar = Deposito::getList('m.id AS id,
m.data AS data,
m.valor AS valor,
m.descricao AS descricao,
m.tipo AS tipo,
m.status AS status,
f.nome AS pagamento,
c.nome AS categoria,
f.nome AS pagamento', ' movimentacoes AS m
INNER JOIN
usuarios AS u ON (m.usuarios_id = u.id)
INNER JOIN
catdespesas AS c ON (m.catdespesas_id = c.id)
INNER JOIN
forma_pagamento AS f ON (m.forma_pagamento_id = f.id)', $consulta . ' AND m.tipo=0', null, null);

$contador = 0;
$soma = 0;
$total = 0;
$qtd = 0;
$valor = 0;
foreach ($listar as $item) {

    $contador += 1;
    $valor = $item->valor;
    $total += $valor;

    $result .= '   <tr>
                        <td style="width:20px">

                        <img src="../../imgs/' . ($item->status <= 0 ? 'seta2.png' : 'seta1.png') . '" style="width:20px; 10px">
                        </td>
                        <td style="width:15px">
                        ' . $contador . '
                        </td>
                        <td style="width:150px">
                      
                        <span style="font-weight: bold; color:' . ($item->status <= 0 ? '#ff2121' : '#00ff00') . '">
                        ' . ($item->status <= 0 ? 'EM ABERTO' : 'PAGO') . '
                        </span>
                        
                        </td>
                        <td style="width:150px">
                      
                        <span style="color:' . ($item->tipo <= 0 ? '#ff2121' : '#48da59 ') . '">
                        ' . ($item->tipo <= 0 ? 'DESPESA' : 'RECEITA') . '
                        </span>
                        
                        </td>
                        <td style="text-transform:uppercase">' . date('d/m/Y', strtotime($item->data)) . '</td>
                        <td>' . $item->categoria . '</td>
                        <td>' . $item->pagamento . '</td>
                        <td> R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
   
                    
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

    <title>Despesas</title>
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
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">**** MINHAS DESPESAS ****</td>
                <td style="text-align:right; border:1px solid #fff;margin-left:-10">
                    <?php echo "Data: " . date('d/m/Y', strtotime($dataInicio));
                    echo " á " . date('d/m/Y', strtotime($dataFim))  ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#fb9ada; border:1px solid #fb9ada; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="8">HISTÓRICO</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <th> # </th>
                <th> Nº</th>
                <th> CÓDIGO </th>
                <th> DATA </th>
                <th> PRODUTO </th>
                <th> QTD </th>
                <th> PAGAMENTO </th>
                <th> VALOR </th>




            </tr>

            <?= $result ?>

            <tr style="background-color: #9a2771; color:#fff">
                <td colspan="7" style="text-align: right;">
                    <span style="font-size: 16px; font-weight:100"> TOTAL &nbsp; &nbsp;</span>
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 16px; font-weight:100;text-align:center;">R$ <?= number_format($total, "2", ",", "."); ?></span>
                </td>
            </tr>


        </tbody>
    </table>

</body>

</html>