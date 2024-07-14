<?php
require_once 'listado_secuestros.php';
//$list = json_decode($_POST['listaNumeros']);
$list = $_POST['listaNumeros'];
/*echo '<pre>';
print_r($list);
echo '</pre>';

exit;
*/
$datos = array();
foreach ($list as $item) {
    $objeto = new listado_secuestros();
    $listados = $objeto->obtenerDatosSecuestros($item);
    foreach ($listados as $item) {
        $fila = array(
            "autos" => $item['autos'],
            "caratula" => $item['caratula'],
            "objeto" => $item['objeto'],
            "descripcion" => $item['descripcion'],
            "secuestro_id" => $item['secuestro_id'],
            "ubicacion" => $item['ubicacion'],
            "acta_infraccion" => $item['infraccion_numero'],
            "apellido" => $item['apellido'],
            "nombre" => $item['nombre'],
            "dni" => $item['dni'],
            "domicilio" => $item['domicilio'],
            "cantidad" => $item['cantidad'],
        );
        array_push($datos, $fila);
    }
}
echo json_encode($datos);
