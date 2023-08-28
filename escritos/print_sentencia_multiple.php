<?php
require_once('doublesided.php');
require_once "../../controller/v1.php";
require_once("../../model/class_escritos_sentencia.php");
//require_once("../../model/class_escritos.php");
require_once("../../model/class_escritos_descargo.php");
require_once("../../model/class_expediente.php");
require_once("../../model/class_persona.php");
//require_once("../../model/class_trace.php");
require_once("../../controller/control_seguridad.php");

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

require('Goupil/index.php');
require('Goupil/Font.php');
require('Goupil/FColor.php');
require('Goupil/BarCode.php');
require('Goupil/FDrawing.php');
include('Goupil/i25.barcode.php');

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

$Autos        = isset($_GET['EM_AUTOS'])  ?       trim( $_GET['EM_AUTOS'])         : 0;
$Acta         = isset($_GET['EM_ACTA'])  ?        trim( $_GET['EM_ACTA'])          : 0;
$Facta        = isset($_GET['EM_FACTA'])  ?       trim( $_GET['EM_FACTA'])         : 0;
$Monto        = isset($_GET['EM_MONTOACTUAL'])?   trim( $_GET['EM_MONTOACTUAL'])   : 0;
$Cuenta       = isset($_GET['EM_DESTINOACTUAL'])? trim( $_GET['EM_DESTINOACTUAL']) : 0;
$Datos_boleta = isset($_GET['EM_BOLETA'])?        trim( $_GET['EM_BOLETA'])        : 0;
$Vencimiento1 = isset($_GET['EM_VENC1'])?         trim( $_GET['EM_VENC1'])         : 0;

$Array_personas = expediente::getDatosPersonas( $Autos, 1);
$Datos = array();
$elejidos = $_GET['eleccion'];
$string='';
$index = 0;

for( $j = 0; $j < count($Array_personas); $j++){
	if( in_array( $Array_personas[$j][8], $elejidos)){
		$Datos[$index]['Caracter'] = $Array_personas[$j][8];
		$Datos[$index]['Id_persona'] = $Array_personas[$j][6];
		$string.= $Array_personas[$j][1].'; ';
		$Datos[$index]['FojaDeclaracion'] = $_GET['EM_FOJA'.$j];
		if($_GET['REDECLARA'.$j]){
			// guardo la declaracion
			$Datos[$index]['Declaracion'] = utf8_decode($_GET['REDECLARA'.$j]);
			$descargo = new descargo( $Autos, $Datos[$index]['Id_persona'], 14);
			$descargo->guardar( 1, $_SESSION["contrav_usr_id"], $_GET['REDECLARA'.$j]);	
		}	
		else{
			// busco la declaracion en la DB
			$Datos[$index]['Declaracion'] = utf8_decode(descargo::getDeclaracion( $Datos[$index]['Caracter']));
		}
		$index ++;
	}
}
$CuentaNombre = sentencia::getNombreCuenta( $Cuenta);
$MONTOACTUAL_LETRA = strtoupper( DoubleToString( $Monto));
$JUS = ($Monto / 10);
if( $Monto > 100){
	$Tipo_escrito = 76;
}else{
	$Tipo_escrito = 61;
}
$string = "";
$string2 = "Condenar al ";

for( $i = 0; $i < count( $Datos); $i++){	
	$sentencia = new sentencia( $Autos, $Datos[$i]['Id_persona'], $Tipo_escrito);
	$IDSENTENCIA = $sentencia->guardar( 1, $_SESSION["contrav_usr_id"], $Datos[$i]['FojaDeclaracion'], $Monto, $Cuenta, "", "", "", "", "");
	$Aux = expediente::getInfoPrint( $Autos, $Datos[$i]['Id_persona']);
	$Datos[$i]['Nombre'] = utf8_decode($Aux[5]);
	$Datos[$i]['Documento'] = $Aux[6];
	$Datos[$i]['Domicilio'] = $Aux[7];
	$string .= "Sr./a. ".$Datos[$i]['Nombre']." ; ";
	$string2.= "Sr./a. ".$Datos[$i]['Nombre'].", ".$Datos[$i]['Documento']." con domicilio en: ".$Datos[$i]['Domicilio']." y al ";
}

$string = substr( $string, 0, -3).".";
$string2 = substr( $string2, 0, -6).".";
$Replace = expediente::getInfoPrint( $Autos, $Datos[0]['Id_persona']);
$Replace[3]=utf8_decode($Replace[3]);
$CuentaNombre=utf8_decode($CuentaNombre);
array_push( $Replace, $MONTOACTUAL_LETRA,$Monto,$Cuenta,$CuentaNombre,$JUS);
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#ACTA','#MONTOACTUAL_LETRA','#MONTOACTUAL','#NRODESTINOACTUAL','#DESTINOACTUAL','#JUS');

$Parrafos = array();
$Parrafos[] = 'SAN JUAN, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = '- - - -AUTOS Y VISTOS: Para resolver estos Autos Nº#AUTOS -C c/#CARATULA. Por presunta Inf. a #CAMPO_LEY - Código de Faltas.-';
$Parrafos[] = '- - - -Y CONSIDERANDO: Que del análisis del Acta Contravencional Nº #ACTA de fecha #FECHAACTA realizada por #REPARTICION contra el/la '.$string.' quienes habrían infringido el #CAMPO_LEY.-';
for( $h=0 ; $h<count($Datos) ; $h++){
	$Parrafos[] = '- - - -Oído que fuera el imputado a fs. '.$Datos[$h]['FojaDeclaracion'].' en cumplimiento Art. 76 del Código de Faltas, el/a Sr./a. '.$Datos[$h]['Nombre'].' quien manifiesta: "'.$Datos[$h]['Declaracion'].'".-';
}
$Parrafos[] = '- - - -FUNDAMENTO: De las constancias de Autos y declaración de los imputados, surge que habrían infringuido el #CAMPO_LEY.-';
$Parrafos[] = '- - - -Todo ello llevado al suscripto, de conformidad a las reglas de la sana crítica, al intimo convencimiento de que los medios de justificación acumulados con la denuncia son suficientes para tener por acreditada la falta, por lo que corresponde de conformidad al Art. 76, 80 y 81 de la ley LP-941-R, Código de Faltas de la Provincia, condenar a los imputados a pena de multa que deberán acreditar en Autos.-';
$Parrafos[] = '- - - -RESUELVO: I) '.$string2.' Por infracción al #CAMPO_LEY, a abonar cada uno, la suma de #MONTOACTUAL_LETRA ($#MONTOACTUAL) equivalente a #JUS JUS en concepto de multa la que deberán acreditar en Autos y ante este Juzgado dentro de los (5) días de notificada la presente mediante boleta de depósitos realizados en Banco San Juan; en la cuenta Nº 600-#NRODESTINOACTUAL - #DESTINOACTUAL. Si así no lo hiciera la multa será convertible en arresto, conforme lo determina el Art. 22 y 23 Ley LP-941-R Código de Faltas.-';
if($JUS > 10){
	$Parrafos[] = '- - - -II) La presente resolución es apelable, de conformidad al Art. 88 de la ley LP-941-R, debiendo el condenado según el Art. 89 de la Ley LP-941-R, interponer y fundar el recurso dentro de los cinco días de la notificación de la presente sentencia. Omitida tal formalidad y vencido el término señalado quedará firme la sentencia.-';
}
$Parrafos[] = 'Protocolícese, agréguese copia en Autos y notifíquese.-';

$xcant = count( $Parrafos);
$pdf = new DoubleSided_PDF();
$pdf->SetMargins(38,38,14);
$pdf->SetDoubleSided(38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
$pdf->SetAutoPageBreak( true, 10);

for( $x = 0; $x < $xcant; $x ++){ 
	$Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 0; $x < $xcant; $x ++){
	$palabras = explode(' ', $Parrafos[$x]);
	for( $j = 0, $cant = count( $palabras); $j < $cant; $j ++){
		$linea = $palabras[$j];
		while(( $pdf->GetStringWidth( $linea) < 154.95) and ($j < $cant)){
			$j++;
			$linea .= ' '.$palabras[$j];
		}
		if( $j < $cant){
			$j--;
		}
	}
	for( $j = 0, $cant = ((154.93 - $pdf->GetStringWidth( $linea)) / 5.08); $j < $cant; $j++){
		$Parrafos[$x] .= $plus;
	}
	//		SI  SE  PASA  UN  PLUS  HACIA  ABAJO  HAY  QUE  DISMINUIR  EL  VALOR  154.93  DE  A  UN  CENTECIMO!
}

// OFICIO - COPIA 1
for( $x = 0; $x < $xcant; $x ++){
	$pdf->MultiCell(0,7, $Parrafos[$x],0,'J');
}
$pdf->AddPage();

// OFICIO - COPIA 2
for( $x = 0; $x < $xcant; $x ++){
	$pdf->MultiCell(0,7, $Parrafos[$x],0,'J');
}

// BOLETA
if( $Datos_boleta == 'SI'){
	$Multa1 = $Monto;
	$Multa2 = $Multa1 + 0.1;
	function sumaDia( $fecha, $dia){
		list( $day, $mon, $year) = explode( '/', $fecha);
		return date( 'd/m/Y', mktime( 0, 0, 0, $mon, $day+$dia, $year));		
	}
	$Vencimiento2= sumaDia( $Vencimiento1, 7);
	$Descripcion = "Contravencion";
	$Estado = "Con sentencia";
	$Titulo = $CuentaNombre;

	isset($_GET['S__PANASEAMULTIPLE__USR'])  ?        $usr = trim( $_GET['S__PANASEAMULTIPLE__USR'])   : $usr = 0;
				
	for($i=0 ; $i<count($Datos) ; $i++){
		$Multa1 = floatval( $Multa1);
		$Multa2 = floatval( $Multa2);
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		$code = paramCode( $Acta, $Autos, $Vencimiento1, $Multa1, $Vencimiento2, $Multa2, $Cuenta);
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		$color_black =& new FColor( 0, 0, 0);
		$color_white =& new FColor( 255, 255, 255);
		$icode =& new i25( 50, $color_black, $color_white, 2, $code, $font);
		$drawing =& new FDrawing( 'amagen.png', $color_white);
		$drawing->setBarcode( $icode);
		$drawing->draw();
		$drawing->finish( IMG_FORMAT_PNG);
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		$pdf->SetMargins(10,10,10);
		$pdf->AddPage();
		$Ft = 'Arial';
		$He = 5;
		for( $j = 0; $j < 3; $j++){
			$De = 10 + 86 * $j;
			//		Titulo
			$pdf->SetFont( $Ft, 'B', 10);
			$pdf->SetXY( 10, $De + 10);
			$pdf->Cell( 0, $He,$Titulo, 'LTRB', 0, 'C', false);
			//		Sucursal y número de cuenta
			$pdf->SetFont( $Ft, '', 8);
			$pdf->SetXY( 10, $De + 15);
			$pdf->Cell( 60, $He,'Sucursal Nº 600', 'LTRB', 0, 'L', false);
			$pdf->SetXY( 10, $De + 20);
			$pdf->Cell( 60, $He,'Nota de crédito para cuenta Nº'.$Cuenta, 'LTRB', 0, 'L', false);
			//		Titular
			$pdf->SetFontSize( 8);
			$pdf->SetXY( 140, $De + 15);
			$pdf->Cell( 10, $He,'Titular:', 'LTB', 1, 'L', false);
			$pdf->SetFont( $Ft, 'B', 8);
			$pdf->SetXY( 150, $De + 15);
			$pdf->Cell( 50, $He,'GOBIERNO DE SAN JUAN', 'TRB', 1, 'L', false);
			//		Ente recaudador
			$pdf->SetFont( $Ft, '', 8);
			$pdf->SetXY( 140, $De + 20);
			$pdf->Cell( 25, $He,'Ente recaudador', 'LTB', 1, 'L', false);
			$pdf->SetFont( $Ft, 'B', 8);
			$pdf->SetXY( 165, $De + 20);
			$pdf->Cell( 35, $He,'Banco SAN JUAN', 'TRB', 0, 'L', false);
			//		Fecha
			$pdf->SetFont( $Ft, '', 8);
			$pdf->SetXY( 10, $De + 25);
			$pdf->Cell( 20, $He,'Lugar y Fecha:', 'L', 0, 'L', false);
			$pdf->SetFont( $Ft, 'BI', 8);
			$pdf->Cell( 170, $He,'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-', 'R', 0, 'L', false);
			//		Encabezado tabla
			$pdf->SetFont( $Ft, 'B', 7);
			$pdf->SetXY( 15, $De + 32);
			$pdf->Cell( 60, $He - 1,'TERCER JUZGADO DE FALTAS', 'LBRT', 0, 'C', false);
			$pdf->Cell( 80, $He - 1,'ARTICULO', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'UF', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'IMPORTE', 'LBRT', 0, 'C', false);
			//		Datos tabla
			$pdf->SetFont( $Ft, '', 7);
			$pdf->SetXY( 15, $De + 36);
			$pdf->Cell( 60, $He - 1,'Autos Nº '.$Autos, 'LBRT', 0, 'L', false);
			$pdf->Cell( 80, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->SetXY( 15, $De + 40);
			$pdf->Cell( 60, $He - 1,'Acta Nº '.$Acta.' - FECHA '.$Facta, 'LBRT', 0, 'L', false);
			$pdf->Cell( 80, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->SetXY( 15, $De + 44);
			$pdf->Cell( 60, $He - 1,'Imputado '.$Datos[$i]['Nombre'], 'LBRT', 0, 'L', false);
			$pdf->Cell( 80, $He - 1,'Proceso '.$Descripcion, 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->SetXY( 15, $De + 48);
			$pdf->Cell( 60, $He - 1,'Usuario '.strtoupper($_SESSION["contrav_usr_nombre"]), 'LBRT', 0, 'L', false);
			$pdf->Cell( 80, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->SetXY( 15, $De + 52);
			$pdf->Cell( 60, $He - 1,'Estado '.$Estado, 'LBRT', 0, 'L', false);
			$pdf->Cell( 80, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			$pdf->Cell( 20, $He - 1,'', 'LBRT', 0, 'C', false);
			//		Recuadro de la boleta a la altura de la tabla
			$pdf->SetXY( 10, $De + 30);
			$pdf->Cell( 190, 28,'', 'LR');
			//		Pesos en letras y números
			$pdf->SetFont( $Ft, 'B', 8);
			$pdf->SetXY( 10, $De + 58);
			$pdf->Cell( 165, $He - 1,'SON'.strtoupper( DoubleToString( $Multa1)), 'LBRT', 0, 'L', false);
			$pdf->SetFillColor(240, 240, 240);
			$pdf->Cell( 25, $He - 1,'TOTAL '.$Multa1, 'LBRT', 1, 'R', true);
			//		Anuncio del juzgado
			$pdf->SetFont( $Ft, 'BI', 6);
			$pdf->SetXY( 20, $De + 62);
			$pdf->Cell( 170, $He - 2,'ESTE COMPROBANTE DE PAGO DEBERÁ SER ACREDITADO ANTE EL JUZGADO Y SU IMPORTE SE ENCUENTRA SUJETO A REVISION POR PARTE DEL MISMO.', '', 0, 'L', false);
			//		Recuadro final
			$pdf->SetXY( 10, $De + 62);
			$pdf->Cell( 190, $He * 4,'', 'LBRT', 0, 'L', false);
			//		Importes y vencimientos
			$pdf->SetFont( $Ft, '', 7);
			$pdf->SetXY( 12, $De + 69);
			$pdf->Cell( 22, $He - 1, 'Importe principal', 'LBT', 0, 'L', false);
			$pdf->Cell( 13, $He - 1, $Multa1, 'BRT', 0, 'L', false);
			$pdf->Cell( 15, $He - 1, 'Vencimiento', 'LBT', 0, 'R', false);
			$pdf->Cell( 15, $He - 1, $Vencimiento1, 'BRT', 0, 'L', false);
			$pdf->SetXY( 12, $De + 73);
			$pdf->Cell( 22, $He - 1, 'Importe c/recargo', 'LBT', 0, 'L', false);
			$pdf->Cell( 13, $He - 1, $Multa2, 'BRT', 0, 'L', false);
			$pdf->Cell( 15, $He - 1, 'Vencimiento', 'LBT', 0, 'R', false);
			$pdf->Cell( 15, $He - 1, $Vencimiento2, 'BRT', 0, 'L', false);
			//		Codigo de barras
			$pdf->Image( 'amagen.png', 85, $De + 67, 107, 10);
			$pdf->SetFont( $Ft, '', 10);
			$pdf->SetXY( 87, $De + 78);
			$pdf->Cell( 0, $He - 1, $code, '', 0, 'L', false);
		}
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		//		Marca de corte
		$pdf->SetFont( 'Courier', '', 10);
		$pdf->SetXY( 5, 97);
		$pdf->Cell( 0, 3,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', '', 1);
		$pdf->SetXY( 5, 183);
		$pdf->Cell( 0, 3,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', '', 1);
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		// trace
//		trace::nuevo($_SESSION["contrav_usr_id"],'4',$Autos,'Imputado: '.$Datos[$i]['Nombre'],'0','0');
		$pdf->AddPage();	
	}
}

$pdf->Output();	
?>