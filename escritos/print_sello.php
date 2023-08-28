<?php
error_reporting( 0);
require_once "../../controller/session_seguridad.php";
require_once "../../model/escritos.php";
require_once "../../model/actuaciones.php";
require_once "../../model/expedientes.php";
require_once "../../model/personas.php";
require_once "../../model/protocolos.php";
require_once "TCPDF/tcpdf.php";
// ---------------------------------------------------------
class MYPDF extends TCPDF {
	public function Header(){
	}
	public function Footer(){
	}
}
// ---------------------------------------------------------
$Ids = isset($_GET['sid'])? strip_tags( trim( $_GET['sid'])): 0;
$Ids = explode( ",", $Ids);
// ---------------------------------------------------------
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetAuthor('Tercer Juzgado de Faltas');
$Proto = 0;/* eligió protocolizar */
$Sello = 0;
// ---------------------------------------------------------
for( $i = 0, $cant = max( count( $Ids), 2) - 1; $i < $cant; $i ++){
	$Escrito = Escritos::get( $Ids[$i]);		
	$Actor = Actuaciones::get( $Escrito['actor']);	
	$Expediente = Expedientes::get( $Actor['expediente'], $_SESSION["JmZj07_juzgado"], $_SESSION["JmZj07_id"]);
	$Persona = Personas::getPorId( $Actor['persona']);
	/* ----- */
	$pdf->startPageGroup();
	$pdf->SetMargins( 40, 40, 15);
	$pdf->SetAutoPageBreak( true, 10);
	$pdf->setPrintFooter( false);
	$pdf->AddPage();
	$pdf->SetBooklet( true, 40, 15);
	
	if( !$Proto){
		$AP = Protocolos::get( $Ids[$i]);
		if( is_array( $AP)){
			$pdf->Image( "../imagen/folio.png", 167, 5, 30 , 0, 'PNG');
			$pdf->SetXY( 175, 20);
			$pdf->SetFont( 'Courier', 'B', 12);
			$pdf->Cell( 15,0, $AP['folio']);
			$Proto = 1;
			$pdf->SetXY( 40, 40);
		}
	}else{ $Sello = 1;}
	// -----------------
	if( $Sello){
		if( is_array( $AP)){
			$mm = $pdf->getMargins();
			if( $mm['left'] == 40){
				$pdf->setXY(33,40);
				$pdf->StartTransform();
				$pdf->Rotate(-90);
				$pdf->SetFont('Courier','B',9);
				$tmp = "AUTOS Nº".$Expediente['autos']." - ACTA Nº".$Expediente['numero_origen']." - CARÁTULA C/".$Expediente['caratula']." - IMPUTADO:".$Persona['apellido'].", ".$Persona['nombre'];
				$pdf->Cell( 0, 5, substr( $tmp, 0, 128),0, 1, 'L');
				$pdf->setX(33);
				$pdf->Cell( 0, 5, "PROTOCOLIZADO EN TOMO:".$AP['letra']." - FOLIO:".$AP['folio']." (Del ".$AP['folio'].' al '.$AP['folio'].") - DEL LIBRO ".$AP['nombre']." - EN FECHA:".$AP['fecha'],0, 1, 'L');
				$pdf->StopTransform();
				$pdf->Rect( 20, 35, 15, 244);
			}else{
				$pdf->setXY(193,40);
				$pdf->StartTransform();
				$pdf->Rotate(-90);
				$pdf->SetFont('Courier','B',9); 
				$pdf->Cell( 0, 5, "AUTOS Nº".$Expediente['autos']." - ACTA Nº".$Expediente['numero_origen']." - CARÁTULA C/".$Expediente['caratula']." - IMPUTADO:".$Persona['apellido'].", ".$Persona['nombre'],0, 1, 'L');
				$pdf->setX(193);
				$pdf->Cell( 0, 5, "PROTOCOLIZADO EN TOMO:".$AP['letra']." - FOLIO:".$AP['folio']." (Del ".$AP['folio'].' al '.$AP['folio'].") - DEL LIBRO ".$AP['nombre']." - EN FECHA:".$AP['fecha'],0, 1, 'L');
				$pdf->StopTransform();
				$pdf->Rect( 180, 35, 15, 240);
			}
		}
		$Proto = 0;
	}
}
/* --------------------------------------------------------------------------------- */
$pdf->Output('protocolo.pdf', 'I');
?>