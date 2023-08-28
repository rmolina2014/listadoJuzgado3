<?php
require_once "../assets/tcpdf/tcpdf.php";
include("../listado_comisarias/listado_comisarias.php");

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$pdf->SetFont('dejavusans', '', 10);
// add a page
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

/*** nuevo ***/

$objeto = new listado_comisarias();

$listado_comisaria_id=(int)$_GET['id'];

$datos = $objeto->obtenerId($listado_comisaria_id);
 foreach($datos as $item)
 {
   $destino=utf8_decode($item['destino']); 
   $contenido=utf8_decode($item['contenido']); 
   $fecha=$item['fecha'];
  } 


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

 $dia=fechaCastellano ($fecha);

/** datos****/

$tipo ='       ';

$pdf->Cell(0, 15, '  ', 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->writeHTML( '<span></span>', true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);

$encabezado ='                              San Juan, '.$dia.' .-';

$pdf->writeHTML( utf8_encode($encabezado), true, false, true, false, "R");

$pdf->writeHTML( '<span></span>', true, false, true, false);

$destinatario='AL '.$destino.'.';

$pdf->writeHTML( utf8_encode($destinatario), true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);

$nota=$contenido;

//$pdf->writeHTML( utf8_encode($nota), true, false, true, false);

$pdf->writeHTMLCell(0, 0, '', '', $nota, 0, 1, 0, true, '', true);

$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);

// print a block of text using Write()

$i=0;
$Bandera='1';
$datos = $objeto->buscarDetalleNotaExpediente($listado_comisaria_id);
foreach($datos as $item)
{
   $i++;
   $caratula=$item['caratula']; 
   $persona_nombre=$item['persona_nombre']; 
   $domicilio=$item['domicilio']; 
   //$domicilio_legal=$item['persona_legal'];
   $persona_dni=$item['persona_dni'];
   $numero_expediente=$item['numero_expediente'];
   $actuaciones_id=$item['actuaciones_id'];
   $persona_id=$item['persona_id'];
   $expediente_id=$item['expedientes_id'];

   /*if (($i > 17) and ($Bandera=='1'))
   {
    $pdf->AddPage();
    $pdf->SetMargins(10, 40, 40);
    $Bandera='2';  
   }*/
   
  $data='<p>'.$i.'- '.$persona_nombre.' DNI:'.$persona_dni.' '.$domicilio.' en Autos N° '.$numero_expediente.'</p>';
	$pdf->writeHTML($data, true, false, true, false);
	$pdf->writeHTML( '<span></span>', true, false, true, false);
}
$pdf->writeHTML( '<span></span>', true, false, true, false);
$fin ='Le saludo muy atentamente.-';
$pdf->writeHTML( utf8_encode($fin), true, false, true, false, "R");
// ---------- Actualizar el estado-----------------------------------------------
$datos = $objeto->actualizarEstado($listado_comisaria_id,"Impreso");
//Close and output PDF document
$pdf->Output('nota.pdf', 'I');
?>
