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
$pdf->SetMargins(40, 40, 10);

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

/*** nuevo ***/

$objeto = new listado_secuestros();

$secuestro_id = (int)$_GET['id'];

$datos = $objeto->obtenerDatosSecuestros($secuestro_id);

foreach ($datos as $item) {
    $autos = $item['autos'];
    $caratula = $item['caratula'];
    $descripcion = $item['descripcion'];
    $ubicacion = $item['ubicacion'];
    $objeto = $item['objeto'];
    $cantidad = $item['cantidad'];
    // $articulo = $item['articulo'];
}
/*echo "<pre>";
print_r($datos);
echo "</pre>";
exit;*/


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

/** datos****/



$tipo = '<strong><u>OFICIO</u></strong>';
$pdf->writeHTML($tipo, true, false, true, false, "C");

//$pdf->Cell(0, 15, ' <strong>OFICIO</strong> ', 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->writeHTML('<span></span>', true, false, true, false);

$pdf->writeHTML('<span></span>', true, false, true, false);

$encabezado = '                              San Juan, ' . $dia . '.';

$pdf->writeHTML($encabezado, true, false, true, false, "R");

$pdf->writeHTML('<span></span>', true, false, true, false);

//$destinatario='AL SR. JEFE DE POLICIA DE LA PROVINCIA DE SAN JUAN '.$comisaria.'.';
$destinatario = 'SEÑOR JEFE DE ';

$pdf->writeHTML($destinatario, true, false, true, false);

$pdf->writeHTML('<span></span>', true, false, true, false);

$destinatario2 = $ubicacion; //'POLICIA DE LA PROVINCIA DE SAN JUAN';

$pdf->writeHTML($destinatario2, true, false, true, false);

$pdf->writeHTML('S.___________/___________D.', true, false, true, false);



$pdf->writeHTML('<span></span>', true, false, true, false);
$pdf->writeHTML('<span></span>', true, false, true, false);

$pdf->setCellHeightRatio(2.5);


$pdf->writeHTML('<span></span>', true, false, true, false);

//$data1 = $i . '- ' . $persona_nombre . ' DNI:' . $persona_dni . ' ' . $domicilio . ' en Autos N° ' . $numero_expediente;

$pdf->MultiCell(0, 0, "Tengo el agrado de dirigirme a usted para que proceda a la Donacion de los siguientes elementos :" . "\n", 0, 'J', 1, 2, '', '', true);

$pdf->writeHTML('- '.$objeto.' Autos N° '.$autos.' C/'.$caratula, true, false, true, false);




$pdf->writeHTML('<span></span>', true, false, true, false);


$nota = '                                        Insértese en la Orden del Dia, a quienes no fueren encontrados y notificados de la presente.-';

$pdf->MultiCell(0, 0, '' . $nota . "\n", 0, 'J', 1, 2, '', '', true);

$pdf->writeHTML('<span></span>', true, false, true, false);

$nota1 = '                                        Sin otro particular, saludo a Ud. atentamente.-';

$pdf->MultiCell(0, 0, '' . $nota1 . "\n", 0, 'J', 1, 2, '', '', true);

$pdf->writeHTML('<span></span>', true, false, true, false);

// ---------- Actualizar el estado-----------------------------------------------
//$datos = $objeto->actualizarEstado($listado_comisaria_id, "Impreso");
//Close and output PDF document
$pdf->Output('nota.pdf', 'I');
