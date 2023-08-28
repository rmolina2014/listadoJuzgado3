<?php
require '../cabecera.php';
require '../menu.php';
include("plazos_vencidos.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Plazos Vencidos - Cedulas</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
   
    <p> <a class="btn btn-primary" href="nuevo.php">Adicionar Nuevo </a> </p>

    <table id="listado" class="table table-striped table-bordered table-hover table-condensed" >
          <thead>
             <tr>
             <th>N° Exp.</th>
             <th>Persona</th>
             <th>Requerimiento</th>
             <th>Fecha</th>
             <th>Fecha Vencimiento</th>
             <th>Estado</th>
             <th>Funciones</th>
             </tr>
           <thead>
           <tbody>
          <?php
          $listados = plazos_vencidos::lista();
          foreach($listados as $item)
          {
          ?>
           <tr>
              <td><?php echo $item['autos']; ?></td>
              <td><?php echo $item['nombre']; ?></td>
              <td><?php echo $item['requerimiento']; ?></td>
              <td><?php echo $item['fecha']; ?></td>
              <td><?php echo $item['fecha_vencimiento']; ?></td>
              <td><?php echo $item['estado']; ?></td>
              <td>
                  <a class="btn btn-primary btn-sm" href="editar.php?id=<?php echo $item ['id'];?>" >Editar</a>
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
 
