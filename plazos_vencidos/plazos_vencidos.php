<?php
include_once("../bd/conexion.php");
class plazos_vencidos
{
  
  public static function lista()
  {
    $data=[];
    $consulta="SELECT
listado_requerimiento.`estado` AS estado,
listado_requerimiento.`fecha` AS fecha,
listado_requerimiento.`requerimiento` AS requerimiento,
listado_requerimiento.`fecha_vencimiento` AS fecha_vencimiento,
listado_requerimiento.`id` AS id,
CONCAT(personas.`apellido`,' ',personas.`nombre`) AS nombre,
expedientes.`autos` AS autos
FROM
    `listado_requerimiento`
    INNER JOIN `personas` 
        ON (`listado_requerimiento`.`persona_id` = `personas`.`id`)
    INNER JOIN `expedientes` 
        ON (`listado_requerimiento`.`expediente_id` = `expedientes`.`id`)
    INNER JOIN `actuaciones` 
        ON (`actuaciones`.`persona` = `personas`.`id`) AND (`actuaciones`.`expediente` = `expedientes`.`id`);";
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if ($rs)
     {
      if(mysqli_num_rows($rs) >0)
      {
        while($fila = mysqli_fetch_assoc($rs))
        {
          $data[] = $fila;
        }
      }
    }
    return $data;
  }

  
  public function buscarpersonasporexpediente($num_expediente)
  {
   $data=[];
   $consulta="SELECT
actuaciones.`id` AS actuaciones_id, personas.`id` AS persona_id, expedientes.`id` AS expediente_id,
actuaciones.`expediente` AS expediente, expedientes.`autos` AS autos, expedientes.`caratula`  AS caratula, personas.`id` AS persona_id, 
personas.`numero_documento` AS persona_dni, personas.`apellido` AS persona_apellido, personas.`nombre` AS persona_nombre , personas.`domicilio` AS persona_domicilio, personas.`domicilio_legal` AS persona_legal,
roles.`nombre` AS rol, estados_actuacion.`nombre` AS estado_actuacion, personas.`numero_documento` AS persona_dni
FROM
    `actuaciones`
    INNER JOIN `expedientes` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas`  
        ON (`actuaciones`.`persona` = `personas`.`id`)
        INNER JOIN `roles` 
        ON (`actuaciones`.`rol` = `roles`.`id`)
    INNER JOIN `estados_actuacion` 
        ON (`actuaciones`.`estado` = `estados_actuacion`.`id`)
         WHERE expedientes.`autos`='$num_expediente';";

    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if(mysqli_num_rows($rs) >0)
    {
      while($fila = mysqli_fetch_assoc($rs))
      {
        $data[] = $fila;
      }
    }
    return $data;
  }  

  public function nuevo($expediente_id,$actuaciones_id,$persona_id,$fecha,$fecha_vencimiento,$requerimiento,$estado)
  {
   $sql="INSERT INTO `listado_requerimiento`
            (`expediente_id`,
             `actuaciones_id`,
             `persona_id`,
             `fecha`,
             `fecha_vencimiento`,
             `requerimiento`,
             `estado`)
              VALUES (
              '$expediente_id',
              '$actuaciones_id',
              '$persona_id',
              '$fecha',
              '$fecha_vencimiento',
              '$requerimiento',
              '$estado');";
   $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
   /*$ultimo_id = mysqli_insert_id(conexion::obtenerInstancia());
    return $ultimo_id;*/
    return $rs;
  }
  
 public function obtenerId($id)
 {
  $data=[];
  $sql="SELECT * FROM listado_requerimiento where id='$id'";
   $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
   if(mysqli_num_rows($rs) >0)
   {
     while($fila = mysqli_fetch_assoc($rs))
     {
       $data[] = $fila;
     }
   }
   return $data;
   }

 public function eliminar($id)
 {
  $sql="DELETE FROM listado_requerimiento WHERE id ='$id'";
  $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
  return $rs;
 }

 public function editar($id,$fecha_vencimiento,$requerimiento,$estado)
 {
  $sql="UPDATE `listado_requerimiento`
  SET 
    `fecha_vencimiento` = '$fecha_vencimiento',
    `requerimiento` = '$requerimiento',
    `estado` = '$estado'
  WHERE `id` = '$id';";
  $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
  return $rs;
 }

 
}
?>