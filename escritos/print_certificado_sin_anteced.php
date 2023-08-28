<?php
require('fpdf/fpdf.php');
require "../../controller/v1.php";
require("../../model/class_expediente.php");  

$NuevaPersona = isset($_GET['PERSONA']) ? trim( $_GET['PERSONA']) : "";
$NuevoDNI =     isset($_GET['DNI']) ? trim( $_GET['DNI']) : "";
$ENC1 =         isset($_GET['ENC1']) ? trim( $_GET['ENC1']) : "";
$ENC2 =         isset($_GET['ENC2']) ? trim( $_GET['ENC2']) : "";
$ENC3 =         isset($_GET['ENC3']) ? trim( $_GET['ENC3']) : "";
$ENC4 =         isset($_GET['ENC4']) ? trim( $_GET['ENC4']) : "";

$encabezados =0;
for($i = 1 ; $i<5; $i++){
	if(${'ENC'.$i} != ""){
		$encabezados++;
	}
}
$Replace = array($ENC1,$ENC2,$ENC3,$ENC4,$NuevaPersona, $NuevoDNI);

for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}

$Search = array('#ENC1','#ENC2','#ENC3','#ENC4','#PERSONA','#DNIPERSONA');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = ' #ENC1';
$Parrafos[] = ' #ENC2';
$Parrafos[] = ' #ENC3';
$Parrafos[] = ' #ENC4';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Tengo el agrado de dirigirme a usted,  a fin de comunicarle que en este Juzgado  el/la Sr./a. #PERSONA M.I.Nº #DNIPERSONA; no posee causa; además no registra antecedentes ni orden de detención. Todo ello sin perjuicio de otros pedidos de captura que pudiere tener proveniente de otro Juzgado. -  ';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$xcant = count( $Parrafos);
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

for( $x = 0; $x < $xcant; $x ++){ 
   $Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 6; $x < 8; $x++){
	$palabras = explode(' ', $Parrafos[$x]);
	for( $i = 0, $cant = count( $palabras); $i < $cant; $i ++){
		$linea = $palabras[$i];
		while(( $pdf->GetStringWidth( $linea) < 154.95) and ($i < $cant)){
			$i++;
			$linea .= ' '.$palabras[$i];
		}
		if( $i < $cant){
			$i--;
		}
	}
	for( $i = 0, $cant = ((154.93 - $pdf->GetStringWidth( $linea)) / 5.08); $i < $cant; $i++){
		$Parrafos[$x] .= $plus;
	}
			//SI  SE  PASA  UN  PLUS  HACIA  ABAJO  HAY  QUE  DISMINUIR  EL  VALOR  154.93  DE  A  UN  CENTECIMO!
}

switch($encabezados){
	case 1 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;
	case 2 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[2],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;	
	case 3 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[2],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[3],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;	
	case 4 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[2],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[3],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[4],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;	
}		
		
	$pdf->MultiCell(0,5, $Parrafos[6],0,'J');
	$pdf->MultiCell(0,2, '',0,'J');	
	$pdf->MultiCell(0,2, '',0,'J');
	$pdf->MultiCell(0,5, $Parrafos[7],0,'R');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();
?>