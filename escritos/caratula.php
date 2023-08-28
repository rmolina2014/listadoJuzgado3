<?php
error_reporting( 0);
chdir( "..");
require_once "../controller/session_seguridad.php";
require_once "../model/expedientes.php";
$Id_expediente = isset($_GET['Id']) ? trim( $_GET['Id']) : 0;
$Datos = Expedientes::get( $Id_expediente, $_SESSION["JmZj07_juzgado"], $_SESSION["JmZj07_id"], 0);
/* ----- */
$Opcion = '3';
//$Id_expediente = $Datos['idExp'];
require_once "../controller/actualiza_certeza.php";
/* ----- */

require_once "print/TCPDF/tcpdf.php";
class MYPDF extends TCPDF {
	public function Header(){
		global $Code;
		$style = array('align'=>'C', 'stretch'=>false, 'fitwidth'=>true, 'border'=>true, 'hpadding'=>'auto', 'vpadding'=>'auto', 'fgcolor'=>array(0,0,0));
		$this->SetXY(145,15);
		$this->write1DBarcode( $Code, 'EAN13', '', '', '', 15, 0.4, $style, 'N');
	}
	public function Footer(){
	}
}
/* ----- */
$aux = (string) $Datos['autos'];
switch( strlen( $aux)){
	case 1: $aux = '000000' . $aux; break;
	case 2: $aux = '00000' . $aux; break;
	case 3: $aux = '0000' . $aux; break;
	case 4: $aux = '000' . $aux; break;
	case 5: $aux = '00' . $aux; break;
	case 6: $aux = '0' . $aux; break;
	case 7: $aux = $aux; break;
}
$Code = $_SESSION["JmZj07_juzgado"]."0100".$aux;
/* ----- */
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetAuthor('Tercer Juzgado de Faltas');
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
/* ----- */
$pdf->SetFont('Courier','BU',14);
$html = '<span style="text-align:center;">JUZGADO DE FALTAS DE TERCERA NOMINACION</span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$pdf->SetFont('Courier','',14);
$html = '<span style="text-align:left;">TIPO DE EXPEDIENTE: <b>'.$Datos['tipo'].'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$html = '<span style="text-align:left;">AUTOS N&deg;: <b>'.$Datos['autos'].'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$html = '<span style="text-align:left;">CARATULADOS: <b>'.$Datos['caratula'].'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$html = '<span style="text-align:left;">LEYES: <b>'.Expedientes::getLeyPrint( $Id_expediente).'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$html = '<span style="text-align:left;">PROCEDENCIA: <b>'.$Datos['reparticion'].'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$html = '<span style="text-align:left;">ACTA N&deg;: <b>'.$Datos['numero_origen'].'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$html = '<span style="text-align:left;">FECHA DE ACTA: <b>'.$Datos['fecha_origen'].'</b></span>';
$pdf->writeHTML( $html, true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
$pdf->writeHTML( '<span></span>', true, false, true, false);
/* ----- */
$pdf->Output();
?>