<?php
include("listado_comisarias.php");
if( isset($_POST['num_expediente']) && !empty($_POST['num_expediente']) )
{
 $num_expediente=(int)$_POST['num_expediente'];
 $listado_comisaria_id=(int)$_POST['listado_comisaria_id'];

 $objeto = new listado_comisarias();
 $total=0;
 $datos = $objeto->buscarpersonasporexpediente($num_expediente);
 foreach($datos as $item)
 {
   $caratula=$item['caratula']; 
   $persona_nombre=$item['persona_apellido'].' '.$item['persona_nombre']; 
   $domicilio=$item['persona_domicilio']; 
   //$domicilio_legal=$item['persona_legal'];
   $persona_dni=$item['persona_dni'];
   $numero_expediente=$item['autos'];
   $actuaciones_id=$item['actuaciones_id'];
   $persona_id=$item['persona_id'];
   $expediente_id=$item['expediente_id'];
   $rol=$item['rol'];
   $estado_actuacion=$item['estado_actuacion'];
   $listado_comisaria_id=$listado_comisaria_id;

   $todobien = $objeto->nuevoDetalle($persona_id,$actuaciones_id,$expediente_id,$listado_comisaria_id,$caratula,$persona_nombre,$domicilio,$persona_dni,$numero_expediente,$rol,$estado_actuacion);
 
   if($todobien)
   {
    echo "Ok insertar personas.";
   } 
    
  }
}
?>
