<?php
require '../cabecera.php';
require '../menu.php';
include("cedulas_sin_retorno.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Cedulas Sin Retorno</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
   
    <p> <a class="btn btn-primary" href="datos_imprimir.php">Datos para Imprimir</a> </p>

    <table id="listado" class="table table-striped table-bordered table-hover table-condensed" >
          <thead>
             <tr>
              <th></th>
             <th>N° Exp.</th>
             <th>Persona</th>
             <th>DNI</th>
             <th>Caratula</th>
             <th>Estado Actuacion</th>
             <th>Repartición</th>
             <th>Fecha Salida</th>
             </tr>
           <thead>
           <tbody>
          <?php
          $i=0;
          $listados = cedulas_sin_retorno::lista();
          foreach($listados as $item)
          {
           $i++;
          ?>
           <tr>
            <td><?php echo $i; ?></td>
              <td><?php echo $item['exp_autos']; ?></td>
              <td><?php echo $item['nombre']; ?></td>
              <td><?php echo $item['dni']; ?></td>
              <td><?php echo $item['exp_caratula']; ?></td>
              <td><?php echo $item['estados_actuaciones']; ?></td>
              <td><?php echo $item['reparticion']; ?></td>
              <td><?php echo $item['cedula_fecha_salida']; ?></td>
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
 
