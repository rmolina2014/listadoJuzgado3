<?php
require_once "../assets/tcpdf/tcpdf.php";
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 039');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 039', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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

// add a page
$pdf->AddPage();

// set font
$pdf->SetFont('Courier', '', 11);


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

// create some HTML content

$html='<span style="text-align:justify;text-indent: 8px;">                             Me dirijo a Ud., a fin de remitirle oficios de <strong> tipo_oficio </strong>, por causas que se tramitan por ante este Juzgado de Faltas de tercera Nominación, para que sean diligenciadas por esa repartición.- Solicito se entreguen copia de la cédula al notificador y remita a este Juzgado el original que a continuación se detallan: </span>';

// set core font
$pdf->SetFont('Courier', '', 11);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);

//$pdf->writeHTML($data.'.', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);

$fin ='Sin otro particular, lo saludo atte.';
$pdf->writeHTML( utf8_encode($fin), true, false, true, false, "R");

//Close and output PDF document
$pdf->Output('nota.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+