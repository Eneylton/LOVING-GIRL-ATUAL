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
                     <div class="row my-7">
                     


                        <div class="col d-flex align-items-end">
                           
                          <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-home"></i>

                              Voltar

                           </button>
                         
                         

                           &nbsp; &nbsp; &nbsp;
                         

                        </div>


                     </div>

                  </form>

               </div>

               <div class="card-body">

                  <div class="col d-flex align-items-end">

                     <a href="finalizar-compra.php" target="_blank">
                        <button type="submit" class="btn btn-dark"> <i class="fas fa-print"></i> &nbsp; &nbsp; IMPRIMIR RELATÓRIO</button>
                     </a>

                  </div>
                  <br>

                  <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  Seu pedido foi realizado com sucesso aguarde o andamento do processo .....
                </div>
                     
               </div>

            </div>

         </div>

      </div>

   </div>
</section>

