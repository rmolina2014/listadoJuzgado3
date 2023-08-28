<?php
require '../cabecera.php';
require '../menu.php';
include("usuario.php");

$objecto = new Usuario();
if( isset($_POST['nombre']) && !empty($_POST['nombre']) )
 {
//   $nInscripcion,$nombre,$dni,$curso,$horario,$sucursal,$email,$observacion,$otros,$idCurso
  $usuario = $_POST['nombre'];
  $nombrereal= $_POST['nombrereal'];
  $nivel = $_POST['nivel'];
  $password= md5($_POST['password']);
  $fechaingreso = date("Y-m-d");
  $estado = 'Activo';
  $empresa_id = $_POST['empresa_id'];

  $todobien = $objecto->nuevo($usuario,$password,$nombrereal,$nivel,$empresa_id);
  if($todobien){
      echo "<script language=Javascript> location.href=\"index.php\"; </script>"; 
      //header('Location: listado.php');
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
 <div class="container">
 <h3>Usuarios</h3>
 <script src="../js/jquery.js"></script>
 <hr>
 <div class="row">


 <div class="col-md-8">
     
 <h4>Agregar Usuario</h4>
 <hr>
 
  <form method="POST" role="form" action="nuevo.php">

  <div class="col-md-8">
    <label >Nombre Real *</label>
    <input name="nombrereal"  class="form-control" type="text" tabindex="3" maxlength="35"  required />
  </div>

   
  <div class="col-md-8">
    <label>Nombre de Usuario *</label>
    <input name="nombre"  class="form-control" type="text" tabindex="2" maxlength="15" required />
  </div>

  

  <div class="col-md-8">
    <label >Contraseña *</label>
   <input type="password" class="form-control" placeholder="Contraseña (8 caracteres max.)" id="password" name="password" maxlength="8" tabindex="4" required>
</div>


  <div class="col-md-8">
    <label >Nivel *</label>
    <select class="form-control" name="nivel" tabindex="5" required>
      <option >Seleccionar.....</option>
      <option value="1">Administrador</option>
      <option value="2">Operador</option>
     </select>
  </div>

    
  <div class="col-md-8">
  <hr>
      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>
      <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Guardar</button>
  </div>
</form> 
 <script src="../js/util.js"></script>
 <script src="../js/jquery-1.10.2.js"></script>
 <script type="text/javascript">
 $(document).ready(function()
  {
   
     listadoEmpresa();
       //22-08-2017 listado para el select recibe un json
     function listadoEmpresa(){
       $.getJSON('listaEmpresa.php',function(data){
         $.each(data, function(i,cliente){
         $("#empresa_id").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');
           });
       });
      };

      

 });//fin jquery

</script>    
 <?
 }
 ?>             
   