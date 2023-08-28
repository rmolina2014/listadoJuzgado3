<?php
include("listado_comisarias.php");
if( isset($_POST['id']) && !empty($_POST['id']) )
{
 $id=(int)$_POST['id'];
 $objeto = new listado_comisarias();
 $datos = $objeto->borrarPersonaDetalle($id);
 echo 'Se borro id: '.$id; 
}
?>
