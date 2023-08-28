<?php
require_once "fpdf/fpdf.php";
require_once "../../model/class_protocolo.php";
$ID_proto = isset($_GET['P01']) ? trim( $_GET['P01']) : 0;
$Proto = protocolo::getProtocoloMultiple( $ID_proto);
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->SetMargins(10,30,12);
if( is_array( $Proto)){
	$cant = count( $Proto);
	for( $i = 0; $i < $cant; $i ++){
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->setXY(22,21);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 17, 5, "AUTOS Nº",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 18, 5, $Proto[$i][5],0, 0, 'L', true);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 15, 5, "ACTA Nº",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 25, 5, $Proto[$i][6],0, 0, 'L', true);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 22, 5, "CARÁTULA C/",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 73, 5, strtoupper($Proto[$i][7]),0, 0, 'L', true);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 18, 5, "IMPUTADO:",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 69, 5, strtoupper($Proto[$i][8]),0, 0, 'L', true);
		$pdf->Cell( 40, 5, "",0, 1, 'L', true);
		$pdf->setXY(22,27);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 42, 5, "PROTOCOLIZADO EN TOMO:",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 13, 5, $Proto[$i][3],0, 0, 'L', true);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 14, 5, "FOLIO:",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		if( $cant == 1){
			$pdf->Cell( 45, 5, $Proto[$i][1]." al ".$Proto[$i][2],0, 0, 'L', true);
		}else{
			$pdf->Cell( 45, 5, $Proto[$i][1]." (Del ".$Proto[$i][9]." al ".$Proto[$i][2].")",0, 0, 'L', true);
		}
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 20, 5, "DEL LIBRO",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 80, 5, utf8_decode($Proto[$i][4]),0, 0, 'L', true);
		$pdf->SetFont('Courier','B',9); 
		$pdf->Cell( 20, 5, "EN FECHA:",0, 0, 'L', true);
		$pdf->SetFont('Courier','',9); 
		$pdf->Cell( 23, 5, $Proto[$i][0],0, 0, 'L', true);
		$pdf->Cell( 40, 5, "",0, 1, 'L', true);
		$pdf->Rect( 20, 20, 260, 13);
	}
}else{
	$pdf->AddPage();
	$pdf->SetFont('Courier','',12);
	$pdf->MultiCell( 0, 6, "Error al obtener el sello múltiple", 0, 'C');
}
$pdf->Output();
?>