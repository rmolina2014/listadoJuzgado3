<?php
include("plazos_vencidos.php");
if( isset($_POST['persona_id']) && !empty($_POST['persona_id']) )
{
   $actuaciones_id=$_POST['actuaciones_id'];
   $persona_id=$_POST['persona_id'];
   $expediente_id=$_POST['expediente_id'];
   $requerimiento=$_POST['requerimiento'];
   $fecha=date("Y-m-d");
   $fecha_vencimiento=$_POST['fecha_vencimiento'];
   $estado='Ingresado';
   $objeto = new plazos_vencidos();
   $todobien = $objeto->nuevo($expediente_id,$actuaciones_id,$persona_id,$fecha,$fecha_vencimiento,$requerimiento,$estado);
 
   if($todobien)
   {
    echo "<script language=Javascript> location.href=\"index.php\"; </script>";
      //header('Location: listado.php');
      exit;
   } 
    
}
?>
