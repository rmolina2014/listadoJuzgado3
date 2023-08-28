<?php
include("../listado_comisarias/listado_comisarias.php");
if( isset($_POST['id']) && !empty($_POST['id']) )
{
 
 $listado_comisaria_id=(int)$_POST['id'];
 $i=0;
 $objeto = new listado_comisarias();
 $datos = $objeto->buscarDetalleNota($listado_comisaria_id);
 foreach($datos as $item)
 {
   $i++;
   $caratula=$item['caratula']; 
   $persona_nombre=$item['persona_nombre']; 
   $domicilio=$item['domicilio']; 
   //$domicilio_legal=$item['persona_legal'];
   $persona_dni=$item['persona_dni'];
   $numero_expediente=$item['numero_expediente'];
   $actuaciones_id=$item['actuaciones_id'];
   $persona_id=$item['persona_id'];
   $expediente_id=$item['expedientes_id'];
   $listado_comisaria_id=$listado_comisaria_id;
   $rol=$item['rol'];
   $estado_actuacion=$item['estado_actuacion'];
   //$url='<a href="borrarPersona.php?id='.$item['id'].'"> X </a>';

   $lista[] = array('id'=> $item['id'],'numero_expediente'=> $numero_expediente,'caratula'=> $caratula, 'persona'=>$persona_nombre, 'domicilio'=> $domicilio,'persona_dni'=> $persona_dni,'orden'=>$i,'rol'=>$rol,'estado_actuacion'=>$estado_actuacion);
   
  }

  $json_string = json_encode($lista);
  echo $json_string;
}
?>
