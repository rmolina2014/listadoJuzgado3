<?php
include_once("../bd/conexion.php");
class listado_secuestros
{

  /*autos es lla relacion con expedientes
  
  */
  public function lista()
  {
    $data = [];

    $consulta_antes = "SELECT 
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


$consulta="SELECT
expedientes.`autos` AS autos,
expedientes.`caratula` AS caratula,
  secuestros.`objeto` AS objeto,
  secuestros.`cantidad` AS cantidad,
  secuestros.`descripcion` AS descripcion,
  secuestros.`ubicacion` AS ubicacion,
  secuestros.`id` AS sucuestro_id
FROM
    `ubicaciones`
    INNER JOIN `usuarios` 
        ON (`ubicaciones`.`usuario` = `usuarios`.`id`)
    INNER JOIN `expedientes` 
        ON (`ubicaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `secuestros` 
        ON (`secuestros`.`expediente` = `expedientes`.`id`)
    INNER JOIN `armarios` 
        ON (`ubicaciones`.`armario` = `armarios`.`id`)
        WHERE armarios.nombre='K09' AND usuarios.`id`<>14";

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

    $consulta = "SELECT
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
    secuestros.`id` AS secuestro_id,
    personas.`apellido` AS apellido,
    personas.`nombre` AS nombre,
    personas.`numero_documento` AS dni,
    personas.`domicilio` AS domicilio
    FROM  `actuaciones`
    INNER JOIN `expedientes` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`)
    INNER JOIN `secuestros` 
        ON (`secuestros`.`expediente` = `expedientes`.`id`)
         where secuestros.`id`=".$secuestro_id." AND  personas.`numero_documento`<> 0;";

    //AND expedientes.`autos`=142703; ";
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

    $consulta = "SELECT
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
    secuestros.`id` AS secuestro_id
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

  // listado de secuestros historicos
  public function registro_secuestro_historico()
  {
    $data = [];
    $consulta = "SELECT
  `id`,
  `autos`,
  `fecha`,
  `acta`,
  `caratula`,
  `reparticion`,
  `objeto`,
  `destino`
FROM `registro_secuestro_historico`";
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if ($rs) {
      if (
        mysqli_num_rows($rs) > 0
      ) {
        while ($fila = mysqli_fetch_assoc($rs)) {
          $data[] = $fila;
        }
      }
    }
    return $data;
  }

  // insertar en la tabla registro_secuestro_historico
  public function insertar_registro_secuestro_historico($autos, $fecha, $acta, $caratula, $reparticion, $destino, $donado_a, $restituido_a)
  {
    $consulta = "INSERT INTO `registro_secuestro_historico`
            (
             `autos`,
             `fecha`,
             `acta`,
             `caratula`,
             `reparticion`,
             `destino`,
             `donado_a`,
             `restituido_a`)
VALUES (
        '$autos',
        '$fecha',
        '$acta',
        '$caratula',
        '$reparticion',
        '$destino',
        '$donado_a',
        '$restituido_a')";


    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    $ultimo_id = mysqli_insert_id(conexion::obtenerInstancia());
    return $ultimo_id;
  }

  // insertar en la tabla registro_secuestro_historico
  public function insertar_registro_secuestro_detalle_objeto($registro_secuestro_id, $secuestro_id)
  {
    $consulta = "INSERT INTO `registro_secuestro_detalle_objeto`
            (
             `registro_secuestro_id`,
             `secuestro_id`)
VALUES (
        '$registro_secuestro_id',
        '$secuestro_id');";
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    $ultimo_id = mysqli_insert_id(conexion::obtenerInstancia());
    return $ultimo_id;
  }

  // listado de registros historicos
  public function listado_registro_secuestro_detalle_objeto()
  {
    $consulta = "SELECT
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
    secuestros.`id` AS secuestro_id,
    personas.`apellido` AS apellido,
    personas.`nombre` AS nombre,
    personas.`numero_documento` AS dni,
    personas.`domicilio` AS domicilio,
    registro_secuestro_historico.`id` AS id_registro_historico,
    registro_secuestro_historico.`destino` AS destino,
    registro_secuestro_historico.`donado_a` AS donado_a,
    registro_secuestro_historico.`restituido_a` AS restituido_a,
    registro_secuestro_historico.`fecha` AS fecha_registro,
    registro_secuestro_historico.`acta` AS acta_infraccion ,
    registro_secuestro_historico.`caratula` AS caratula_registro,
    registro_secuestro_historico.`reparticion` AS reparticion_registro,
    registro_secuestro_historico.`autos` AS autos_registro 
 FROM
    `secuestros`
    INNER JOIN `expedientes` 
        ON (`secuestros`.`expediente` = `expedientes`.`id`)
    INNER JOIN `registro_secuestro_detalle_objeto` 
        ON (`secuestros`.`id` = `registro_secuestro_detalle_objeto`.`secuestro_id`)
    INNER JOIN `registro_secuestro_historico` 
        ON (`registro_secuestro_detalle_objeto`.`registro_secuestro_id` = `registro_secuestro_historico`.`id`)
    INNER JOIN `actuaciones` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`) WHERE personas.`numero_documento`<> 0;";
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if ($rs) {
      if (
        mysqli_num_rows($rs) > 0
      ) {
        while ($fila = mysqli_fetch_assoc($rs)) {
          $data[] = $fila;
        }
      }
    }
    return $data;
  }
}
