<?php
/* revisar todo el archivo */
require('fpdf/fpdf.php');
require "../../controller/v1.php";
require("../../model/class_expediente.php");

$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);

for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      1
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#NROACTA');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'AL SR. JEFE DE LA POLICIA';
$Parrafos[] = 'DE LA PROVINCIA DE SAN JUAN';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Me dirijo a Ud. A fin de comunicarle que en Autos Nº #AUTOS-C c/#CARATULA, por Falta al Art. 113 inc. 02 de la Ley LP-941-R- Expte. Contravencional Nº #NROACTA de fecha #FECHAACTA que se tramitan por ante este Juzgado, a fin de solicitarle SE REMITA LA PLANILLA PRONTUARIAL del Sr/Sra: #NOMBRE - #DNI, con Domicilio en: #DOMICILIO".- Fdo. Dr. Enrique Gerónimo Mattar-Juez del Tercer Juzgado de Faltas-Dra. Adriana Corral de Lobos -Secretaria Letrada.-';
$Parrafos[] = 'Sin otro particular le saluda a Ud. atentamente.-';

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

$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'R');
$pdf->MultiCell(0,5, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[5],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'R');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      2
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$pdf->SetMargins(38,38,14);
$pdf->AddPage();$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'R');
$pdf->MultiCell(0,5, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[5],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'R');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      3     
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.- En Autos Nº #AUTOS-C c/#CARATULA, por Falta al Art. 109-113 de la Ley LP-941-R- Expte. Contravencional Nº #NROACTA- Fecha #FECHAACTA, que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, a fin de solicitarle se remita la planilla prontuarial de el/la Sr./a #NOMBRE, #DNI , con domicilio en: #DOMICILIO.”-';
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

$pdf->MultiCell(0,6, $Parrafos2[0],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();
?>