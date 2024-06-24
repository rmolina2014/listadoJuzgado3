<?php
include_once("../bd/conexion.php");
class listado_secuestros
{

  /*autos es lla relacion con expedientes
  
  */
  public function lista()
  {
    $data = [];

    $consulta = "SELECT 
  expedientes.`autos` AS autos,
expedientes.`caratula` AS caratula,
  secuestros.`objeto` AS objeto,
  secuestros.`cantidad` AS cantidad,
  secuestros.`descripcion` AS descripcion,
  secuestros.`ubicacion` as ubicacion,
  secuestros.`id` AS sucuestro_id
FROM
  `armarios`,
  `secuestros` 
  INNER JOIN `expedientes` 
    ON (
      `secuestros`.`expediente` = `expedientes`.`id`
    ) 
WHERE armarios.nombre='K09' "; //AND expedientes.`autos`=142703; ";


    /* $consulta = "SELECT
expedientes.`autos` AS autos,
expedientes.`caratula` AS caratula,
expedientes.`fecha_origen`,
expedientes.`fecha_origen` AS fecha_origen,
expedientes.`numero_origen` AS numero_origen,
secuestros.`descripcion` AS descripcion,
secuestros.`ubicacion` AS ubicacion,
secuestros.`objeto` AS objeto,
secuestros.`cantidad` AS cantidad,
secuestros.`accion` AS accion,
secuestros.`escrito` AS escrito,
secuestros.`id` AS sucuestro_id,
infracciones.`articulo` AS articulo
FROM
   `secuestros`
    INNER JOIN `expedientes` 
        ON (`secuestros`.`expediente` = `expedientes`.`id`)
    INNER JOIN `infracciones` 
        ON (`infracciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `actuaciones` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`)
    INNER JOIN `escritos` 
        ON (`escritos`.`actor` = `actuaciones`.`id`)";
       // WHERE expedientes.`autos`=120242;";
*/
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);

    if ($rs) {
      if (mysqli_num_rows($rs) > 0) {
        while ($fila = mysqli_fetch_assoc($rs)) {
          $data[] = $fila;
        }
      }
    }
    return $data;
  }

  /*autos es lla relacion con expedientes
  
  */
  public function obtenerDatosSecuestros($secuestro_id)
  {
    $data = [];

    $consulta ="SELECT
expedientes.`autos` AS autos,
expedientes.`caratula` AS caratula,
expedientes.`fecha_origen` AS fecha_origen,
expedientes.`numero_origen` AS infraccion_numero,
secuestros.`descripcion` AS descripcion,
secuestros.`ubicacion` AS ubicacion,
secuestros.`objeto` AS objeto,
secuestros.`cantidad` AS cantidad,
secuestros.`accion` AS accion,
secuestros.`escrito` AS escrito,
secuestros.`id` AS sucuestro_id
FROM
`secuestros`
    INNER JOIN `expedientes` 
        ON (`secuestros`.`expediente` = `expedientes`.`id`)
         where secuestros.`id`=$secuestro_id"; //AND expedientes.`autos`=142703; ";
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if ($rs) {
      if (mysqli_num_rows($rs) > 0) {
        while ($fila = mysqli_fetch_assoc($rs)) {
          $data[] = $fila;
        }
      }
    }
    return $data;
  }


  public function obtenerDatosSecuestros2($secuestro_id)
  {
    $data = [];

    $consulta ="SELECT
expedientes.`autos` AS autos,
expedientes.`caratula` AS caratula,
expedientes.`fecha_origen` AS fecha_origen,
expedientes.`numero_origen` AS infraccion_numero,
secuestros.`descripcion` AS descripcion,
secuestros.`ubicacion` AS ubicacion,
secuestros.`objeto` AS objeto,
secuestros.`cantidad` AS cantidad,
secuestros.`accion` AS accion,
secuestros.`escrito` AS escrito,
secuestros.`id` AS sucuestro_id
FROM
`secuestros`
    INNER JOIN `expedientes` 
        ON (`secuestros`.`expediente` = `expedientes`.`id`)
         where secuestros.`id`=$secuestro_id"; //AND expedientes.`autos`=142703; ";
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if ($rs) {
      if (mysqli_num_rows($rs) > 0) {
        while ($fila = mysqli_fetch_assoc($rs)) {
          $data[] = $fila;
        }
      }
    }
    return $data;
  }
}
