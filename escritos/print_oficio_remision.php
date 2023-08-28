<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/v1.php";
require_once "../../model/class_escritos_cedula.php";
$Datos = isset($_GET['id'])? trim( $_GET['id']): 0;
$Datos = Cedula::getDatos($Datos);
/* - - - - - - - */
$Parrafos = array();
$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'AL SR. JEFE';
$Parrafos[] = 'POLICIA DE SAN JUAN';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '                   Me dirijo a Ud., a fin de remitir CEDULAS DE NOTIFICACION por causas que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, para que sean diligenciadas por esa repartición.-';
$Parrafos[] = '                   Solicito se entreguen copia de la cedula al notificador y remita a este juzgado el original que a continuación se detallan.-';
$Parrafos[] = '     EXPED Nº		APELLIDO Y NOMBRE';
$Parrafos[] = '                   Le saludo muy atentamente.-';
/* - - - - - - - */
$pdf = new FPDF();
$pdf->SetMargins( 38, 38, 14);
$pdf->AddPage();
$pdf->SetFont( "Courier", "BU", 12);
$pdf->MultiCell( 0, 5, $Parrafos[0], 0, 'C');
$pdf->MultiCell( 0, 4, "", 0, 'J');
$pdf->SetFont( "Courier", "", 12);
$pdf->MultiCell( 0, 6, $Parrafos[1], 0, 'R');
$pdf->MultiCell( 0, 4, "", 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[2], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[3], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[4], 0, 'L');
$pdf->MultiCell( 0, 4, "",0,'J');
$pdf->MultiCell( 0, 6, $Parrafos[5], 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[6], 0, 'J');
$pdf->MultiCell( 0, 4, "",0,'J');
$pdf->SetFont( "Courier", "B", 10);
$pdf->MultiCell( 0, 6, $Parrafos[7], 0, 'L');
$pdf->SetFont( "Courier", "", 10);
for( $j = 0; $j < count( $Datos); $j ++){
	$pdf->MultiCell( 0, 6, "     ".$Datos[$j][0]."-C   ".strtoupper( $Datos[$j][1]), 0, 'L');
}
$pdf->SetFont( "Courier", "", 12);
$pdf->MultiCell( 0, 4, "", 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[8], 0, 'C');
$File = "Oficio_remision_".date('Ymd_his').".pdf";
$pdf->Output( "../../files/$File" , 'F');
$pdf->Output( "$File" , 'I');
?>