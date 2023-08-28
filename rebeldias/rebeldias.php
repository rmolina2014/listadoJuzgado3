<?php
include_once("../bd/conexion.php");
class rebeldias
{
  public function buscardatos_dni($dni)
  {
   $consulta="SELECT
   `id`,
   `tipo_documento`,
   `numero_documento`,
   `apellido`,
   `nombre`,
   `edad`,
   `estado_civil`,
   `sexo`,
   `cuit`,
   `domicilio`,
   `domicilio_legal`,
   `matricula`,
   `juridica`
 FROM `personas`
 WHERE numero_documento=$dni;";
    
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if(mysqli_num_rows($rs) >0)
    {
      while($fila = mysqli_fetch_assoc($rs))
      {
        $data[] = $fila;
      }
      return $data;
    }else return $rs;
  }
  
        
public function buscar_actuaciones_dni($dni)
{
   $consulta="SELECT
   estados_actuacion.`nombre` AS actuaciones_estado,
roles.`nombre` AS actuaciones_rol,
expedientes.`autos` AS expedientes_autos,
expedientes.`caratula` AS expedientes_caratula,
tipos_expediente.`nombre` AS tipo_expediente,
expedientes.`descripcion` AS expediente_descripcion,
estados_expediente.`nombre` AS estado_expediente
FROM
    `actuaciones`
    INNER JOIN `expedientes` 
        ON (`actuaciones`.`expediente` = `expedientes`.`id`)
    INNER JOIN `estados_expediente` 
        ON (`expedientes`.`estado` = `estados_expediente`.`id`)
    INNER JOIN `personas` 
        ON (`actuaciones`.`persona` = `personas`.`id`)
    INNER JOIN `tipos_expediente` 
        ON (`expedientes`.`tipo` = `tipos_expediente`.`id`)
    INNER JOIN `estados_actuacion` 
        ON (`actuaciones`.`estado` = `estados_actuacion`.`id`)
    INNER JOIN `roles` 
        ON (`actuaciones`.`rol` = `roles`.`id`)
                WHERE `personas`.`numero_documento`=$dni and estados_expediente.`nombre`='Activo'";
    
    
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if(mysqli_num_rows($rs) >0)
    {
      while($fila = mysqli_fetch_assoc($rs))
      {
        $data[] = $fila;
      }
      return $data;
    }else return $rs;
  }        



}
?>