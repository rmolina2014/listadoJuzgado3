<?php
require('fpdf/fpdf.php');
require "../../controller/v1.php";
require("../../model/class_expediente.php");

class PDF extends FPDF{
	function TablaBasica($header, $Autos, $Deuda, $Dni, $Nombre){
		// Cabecera
		$this->SetFont('Courier','',10);
		$this->Cell( 16,7,$header[0],1,0,'C');
		$this->Cell( 20,7,$header[1],1,0,'C');
		$this->Cell( 23,7,$header[2],1,0,'C');
		$this->Cell( 100,7,$header[3],1,0,'C');
		$this->Ln();
		if(count($Autos) >0)
		{
			// Cuerpo
			$this->Ln(2);
			$this->SetFont('Courier','',9);
			for($j=0 ; $j<count($Autos) ; $j++){
				$this->Cell( 16,5,$Autos[$j],1,0,'R');
				$this->Cell( 20,5,$Deuda[$j],1,0,'R');
				$this->Cell( 23,5,$Dni[$j],1,0,'R');
				$this->Cell( 100,5,$Nombre[$j],1);
				$this->Ln();
			}
		}else{
			// Cuerpo
			$this->Ln(2);
			$this->SetFont('Courier','',9);
			$this->MultiCell( 159,5,"No se encontro deuda para ese numero de Autos.",1,'C');
		}
	}
	function Footer(){
		//Posición: a 1,5 cm del final
		$this->SetY(-10);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'R');
		//Posición: a 1,5 cm del final
		$this->SetY(-10);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,10,'Sistema de Expedientes Contravencionales',0,0,'C');
	}
}

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      1
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

session_start();

$Autos = array();      $Autos = $_SESSION['ArrayDatsAutos'];
$Deuda = array();      $Deuda = $_SESSION['ArrayDatsDeuda'];
$Dni = array();        $Dni = $_SESSION['ArrayDatsDni'];
$Nombre = array();     $Nombre = $_SESSION['ArrayDatsNombre'];

isset($_GET['filtro']) ?  $Filtro = trim( $_GET['filtro']) : $Filtro = 0;
isset($_GET['autos']) ?   $auto = trim( $_GET['autos']) : $auto = 0;

$Parrafos = array();
$Parrafos[] = '3º JUZGADO DE FALTAS';
if($Filtro == 1){
	$Parrafos[] = 'INFORME DE DEUDORES - Listado General al '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.';
}else{
	$Parrafos[] = 'INFORME DE DEUDORES - Autos Nº '.$auto.' - al '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.';
}	

$xcant = count( $Parrafos);
$pdf = new PDF();
$pdf->SetMargins(22,18,14);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,5, $Parrafos[1],0,'C');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->SetFont('Courier','',12);

$header=array('Expdte','Deuda','Dni','Nombre y Apellido');	
$pdf->TablaBasica($header, $Autos, $Deuda, $Dni, $Nombre);

if (isset($_SESSION['ArrayDatsAutos']))   unset($_SESSION['ArrayDatsAutos']);
if (isset($_SESSION['ArrayDatsDeuda']))   unset($_SESSION['ArrayDatsDeuda']);
if (isset($_SESSION['ArrayDatsDni']))     unset($_SESSION['ArrayDatsDni']);
if (isset($_SESSION['ArrayDatsNombre']))  unset($_SESSION['ArrayDatsNombre']);

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();
?>
