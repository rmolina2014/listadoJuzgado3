<?php
include("../sesion.php");
include("usuario.php");
include '../menu.php';


if( isset($_GET['id']) && !empty($_GET['id']) )
 {
  $id=(int)$_GET['id'];
  $registros=usuario::obtenerId($id);
   foreach($registros as $veh)
  {
    $id = $veh['id'];
  ?>

 <div class="container">
 <h3>Usuarios</h3>
 <script src="../js/jquery.js"></script>
 <hr>
 <div class="row">
  
 <div class="col-md-8">
 <h4>Editar Usuario</h4> 
 <hr>
 <form class="form-horizontal" role="form" method="POST" action="editar.php">
  <input type="hidden" name="idCliente" value="<?echo $id; ?>" />
  
     <div class="col-md-8">
      <label>Empresa</label>
      <select class="form-control" name="empresa_id" id="empresa_id" tabindex="1" required >
        <?
        $listaEmpresa = usuario::listaEmpresa();
        foreach($listaEmpresa as $item)
        {
           if ($item[id]==$veh[empresa_id]) {
                 echo "<option value='".$item[id]."' selected > ". $item[nombre]." </option>";
              }
               else {
                echo "<option value='".$item[id]."'> ". $item[nombre]."</option>";
               }   
           
        }
        ?>
      </select>

         <div id="Info"></div>
    </div>


    <div class="col-md-8">
    <label>Usuario *</label>
    <input name="usuario"  class="form-control" type="text" tabindex="1"  value="<?echo utf8_encode($veh['usuario']); ?>" maxlength="20" required autofocus/>
  </div>


  <div class="col-md-8">
    <label >Nombre Real *</label>
    <input name="nombrereal"  class="form-control" type="text" tabindex="1"  value="<?echo utf8_encode($veh['nombrereal']); ?>" maxlength="35" required />
  </div>

  


  <div class="col-md-8">
    <label >Nivel *</label>
    <select class="form-control" name="nivel">
      <option value="1">Administrador</option> 
      <option value="2">Empleado</option>
  </select>
  </div>


  <div class="col-md-8">
    <label >Contraseña *</label>
   <!--input type="password" class="form-control" placeholder="Contraseña (8 caracteres max.)" id="password" name="password" value="<?echo utf8_encode($veh['password']); ?>"  maxlength="8" required-->

   <button class="form-control btn-primary">Cambiar Pasword</button>
</div>

   <div class="col-md-8">
  <hr>
      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>
      <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i>Guardar</button>
  </div>
</form>   
</div>
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
 }//fin del while
}// fin del if
if( isset($_POST['idCliente']) && !empty($_POST['idCliente']) )
 {
  $id= $_POST['idCliente'];
  $usuario= $_POST['usuario'];
  $nivel= $_POST['nivel'];
  $nombrereal= $_POST['nombrereal'];
  $password= md5($_POST['password']);

  $registros=usuario::editar($id,$usuario,$nivel,$nombrereal,$password);

  if($registros){
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
?>