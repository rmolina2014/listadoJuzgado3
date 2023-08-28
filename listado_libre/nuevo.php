<?php
require '../cabecera.php';
require '../menu.php';
include("../listado_comisarias/listado_comisarias.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>Listado de Notas Libres</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!--li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li-->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<?php
if( isset($_POST['destino']) && !empty($_POST['destino']) )
{
  $objeto = new listado_comisarias();
  //insertar bd
  $destino = $_POST['destino'];
  $contenido=$_POST['contenido'];
  $fecha =date("Y-m-d");
  $fecha_creacion=date("Y-m-d");
  $estado="Edicion";
  $usuario="$NOMBRE_USUARIO";
  $contenido=$_POST['contenido'];
  $tipo="Libre";

  $todobien = $objeto->nuevo($fecha,$destino,$estado,$fecha_creacion,$usuario,$contenido,$tipo);
  
  echo '<script language=Javascript> location.href="agregar_personas.php?id='.$todobien.'"; </script>'; 
  exit;

  if($todobien > 0)
  {
    echo '<script language=Javascript> location.href=\"agregar_personas.php?'.$todobien.'\"; </script>'; 
      //header('Location: agregarpersona.php');
      exit;
    } 
    else {
    ?>      
         <div class="alert alert-block alert-error fade in" style="max-width: 220px; margin: 0px auto 20px;">
         <button data-dismiss="alert" class="close" type="button">×</button>
         Lo sentimos, no se pudo guardar ...
         </div> 
    <?
    }     
}
else
{
?>
  <!-- Main content -->
  <section class="content">
    <div class="card card-secundary">
      <div class="card-header">
        <h3 class="card-title">Formulario de Ingreso </h3>
      </div>
      <div class="card-body">
        <form id="form" enctype="multipart/form-data" method="post" action="nuevo.php">
          <div class="row">
             <div class="col-sm-6">
              <div class="form-group">
                <label>Destinatario </label>
                <input type="text" name="destino" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="row">
             <div class="col-sm-6">
              <div class="form-group">
                <label>Contenido de la Nota</label>
                <textarea name="contenido" class="form-control" required></textarea>
              </div>
             </div>   
          </div> 
        <br>
        <br>
        <br>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Agregar Personas</button>
            </div>
          </div>
          </div>
        </form>
     </div>
  </div>
 <?php
 }
 require '../footer.html';
?>
