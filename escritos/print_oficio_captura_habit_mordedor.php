<?php
/* revisar todo el archivo */
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_expediente.php";
$Replace = expediente::getInfoPrint( $_GET['AUTOS'], $_GET['PERSONA']);
// necesito el apellido del dueño del can
$array= array();
$array = explode( ',', $Replace[5]);
$FAMILIADELCAN = $array[0];
array_push( $Replace,$_GET['CCM1'],$_GET['CCM2'],$_GET['CCM3']);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
// - - - - - - - - - - - - - - - - - - - - - -
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#NROACTA','#DESCRIPCION','#LUGAR','#DIRECCION');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'Al Jefe de Epidemiología';
$Parrafos[] = 'Ministerio de Salud Pública';
$Parrafos[] = 'Gobierno de San Juan';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Me dirijo a usted, en Autos Nº #AUTOS-C c/#CARATULA - Falta al 170 de la Ley LP-941-R - Código de Faltas- Acta Nº #NROACTA- Fecha #FECHAACTA, que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, a fin de comunicarle que se ha dictado la siguiente resolución: “San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.- Ofíciese al Ministerio de Salud Pública para que proceda a determinar la peligrosidad del can al parecer #DESCRIPCION, que habitaría el/la “#LUGAR” ubicada/o en: #DIRECCION. Dicho operativo deberá realizarse con personal especializado de los existentes en dicho organismo y con la colaboración de la Policía de la Provincia (art. 21 de la Ley 6.535) y realizada la determinación de peligrosidad se proceda a su captura, y puestos bajo inspección veterinaria por el término legal (Art. 8 de la Ley 6.535). Todo con noticia a éste Juzgado al que se le proveerá igualmente informe de médico veterinario del estado sanitario del can: vacunación; identificación; esterilización y especialmente su peligrosidad por exhibir hábito mordedor o enfermedad infecto contagiosas. Comprobada su peligrosidad, deberá proceder de conformidad a lo establecido en el art. 8 del Dec. Nº 1937-69. Córrase vista de la totalidad de las actuaciones al Ministerio de Salud Pública- División Epidemiología (Decreto 0556-SESP-96) poniéndose en Secretaria de este Juzgado y a su disposición el Expediente de marras”.-';
$Parrafos[] = 'Diligenciado el presente, sírvase remitirlo al juzgado de origen.-';
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
// - - - - - - - - - - - - - - - - - - - - - -
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
$pdf->MultiCell(0,6, $Parrafos[8],0,'R');
// - - - - - - - - - - - - - - - - - - - - - -
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
$pdf->MultiCell(0,6, $Parrafos[8],0,'R');
// - - - - - - - - - - - - - - - - - - - - - -
$Parrafos2 = array();
$Parrafos2[] = '“San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.- Ofíciese al Ministerio de Salud Pública para que proceda a determinar la peligrosidad del can al parecer #DESCRIPCION, que habitaría el/la “#LUGAR” ubicada/o en: #DIRECCION. Dicho operativo deberá realizarse con personal especializado de los existentes en dicho organismo y con la colaboración de la Policía de la Provincia (art. 21 de la Ley 6.535) y realizada la determinación de peligrosidad se proceda a su captura, y puestos bajo inspección veterinaria por el término legal (Art. 8 de la Ley 6.535). Todo con noticia a éste Juzgado al que se le proveerá igualmente informe de médico veterinario del estado sanitario del can: vacunación; identificación; esterilización y especialmente su peligrosidad por exhibir hábito mordedor o enfermedad infecto contagiosas. Comprobada su peligrosidad, deberá proceder de conformidad a lo establecido en el art. 8 del Dec. Nº 1937-69. Córrase vista de la totalidad de las actuaciones al Ministerio de Salud Pública- División Epidemiología (Decreto 0556-SESP-96) poniéndose en Secretaria de este Juzgado y a su disposición el Expediente de marras"';
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
// - - - - - - - - - - - - - - - - - - - - - -
// $pdf->AddPage();
// $pdf->MultiCell(0,6, $Parrafos2[0],0,'J');
$pdf->Output();
?>