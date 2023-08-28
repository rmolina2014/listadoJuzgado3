<?php
require_once "../assets/tcpdf/tcpdf.php";
include("cpanel.php");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

//$pdf->SetFont('dejavusans', '', 10);
$pdf->SetFont('Courier','',12);
// add a page
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

/*** nuevo ***/

$objeto = new cpanel();

$id_req=(int)$_GET['req_id'];

$datos = $objeto->obtenerDatosIntimacion($id_req);
 foreach($datos as $item)
 {
   $nombre=utf8_decode($item['nombre']); 
   $domicilio=utf8_decode($item['domicilio']); 
   $autos=utf8_decode($item['autos']); 
   $caratula=utf8_decode($item['caratula']);
   $intimacion=$item['intimacion']; 
   $fecha_intimacion=$item['fecha_intimacion'];
   
  } 

/** datos****/

  $fecha_intimacion=date("Y-m-d");
 
  /**fecha**/

  function fechaCastellano ($fecha) {
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
  return $numeroDia." de ".$nombreMes." de ".$anio;
  }

$dia=fechaCastellano($fecha_intimacion);

$tipo ='<span style="text-align:center;"><u>CEDULA</u></span>';

$pdf->writeHTML( $tipo, true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);

$destinatario='APELLIDO Y NOMBRE : '.$nombre.'.';

$pdf->writeHTML( utf8_encode($destinatario), true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);

$domicilio='DOMICILIO : '.$domicilio.'.';

$pdf->writeHTML( utf8_encode($domicilio), true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);

$nota1='                    Me dirijo a Ud. en Autos Nº'.$autos.'c/'.$caratula.',que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, sito en calle Avda. Libertador N° 750 - Oeste - Centro Civico - 3° Piso - Núcleo 5 - Ciudad - San Juan, a fin de notificarle que se ha dictado la siguiente providencia: '.$intimacion.' Fdo Abdo. Enrique G. Mattar- Juez de Faltas- Abda. Adriana Corral de Lobos- Secretaria Letrada.-';


$pdf->MultiCell(0, 0,$nota1."\n", 0,'J', 1, 2, '' ,'', true);


$pdf->writeHTML( '<span></span>', true, false, true, false);

$fin ='<span style="text-align:right;">Queda Ud. debidamente notificado.-</span>';
$pdf->writeHTML( utf8_encode($fin), true, false, true, false, "R");


$pdf->writeHTML( '<span></span>', true, false, true, false);
$fecha ='<span style="text-align:right;">San Juan,'.$dia.'.-</span>';
$pdf->writeHTML( utf8_encode($fecha), true, false, true, false, "R");

//-------- imagen ----------------


$imagen ='<img src="juzgado_faltas.png" alt="" width="130" height="180"  />
<img src="jefa_despacho.png" alt="" width="150" height="60"  />';

$pdf->writeHTML( $imagen, true, false, true, false, "C");



// ---------- Actualizar el estado-----------------------------------------------
//$datos = $objeto->actualizarEstado($listado_comisaria_id,"Impreso");
//Close and output PDF document

$pdf->Output('nota.pdf', 'I');
?>