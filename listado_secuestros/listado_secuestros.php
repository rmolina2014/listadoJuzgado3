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
  public function obtenerDatosDonacion($secuestro_id)
  {
    $data = [];
    $consulta = "SELECT 
  expedientes.`autos` AS autos,
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
