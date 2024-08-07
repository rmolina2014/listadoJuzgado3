<?php
require_once "../assets/tcpdf/tcpdf.php";
include("listado_secuestros.php");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Nota');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins antes
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// hoy 
$pdf->SetMargins(30, 30, 30);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

/**fecha**/
$fecha = date("Y-m-d");
function fechaCastellano($fecha)
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia . " de " . $nombreMes . " de " . $anio;
}

$dia = fechaCastellano($fecha);

$tipo = '<strong><u>OFICIO</u></strong>';

$pdf->writeHTML($tipo, true, false, true, false, "C");

$pdf->writeHTML('<span></span>', true, false, true, false);

$pdf->writeHTML('<span></span>', true, false, true, false);

$encabezado = '                              San Juan, ' . $dia . '.';

$pdf->writeHTML($encabezado, true, false, true, false, "R");

$pdf->writeHTML('<span></span>', true, false, true, false);

/**datos post */
$destinatario = $_POST['destinatario']; //'SEÑOR ';

$acta_infraccion = $_POST['acta_infraccion'];

$autos = $_POST['autos'];

$proceder = $_POST['proceder'];

$donado_a = $_POST['donar_a'];

$pdf->writeHTML("Señor Jefe de", true, false, true, false);

/*** buscar los datos ***/

$objeto = new listado_secuestros();
/**datos del json */
$list = json_decode($_POST['donacion']);
/*
echo '<pre>';
print_r($list);
echo '</pre>';
exit;*/

// recorrer el json

foreach ($list as $item) {
    $ubicacion = $item->ubicacion;
    $caratula = $item->caratula;
    $autos = $item->autos;
    $acta = $item->acta_infraccion;
    $secuestro_id = $item->secuestro_id;
    $restituido_a = $item->apellido . '' . $item->nombre;
}

/** insertar datos del secuestro */
$id_registro_historico = $objeto->insertar_registro_secuestro_historico($autos, $fecha, $acta, $caratula, $ubicacion, $proceder, $donado_a, $restituido_a);
/*echo '<pre>' . $band . '</pre>';
if($band>0) {echo "error"; exit;}
exit;*/

/** obtener ubicacion */

$destinatario2 = $ubicacion; //'POLICIA DE LA PROVINCIA DE SAN JUAN';

$pdf->writeHTML($destinatario, true, false, true, false);

$pdf->writeHTML('S.___________/___________D.', true, false, true, false);

$pdf->setCellHeightRatio(2.5);

$proceder = $_POST['proceder'];

switch ($proceder) {
    case 'Donacion':
        $nota = '                                        Me dirigo a Ud., con el fin de comunicarle que ha dictado la siguiente providencia: "San Juan, ' . $dia . ': I) Oficiese a ' . $destinatario . ' para que proceda a la Donación, a ' . $donado_a . ' de los siguientes elementos secuestrados en autos que ha continuación se detallan, tales son: ';
        break;
    case 'Destruccion':
        $nota = '                                        Me dirigo a Ud., con el fin de comunicarle que ha dictado la siguiente providencia: "San Juan, ' . $dia . ': I) Oficiese a ' . $destinatario . ' para que proceda a la Destrucción de los siguientes elementos secuestrados en autos que ha continuación se detallan, tales son: ';
        ' que se encuentran en calidad de secuestro en los autos utsupra mencionados, tales son :';
        break;
    case 'Restitucion':
        $nombre_apellido = $_POST['nombre'] . ' ' . $_POST['apellido'];
        $dni = $_POST['dni'];
        $domicilio = $_POST['domicilio'];
        $nota = '                                        Me dirigo a Ud., con el fin de comunicarle que ha dictado la siguiente providencia: "San Juan, ' . $dia . ': I) Oficiese a ' . $destinatario . ' para que proceda a la Restitución, al SR/A.: ' . $nombre_apellido . ' DNI:' . $dni . ' domicilio: ' . $domicilio . ' de los siguientes elementos secuestrados en autos que ha continuación se detallan, tales son: ';
        break;
}

//$pdf->MultiCell(0, 0, " " . $nota . "", 0, 'J', 1, 1, '', '', true);

$i = 0;
$fila='';
$texto='';
foreach ($list as $item2) {
    $longitud = count($list);
    $i++;
    $secuestro_id1 = $item2->secuestro_id;
    $objeto = new listado_secuestros();
    $datos = $objeto->obtenerDatosSecuestros2($secuestro_id1);
    foreach ($datos as $item) {
        $autos = $item['autos'];
        $caratula = $item['caratula'];
        $descripcion = $item['descripcion'];
        $ubicacion = $item['ubicacion'];
        $objeto = $item['objeto'];
        $cantidad = $item['cantidad'];
        $acta_infraccion = $item['infraccion_numero'];
        $secuestro_id = $item['secuestro_id'];
        // insertar detalle del secuestro
        $objeto2 = new listado_secuestros();
        $band = $objeto2->insertar_registro_secuestro_detalle_objeto($id_registro_historico, $secuestro_id);
        // echo $band;
        //exit;
    }

    if ($i == $longitud) {
        $fila= 'Autos Nº ' . $autos . ' - ' . $cantidad . ' ' . $objeto . ' ' . $descripcion . '. - Fdo Dr.Enrique Mattar Juez de Faltas - Dra. Adriana Corral de Lobos - Secretaria Letrada -".';
    } else {
        $fila= 'Autos Nº ' . $autos . ' - ' . $cantidad . ' ' . $objeto . ' ' . $descripcion.'; ';
    }
    $texto=$texto.$fila;
    //$pdf->MultiCell(0, 0,$fila.' ', 0, 'J', 1, 1, '', '', true);
}



$pdf->MultiCell(0, 0, " " . $nota .$texto."\n", 0, 'J', 1, 1, '', '', true);

$notafin = '                                        II)Para llevar a cabo esta medida, deberá labrarse acta con noticia al Juzgado actuante.';

$pdf->MultiCell(0, 0, '' . $notafin. "\n", 0, 'J', 1, 1, '', '', true);

$pdf->writeHTML('<span></span>', true, false, true, false);

$nota1 = '                                        Sin más,le saludo a Ud. atentamente.-';

$pdf->MultiCell(0, 0, '' . $nota1 . "\n", 0, 'J', 1, 1, '', '', true);

/*
$pdf->Image("../imagenes/sello_secretaria.jpg", 20, 230, 39, 0, 'JPG');
$pdf->Image("../imagenes/sello_juzgado.jpg", 90, 200, 39, 0, 'JPG');
$pdf->Image("../imagenes/sello_juez.jpg", 160, 230, 39, 0, 'JPG');
*/

$pdf->writeHTML('<span></span>', true, false, true, false);

// ---------- Actualizar el estado-----------------------------------------------
//$datos = $objeto->actualizarEstado($listado_comisaria_id, "Impreso");
//Close and output PDF document
$pdf->Output('nota.pdf', 'I');
