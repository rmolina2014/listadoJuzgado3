<?php
include_once("../bd/conexion.php");
class listado_comisarias
{
  
  
  /*********** listados por tipo ***********/ 

  public static  function lista()
  {
    $data=[];
    $consulta="SELECT * FROM listado_comisarias where estado='Impreso' and tipo <> 'Libre' order by id desc";
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

  public static function listaLibre()
  {
    $data=[];
    $consulta="SELECT * FROM listado_comisarias where (estado='Impreso') and (tipo='Libre') order by id desc";
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


  public static  function listaOficioPolicia()
  {
    $data=[];
    $consulta="SELECT * FROM listado_comisarias where (estado='Impreso') and (tipo='Oficio_Policia') order by id desc";
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


  public function nuevo($fecha,$destino,$estado,$fecha_creacion,$usuario,$contenido,$tipo)
  {
   $sql="INSERT INTO `listado_comisarias`
                 (`fecha`,
                 `destino`,
                 `estado`,
                 `fecha_creacion`,
                 `usuario`,
                 `contenido`,
                 `tipo`)
           VALUES (
             '$fecha',
             '$destino',
             '$estado',
             '$fecha_creacion',
             '$usuario',
              '$contenido',
              '$tipo');";
   $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
   $ultimo_id = mysqli_insert_id(conexion::obtenerInstancia());
    return $ultimo_id;
   }

  public function actualizarEstado($id,$estado)
  {
  $sql="UPDATE `listado_comisarias`
          SET 
            `estado` = '$estado'
              WHERE `id` = '$id'";
  $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
  return $rs;
  }

 public function obtenerId($id)
 {
  $sql="SELECT * FROM listado_comisarias where id='$id'";
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
  $sql="DELETE FROM listado_comisarias WHERE id ='$id'";
  $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
  return $rs;
 }

 /*------------- detalles ----------*/

 public function nuevoDetalle($persona_id,$actuaciones_id,$expediente_id,$listado_comisaria_id,$caratula,$persona_nombre,$domicilio,$persona_dni,$numero_expediente,$rol,$estado_actuacion)
  {
   $sql="INSERT INTO `listado_comisaria_detalle`
            (`persona_id`,
             `actuaciones_id`,
             `expedientes_id`,
             `listado_comisaria_id`,
             `caratula`,
             `persona_nombre`,
             `domicilio`,
             `persona_dni`,
             `numero_expediente`,
             `rol`,
             `estado_actuacion`)
          VALUES ('$persona_id',
                  '$actuaciones_id',
                  '$expediente_id',
                  '$listado_comisaria_id',
                  '$caratula',
                  '$persona_nombre',
                  '$domicilio',
                  '$persona_dni',
                  '$numero_expediente',
                  '$rol',
                  '$estado_actuacion'
                   );";
               
   $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
   $ultimo_id = mysqli_insert_id(conexion::obtenerInstancia());
    return $ultimo_id;
   }

   public function buscarDetalleNota($id)
   {
    $data=[];
    $consulta="SELECT
              `id`,
              `persona_id`,
              `actuaciones_id`,
              `expedientes_id`,
              `listado_comisaria_id`,
              `caratula`,
              `persona_nombre`,
              `domicilio`,
              `persona_dni`,
              `numero_expediente`,
              `rol`,
              `estado_actuacion`
              FROM `listado_comisaria_detalle`
              where `listado_comisaria_id`=$id order by id desc";
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

  public function buscarDetalleNotaExpediente($id)
   {
    $data=[];
    $consulta="SELECT
              `id`,
              `persona_id`,
              `actuaciones_id`,
              `expedientes_id`,
              `listado_comisaria_id`,
              `caratula`,
              `persona_nombre`,
              `domicilio`,
              `persona_dni`,
              `numero_expediente`
              FROM `listado_comisaria_detalle`
              where `listado_comisaria_id`=$id order by actuaciones_id asc";
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

 public function borrarPersonaDetalle($id)
 {
  $sql="DELETE FROM listado_comisaria_detalle WHERE id ='$id'";
  $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
  return $rs;
 }
 
}
?>