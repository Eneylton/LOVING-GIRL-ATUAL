<?php

$resultados = '';

foreach ($produtos2 as $item) {
   if(empty($item->foto)){
    
      $foto = 'imgs/sem.jpg';

   }else{

      $foto= $item->foto;
   }

   $resultados .= '<tr>
                      <td>
                      <a href="galeria-list.php?id=' . $item->id . '">
                      <img style="width:80px; heigth:70px;object-fit: contain;" src="' . $foto . '" class="img-thumbnail">
                      </a>
                      </td>
                      <td>' . $item->codigo . '</td>
                      <td>' . $item->barra . '</td>
                      <td>' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                      <td style="text-transform: uppercase;">' . $item->nome . '</td>
                      <td style="text-transform: uppercase;">' . $item->categoria . '</td>
                      <td>
                      
                      <span style="font-size:16px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-secondary') . '">' . $item->estoque . '</span>
                      
                      </td>
                      <td> <button type="button" class="btn btn-success"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</button></td>
                      <td style="text-align: center;">
                      
                      <a href="carrinho.php?acao=add&id='.$item->id.'">
                         <button type="button" class="btn btn-info"> <i class="fas fa-plus"></i> &nbsp Adicionar</button>
                       </a>



                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="9" class="text-center" > Nenhuma Vaga Encontrada !!!!! </td>
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
<div class="content-wrapper" style="margin-top: 60px;">

<div class="content-header">
     <div class="container-fluid">
          <div class="row mb-2">
               <div class="col-sm-6">
                    <h1 class="m-0"><?= TITLE ?></h1>
               </div>
               <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active"><?= BRAND ?></li>
                    </ol>
               </div>
          </div>
     </div>
</div>

<section class="content">
     <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-danger">
               <div class="card-header">

                  <form method="get">
                     <div>
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

               <div>

                  <table id="example1" class="table table-dark table-hover table-striped">
                     <thead>
                        <tr>
                           <th> IMAGEM </th>
                           <th> CÓDIGO </th>
                           <th> BARRA </th>
                           <th> DATA CADASTRO </th>
                           <th> NOME </th>
                           <th> CATEGORIA </th>
                           <th> QTD </th>
                           <th> VALOR </th>
                           <th style="text-align: center;"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>

                  </table>
               </div>

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
