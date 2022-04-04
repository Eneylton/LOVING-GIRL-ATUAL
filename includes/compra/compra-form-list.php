<?php

$resultados = '';

foreach ($listar as $item) {
   if (empty($item->foto)) {
      $foto = './imgs/sem-foto.jpg';
   } else {
      $foto = $item->foto;
   }

   $resultados .= '<tr>

                     <td>

                     <div class="icheck-red ">
                     <input type="checkbox" value="' . $item->id . '" name="id[]" id="[' . $item->id . ']">
                     <label for="[' . $item->id . ']"></label>
                     </div>
                     </td>
                     
                      <td>
                      <a href="galeria-list.php?id=' . $item->id . '">
                      <img style="width:40px; heigth:40px;object-fit: contain;" src="../.' . $foto . '" class="img-thumbnail">
                      </a>
                      </td>
                      <td style="text-transform: uppercase;">' . $item->nome . '</td>
                      <td style="text-transform: uppercase;">' . $item->categoria . '</td>
                      <td>' . $item->aplicacao . '</td>
                      <td>
                      
                      <span style="font-size:21px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-secondary') . '">' . $item->estoque . '</span>
                      
                      </td>
                      <td style="text-align: center;"> <button type="button" class="btn btn-success"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</button></td>
                      <td style="text-align: center;">
                      
                      <a href="carrinho.php?acao=add&id=' . $item->id . '">
                         <button type="button" class="btn btn-info"> <i class="fas fa-plus"></i> &nbsp Adicionar</button>
                       </a>



                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="9" class="text-center" > Nenhum Produto Encontrado !!!!! </td>
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
                     <div class="row my-7">
                        <div class="col">

                           <label>Pesquisar</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>" autofocus>

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


               <form id="form1" action="carrinho.php" method="post">
                  <table id="example1" class="table table-dark table-hover table-striped">
                     <thead>
                        <tr>
                           <td colspan="8">

                              <input type="submit" name="submit" value="Adicionar todos " onclick="return confirm('Produtos Adicionados com Sucesso !!!')" class="btn btn-primary">

                           </td>
                        </tr>
                        <tr>
                           <th style="width: 20px;">
                              <div class="icheck-warning d-inline">
                                 <input type="checkbox" id="select-all">
                                 <label for="select-all">
                                 </label>
                              </div>
                           </th>
                           <th> IMAGEM </th>
                           <th> NOME </th>
                           <th> CATEGORIA </th>
                           <th> APLICAÇÃO </th>
                           <th> QTD </th>
                           <th style="text-align: center;"> VALOR </th>
                           <th style="text-align: center;"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>

                  </table>

               </form>
            </div>

         </div>

      </div>

   </div>
</section>

<?= $paginacao ?>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form>
               <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Recipient:</label>
                  <input type="text" class="form-control" id="recipient-name">
               </div>
               <div class="form-group">
                  <label for="message-text" class="col-form-label">Message:</label>
                  <textarea class="form-control" id="message-text"></textarea>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Send message</button>
         </div>
      </div>
   </div>
</div>