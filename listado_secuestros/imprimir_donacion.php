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

//$pdf->Cell(0, 15, ' <strong>OFICIO</strong> ', 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->writeHTML('<span></span>', true, false, true, false);

$pdf->writeHTML('<span></span>', true, false, true, false);

$encabezado = '                              San Juan, ' . $dia . '.';

$pdf->writeHTML($encabezado, true, false, true, false, "R");

$pdf->writeHTML('<span></span>', true, false, true, false);

$destinatario = 'SEÑOR ';

$pdf->writeHTML($destinatario, true, false, true, false);

$pdf->writeHTML('<span></span>', true, false, true, false);

/*** buscar los datos ***/

$objeto = new listado_secuestros();

$list = json_decode($_POST['donacion']);

// recorrer el json

foreach ($list as $item) {
    $ubicacion = $item->ubicacion;
}

/** obtener ubicacion */

$destinatario2 = $ubicacion; //'POLICIA DE LA PROVINCIA DE SAN JUAN';

$pdf->writeHTML($destinatario, true, false, true, false);

$pdf->writeHTML('S.___________/___________D.', true, false, true, false);
$pdf->writeHTML('<span></span>', true, false, true, false);
$pdf->writeHTML('<span></span>', true, false, true, false);

$pdf->setCellHeightRatio(2.5);

$pdf->writeHTML('<span></span>', true, false, true, false);

$nota = '                                        Me dirigo a Ud.,con el fin de comunicarle se ha dictado la siguiente providencia:"San Juan,' . $dia . ': I) Oficiese a '. $destinatario.' para que proceda a la donacion de los siguientes elementos secuestrados:';

$pdf->MultiCell(0, 0," ".$nota . "\n", 0, 'J', 1, 2, '', '', true);

foreach ($list as $item2) {
    $secuestro_id = $item2->secuestro_id;
    $objeto = new listado_secuestros();
    $datos = $objeto->obtenerDatosSecuestros2($secuestro_id);
    foreach ($datos as $item) {
        $autos = $item['autos'];
        $caratula = $item['caratula'];
        $descripcion = $item['descripcion'];
        $ubicacion = $item['ubicacion'];
        $objeto = $item['objeto'];
        $cantidad = $item['cantidad'];
        $acta_infraccion = $item['infraccion_numero'];
    }

    $pdf->writeHTML('En Acta de Infracción N° : '.$acta_infraccion.' en  Autos N° ' . $autos . ' C/' . $caratula.' elementos '.$cantidad.' '.$objeto.'-'.$descripcion.'-', true, false, true, false);
}

$nota = '                                        II)Para llevar a cabo esta medida, deberá labrarse acta con noticia al Juzgado actuante".-';

$pdf->MultiCell(0, 0, '' . $nota . "\n", 0, 'J', 1, 2, '', '', true);
$pdf->writeHTML('<span></span>', true, false, true, false);

$pdf->writeHTML('<span></span>', true, false, true, false);

$nota1 = '                                        Sin más,le saludo a Ud. atentamente.-';

$pdf->MultiCell(0, 0, '' . $nota1 . "\n", 0, 'J', 1, 2, '', '', true);

$pdf->writeHTML('<span></span>', true, false, true, false);

// ---------- Actualizar el estado-----------------------------------------------
//$datos = $objeto->actualizarEstado($listado_comisaria_id, "Impreso");
//Close and output PDF document
$pdf->Output('nota.pdf', 'I');
