<?php
include_once("../bd/conexion.php");
class cedulas_sin_retorno
{
  
  public static function lista()
  {
    
    // el estado del expediente debe ser menor que 4 
    $data=[];
    $Antes_consulta="SELECT
expedientes.`autos` AS exp_autos,
cedulas.`fecha_salida` AS cedula_fecha_salida,
CONCAT(personas.`apellido`,' ',personas.`nombre`) AS nombre,
personas.`numero_documento` AS dni,
expedientes.`caratula` AS exp_caratula,
estados_actuacion.`nombre` AS estados_actuaciones,
reparticiones.`nombre` AS reparticion 
FROM
    `escritos`
    INNER JOIN `actuaciones` 
        ON (`escritos`.`actor` = `actuaciones`.`id`)
    INNER JOIN `expedientes` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`)
    INNER JOIN `cedulas` 
        ON (`cedulas`.`escrito` = `escritos`.`id`)
    INNER JOIN `departamentos` 
        ON (`expedientes`.`departamento` = `departamentos`.`id`)
    INNER JOIN `estados_actuacion` 
        ON (`actuaciones`.`estado` = `estados_actuacion`.`id`)
    INNER JOIN `reparticiones` 
        ON (`expedientes`.`reparticion` = `reparticiones`.`id`)    
         WHERE cedulas.`fecha_salida`IS NOT NULL 
         AND cedulas.`fecha_regreso`IS NULL 
         AND escritos.`activo`=1 
         AND actuaciones.`estado`=1
         AND YEAR(cedulas.`fecha_salida`) >= YEAR(CURDATE()) - 2 
         ORDER BY cedula_fecha_salida DESC";

    $consulta="SELECT
expedientes.`autos` AS exp_autos,
cedulas.`fecha_salida` AS cedula_fecha_salida,
CONCAT(personas.`apellido`,' ',personas.`nombre`) AS nombre,
personas.`numero_documento` AS dni,
expedientes.`caratula` AS exp_caratula,
estados_actuacion.`nombre` AS estados_actuaciones,
reparticiones.`nombre` AS reparticion,
expedientes.`estado` AS expediente_estado,
estados_expediente.`nombre` AS nombre_estado_expediente 
FROM
    `escritos`
    INNER JOIN `actuaciones` 
        ON (`escritos`.`actor` = `actuaciones`.`id`)
    INNER JOIN `expedientes` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`)
    INNER JOIN `cedulas` 
        ON (`cedulas`.`escrito` = `escritos`.`id`)
    INNER JOIN `departamentos` 
        ON (`expedientes`.`departamento` = `departamentos`.`id`)
    INNER JOIN `estados_actuacion` 
        ON (`actuaciones`.`estado` = `estados_actuacion`.`id`)
    INNER JOIN `estados_expediente` 
        ON (`expedientes`.`estado` = `estados_expediente`.`id`)    
    INNER JOIN `reparticiones` 
        ON (`expedientes`.`reparticion` = `reparticiones`.`id`)    
         WHERE cedulas.`fecha_salida`IS NOT NULL 
         AND cedulas.`fecha_regreso`IS NULL 
         AND escritos.`activo`=1 
         AND actuaciones.`estado`=1
         AND estados_expediente.`id` < 4
         AND YEAR(cedulas.`fecha_salida`) >= YEAR(CURDATE()) - 2 
         ORDER BY cedula_fecha_salida DESC";     

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

  public static function listacomisarias()
  {
    
    $consulta="SELECT
  reparticiones.`id` AS id, reparticiones.`nombre` AS nombre
  FROM
    `reparticiones`
    INNER JOIN `organismos` 
        ON (`reparticiones`.`organismo` = `organismos`.`id`)
        WHERE organismos.`id`=1";
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

  public static function listadoFiltradoReparticion($id)
  {
    $data=[];
     $consulta="SELECT
expedientes.`autos` AS exp_autos,
cedulas.`fecha_salida` AS cedula_fecha_salida,
CONCAT(personas.`apellido`,' ',personas.`nombre`) AS nombre,
personas.`numero_documento` AS dni,
personas.`domicilio` AS domicilio,
expedientes.`caratula` AS exp_caratula,
estados_actuacion.`nombre` AS estados_actuaciones,
reparticiones.`nombre` AS reparticion 
FROM
    `escritos`
    INNER JOIN `actuaciones` 
        ON (`escritos`.`actor` = `actuaciones`.`id`)
    INNER JOIN `expedientes` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`)
    INNER JOIN `cedulas` 
        ON (`cedulas`.`escrito` = `escritos`.`id`)
    INNER JOIN `departamentos` 
        ON (`expedientes`.`departamento` = `departamentos`.`id`)
    INNER JOIN `estados_actuacion` 
        ON (`actuaciones`.`estado` = `estados_actuacion`.`id`)
    INNER JOIN `reparticiones` 
        ON (`expedientes`.`reparticion` = `reparticiones`.`id`)    
         WHERE cedulas.`fecha_salida`IS NOT NULL 
         AND cedulas.`fecha_regreso`IS NULL 
         AND escritos.`activo`=1 
         AND actuaciones.`estado`=1
         AND YEAR(cedulas.`fecha_salida`) >= YEAR(CURDATE()) - 2 
         AND reparticiones.`id`=".$id." 
         ORDER BY cedula_fecha_salida DESC";

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

 
}
?>