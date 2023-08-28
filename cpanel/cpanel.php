<?php
include_once("../bd/conexion.php");
class cpanel
{
  
  // buscra personas por numero de expediente
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
  
  // DATOS DE LOS REQUERIMIENTOS VENCIDOS 
  public static function lista_requeriminetos_vencidos()
  {
    $data=[];
    $consulta="SELECT
    listado_requerimiento.`estado` AS estado,
    listado_requerimiento.`fecha` AS fecha,
    listado_requerimiento.`requerimiento` AS requerimiento,
    listado_requerimiento.`fecha_vencimiento` AS fecha_vencimiento,
    listado_requerimiento.`id` AS id,
    CONCAT(personas.`apellido`,' ',personas.`nombre`) AS nombre,
    expedientes.`autos` AS autos,
    personas.`id` as persona_id
    FROM
    `listado_requerimiento`
    INNER JOIN `personas` 
        ON (`listado_requerimiento`.`persona_id` = `personas`.`id`)
    INNER JOIN `expedientes` 
        ON (`listado_requerimiento`.`expediente_id` = `expedientes`.`id`)
    INNER JOIN `actuaciones` 
        ON (`actuaciones`.`persona` = `personas`.`id`) AND (`actuaciones`.`expediente` = `expedientes`.`id`)
        WHERE listado_requerimiento.`estado`='Vencido' OR listado_requerimiento.`fecha_vencimiento` < CURDATE() ";
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

  // DATOS DE UNA PERSONA
  public static function obtenerDatosPersona($id)
  {
    $data=[];
    $consulta="SELECT
              `id`,
              `numero_documento`,
              CONCAT (`apellido`,' ',`nombre`) AS nombre,
              `domicilio`,
              `domicilio_legal`
             FROM `personas`
             where id=".$id;
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

  // DATOS para imprimir la intimacion
  public static function obtenerDatosIntimacion($id)
  {
    $data=[];
    $consulta="SELECT
    CONCAT(personas.`apellido`,' ',personas.`nombre`) AS nombre,
    personas.`domicilio` AS domicilio,
    expedientes.`autos` AS autos,
    expedientes.`caratula` AS caratula,
    listado_requerimiento.`intimacion` AS intimacion,
    listado_requerimiento.`fecha_intimacion` AS fecha_intimacion
    FROM
        `listado_requerimiento`
        INNER JOIN `expedientes` 
            ON (`listado_requerimiento`.`expediente_id` = `expedientes`.`id`)
        INNER JOIN `actuaciones` 
            ON (`actuaciones`.`expediente` = `expedientes`.`id`)
        INNER JOIN `personas` 
            ON (`actuaciones`.`persona` = `personas`.`id`)
            WHERE `listado_requerimiento`.`id`=".$id;
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

  // actualiar los requerimientos que fueron intimados por cedula
  public function actualizarRequerimiento($id_req,$contenido,$fecha)
  {
  $sql="UPDATE `listado_requerimiento`
        SET
          `estado` = 'Intimado-Cedula',
          `intimacion` = '$contenido',
          `fecha_intimacion` = '$fecha'
        WHERE `id` = '$id_req';";
  $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
  return $rs;
  }

  
 
}
?>