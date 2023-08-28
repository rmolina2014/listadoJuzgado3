<?php

require_once('fpdf/fpdf.php');

class MyPDF extends FPDF{
	function Header(){
		global $Titulo;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(125,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'Mis expedientes',0,1,'R');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(13,6,'Orden',1,0,'L',1);
		$this->Cell(15,6,'Autos',1,0,'L',1);
		$this->Cell(30,6,'Acta',1,0,'L',1);
		$this->Cell(25,6,'Fecha',1,0,'L',1);
		$this->Cell(160,6,'Caratula',1,0,'L',1);
		$this->Cell(20,6,'Ubi.',1,0,'R',1);
		$this->Ln(5);
	}
	function Footer(){
		$this->setXY(25,190);
	    $this->SetFont('Arial','B',10);
		$this->SetTextColor(70);
		$this->Cell( 0, 2,'_______________________________________________________________________________________________________________________________',0,1,'L');
		$this->Cell(125,7,'Fecha de impresión: '.date(d).'/'.date(m).'/'.date(Y),0,0,'L');
		$this->Cell(125,7,'Pagina '.$this->PageNo(),0,1,'R');
		$this->Ln(25);
	}
}
// - - - - - - - - - - - - - - - - - - - - - -
$pdf=new MyPDF('L', 'mm', 'A4');
$pdf->SetMargins(25,25,8);
$pdf->AddPage();
$pdf->SetFont('Courier','',10);
// - - - - - - - - - - - - - - - - - - - - - -
/*
$pdf->MultiCell(0,6,$error,0,'L');
$pdf->MultiCell(0,6,$criterio,0,'L');
$pdf->MultiCell(0,6,$lote->master_query,0,'L');
*/
$listado = $lote->getLote();
$cant = count( $listado);
$pdf->setFillColor(255,255,255);
for( $i = 0; $i < $cant; $i ++){
	//$pdf->MultiCell(0,6,($i+1).' - '.$listado[$i][0].' - '.$listado[$i][1].' - '.$listado[$i][4].' - '.utf8_decode(strtoupper($listado[$i][3])).' - '.utf8_decode(strtoupper($listado[$i][5].' '.$listado[$i][6])),0,'L');
	$pdf->Cell(13,5,($i+1),1,0,'L',1);
	$pdf->Cell(15,5,$listado[$i][0],1,0,'L',1);
	$pdf->Cell(30,5,$listado[$i][1],1,0,'L',1);
	$pdf->Cell(25,5,$listado[$i][4],1,0,'L',1);
	$pdf->Cell(160,5,utf8_decode(strtoupper($listado[$i][3])),1,0,'L',1);
	
	$pdf->Cell(20,5,utf8_decode(strtoupper($listado[$i][5])),1,0,'R',1);
	$pdf->Cell(40,5,"",0,1,'L',1);
}
//$pdf->MultiCell(0,6,'i='.$i.' - cant='.$cant,0,'L');
$pdf->Output();
?>