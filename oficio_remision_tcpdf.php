<?php
error_reporting(0);
require_once "../../controller/session_seguridad.php";
require_once "../../controller/_ccore.php";
require_once "../../model/cedulas.php";
require_once "TCPDF/tcpdf.php";
$Datos = isset($_GET['id'])? trim( $_GET['id']): 0;
$Datos = Cedulas::getParaEnviar( $_SESSION["JmZj07_juzgado"], $Datos);
/* - - - - - - - */
$Parrafos = array();
$Parrafos[0] = 'OFICIO';
$Parrafos[1] = 'San Juan, '.date('d').' de '.write_month( date('m')).' de '.date('Y').'.-';
$Parrafos[2] = 'AL SR. JEFE';
$Parrafos[3] = 'POLICIA DE SAN JUAN';
$Parrafos[4] = 'S--------/--------D';
$Parrafos[5] = '                   Me dirijo a Ud., a fin de remitir CEDULAS DE NOTIFICACION por causas que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, para que sean diligenciadas por esa repartición.-';
$Parrafos[6] = '                   Solicito se entreguen copia de la cedula al notificador y remita a este juzgado el original que a continuación se detallan.-';
$Parrafos[7] = '     EXPED Nº		APELLIDO Y NOMBRE';
$Parrafos[8] = '                   Le saludo muy atentamente.-';
/* - - - - - - - */
class MYPDF extends TCPDF {
	public function Header(){
	}
	public function Footer(){
	}
}
/* - - - - - - - */
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetAuthor('Tercer Juzgado de Faltas');
$pdf->startPageGroup();
$pdf->SetMargins( 40, 40, 15);
$pdf->SetAutoPageBreak( true, 15);
$pdf->setPrintFooter( false);
$pdf->AddPage();
$pdf->SetFont( "Courier", "BU", 12);
$pdf->writeHTML( utf8_encode($Parrafos[0]), true, false, true, false, "C");
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->SetFont( "Courier", "", 12);
$pdf->writeHTML( utf8_encode($Parrafos[1]), true, false, true, false, "R");
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( utf8_encode($Parrafos[2]), true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( utf8_encode($Parrafos[3]), true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( utf8_encode($Parrafos[4]), true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);

$pdf->writeHTML( '<div style="text-align:justify;line-height:150%;">'.utf8_encode($Parrafos[5]).'</div>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<div style="text-align:justify;line-height:150%;">'.utf8_encode($Parrafos[6]).'</div>', true, false, true, false);

$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->SetFont( "Courier", "B", 10);
$pdf->writeHTML( utf8_encode($Parrafos[7]), true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
for( $j = 0; $j < count( $Datos); $j ++){
	$pdf->writeHTML( utf8_encode("     ").$Datos[$j]->autos."-C".utf8_encode("   ").strtoupper( $Datos[$j]->persona), true, false, true, false);
	$pdf->writeHTML( '<span></span>', true, false, true, false);
}
$pdf->SetFont( "Courier", "", 12);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( utf8_encode($Parrafos[8]), true, false, true, false);
$pdf->Output( "Oficio_remision_".date('Ymd_his').".pdf" , 'I');
?>