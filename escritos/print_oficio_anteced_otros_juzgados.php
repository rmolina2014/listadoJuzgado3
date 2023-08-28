<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_expediente.php";
$ENC1 = isset($_GET['HEAD_1'])? trim( strtoupper( $_GET['HEAD_1'])): "";
$ENC2 = isset($_GET['HEAD_2'])? trim( strtoupper( $_GET['HEAD_2'])): "";
$ENC3 = isset($_GET['HEAD_3'])? trim( strtoupper( $_GET['HEAD_3'])): "";
$ENC4 = isset($_GET['HEAD_4'])? trim( strtoupper( $_GET['HEAD_4'])): "";
$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);
array_push( $Replace,$ENC1,$ENC2,$ENC3,$ENC4);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
// - - - - - - - - - - - - - - - - - - - - - -
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#NROACTA','#ENC1','#ENC2','#ENC3','#ENC4');
$Parrafos = array();
$Parrafos[] = "OFICIO";
$Parrafos[] = "San Juan, ".date(d)." de ".write_month( date(m))." de ".date(Y).".-";
$Parrafos[] = "#ENC1";
$Parrafos[] = "#ENC2";
$Parrafos[] = "#ENC3";
$Parrafos[] = "#ENC4";
$Parrafos[] = "S--------/--------D";
$Parrafos[] = "               Tengo el agrado de dirigirme al Señor Juez en Autos Nº #AUTOS-C c/#CARATULA - FALTA ART. 109-113 DE LA LEY LP-941-R, en trámite por ante este Juzgado de Faltas de Tercera Nominación, a fin de peticionarle quiera tener a bien disponer lo pertinente para que nos informe si en su Juzgado a cargo se tramita causa y/o posee antecedentes contra el/la Sr/a. #NOMBRE.-";
$Parrafos[] = "Sin otro motivo, saludo al Sr. Juez con distinguida consideración.-";
$xcant = count( $Parrafos);
// - - - - - - - - - - - - - - - - - - - - - -
$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
for( $x = 0; $x < $xcant; $x ++){ 
   $Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 7; $x < 9; $x++){
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
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
if( $ENC2 != ""){ $pdf->MultiCell(0,2, '',0,'J');$pdf->MultiCell(0,6, $Parrafos[3],0,'L');}
if( $ENC3 != ""){ $pdf->MultiCell(0,2, '',0,'J');$pdf->MultiCell(0,6, $Parrafos[4],0,'L');}
if( $ENC4 != ""){ $pdf->MultiCell(0,2, '',0,'J');$pdf->MultiCell(0,6, $Parrafos[5],0,'L');}
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[7],0,'J');
$pdf->MultiCell(0,2, '',0,'J');	
$pdf->MultiCell(0,6, $Parrafos[8],0,'R');
$pdf->AddPage();
$pdf->SetFont('Courier','BU',12);
$pdf->MultiCell(0,6, $Parrafos[0],0,'C');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell(0,6, $Parrafos[1],0,'R');
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[2],0,'L');
$pdf->MultiCell(0,2, '',0,'J');
if( $ENC2 != ""){ $pdf->MultiCell(0,2, '',0,'J');$pdf->MultiCell(0,6, $Parrafos[3],0,'L');}
if( $ENC3 != ""){ $pdf->MultiCell(0,2, '',0,'J');$pdf->MultiCell(0,6, $Parrafos[4],0,'L');}
if( $ENC4 != ""){ $pdf->MultiCell(0,2, '',0,'J');$pdf->MultiCell(0,6, $Parrafos[5],0,'L');}
$pdf->MultiCell(0,2, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[7],0,'J');
$pdf->MultiCell(0,2, '',0,'J');	
$pdf->MultiCell(0,6, $Parrafos[8],0,'R');
// - - - - - - - - - - - - - - - - - - - - - -
$pdf->Output();
?>