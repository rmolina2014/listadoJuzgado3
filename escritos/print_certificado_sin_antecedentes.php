<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/_ccore.php";

$tipoDocumento	= isset($_GET['tipoDocumento']) ? trim( $_GET['tipoDocumento']) : "";
$documento =	isset($_GET['documento']) ? trim( $_GET['documento']) : "";
$nombre =		isset($_GET['nombre']) ? trim( $_GET['nombre']) : "";

$ENC1 =         isset($_GET['ENC1']) ? trim( $_GET['ENC1']) : "";
$ENC2 =         isset($_GET['ENC2']) ? trim( $_GET['ENC2']) : "";
$ENC3 =         isset($_GET['ENC3']) ? trim( $_GET['ENC3']) : "";
$ENC4 =         isset($_GET['ENC4']) ? trim( $_GET['ENC4']) : "";

$encabezados =0;
for($i = 1 ; $i<5; $i++){
	if(${'ENC'.$i} != ""){
		$encabezados++;
	}
}
$Replace = array($ENC1,$ENC2,$ENC3,$ENC4,$nombre, $documento);

for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}

$Search = array('#ENC1','#ENC2','#ENC3','#ENC4','#PERSONA','#DNIPERSONA');
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = ' #ENC1';
$Parrafos[] = ' #ENC2';
$Parrafos[] = ' #ENC3';
$Parrafos[] = ' #ENC4';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '���������������Tengo el agrado de dirigirme a usted,  a fin de comunicarle que en este Juzgado  el/la Sr./a. #PERSONA M.I.N� #DNIPERSONA; no posee causa; adem�s no registra antecedentes ni orden de detenci�n. Todo ello sin perjuicio de otros pedidos de captura que pudiere tener proveniente de otro Juzgado. -  ';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
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

switch($encabezados){
	case 1 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;
	case 2 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[2],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;	
	case 3 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[2],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[3],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;	
	case 4 :
		$pdf->SetFont('Courier','BU',12);
		$pdf->MultiCell(0,5, $Parrafos[0],0,'C');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->SetFont('Courier','',12);
		$pdf->MultiCell(0,5, $Parrafos[1],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[2],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[3],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[4],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		$pdf->MultiCell(0,5, $Parrafos[5],0,'L');
		$pdf->MultiCell(0,2, '',0,'J');
		break;	
}		
		
	$pdf->MultiCell(0,5, $Parrafos[6],0,'J');
	$pdf->MultiCell(0,2, '',0,'J');	
	$pdf->MultiCell(0,2, '',0,'J');
	$pdf->MultiCell(0,5, $Parrafos[7],0,'R');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();


// require_once "fpdf/fpdf.php";
// require_once "../../controller/v1.php";
// require_once "../../model/class_escritos_cedula.php";
// $Datos = isset($_GET['id'])? trim( $_GET['id']): 0;
// $Datos = Cedula::getDatos($Datos);
// /* - - - - - - - */
// $Parrafos = array();
// $Parrafos[] = 'OFICIO';
// $Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
// $Parrafos[] = 'AL SR. JEFE';
// $Parrafos[] = 'POLICIA DE SAN JUAN';
// $Parrafos[] = 'S--------/--------D';
// $Parrafos[] = '�������������������Me dirijo a Ud., a fin de remitir CEDULAS DE NOTIFICACION por causas que se tramitan por ante este Juzgado de Faltas de Tercera Nominaci�n, para que sean diligenciadas por esa repartici�n.-';
// $Parrafos[] = '�������������������Solicito se entreguen copia de la cedula al notificador y remita a este juzgado el original que a continuaci�n se detallan.-';
// $Parrafos[] = '�����EXPED N�		APELLIDO Y NOMBRE';
// $Parrafos[] = '�������������������Le saludo muy atentamente.-';
// /* - - - - - - - */
// $pdf = new FPDF();
// $pdf->SetMargins( 38, 38, 14);
// $pdf->AddPage();
// $pdf->SetFont( "Courier", "BU", 12);
// $pdf->MultiCell( 0, 5, $Parrafos[0], 0, 'C');
// $pdf->MultiCell( 0, 4, "", 0, 'J');
// $pdf->SetFont( "Courier", "", 12);
// $pdf->MultiCell( 0, 6, $Parrafos[1], 0, 'R');
// $pdf->MultiCell( 0, 4, "", 0, 'J');
// $pdf->MultiCell( 0, 6, $Parrafos[2], 0, 'L');
// $pdf->MultiCell( 0, 6, $Parrafos[3], 0, 'L');
// $pdf->MultiCell( 0, 6, $Parrafos[4], 0, 'L');
// $pdf->MultiCell( 0, 4, "",0,'J');
// $pdf->MultiCell( 0, 6, $Parrafos[5], 0, 'J');
// $pdf->MultiCell( 0, 6, $Parrafos[6], 0, 'J');
// $pdf->MultiCell( 0, 4, "",0,'J');
// $pdf->SetFont( "Courier", "B", 10);
// $pdf->MultiCell( 0, 6, $Parrafos[7], 0, 'L');
// $pdf->SetFont( "Courier", "", 10);
// for( $j = 0; $j < count( $Datos); $j ++){
	// $pdf->MultiCell( 0, 6, "�����".$Datos[$j][0]."-C   ".strtoupper( $Datos[$j][1]), 0, 'L');
// }
// $pdf->SetFont( "Courier", "", 12);
// $pdf->MultiCell( 0, 4, "", 0, 'J');
// $pdf->MultiCell( 0, 6, $Parrafos[8], 0, 'C');
// $File = "Oficio_remision_".date('Ymd_his').".pdf";
// $pdf->Output( "../../files/$File" , 'F');
// $pdf->Output( "$File" , 'I');
?>