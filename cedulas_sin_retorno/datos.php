<?php
include("cedulas_sin_retorno.php");
if( isset($_POST['id']) && !empty($_POST['id']) )
{
 $id=(int)$_POST['id'];
$datos = array();
$listados = cedulas_sin_retorno::listadoFiltradoReparticion($id);

//print_r($listados); exit();

foreach($listados as $item)
{
    $exp_autos=$item['exp_autos']; 
    $nombre=$item['nombre']; 
    $dni=$item['dni']; 
    $exp_caratula=$item['exp_caratula']; 
    $estados_actuaciones=$item['estados_actuaciones']; 
    $reparticion=$item['reparticion']; 
   // $cedula_fecha_salida=$item['cedula_fecha_salida']; 

    $lista[] = array('exp_autos'=> $item['exp_autos'],'nombre'=> $item['nombre'],'dni'=> $item['dni'], 'exp_caratula'=>$item['exp_caratula'], 'estados_actuaciones'=> $item['estados_actuaciones'],'reparticion'=> $item['reparticion']);

}   


// Simular datos en formato JSON
$datos2 = [
    [
        'nombre' => 'Juan Pérez',
        'domicilio' => 'Calle 123, Ciudad',
        'dni' => '12345678'
    ],
    [
        'nombre' => 'María González',
        'domicilio' => 'Avenida XYZ, Pueblo',
        'dni' => '87654321'
    ],
    [
        'nombre' => 'Juan Pérez',
        'domicilio' => 'Calle 123, Ciudad',
        'dni' => '12345678'
    ]
];


/////// ----------------- nuevo 18/09/2023

$consulta="SELECT
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
         AND reparticiones.`id`=".$id." 
         ORDER BY cedula_fecha_salida DESC";

    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
 $data = array();

    // Iterar a través de los resultados y agregarlos al arreglo
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode($data); //$listados;//json_encode($datos);
}
?>