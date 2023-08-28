<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_escritos_cedula.php";

//require_once "../../model/class_expediente.php";
//require_once "../model/class_ubicaciones.php";

class MyPDF extends FPDF{
	function Header(){
		global $Title;
		global $Opcion;
		$this->setXY(25,13);
		$this->SetTextColor(70);
		$this->SetFont('Courier','B',10);
		$this->MultiCell( 0, 5,strtoupper( $Title), 0, 'L');
		$this->MultiCell( 0, 3,'', 0, 'L');
		$this->SetTextColor( 255, 255, 255);
		$this->SetFillColor( 120, 120, 120);
		$this->Cell( 20, 5, 'AUTOS', 1, 0, 'L', 1);
		$this->Cell( 75, 5, 'NOMBRE', 1, 0, 'L', 1);
		$this->Cell( 25, 5, 'DOCUMENTO', 1, 0, 'L', 1);
		$this->Cell(107, 5, 'TIPO DE CEDULA', 1, 0, 'C', 1);
		switch( $Opcion){
			case 1:  $this->Cell( 35, 5, 'F.CITACION', 1, 0, 'C', 1); break;
			case 2:  $this->Cell( 35, 5, 'F.SALIDA', 1, 0, 'C', 1); break;
			default: $this->Cell( 35, 5, 'FECHA', 1, 0, 'C', 1); break;
		}
		$this->Ln();
	}
	function Footer(){
		$this->setXY(22,190);
		$this->SetFont('Courier','B',10);
		$this->SetTextColor(70);
		$this->Cell( 0, 2,'_____________________________________________________________________________________________________________________________',0,1,'L');
		$this->Cell(100,7,'Impreso el '.date(d).'/'.date(m).'/'.date(Y),0,0,'L');
		$this->Cell(100,7,'Sistema de Expedientes Contravencionales',0,0,'L');
		$this->Cell( 60,7,'Pagina '.$this->PageNo(),0,1,'R');
		$this->Ln(25);
	}
}

$Opcion = isset($_GET['Opcion'])? trim( $_GET['Opcion']): 0;
//isset($_GET['Filtro']) ? $Filtro = trim( $_GET['Filtro']) : $Filtro = 0;
//isset($_GET['Fecha']) ?  $F = trim( $_GET['Fecha']) : $F = 0;

switch( $Opcion){
	case 1: /* cedulas para enviar */
		$Data  = Cedula::getCedulasParaEnviar();
		/*		`escrito`,`expediente`,`cara`,`nom`,`doc`,`dreal`,`fecha`,`tipo`		*/
		$Title = "TERCER JUZGADO DE FALTAS - CEDULAS QUE TODAVIA NO SALEN DEL JUZGADO";
	break;
	case 2: /* cedulas para enviar */
		$Data  = Cedula::getCedulasEnviadas();
		/*		`escrito`,`expediente`,`cara`,`nom`,`doc`,`dreal`,`fecha`,`tipo`		*/
		$Title = "TERCER JUZGADO DE FALTAS - CEDULAS QUE SALIERON DEL JUZGADO Y AUN NO REGRESAN";
	break;
	
}
$pdf=new MyPDF('L', 'mm', 'A4');
$pdf->SetMargins(25,25,8);
$pdf->AddPage();
$pdf->SetFont('Courier','',8);
$pdf->SetTextColor( 0, 0, 0);
$pdf->SetFillColor(255,255,255);
for( $x = 0, $xcant = count( $Data); $x < $xcant; $x ++){
	$pdf->Cell( 20, 6, $Data[$x][1], 1, 0, 'L', 1);
	$pdf->Cell( 75, 6, strtoupper(utf8_decode($Data[$x][3])), 1, 0, 'L', 1);
	$pdf->Cell( 25, 6, $Data[$x][4], 1, 0, 'L', 1);
	$pdf->Cell(107, 6, strtoupper(utf8_decode($Data[$x][7])), 1, 0, 'C', 1);
	$pdf->Cell( 35, 6, $Data[$x][6], 1, 0, 'C', 1);
	$pdf->Cell( 10, 5, "", 0, 1, 'L', 1);
}
$pdf->Output();
?>