<?php

$list = '';

if (isset($_GET['status'])) {

   switch ($_GET['status']) {
      case 'success':
         $icon  = 'success';
         $title = 'Parabéns';
         $text = 'Cadastro realizado com Sucesso !!!';
         break;

         case 'del':
            $icon  = 'error';
            $title = 'Parabéns';
            $text = 'Esse usuário foi excluido !!!';
            break;

            case 'edit':
               $icon  = 'warning';
               $title = 'Parabéns';
               $text = 'Cadastro atualizado com sucesso !!!';
               break;
   

      default:
         $icon  = 'error';
         $title = 'Opss !!!';
         $text = 'Algo deu errado entre em contato com admin !!!';
         break;
   }

   function alerta($icon, $title, $text)
   {
      echo "<script type='text/javascript'>
      Swal.fire({
        type:'type',  
        icon: '$icon',
        title: '$title',
        text: '$text'
       
      }) 
      </script>";
   }

   alerta($icon, $title, $text);

}

$resultados = '';
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

   $resultados .= '<tr>
                      
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

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="7" class="text-center" > Nenhum venda registrada!!!!! </td>
                                                     </tr>';


unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
   $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  </a>';
}

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-purple">
               <div class="card-header">

                  <form method="get">
                     <div class="row ">
                        <div class="col-4">

                           <label>Buscar por Nome</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>">

                        </div>


                        <div class="col d-flex align-items-end">
                           <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>

                        </div>


                     </div>

                  </form>
               </div>

               <div class="table-responsive">

                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>
                        <tr>
                           <td colspan="8">
                              <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                              <button type="submit" style="margin-right:50px; font-weight:600; font-size:x-large" class="btn btn-default float-right" data-toggle="modal" data-target="#modal-data"> <i class="fa fa-print"></i> &nbsp; RELATÓRIOS</button>
                           </td>
                        </tr>
                        <tr>
                           <th> Nª </th>
                           <th> CÓDIGO </th>
                           <th> DATA </th>
                           <th> PRODUTO </th>            
                           <th> QTD </th>
                           <th> PAGAMENTO </th>
                           <th> VALOR </th>
                           
                          
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>
                     <tr>
                           <td colspan="6" style="text-align:right;font-size: 22PX">
                              <span>TOTAL POR MÊS</span>
                           </td>
                           <td colspan="1" style="font-size: 24px;color:#97f303">
                              <span>R$ <?= number_format($total,"2",",",".") ?></span>
                           </td>
                           
                        </tr>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog modal-lg">
      <div class="modal-content bg-light">
         <form action="./clientes-insert.php" method="post">

            <div class="modal-header">
               <h4 class="modal-title">Novo Cliente
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label>Nome</label>
                     <input type="text" class="form-control" name="nome" >
                  </div>

               </div>

            </div>

            <div class="row">
               <div class="col-8">
               <div class="form-group">
                     <label>Email</label>
                     <input type="text" class="form-control" name="email" >
                  </div>

               </div>
               <div class="col-4">

               <div class="form-group">
                     <label>Telefone</label>
                     <input type="text" class="form-control" name="telefone" id="cel" >
                  </div>

               </div>

            </div>
            <div class="row">
               <div class="col-2">
               <div class="form-group">
                     <label>CEP</label>
                     <input type="text" class="form-control" name="cep" id="cep1">
                  </div>
               </div>
               <div class="col-6">
               <div class="form-group">
                     <label>Logradouro</label>
                     <input type="text" class="form-control" name="logradouro" id="logradouro1">
                  </div>
               </div>
               <div class="col-4">
               <div class="form-group">
                     <label>Bairro</label>
                     <input type="text" class="form-control" name="bairro" id="bairro1">
                  </div>
               </div>
            </div>

            <div class="row">

            <div class="col-2">
            <div class="form-group">
                     <label>Nº</label>
                     <input type="text" class="form-control" name="numero" id="numero1">
                  </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                     <label>Complemento</label>
                     <input type="text" class="form-control" name="complemento">
                  </div>
            </div>

            <div class="col-3">
            <div class="form-group">
                     <label>Cidade</label>
                     <input type="text" class="form-control" name="localidade" id="cidade1">
                  </div>
            </div>
            <div class="col-3">

            <div class="form-group">
                     <label>Estado</label>
                     <input type="text" class="form-control" name="uf" id="uf1">
                  </div>

            </div>

            </div>


            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- EDITAR -->

<div class="modal fade" id="editmodal">
   <div class="modal-dialog modal-lg">
      <form action="./clientes-edit.php" method="get">
         <div class="modal-content bg-light">
            <div class="modal-header">
               <h4 class="modal-title">Editar
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id" id="id">
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label>Nome</label>
                     <input type="text" class="form-control" name="nome" id="nome" >
                  </div>

               </div>

            </div>

            <div class="row">
               <div class="col-8">
               <div class="form-group">
                     <label>Email</label>
                     <input type="text" class="form-control" name="email" id="email" >
                  </div>

               </div>
               <div class="col-4">

               <div class="form-group">
                     <label>Telefone</label>
                     <input type="text" class="form-control" name="telefone" id="telefone" >
                  </div>

               </div>

            </div>
            <div class="row">
               <div class="col-2">
               <div class="form-group">
                     <label>CEP</label>
                     <input type="text" class="form-control" name="cep" id="cep">
                  </div>
               </div>
               <div class="col-6">
               <div class="form-group">
                     <label>Logradouro</label>
                     <input type="text" class="form-control" name="logradouro" id="logradouro">
                  </div>
               </div>
               <div class="col-4">
               <div class="form-group">
                     <label>Bairro</label>
                     <input type="text" class="form-control" name="bairro" id="bairro">
                  </div>
               </div>
            </div>

            <div class="row">

            <div class="col-2">
            <div class="form-group">
                     <label>Nº</label>
                     <input type="text" class="form-control" name="numero" id="numero">
                  </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                     <label>Complemento</label>
                     <input type="text" class="form-control" name="complemento" id="complemento">
                  </div>
            </div>

            <div class="col-3">
            <div class="form-group">
                     <label>Cidade</label>
                     <input type="text" class="form-control" name="localidade" id="localidade">
                  </div>
            </div>
            <div class="col-3">

            <div class="form-group">
                     <label>Estado</label>
                     <input type="text" class="form-control" name="uf" id="uf">
                  </div>

            </div>

            </div>


            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-data">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <form action="./gerar-data-pdf.php" method="GET" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Relatórios
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">

               <div class="form-group">

                  <div class="row">

                     <div class="col-lg-6 col-6">
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="dataInicio">
                     </div>


                     <div class="col-lg-6 col-6">
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="dataFim">
                     </div>
                  


                  </div>
              
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Gerar relatório</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>