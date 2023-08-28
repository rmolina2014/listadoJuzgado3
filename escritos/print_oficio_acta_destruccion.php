<?php
/* revisar todo el archivo */
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_secuestro.php";
require_once "../../model/class_expediente.php";
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$Datos = Secuestro::getSecuestrosPorAutos($_GET['AUTOS']);
$TCheck = $_GET['TODOS'];
$Check = explode( ".", $TCheck);
$Strng = "";
for( $j = 0, $Size = count($Datos); $j < $Size; $j++){
	if( in_array( $Datos[$j][6], $Check)){
		$Strng .= $Datos[$j][7];
	}
}
$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);
array_push( $Replace, $Strng);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#ACTA','#STRING');
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos2[] = 'En Autos Nº#AUTOS-C c/#CARATULA, Por falta al 156 INC. 3 de la Ley LP-941-R - Código de Faltas; se procede a la destrucción de el/os elementos secuestrados, esto es: #STRING en presencia del Sr. Enrique G. Mattar- Juez del Juzgado de Faltas de Tercera Nominación- Sra. Adriana Corral de Lobos – Secretaria Letrada.-'.$elejidos;
$xcant2 = count( $Parrafos2);
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
for( $x = 0; $x < $xcant2; $x ++){ 
   $Parrafos2[$x] = str_replace( $Search, $Replace, $Parrafos2[$x]);
}
$plus = ' -';
for( $x = 0; $x < 2; $x++){
	$palabras = explode(' ', $Parrafos2[$x]);
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
		$Parrafos2[$x] .= $plus;
	}
	//		SI  SE  PASA  UN  PLUS  HACIA  ABAJO  HAY  QUE  DISMINUIR  EL  VALOR  154.93  DE  A  UN  CENTECIMO!
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$pdf->MultiCell(0,7, $Parrafos2[0],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos2[1],0,'J');
$pdf->Output();
?>