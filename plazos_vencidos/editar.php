<?php
require '../cabecera.php';
require '../menu.php';
include("plazos_vencidos.php");

if( isset($_GET['id']) && !empty($_GET['id']) )
 {
  $id=(int)$_GET['id'];
  $objeto = new plazos_vencidos();
  $registros=$objeto->obtenerId($id);
   foreach($registros as $veh)
  {
    $id = $veh['id'];
  ?>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>Plazos Vencidos - Cedulas</h1>
          </div>
          <!--div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div-->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
 <div class="row">
  
 <div class="col-md-8">
 <h4>Editar </h4> 
 <hr>
 <form class="form-horizontal" role="form" method="POST" action="editar.php">
  <input type="hidden" name="id" value="<?php echo $id; ?>" />
  
  <div class="col-md-8">
    <label>Expediente </label>
    <input name="actuaciones_id"  class="form-control" type="text" tabindex="1"  value="<?php echo $veh['actuaciones_id']; ?>" maxlength="20" disabled/>
  </div>

  <div class="col-md-8">
    <div class="form-group">
      <label>Requerimientos</label>
        <textarea type="text" id="requerimiento" name="requerimiento" class="form-control"> <?php echo utf8_encode($veh['requerimiento']); ?>  </textarea>  
    </div>
  </div>
       
  <div class="col-md-8">
    <div class="form-group">
      <label>Fecha Vencimiento</label>
      <input type="date" name="fecha_vencimiento" class="form-control" value="<?php echo utf8_encode($veh['fecha_vencimiento']); ?>">  
    </div>
  </div>
       
  <div class="col-md-8">
    <label>Estado</label>
     <select class="form-control" name="estado" required >
      <?php
         if ($veh['estado']=='Ingresado')
         { 
          ?>
            <option value="Ingresado" selected="true">Ingresado</option>
            <option value="Completo">Completo</option>
            <option value="Vencido">Vencido</option>
         <?php  
         }
         if ($veh['estado']=='Completo')
         {  
          ?>
            <option value="Ingresado" >Ingresado</option>
            <option value="Completo" selected="true">Completo</option>
            <option value="Vencido">Vencido</option>
          <?php  
         }

         if ($veh['estado']=='Vencido')
         {  
          ?>
            <option value="Ingresado" >Ingresado</option>
            <option value="Completo" >Completo</option>
            <option value="Vencido" selected="true">Vencido</option>
          <?php  
         
         }
        ?> 
      </select>
  </div>

  <div class="col-md-8">
  <hr>
      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>
      <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Guardar</button>
  </div>
</form>   
</div>

 <?php
 }//fin del while
}// fin del if
if( isset($_POST['id']) && !empty($_POST['id']) )
 {
  $id= $_POST['id'];
  $requerimiento=$_POST['requerimiento'];
  $fecha_vencimiento=$_POST['fecha_vencimiento'];
  $estado=$_POST['estado'];
  $objeto = new plazos_vencidos();

  $registros=$objeto->editar($id,$fecha_vencimiento,$requerimiento,$estado);

  if($registros)
   {
    echo "<script language=Javascript> location.href=\"index.php\"; </script>";
    //header('Location: listado.php');
    exit;
   }
  }
?>