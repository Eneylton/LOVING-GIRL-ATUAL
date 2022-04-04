<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Banco;
use App\Entidy\Deposito;
use App\Entidy\FormaPagamento;
use App\Session\Login;

define('TITLE','Deposito');
define('BRAND','Deposito');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'id LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       data LIKE "%'.str_replace(' ','%',$buscar).'%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Deposito:: getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 40);

$listar = Deposito::getList(' c.id AS id,
c.data AS data,
c.forma_pagamento_id AS forma_pagamento_id,
b.nome as banco,
c.valor AS valor,
f.nome AS pagamento,
c.banco_id AS banco_id','deposito AS c
INNER JOIN
forma_pagamento AS f ON (f.id = c.forma_pagamento_id)
INNER JOIN
banco AS b ON (b.id = c.banco_id)',$where, 'c.id desc',$pagination->getLimit());

$pagamentos = FormaPagamento :: getList('*','forma_pagamento',null,'nome ASC');
$bancos = Banco :: getList('*','banco',null,'nome ASC');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/deposito/deposito-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
$(document).ready(function(){
    $('.editbtn').on('click', function(){
        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id').val(data[0]);
        $('#data').val(data[1]);
        $('#valor').val(data[2]);
        $('#forma_pagamento_id').val(data[3]);
        $('#banco_id').val(data[4]);
        $('#banco').val(data[5]);
       
    });
});
</script>
