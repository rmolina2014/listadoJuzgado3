<?php
/* revisar todo el archivo */

require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_expediente.php";

$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);

for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      1
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#NROACTA','#FOJA','#FECHA','#ART1','#ART2');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'AL SR. JEFE';
$Parrafos[] = 'DEFRAUDACIONES Y ESTAFAS';
$Parrafos[] = 'POLICIA DE SAN JUAN';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Me dirijo a Ud. en mi carácter de titular del Juzgado de Faltas de Tercera Nominación, en Autos Nº#AUTOS-C c/#CARATULA- por presunta inf. al #CAMPO_LEY - según consta en Acta Nº #NROACTA de fecha #FECHAACTA, que se tramitan ante el Juzgado a mi cargo, a fin de comunicarle que el Juez que entiende en la causa, ha resuelto: “San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).' AUTOS VISTOS:… Y CONSIDERANDO:… RESUELVO: CONDENAR al Sr.: #NOMBRE, #DNI, con domicilio sito en: #DOMICILIO, por infracción al #CAMPO_LEY – Código de Faltas; por el término de TRES (03) días, la que deberá cumplir en el domicilio del infractor, conforme lo prevé el Art. 34 Inc. 2 del Código de Faltas de la Provincia. Procédase a través de la Jefatura de Policía de San Juan a hacer efectivo el arresto del contraventor en su domicilio y adopte las medidas necesarias de vigilancia para dar cumplimiento a lo ordenado por la resolución. Se deja expresamente aclarado que la presente sentencia es apelable, conforme lo dispuesto por los Art. 87 y 88 siguientes de la Ley LP-941-R del Código de Faltas de la Provincia.-" Fdo. Dr. Enrique Gerónimo Mattar - Juez del Tercer Juzgado de Faltas - Dra. Adriana Corral de Lobos - Secretaria Letrada.-';
$xcant = count( $Parrafos);
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

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

$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'R');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[5],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[6],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      2
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'R');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[3],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[4],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[5],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[6],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      3     
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos2[] = 'En Autos Nº#AUTOS-C c/#CARATULA, Resuelvo condenar al Sr.: #NOMBRE, #DNI, con domicilio sito en: #DOMICILIO, por infracción al Art. 195 de la Ley LP-941-R – Código de Faltas; por el término de TRES (03) días, la que deberá cumplir en el domicilio del infractor, conforme lo prevé el Art. 34 Inc. 2 del Código de Faltas de la provincia. Procédase a través de la Jefatura de Policía de San Juan hacer efectivo el arresto del contraventor en su domicilio y que adopte las medidas necesarias de vigilancia para dar cumplimiento a lo ordenado por la resolución.-Se deja expresamente aclarado que, la presente sentencia es apelable, conforme lo dispuesto por los Art. 87 y 88 siguientes de la Ley LP-941-R del Código de Faltas de la Provincia.-';
$Parrafos2[] = 'Notifíquese en el momento de ejecutarse.-';
$xcant2 = count( $Parrafos2);
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

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

$pdf->MultiCell(0,7, $Parrafos2[0],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos2[1],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos2[2],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();
?>