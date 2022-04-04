<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Prodvenda;
use App\Session\Login;

define('TITLE','Minhas vendas');
define('BRAND','Vendas');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

$condicoes = [
    strlen($buscar) ? 'id LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       nome LIKE "%'.str_replace(' ','%',$buscar).'%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Prodvenda:: getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 1000);

$listar = Prodvenda::getList(' pv.id as id,
pv.data as data,
pv.codigo as codigo,
pv.qtd as qtd,
p.nome as produto,
f.nome as pagamento,
pv.valor as valor','produto_venda AS pv
INNER JOIN
produtos AS p ON (p.id = pv.produtos_id)
INNER JOIN
forma_pagamento AS f ON (f.id = pv.forma_pagamento_id)',$where .'month(pv.data) = MONTH(CURRENT_DATE()) ', 'pv.data ASC',$pagination->getLimit());

$acessos = Prodvenda :: getList('*','acessos');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/venda/venda-form-list.php';
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
