<?php
require_once "fpdf/fpdf.php";
class MyPDF extends FPDF{
	function Header(){
		global $Caja;
		global $NCaja;
		$this->setXY(15,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(100);
		$this->Cell(90,7,'Expedientes archivados en fecha: '.$Caja[0]['fecha'].' por '.$Caja[0]['usuario'],0,0,'L');
	    $this->SetFont('Arial','B',20);
		$this->SetTextColor(0);
		$this->Cell(90,7,'Caja: '.$NCaja,0,1,'R');
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(100);
		$this->setXY(10,18);
		$this->Cell( 0, 2,'______________________________________________________________________________________',0,1,'C');
		$this->Ln(8);
	}
	function Footer(){
		global $Usuario;
		$this->SetTextColor(100);
	    $this->SetFont('Arial','B',10);
		$this->setXY(10,280);
		$this->Cell(80,7,'Impreso el '.date('d/m/Y'),0,0,'L');
		$this->Cell(100,7,'Usuario: '.strtoupper( $Usuario),0,1,'R');
	}
}
// - - - - -
require_once "../../model/ubicaciones.php";
require_once "../../model/expedientes.php";
$NCaja = isset($_GET['CAJA'])? strip_tags( trim( $_GET['CAJA'])): 0;
$Caja = Ubicaciones::verCaja( $NCaja);
require_once "../../controller/session_seguridad.php";
$Usuario = $_SESSION["JmZj07_nombre"];
$Final = array();
for( $x = 0, $xcant = count( $Caja); $x < $xcant; $x ++){
	if( $temp = Expedientes::getPorAutos( $_SESSION["JmZj07_juzgado"], $Caja[$x]['autos'])){
		$Final[$x]['autos'] = $temp['autos'];
		$Final[$x]['acta'] = $temp['numero_origen'];
		$Final[$x]['fecha'] = $temp['fecha_origen'];
		$Final[$x]['cara'] = utf8_decode( $temp['caratula']);
		$Final[$x]['ley'] = Expedientes::getLeyPrint( $Caja[$x]['expediente']);
		$Final[$x]['repa'] = utf8_decode( $temp['reparticion']);
		// $Final[$x]['reso'] = '';
	}
}
// - - - - -
$pdf = new MyPDF();
$pdf->SetMargins(15,30,12);
$pdf->AddPage();
$pdf->SetFillColor(255,255,255);
for( $x = 0, $xcant = count( $Final); $x < $xcant; $x ++){
	$pdf->SetFont('Courier','B',9); $pdf->Cell( 11, 5, 'Autos', 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 16, 5, $Final[$x]['autos'], 0, 0, 'L', true);
	$pdf->SetFont('Courier','B',9); $pdf->Cell( 10, 5, 'Acta', 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 24, 5, $Final[$x]['acta'], 0, 0, 'L', true);
	$pdf->SetFont('Courier','B',9); $pdf->Cell( 12, 5, 'Fecha:', 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 26, 5, $Final[$x]['fecha'], 0, 0, 'L', true);
	$pdf->SetFont('Courier','B',9); $pdf->Cell( 22, 5, 'Carátula C/', 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 65, 5, $Final[$x]['cara'], 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 13, 5, '' , 0, 1, 'L', true);
	$pdf->SetFont('Courier','B',9); $pdf->Cell(  9, 5, 'Ley:', 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 72, 5, $Final[$x]['ley'], 0, 0, 'L', true);
	$pdf->SetFont('Courier','B',9); $pdf->Cell( 24, 5, 'Repartición:', 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 81, 5, $Final[$x]['repa'], 0, 0, 'L', true);
	$pdf->SetFont('Courier', '',9); $pdf->Cell( 13, 5, '' , 0, 1, 'L', true);
	// $pdf->SetFont('Courier','B',9); $pdf->Cell( 22, 5, 'Resolución:', 0, 0, 'L', true);
	// $pdf->SetFont('Courier', '',9); $pdf->Cell(164, 5, $Final[$x]['reso'], 0, 0, 'L', true);
	// $pdf->SetFont('Courier', '',9); $pdf->Cell( 13, 5, '' , 0, 1, 'L', true);
	$pdf->Cell( 0, 4,'___________________________________________________________________________________________', 0, 1, 'C');
}
$pdf->Output();
?>