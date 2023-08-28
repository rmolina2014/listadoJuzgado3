<?php
// error_reporting(0);
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
		if( $year = date("Y")){
			if( $mon >= date("m")){
				if( $mon = date("m")){
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
/*Lote*/{
	$Id_plan[0] = 21799; $Id_cuota[0] = 1; $Font[0] = 'helvetica';
	$Id_plan[1] = 21686; $Id_cuota[1] = 1; $Font[1] = 'helvetica';
	$Id_plan[2] = 21797; $Id_cuota[2] = 1; $Font[2] = 'helvetica';
	$Id_plan[3] = 21796; $Id_cuota[3] = 1; $Font[3] = 'helvetica';
	$Id_plan[4] = 21795; $Id_cuota[4] = 1; $Font[4] = 'helvetica';
	$Id_plan[5] = 21607; $Id_cuota[5] = 1; $Font[5] = 'helvetica';
	$Id_plan[6] = 21454; $Id_cuota[6] = 1; $Font[6] = 'helvetica';
	$Id_plan[7] = 21333; $Id_cuota[7] = 1; $Font[7] = 'helvetica';
	$Id_plan[8] = 21300; $Id_cuota[8] = 1; $Font[8] = 'helvetica';
	$Id_plan[9] = 20879; $Id_cuota[9] = 1; $Font[9] = 'helvetica';
	$Id_plan[10] = 19713; $Id_cuota[10] = 1; $Font[10] = 'helvetica';
	$Id_plan[11] = 18180; $Id_cuota[11] = 1; $Font[11] = 'helvetica';
	$Id_plan[12] = 18001; $Id_cuota[12] = 1; $Font[12] = 'helvetica';
	$Id_plan[13] = 17398; $Id_cuota[13] = 1; $Font[13] = 'helvetica';
	$Id_plan[14] = 17967; $Id_cuota[14] = 1; $Font[14] = 'helvetica';
	$Id_plan[15] = 9439; $Id_cuota[15] = 1; $Font[15] = 'helvetica';
	$Id_plan[16] = 21799; $Id_cuota[16] = 1; $Font[16] = 'courier';
	$Id_plan[17] = 21686; $Id_cuota[17] = 1; $Font[17] = 'courier';
	$Id_plan[18] = 21797; $Id_cuota[18] = 1; $Font[18] = 'courier';
	$Id_plan[19] = 21796; $Id_cuota[19] = 1; $Font[19] = 'courier';
	$Id_plan[20] = 21795; $Id_cuota[20] = 1; $Font[20] = 'courier';
	$Id_plan[21] = 21607; $Id_cuota[21] = 1; $Font[21] = 'courier';
	$Id_plan[22] = 21454; $Id_cuota[22] = 1; $Font[22] = 'courier';
	$Id_plan[23] = 21333; $Id_cuota[23] = 1; $Font[23] = 'courier';
	$Id_plan[24] = 21300; $Id_cuota[24] = 1; $Font[24] = 'courier';
	$Id_plan[25] = 20879; $Id_cuota[25] = 1; $Font[25] = 'courier';
	$Id_plan[26] = 19713; $Id_cuota[26] = 1; $Font[26] = 'courier';
	$Id_plan[27] = 18180; $Id_cuota[27] = 1; $Font[27] = 'courier';
	$Id_plan[28] = 18001; $Id_cuota[28] = 1; $Font[28] = 'courier';
	$Id_plan[29] = 17398; $Id_cuota[29] = 1; $Font[29] = 'courier';
	$Id_plan[30] = 17967; $Id_cuota[30] = 1; $Font[30] = 'courier';
	$Id_plan[31] = 9439; $Id_cuota[31] = 1; $Font[31] = 'courier';
	$Id_plan[32] = 21799; $Id_cuota[32] = 1; $Font[32] = 0;
	$Id_plan[33] = 21686; $Id_cuota[33] = 1; $Font[33] = 0;
	$Id_plan[34] = 21797; $Id_cuota[34] = 1; $Font[34] = 0;
	$Id_plan[35] = 21796; $Id_cuota[35] = 1; $Font[35] = 0;
	$Id_plan[36] = 21795; $Id_cuota[36] = 1; $Font[36] = 0;
	$Id_plan[37] = 21607; $Id_cuota[37] = 1; $Font[37] = 0;
	$Id_plan[38] = 21454; $Id_cuota[38] = 1; $Font[38] = 0;
	$Id_plan[39] = 21333; $Id_cuota[39] = 1; $Font[39] = 0;
	$Id_plan[40] = 21300; $Id_cuota[40] = 1; $Font[40] = 0;
	$Id_plan[41] = 20879; $Id_cuota[41] = 1; $Font[41] = 0;
	$Id_plan[42] = 19713; $Id_cuota[42] = 1; $Font[42] = 0;
	$Id_plan[43] = 18180; $Id_cuota[43] = 1; $Font[43] = 0;
	$Id_plan[44] = 18001; $Id_cuota[44] = 1; $Font[44] = 0;
	$Id_plan[45] = 17398; $Id_cuota[45] = 1; $Font[45] = 0;
	$Id_plan[46] = 17967; $Id_cuota[46] = 1; $Font[46] = 0;
	$Id_plan[47] = 9439; $Id_cuota[47] = 1; $Font[47] = 0;
	$Id_plan[48] = 21799; $Id_cuota[48] = 1; $Font[48] = 1;
	$Id_plan[49] = 21686; $Id_cuota[49] = 1; $Font[49] = 1;
	$Id_plan[50] = 21797; $Id_cuota[50] = 1; $Font[50] = 1;
	$Id_plan[51] = 21796; $Id_cuota[51] = 1; $Font[51] = 1;
	$Id_plan[52] = 21795; $Id_cuota[52] = 1; $Font[52] = 1;
	$Id_plan[53] = 21607; $Id_cuota[53] = 1; $Font[53] = 1;
	$Id_plan[54] = 21454; $Id_cuota[54] = 1; $Font[54] = 1;
	$Id_plan[55] = 21333; $Id_cuota[55] = 1; $Font[55] = 1;
	$Id_plan[56] = 21300; $Id_cuota[56] = 1; $Font[56] = 1;
	$Id_plan[57] = 20879; $Id_cuota[57] = 1; $Font[57] = 1;
	$Id_plan[58] = 19713; $Id_cuota[58] = 1; $Font[58] = 1;
	$Id_plan[59] = 18180; $Id_cuota[59] = 1; $Font[59] = 1;
	$Id_plan[60] = 18001; $Id_cuota[60] = 1; $Font[60] = 1;
	$Id_plan[61] = 17398; $Id_cuota[61] = 1; $Font[61] = 1;
	$Id_plan[62] = 17967; $Id_cuota[62] = 1; $Font[62] = 1;
	$Id_plan[63] = 9439; $Id_cuota[63] = 1; $Font[63] = 1;
}
$c = count( $Id_plan);
for( $i = 0; $i < $c; $i++){
	$Plan = Planes_pago::get( $Id_plan[$i]);
	$Cuota = Cuotas::get( $Id_plan[$i], $Id_cuota[$i]);
	$Escrito = Escritos::get( $Plan['sentencia']);
	$Actores = Actuaciones::get( $Escrito['actor']);
	$Expediente = Expedientes::get( $Actores['expediente'], $_SESSION["JmZj07_juzgado"], $_SESSION["JmZj07_login"], 0);
	$Persona = Personas::getPorId( $Actores['persona']);
	$Datos[$i]['autos'] = $Expediente['autos'];
	$Datos[$i]['acta'] = $Expediente['numero_origen'];
	$Datos[$i]['actor'] = $Escrito['actor'];
	$Datos[$i]['fecha_acta']= $Expediente['fecha_origen'];
	$Datos[$i]['cuenta'] = $Escrito['cuenta'];
	$Datos[$i]['multa1'] = $Cuota['monto_1'];
	$Datos[$i]['multa2'] = $Cuota['monto_2'];
	$Datos[$i]['fecha1'] = $Cuota['vencimiento_1'];
	$Datos[$i]['fecha2']= $Cuota['vencimiento_2'];
	$Datos[$i]['detalle'] = "Cuota ".$Cuota['cuota']." de ".$Plan['cuotas'];
	$Datos[$i]['titulo'] = $Escrito['nombre_cuenta'];
	$Datos[$i]['persona'] = $Persona['apellido'].", ".$Persona['nombre'];
	/* ----- */
	if( isVencida( $Datos['fecha1'])){
		$Datos['fecha1'] = date('d/m/Y');
		$Datos['fecha2']= sumaDia( $Datos['fecha1'], 7);
	}
}
/* ----- */
$color_black = new FColor( 0, 0, 0);
$color_white = new FColor( 255, 255, 255);
$pdf = new MYPDF();
$pdf->SetMargins(12,12,10);
/* ----- */
for( $i = 0; $i < $c; $i++){
	if(( $i % 9) == 0){
		$pdf->AddPage();
	}
	$pdf->SetFont( "helvetica", "", 8);
	/* ----- */
	$pdf->Cell( 120, 3, $Datos[$i]['titulo']." - Cuenta N".utf8_encode( "º").$Datos[$i]['cuenta']." - Letra ".$Font[$i], 0, 1);
	$pdf->Cell( 60, 3, utf8_encode( strtoupper( substr( $Datos[$i]['persona'], 0, 42))), 0, 1);
	// $pdf->Cell( 60, 3, "JF3 - Autos N".utf8_encode( "º").$Datos[$i]['autos']." - Acta N".utf8_encode( "º").$Datos[$i]['acta'], 0, 1);
	$pdf->Cell( 60, 3, "JF3 - Autos N".utf8_encode( "º").$Datos[$i]['autos']." - Acta N".utf8_encode( "º").$Datos[$i]['actor'], 0, 1);
	$pdf->Cell( 60, 3, 'Importe 1 '.$Datos[$i]['multa1'].' - Vencimiento '.$Datos[$i]['fecha1'], 0, 1);
	$pdf->Cell( 60, 3, 'Importe 2 '.$Datos[$i]['multa2'].' - Vencimiento '.$Datos[$i]['fecha2'], 0, 1);
	/* ----- */
	$code = paramCode( $Datos[$i]['actor'], $Datos[$i]['autos'], $Datos[$i]['fecha1'], $Datos[$i]['multa1'], $Datos[$i]['fecha2'], $Datos[$i]['multa2'], $Datos[$i]['cuenta']);
	$icode = new i25( 50, $color_black, $color_white, 2, $code, $Font[$i]);
	$drawing = new FDrawing( "barcode.$i.png", $color_white);
	$drawing->setBarcode( $icode);
	$drawing->draw();
	$drawing->finish( IMG_FORMAT_PNG);
	/* ----- */
	$pdf->Image( "barcode.$i.png", 85, 17 + (30 * ($i % 9)), 107, 10);
	$pdf->SetFont( "helvetica", '', 10);
	$pdf->SetXY( 87, 27 + (30 * ($i % 9)));
	$pdf->Cell( 0, 4, $code, '', 1);
	/* ----- */
	$pdf->Ln(10);
	$pdf->Rect( 10, 10 + (($i % 9) * 30), 186 , 25);
}
/* ----- */
$pdf->Output();
?>