<?php
/* revisar todo el archivo */
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_expediente.php";

$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);

// necesito el apellido del dueño del can
$array = explode( ',', $Replace[5]);
$FAMILIADELCAN = $array[0];

array_push( $Replace,$_GET['OFECHA'],$_GET['OHORA'],$_GET['ODESCR'],$FAMILIADELCAN);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}

// - - - - - - - - - - - - - - - - - - - - - -

$Search=array('#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#NROACTA'
,'#FECHACCID','#HS','#DESCRIP','#FAMILIADELCAN');

$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'Al Jefe de Epidemiología';
$Parrafos[] = 'Ministerio de Salud Pública';
$Parrafos[] = 'Gobierno de San Juan';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '                   Me dirijo a Ud. A fin de comunicarle que en Autos Nº #AUTOS-C c/#CARATULA- Falta al 170 Art. de la Ley LP-941-R - Código de Faltas - Acta Nº #NROACTA de fecha #FECHAACTA, que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, se ha dictado la siguiente providencia en los autos del epígrafe: “San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'. Avocado al conocimiento de la presente causa, y como medida de mejor proveer se oficie al Jefe de Epidemiología del Ministerio de Salud Pública, para que tome conocimiento que el día #FECHACCID a las #HShs, #DESCRIP. El/la propietario/a del can sería la familia #FAMILIADELCAN domiciliado en: #DOMICILIO; debiendo tomar los recaudos necesarios del caso.- Fdo. Dr. Enrique Gerónimo Mattar-Juez del Tercer Juzgado de Faltas-Dra. Adriana Corral de Lobos -Secretaria Letrada.-"';
$Parrafos[] = '                   Para llevar a cabo esta medida se deberá labrar acta con noticia al Juzgado actuante.-';
$Parrafos[] = '                   Sin otro particular le saluda a Ud. atentamente.-';

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
$pdf->MultiCell(0,6, $Parrafos[5],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[7],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[8],0,'J');

$pdf->SetMargins(38,38,14);
$pdf->AddPage();
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
$pdf->MultiCell(0,6, $Parrafos[5],0,'L');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[6],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[7],0,'J');
$pdf->MultiCell(0,1, '',0,'J');
$pdf->MultiCell(0,6, $Parrafos[8],0,'J');

// - - - - - - - - - - - - - - - - - - - - - -

$Parrafos2 = array();
$Parrafos2[] = '“San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.- Avocado al conocimiento de la presente causa, y como medida de mejor proveer se oficie al Jefe de Epidemiología del Ministerio de Salud Pública, para que tome conocimiento que el día #FECHACCID a las #HShs, #DESCRIP. El/la propietario/a del can sería la Familia #FAMILIADELCAN domiciliado en: #DOMICILIO; debiendo tomar los recaudos necesarios del caso.- .-';
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
	}// si se pasa un plus hacia abajo hay que disminuir el valor 154.93 de a un centecimo!
}
$pdf->MultiCell(0,6, $Parrafos2[0],0,'J');
// $pdf->AddPage();
// $pdf->MultiCell(0,6, $Parrafos2[0],0,'J');

// - - - - - - - - - - - - - - - - - - - - - -

$pdf->Output();
?>