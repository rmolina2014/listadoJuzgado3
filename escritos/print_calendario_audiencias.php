<?php
require("../../controller/control_seguridad.php");
require("../../model/class_escritos_cedula.php");
require "../../controller/v1.php";

$Fecha    = isset($_GET['Fecha'])  ?       trim( $_GET['Fecha']) : 0;
$listado  = cedula::CalendarioAudiencias( $Fecha); 

require_once('fpdf/fpdf.php');

class MyPDF extends FPDF{
	function Header(){
		global $Titulo;
		global $Fecha;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(100,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'Calendario de audiencias ' .$Fecha,0,1,'J');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(15,6,'Orden',1,0,'L',1);
		$this->Cell(40,6,'Autos',1,0,'L',1);
		$this->Cell(20,6,'Hora',1,0,'L',1);
		$this->Cell(100,6,'Apellido y Nombre',1,0,'L',1);
		$this->Ln(5);
	}
	function Footer(){
		$this->setXY(25,280);
	    $this->SetFont('Arial','B',10);
		$this->SetTextColor(70);
		$this->Cell( 0, 2,'___________________________________________________________________________________',0,1,'L');
		$this->Cell(50,7,'Fecha de impresión: '.date(d).'/'.date(m).'/'.date(Y),0,0,'L');
		$this->Cell(110,7,'Pagina '.$this->PageNo(),0,1,'R');
		$this->Ln(25);
	}
}
// - - - - - - - - - - - - - - - - - - - - - -
$pdf=new MyPDF('P', 'mm', 'A4');
$pdf->SetMargins(20,30,8);
$pdf->AddPage();
$pdf->SetFont('Courier','',10);
// - - - - - - - - - - - - - - - - - - - - - -
/*
$pdf->MultiCell(0,6,$error,0,'L');
$pdf->MultiCell(0,6,$criterio,0,'L');
$pdf->MultiCell(0,6,$lote->master_query,0,'L');
*/
// $listado = $lote->getLote();
$cant = count( $listado);
$pdf->setFillColor(255,255,255);
for( $i = 0; $i < $cant; $i ++){
	
	$pdf->Cell(15,5,($i+1),1,0,'L',1); //NUMERO
	$pdf->Cell(40,5,$listado[$i][3],1,0,'L',1);//AUTOS
	$pdf->Cell(20,5,$listado[$i][2],1,0,'L',1); //HORA
	$pdf->Cell(100,5,utf8_decode(strtoupper($listado[$i][0])),1,0,'L',1); //NOMBRE
	$pdf->Cell(40,5,"",0,1,'L',1);
	
	
}
//$pdf->MultiCell(0,6,'i='.$i.' - cant='.$cant,0,'L');
$pdf->Output();
?>