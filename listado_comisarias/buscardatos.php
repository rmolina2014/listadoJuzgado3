<?php
include("listado_comisarias.php");
if( isset($_POST['id']) && !empty($_POST['id']) )
{
 $id=(int)$_POST['id'];
 $objeto = new listado_comisarias();
 $total=0;
 $datos = $objeto->buscarpersonasporexpediente($id);
 foreach($datos as $item)
 {
   $caratula=$item['caratula']; 
   $persona=$item['persona_apellido'].' '.$item['persona_nombre']; 
   $domicilio=$item['persona_domicilio']; 
   $domicilio_legal=$item['persona_legal'];
   $persona_dni=$item['persona_dni'];
   $numero_expediente=$item['autos'];
   // armar un   $caratula=$item['caratula'['apellido']];  json
    $url='<a href="liquidacion.php?id='.$persona_dni.'"> X </a>';
    $lista[] = array('id'=> $id,'numero_expediente'=> $numero_expediente,'caratula'=> $caratula, 'persona'=>$persona, 'domicilio'=> $domicilio,'domicilio_legal'=> $domicilio_legal,'persona_dni'=> $persona_dni , 'url'=>$url);
  }
  $json_string = json_encode($lista);
  echo $json_string;
}
?>
