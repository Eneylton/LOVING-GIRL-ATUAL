<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Movimentacao;
use App\Entidy\Prodvenda;
use App\Session\Login;

define('TITLE','Minhas Despesas');
define('BRAND','Despesas');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

if ($buscar == null) {

    $and = "";
} else {

    $and = " AND";
}


$condicoes = [
    strlen($buscar) ? 'm.id LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       c.nome LIKE "%'.str_replace(' ','%',$buscar).'%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Prodvenda:: getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 2000);

$listar = Movimentacao::getList(' m.id AS id,
m.data AS data,
m.valor AS valor,
m.descricao AS descricao,
m.tipo AS tipo,
m.status AS status,
f.nome AS pagamento,
c.nome AS categoria,
f.nome AS pagamentor','movimentacoes AS m
INNER JOIN
usuarios AS u ON (m.usuarios_id = u.id)
INNER JOIN
catdespesas AS c ON (m.catdespesas_id = c.id)
INNER JOIN
forma_pagamento AS f ON (m.forma_pagamento_id = f.id)',$where . $and .' m.tipo= 0 AND month(m.data) = MONTH(CURRENT_DATE()) ', 'm.id desc',$pagination->getLimit());

$acessos = Prodvenda :: getList('*','acessos');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/venda/despesa-form-list.php';
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
        $('#descricao').val(data[1]);
       
    });
});
</script>
