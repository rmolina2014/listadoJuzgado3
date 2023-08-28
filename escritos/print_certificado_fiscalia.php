<?php
require('fpdf/fpdf.php');
require "../../controller/v1.php";
require("../../model/class_expediente.php");

//	Montos de la multa
$DEUDALETRA = strtoupper( DoubleToString( $_GET['DEUDA']));
// fecha autos
$f=expediente::getStringDatosBasicos( $_GET['AUTOS']);
$res = explode('&',$f);
$res2= $res[0];
$res3= explode('=',$res2);
$AUTOSF=$res3[1];
 
$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);
array_push( $Replace, $DEUDALETRA,$_GET['DEUDA'],$_GET['FECHA'],$AUTOSF,$_GET['NROCUENTA'],$_GET['CUENTA']);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      1
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#ACTA','#DEUDALETRA','#DEUDA','#FECHANOTIFICACION','#FAUTOS','#NROCUENTA','#CUENTA');
$Parrafos = array();
$Parrafos[] = 'INFORME DE SECRETARIA ';
$Parrafos[] = 'Autos Nº#AUTOS de fecha: #FAUTOS';
$Parrafos[] = 'INFORMO A V.S.: Que el Sr/a. #NOMBRE #DNI, domiciliado en calle #DOMICILIO, adeuda a la Pcia. de San Juan, la suma de #DEUDALETRA ($#DEUDA), en concepto de multa impuesta dictada en Autos nº #AUTOS-C caratulados c/#CARATULA- que tramitan por ante el Tercer juzgado de Faltas por infracción al #CAMPO_LEY  - Código de Faltas de fecha #FECHAACTA, de la que fue notificado el infractor el día #FECHANOTIFICACION, estando firme la resolución.-';
$Parrafos[] = '- - - No encontrándose acreditado el pago de la multa en Autos, corresponde emitir el certificado de ejecucion y remitirse a Fiscalia.-';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'. Atento el informe que antecede, emítase Certificado de ejecución y multa y remítase a Fiscalia de Estado conforme lo dispuesto por el Art. 20 de la Ley LP-941-R-';

$xcant = count( $Parrafos);
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

for( $x = 0; $x < $xcant; $x ++){ 
   $Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x=2; $x < 6; $x++){
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
$pdf->MultiCell(0,2, $Parrafos[1],0,'C');
$pdf->MultiCell(0,10, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[2],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[3],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[4],0,'J');
$pdf->MultiCell(0,23, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[5],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      2
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
$pdf->MultiCell(0,8, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,2, $Parrafos[1],0,'C');
$pdf->MultiCell(0,10, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[2],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[3],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[4],0,'J');
$pdf->MultiCell(0,23, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos[5],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      3     
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Parrafos2 = array();
$Parrafos2[] = 'CERTIFICADO DE EJECUCIÓN DE MULTA';
$Parrafos2[] = 'CERTIFICO que el Sr/a. #NOMBRE #DNI, domiciliado en calle #DOMICILIO, adeuda a la Pcia. de San Juan, la suma de #DEUDALETRA ($#DEUDA), en concepto de multa impuesta dictada en Autos nº #AUTOS-C caratulados c/#CARATULA- que tramitan por ante el Tercer juzgado de Faltas por infracción al #CAMPO_LEY  - Código de Faltas de fecha #FECHAACTA, de la que fue notificado el infractor el día #FECHANOTIFICACION, estando firme la resolución.-';
$Parrafos2[] = '- - - - A la fecha no se ha acreditado el pago en Autos. Dicho monto deberá ser depositado en Banco San Juan, en la cuenta nº #NROCUENTA #CUENTA según el artículo nº 21 de la Ley LP-941-R.-';
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$xcant2 = count( $Parrafos2);
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

for( $x = 0; $x < $xcant2; $x ++){ 
   $Parrafos2[$x] = str_replace( $Search, $Replace, $Parrafos2[$x]);
}
$plus = ' -';
for( $x = 1; $x < 4; $x++){
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

$pdf->SetMargins(38,38,14);
//$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos2[0],0,'C');
$pdf->MultiCell(0,18, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,9, $Parrafos2[1],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos2[2],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos2[3],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      4
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,5, $Parrafos2[0],0,'C');
$pdf->MultiCell(0,18, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,9, $Parrafos2[1],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,9, $Parrafos2[2],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos2[3],0,'J');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();
?>