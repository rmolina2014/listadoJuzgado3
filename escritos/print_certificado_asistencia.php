<?php
require('fpdf/fpdf.php');
require "../../controller/v1.php";
require("../../model/class_expediente.php");
//require("../../model/class_escritos.php");

$Replace = expediente::getInfoPrint( $_GET['CAMPO_AUTOS'], $_GET['CAMPO_PERSONA']);

array_push( $Replace, $_GET['DESDEH'], $_GET['HASTAH']);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#ACTA','#DESDEH','#HASTAH');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Parrafos = array();
$Parrafos[] = 'CERTIFICO: Que en Autos Nº#AUTOS-C c/#CARATULA. que el/la Sr/a. #NOMBRE #DNI con domicilio en: #DOMICILIO, ha comparecido en el día de la fecha ante el Tercer Juzgado de Faltas de la Provincia de San Juan, de #DESDEH hs. a #HASTAH hs. ';
$Parrafos[] = 'SAN JUAN, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';

$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

for( $x = 0; $x < 1 ; $x ++){ 
	$Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}

$plus = ' -';
for( $x = 0; $x < 1; $x ++){
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
	//		SI  SE  PASA  UN  PLUS  HACIA  ABAJO  HAY  QUE  DISMINUIR  EL  VALOR  154.93  DE  A  UN  CENTECIMO!
}

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

	$pdf->MultiCell(0,8, $Parrafos[0],0,'J');
	$pdf->MultiCell(0,8, '',0,'J');
	$pdf->MultiCell(0,6, $Parrafos[1],0,'R');


$pdf->Output();
?>