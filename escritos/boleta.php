<?php
error_reporting(0);
require_once "../../controller/session_seguridad.php";
require_once "../../controller/_ccore.php";
require_once "../../model/planes_pago.php";
require_once "../../model/cuotas.php";
require_once "../../model/escritos.php";
require_once "../../model/actuaciones.php";
require_once "../../model/expedientes.php";
require_once "../../model/cuentas.php";
require_once "../../model/personas.php";
require_once "TCPDF/tcpdf.php";
require_once "Barcode/index.php";
require_once "Barcode/Font.php";
require_once "Barcode/FColor.php";
require_once "Barcode/BarCode.php";
require_once "Barcode/FDrawing.php";
require_once "Barcode/i25.barcode.php";
/* ----- */
function sumaDia( $fecha, $dia){
	list( $day, $mon, $year) = explode( '/', $fecha);
	return date( 'd/m/Y', mktime( 0, 0, 0, $mon, $day+$dia, $year));		
}
function isVencida( $fecha){
	list( $day, $mon, $year) = explode( '/', $fecha);
	if( $year >= date("Y")){
		if( $year == date("Y")){
			if( $mon >= date("m")){
				if( $mon == date("m")){
					if( $day >= date("d")){
						return false;
					}else{
						return true;
					}
				}else{
					return false;
				}
			}else{
				return true;
			}
		}else{
			return false;
		}
	}else{
		return true;
	}
}
/* ----- */
class MYPDF extends TCPDF {
	public function Header(){}
	public function Footer(){}
}
/* ----- */
$Id_plan = isset($_GET['p'])? trim( $_GET['p']): 0;
$Id_cuota = isset($_GET['c'])? trim( $_GET['c']): 0;
if($Id_plan && $Id_cuota){
	$Plan = Planes_pago::get( $Id_plan);
	$Cuota = Cuotas::get( $Id_plan, $Id_cuota);
	$Escrito = Escritos::get( $Plan['sentencia']);
	$Actores = Actuaciones::get( $Escrito['actor']);
	$Expediente = Expedientes::get( $Actores['expediente'], $_SESSION["JmZj07_juzgado"], $_SESSION["JmZj07_id"], 0);
	$Persona = Personas::getPorId( $Actores['persona']);
	$Datos['autos'] = $Expediente['autos'];
	$Datos['acta'] = $Expediente['numero_origen'];
	$Datos['actor'] = $Escrito['actor'];
	$Datos['fecha_acta']= $Expediente['fecha_origen'];
	$Datos['cuenta'] = $Escrito['cuenta'];
	$Datos['multa1'] = $Cuota['monto_1'];
	$Datos['multa2'] = $Cuota['monto_2'];
	$Datos['fecha1'] = $Cuota['vencimiento_1'];
	$Datos['fecha2']= $Cuota['vencimiento_2'];
	$Datos['detalle'] = "Cuota ".$Cuota['cuota']." de ".$Plan['cuotas'];
	$Datos['estado'] = $Actores['estado'];
	$Datos['titulo'] = $Escrito['nombre_cuenta'];
	$Datos['persona'] = $Persona['apellido'].", ".$Persona['nombre'];
}else{
	$Id_expediente = isset($_GET['e'])? trim( $_GET['e']): 0;
	$Expediente = Expedientes::get( $Id_expediente, $_SESSION["JmZj07_juzgado"], $_SESSION["JmZj07_id"], 0);
	$Datos['autos'] = $Expediente['autos'];
	$Datos['acta'] = $Expediente['numero_origen'];
	$Datos['actor'] = isset($_GET['a'])? trim( $_GET['a']): 0;
	$Datos['fecha_acta']= $Expediente['fecha_origen'];
	$Datos['cuenta'] = isset($_GET['d'])? trim( $_GET['d']): 0;
	$Datos['multa1'] = isset($_GET['m'])? floatval( trim( $_GET['m'])): 0;
	$Datos['multa2'] = $Datos['multa1'] + 0.1;
	$Datos['fecha1'] = isset($_GET['f'])? trim( $_GET['f']): 0;
	$Datos['fecha2']= sumaDia( $Datos['fecha1'], 7);
	$Datos['detalle'] = "Boleta Libre";
	$Cuenta = Cuentas::getByNumber( $Datos['cuenta']);
	$Actores = Actuaciones::get( $Datos['actor']);
	$Persona = Personas::getPorId( $Actores['persona']);
	$Datos['titulo'] = $Cuenta['nombre'];
	$Datos['persona'] = $Persona['apellido'].", ".$Persona['nombre'];
	$Datos['estado'] = $Actores['estado'];;
}
$Datos['usuario'] = $_SESSION["JmZj07_login"];
switch( $_SESSION["JmZj07_juzgado"]){
	case 3: $Datos['juzgado'] = utf8_encode( "JUZGADO DE FALTAS TERCERA NOMINACIÓN");
}
/* ----- */
if( isVencida( $Datos['fecha1'])){
	$Datos['fecha1'] = date('d/m/Y');
	$Datos['fecha2']= sumaDia( $Datos['fecha1'], 7);
}
/* ----- */
$code = paramCode( $Datos['actor'], $Datos['autos'], $Datos['fecha1'], $Datos['multa1'], $Datos['fecha2'], $Datos['multa2'], $Datos['cuenta']);
$color_black = new FColor( 0, 0, 0);
$color_white = new FColor( 255, 255, 255);
$icode = new i25( 50, $color_black, $color_white, 2, $code, 0);
$drawing = new FDrawing( 'barcode_'.$_SESSION["JmZj07_id"].'.png', $color_white);
$drawing->setBarcode( $icode);
$drawing->draw();
$drawing->finish( IMG_FORMAT_PNG);
/* ----- */
$pdf = new MYPDF();
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$Ft = 'helvetica';
$He = 5;
/* ----- */
for( $i = 0; $i < 3; $i++){
	$De = 10 + 86 * $i;
	//		Titulo
	$pdf->SetFont( 'helvetica', 'B', 10);
	$pdf->SetXY( 10, $De + 10);
	$pdf->Cell( 0, 5, utf8_encode( "CONTRAVENCIÓN - ").$Datos['titulo'], 'LTRB', 0, 'C', false);
	//		Sucursal y número de cuenta
	$pdf->SetFont( 'helvetica', '', 8);
	$pdf->SetXY( 10, $De + 15);
	$pdf->Cell( 60, 5, utf8_encode( 'Sucursal Nº600'), 'LTRB', 0, 'L', false);
	$pdf->SetXY( 10, $De + 20);
	$pdf->Cell( 60, 5, utf8_encode( 'Nota de crédito para cuenta Nº'.$Datos['cuenta']), 'LTRB', 0, 'L', false);
	//		Logo de seguridad
	//$pdf->Image( 'sello.png', 85, $De + 18, 41, 8);
	//		Titular
	$pdf->SetFontSize( 8);
	$pdf->SetXY( 140, $De + 15);
	$pdf->Cell( 10, 5,'Titular:', 'LTB', 1, 'L', false);
	$pdf->SetFont( 'helvetica', 'B', 8);
	$pdf->SetXY( 150, $De + 15);
	$pdf->Cell( 50, 5,'GOBIERNO DE SAN JUAN', 'TRB', 1, 'L', false);
	//		Ente recaudador
	$pdf->SetFont( 'helvetica', '', 8);
	$pdf->SetXY( 140, $De + 20);
	$pdf->Cell( 23, 5,'Ente recaudador:', 'LTB', 1, 'L', false);
	$pdf->SetFont( 'helvetica', 'B', 8);
	$pdf->SetXY( 163, $De + 20);
	$pdf->Cell( 37, 5,'Banco SAN JUAN', 'TRB', 0, 'L', false);
	//		Fecha
	$pdf->SetFont( 'helvetica', '', 8);
	$pdf->SetXY( 10, $De + 25);
	$pdf->Cell( 20, 5,'Lugar y Fecha:', 'L', 0, 'L', false);
	$pdf->SetFont( 'helvetica', 'BI', 8);
	$pdf->Cell( 170, 5,'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-', 'R', 0, 'L', false);
	//		Encabezado tabla
	$pdf->SetFont( 'helvetica', 'B', 7);
	$pdf->SetXY( 15, $De + 32);
	$pdf->Cell( 60, 5 - 1, $Datos['juzgado'], 'LBRT', 0, 'C', false);
	$pdf->Cell( 80, 5 - 1,'ARTICULO', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'UF', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'IMPORTE', 'LBRT', 0, 'C', false);
	//		Datos tabla
	$pdf->SetFont( 'helvetica', '', 7);
	$pdf->SetXY( 15, $De + 36);
	$pdf->Cell( 60, 5 - 1, utf8_encode( 'Autos Nº ').$Datos['autos'], 'LBRT', 0, 'L', false);
	$pdf->Cell( 80, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->SetXY( 15, $De + 40);
	$pdf->Cell( 60, 5 - 1, utf8_encode( 'Acta Nº ').$Datos['acta'].' - FECHA '.$Datos['fecha_acta'], 'LBRT', 0, 'L', false);
	$pdf->Cell( 80, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->SetXY( 15, $De + 44);
	$pdf->Cell( 60, 5 - 1,'Imputado '.utf8_encode( strtoupper( $Datos['persona'])), 'LBRT', 0, 'L', false);
	$pdf->Cell( 80, 5 - 1,utf8_encode( strtoupper( $Datos['detalle'])), 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->SetXY( 15, $De + 48);
	$pdf->Cell( 60, 5 - 1,'Usuario '.strtoupper( $Datos['usuario']), 'LBRT', 0, 'L', false);
	$pdf->Cell( 80, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->SetXY( 15, $De + 52);
	$pdf->Cell( 60, 5 - 1,'Estado '.utf8_encode( $Datos['estado']), 'LBRT', 0, 'L', false);
	$pdf->Cell( 80, 5 - 1,'Version 2019.07.17', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	$pdf->Cell( 20, 5 - 1,'', 'LBRT', 0, 'C', false);
	//		Recuadro de la boleta a la altura de la tabla
	$pdf->SetXY( 10, $De + 30);
	$pdf->Cell( 190, 28,'', 'LR');
	//		Pesos en letras y números
	$pdf->SetFont( 'helvetica', 'B', 8);
	$pdf->SetXY( 10, $De + 58);
	$pdf->Cell( 165, 5 - 1,'SON'.strtoupper( DoubleToString( $Datos ['multa1'])), 'LBRT', 0, 'L', false);
	$pdf->SetFillColor(240, 240, 240);
	$pdf->Cell( 25, 5 - 1,'TOTAL '.$Datos ['multa1'], 'LBRT', 1, 'R', true);
	//		Anuncio del juzgado
	$pdf->SetFont( 'helvetica', 'BI', 6);
	$pdf->SetXY( 20, $De + 63);
	$pdf->Cell( 170, 5 - 2, utf8_encode( 'ESTE COMPROBANTE DE PAGO DEBERÁ SER ACREDITADO ANTE EL JUZGADO Y SU IMPORTE SE ENCUENTRA SUJETO A REVISION POR PARTE DEL MISMO.'), '', 0, 'L', false);
	//		Recuadro final
	$pdf->SetXY( 10, $De + 62);
	$pdf->Cell( 190, (5 * 4 )+ 5,'', 'LBRT', 0, 'L', false);
	//		Importes y vencimientos
	$pdf->SetFont( 'helvetica', '', 7);
	$pdf->SetXY( 12, $De + 71);
	$pdf->Cell( 17, 5 - 1, 'Imp. principal', 'LBT', 0, 'L', false);
	$pdf->Cell( 12, 5 - 1, $Datos['multa1'], 'BRT', 0, 'L', false);
	$pdf->Cell( 15, 5 - 1, 'Vencimiento', 'LBT', 0, 'R', false);
	$pdf->Cell( 14, 5 - 1, $Datos['fecha1'], 'BRT', 0, 'L', false);
	$pdf->SetXY( 12, $De + 75);
	$pdf->Cell( 17, 5 - 1, 'Imp. c/recargo', 'LBT', 0, 'L', false);
	$pdf->Cell( 12, 5 - 1, $Datos['multa2'], 'BRT', 0, 'L', false);
	$pdf->Cell( 15, 5 - 1, 'Vencimiento', 'LBT', 0, 'R', false);
	$pdf->Cell( 14, 5 - 1, $Datos['fecha2'], 'BRT', 0, 'L', false);
	//		Codigo de barras
	$pdf->Image( 'barcode_'.$_SESSION["JmZj07_id"].'.png', 81, $De + 70, 107, 10);
	$pdf->SetFont( 'helvetica', '', 10);
	$pdf->SetXY( 83, $De + 82);
	$pdf->Cell( 0, 5 - 1, $code, '', 0, 'L', false);
}
/* ----- */
$pdf->SetFont( 'Courier', '', 10);
$pdf->SetXY( 5, 100);
$pdf->Cell( 0, 3,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', '', 1);
$pdf->SetXY( 5, 186);
$pdf->Cell( 0, 3,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', '', 1);
/* ----- */
$pdf->Output();
?>