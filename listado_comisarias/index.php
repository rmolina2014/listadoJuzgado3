<?php
require '../cabecera.php';
require '../menu.php';
include("listado_comisarias.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de Notas para Comisarias</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
   
    <p> <a class="btn btn-primary" href="nuevo.php">Adicionar Nueva Nota </a> </p>

    <table id="listado" class="table table-striped table-bordered table-hover table-condensed" >
          <thead>
             <tr>
             <th>Nota Nº</th>
             <th>Fecha</th>
             <th>Comisaria</th>
             <th>Funciones</th>
             </tr>
           <thead>
           <tbody>
          <?php
          $listados = listado_comisarias::lista();
          foreach($listados as $item)
          {
          ?>

           <tr>
              <td><?php echo $item ['id']; ?></td>
              <td><?php echo $item ['fecha']; ?></td>
              <td><?php echo $item ['destino']; ?></td>
              <td>
                  <a class="btn btn-primary btn-sm" href="imprimir.php?id=<?php echo $item ['id'];?>" target="_blank">Imprimir</a>
                  <!--a class="btn btn-danger btn-sm" id="borrar<?php echo $item['id'];?>" > Borrar</a-->
              </td>
          </tr>
          <?php
           }
          ?>
          </tbody>
         </table>
         </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
require '../footer.html';
?>
 
