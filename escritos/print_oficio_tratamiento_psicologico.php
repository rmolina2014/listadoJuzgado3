<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_expediente.php";
$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
// - - - - - - - - - - - - - - - - - - - - - -
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#NROACTA','#FOJA','#FECHA','#ART1','#ART2');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'MINISTERIO DE DESARROLLO HUMANO';
$Parrafos[] = 'DIVISION ASISTENCIA';
$Parrafos[] = 'LIC. SONIA ESQUIVEL';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Me dirijo a Ud. en mi carácter de titular del Juzgado de Faltas de Tercera Nominación, en Autos Nº#AUTOS-C c/#CARATULA- por presunta inf. al 98-99-143 de la LP-941-R - Código de Faltas - Acta Nº #NROACTA de fecha #FECHAACTA, que se tramitan ante el Juzgado a mi cargo, a fin de comunicarle que el Juez que entiende en la causa, ha resuelto: “San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'. INTIMESE al Sr/a. #NOMBRE; ha emprender tratamiento psicológico en establecimiento asistencia público y a acreditarlo ante este Juzgado.- Fdo. Dr. Enrique Gerónimo Mattar-Juez del Tercer Juzgado de Faltas-Dra. Adriana Corral de Lobos -Secretaria Letrada.-"';
$xcant = count( $Parrafos);
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
// - - - - - - - - - - - - - - - - - - - - - -
for( $x = 0; $x < $xcant; $x ++){ 
   $Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 6; $x < 7; $x++){
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
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'R');
$pdf->MultiCell(0,4, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[5],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[6],0,'J');
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'R');
$pdf->MultiCell(0,4, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[5],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[6],0,'J');
// - - - - - - - - - - - - - - - - - - - - - -
$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos2[] = 'En Autos Nº#AUTOS-C c/#CARATULA, INTIMESE al Sr/a. #NOMBRE; ha emprender tratamiento psicológico en establecimiento asistencia público y a acreditarlo ante este Juzgado.-';
$Parrafos2[] = 'Notifíquese en el momento de ejecutarse.-';
$xcant2 = count( $Parrafos2);
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
// - - - - - - - - - - - - - - - - - - - - - -
for( $x = 0; $x < $xcant2; $x ++){ 
   $Parrafos2[$x] = str_replace( $Search, $Replace, $Parrafos2[$x]);
}
$plus = ' -';
for( $x = 0; $x < 3; $x++){
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
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->MultiCell(0,7, $Parrafos2[0],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos2[1],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos2[2],0,'J');
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->Output();
?>