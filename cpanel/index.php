<?php
require '../cabecera.php';
require '../menu.php';
include("cpanel.php");
?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Panel de Control</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="conteiner">
    <div class="card">
      <div class="card-header">
          <h3 class="card-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                Plazos Vencidos</font></font></h3>
      </div>

      <?php 
       // 1 - buscar los expedientes con requerimientos vencidos

       // 2- buscar las personas dentro de los expedientes y listarlos para enviar una cedula de intimacion
  
      ?>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <table id="listado" class="table table-striped table-bordered table-hover table-condensed" >
          <thead>
             <tr>
             <th>N° Exp.</th>
             <th>Persona</th>
             <th>Requerimiento</th>
             <th>Fecha Vencimiento</th>
             <th>Estado</th>
             <th>Funciones</th>
             </tr>
           <thead>
           <tbody>
          <?php
          $datos=new cpanel();
          $listados = $datos->lista_requeriminetos_vencidos();
          foreach($listados as $item)
          {
          ?>
           <tr>
              <td><?php echo $item['autos']; ?></td>
              <td><?php echo $item['nombre']; ?></td>
              <td><?php echo $item['requerimiento']; ?></td>
              <td><?php echo $item['fecha_vencimiento']; ?></td>
              <td><?php echo $item['estado']; ?></td>
              <td>
                  <?php
                   if ($item['estado']=='Vencido')
                   {
                     ?>
                      <a class="btn btn-primary btn-sm" href="imprimir_intimacion.php?req_id=<?php echo $item ['id'];?>&per_id=<?php echo $item ['persona_id'];?>"  > Generar Intimación </a>
                     <?php
                   }
                   else 
                    {
                    ?>
                    <a class="btn btn-primary btn-sm" href="ver_intimacion.php?req_id=<?php echo $item ['id'];?>&per_id=<?php echo $item ['persona_id'];?>" target="_blank" > Ver Intimación </a>
                    
                    <?php
                    }
                    ?>
              </td>
          </tr>
          <?php
           }
          ?>
          </tbody>
         </table>
         </div>
        <!-- /.card-body -->
      </div>
    </div>
   
 </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
         

   <?php
require '../footer.html';
?>

  