<?php
require_once "../assets/tcpdf/tcpdf.php";
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola ');
$pdf->SetTitle('Nota');
$pdf->SetSubject('TCPDF ');
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

$pdf->setCellHeightRatio(2); 


// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

//$pdf->SetFont('dejavusans', '', 10);


$pdf->SetFont('Courier', '', 11);


// add a page
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

/*** datos ***/

 
  $fecha=date('Y-m-d');

  $tipo_oficio=$_GET['tipo'];

  $listado=json_decode($_GET['lista']);

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

$pdf->Cell(0, 15, ' OFICIO ', 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->writeHTML( '<span></span>', true, false, true, false);

$encabezado ='                              San Juan, '.$dia.' .';

$pdf->writeHTML( utf8_encode($encabezado), true, false, true, false, "R");

$pdf->writeHTML( '<span></span>', true, false, true, false);

$destinatario='Al Sr. Jefe  ';

$pdf->writeHTML( $destinatario, true, false, true, false);

$destinatario2='Policía de San Juan';

$pdf->writeHTML( $destinatario2, true, false, true, false);

$pdf->writeHTML( 'S.-----------/-----------D.', true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);

$nota='<span >                             Me dirijo a Ud., a fin de remitirle oficios de <strong> '.$tipo_oficio.' </strong>, por causas que se tramitan por ante este Juzgado de Faltas de tercera Nominación, para que sean diligenciadas por esa repartición.- Solicito se entreguen copia de la cédula al notificador y remita a este Juzgado el original que a continuación se detallan: </span>';

//$pdf->writeHTMLCell(0, 0, '', '', $nota, 0, 1, 0, true, '', true);

$html='<span style="text-align:justify;text-indent: 8px;">                         Me dirijo a Ud., a fin de remitirle oficios de <strong>'.$tipo_oficio.'</strong>, por causas que se tramitan por ante este Juzgado de Faltas de tercera Nominación, para que sean diligenciadas por esa repartición.- Solicito se entreguen copia de la cédula al notificador y remita a este Juzgado el original que a continuación se detallan: </span>';

// set core font
$pdf->SetFont('Courier', '', 11);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);


// print a block of text using Write()

$data='<strong> Autos N°</strong> : ';
foreach($listado as $item)
{
  //$data='<p>'.$item.' </p>';
  //$data=$data.'<strong>'.$item.'</strong>; ';
  $data=$data.$item.' - ';
}

//$data=substr($data, 0, -2);

$pdf->writeHTMLCell(0, 0, '', '', $data.'.', 0, 1, 0, true, '', true);

//$pdf->writeHTML($data.'.', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);

$fin ='Sin otro particular, lo saludo atte.';
$pdf->writeHTML( utf8_encode($fin), true, false, true, false, "R");

//Close and output PDF document
$pdf->Output('nota.pdf', 'I');
?>
