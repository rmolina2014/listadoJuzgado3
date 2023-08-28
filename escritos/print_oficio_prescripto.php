<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_expediente.php";
$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);
$partes = explode( "/", $_GET['EM_FD']);
$dia = $partes[0];
$mes = $partes[1];
$año = $partes[2];
$LEY=array();
$LEY=expediente::getDatosLey( $_GET['CAMPO_AUTOS']);
$ARR = explode(" -",$LEY[0][0]);
if($ARR[0] == 'Ley LP-941-R'){
	$ANIOS = "1 año";
}else{
	$ANIOS = "2 años";
}
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
array_push( $Replace,$ANIOS);
// - - - - - - - - - - - - - - - - - - - - - -
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#ACTA','#ANIOS');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'AL SR. JEFE';
$Parrafos[] = 'DE LA POLICIA DE SAN JUAN';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Tengo el agrado de dirigirme a Ud. en Autos  Nº #AUTOS-C c/#CARATULA por infracción al #CAMPO_LEY, a fin de comunicarle que se ha dictado la siguiente resolución: “San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).' Habiendo trascurrido #ANIOS desde la expedición del oficio que ordena la comparencia por la fuerza publica del infractor, sin que ello se haya producido, la acción  contra el mismo ha prescripto y corresponde declararlo así, remitiendo oficio que deje sin efecto la orden de detención decretada en fecha '.$dia.' de '.write_month($mes).' de '.$año.' al Sr/Sra. #NOMBRE #DNI con domicilio en: #DOMICILIO en los autos arriba mencionado. Déjese copia en autos y archívese. ". Fdo  Abdo. Enrique G. Mattar- Juez de Faltas- Abda. Adriana Corral de Lobos- Secretaria.-';
$Parrafos[] = 'Sin otro particular le saluda a Ud. atentamente.-';
// - - - - - - - - - - - - - - - - - - - - - -
$xcant = count( $Parrafos);
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
for( $x = 0; $x < $xcant; $x ++){ 
   $Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 5; $x < 6; $x++){
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
$pdf->MultiCell(0,6, $Parrafos[0],0,'C');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,6, $Parrafos[1],0,'R');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[5],0,'J');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'R');
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,6, $Parrafos[0],0,'C');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,6, $Parrafos[1],0,'R');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[5],0,'J');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'R');
// - - - - - - - - - - - - - - - - - - - - - -
$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos2[] = 'En Autos Nº#AUTOS-C ACTA Nº#ACTA. Habiendo trascurrido #ANIOS desde la expedición del oficio que ordena la comparencia por la fuerza publica del infractor, sin que ello se haya producido, la acción contra el mismo ha prescripto y corresponde declararlo así, remitiendo oficio que deje sin efecto a la orden de detención de decretada en fecha '.$dia.' de '.write_month($mes).' de '.$año.' #NOMBRE #DNI en los autos arriba mencionado. Déjese copia en autos y archívese.-';
$xcant2 = count( $Parrafos2);
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
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
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->MultiCell(0,6, $Parrafos2[0],0,'J');
$pdf->MultiCell(0,4, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos2[1],0,'J');
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->Output();
?>