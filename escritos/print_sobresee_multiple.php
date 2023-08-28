<?php
require_once('doublesided.php');
require_once "../../controller/v1.php";
require_once("../../model/class_escritos_sentencia.php");
//require_once("../../model/class_escritos.php");
require_once("../../model/class_escritos_descargo.php");
require_once("../../model/class_expediente.php");
require_once("../../model/class_persona.php");
require_once("../../controller/control_seguridad.php");

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

require('Goupil/index.php');
require('Goupil/Font.php');
require('Goupil/FColor.php');
require('Goupil/BarCode.php');
require('Goupil/FDrawing.php');
include('Goupil/i25.barcode.php');

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

$Autos        = isset($_GET['EM_AUTOS'])? trim( $_GET['EM_AUTOS']): 0;
$Acta         = isset($_GET['EM_ACTA']) ? trim( $_GET['EM_ACTA']) : 0;
$Facta        = isset($_GET['EM_FACTA'])? trim( $_GET['EM_FACTA']): 0;
$Constatacion = isset($_GET['NUEVOFUNDAMENTO'])? trim( $_GET['NUEVOFUNDAMENTO']): 0;

$Array_personas = expediente::getDatosPersonas( $Autos, 1);
$Datos = array();$Pers = array();
$string='';
$Tipo_escrito = 67;
$index=0;

for ($i=0 ; $i<count($Array_personas) ; $i++){
	$Pers[$i]= isset($_GET['eleccio'.$i]) ? trim( $_GET['eleccio'.$i]): 0;
	$declaracion= isset($_GET['EM_REDECLARA'.$i]) ? trim( $_GET['EM_REDECLARA'.$i]): 0;
	if($Pers[$i] != 0){
		$Datos[$index]['Caracter']   = $Array_personas[$i][8];
		$Datos[$index]['Id_persona'] = $Array_personas[$i][6];
		$Datos[$index]['Nombre']     = $Array_personas[$i][1];
		if($declaracion != "Ya habia declarado"){
			$Descargo = new descargo( $Autos, $Datos[$index]['Id_persona'],14);	
			$Descargo->guardar( 3, $_SESSION["contrav_usr_id"], $declaracion );
			$Datos[$index]['Declaracion'] = $declaracion;
		}else{
			$Datos[$index]['Declaracion'] = descargo::getDeclaracion( $Datos[$index]['Caracter']);
		}
		$string.= ' Sr/a. '.$Array_personas[$i][1].' '.$Array_personas[$i][0].' con domicilio en '.$Array_personas[$i][9].' y al ';
		$index++;
	}
}
$string2 = substr( $string, 0, -6).".";

for( $i = 0; $i < count( $Datos); $i++){	
	$sentencia = new sentencia( $Autos, $Datos[$i]['Id_persona'], $Tipo_escrito);
	// $sentencia->guardar(  1, $_SESSION["contrav_usr_id"], 0, 0, 0, "0000-00-00 00:00:00", "0000-00-00 00:00:00", "00:00", 0, "");
	$sentencia->guardar(  1, $_SESSION["contrav_usr_id"], 0, 0, 0, "0000-00-00 00:00:00", "0000-00-00 00:00:00", "00:00", $Constatacion, "");
}

$Replace = expediente::getInfoPrint( $Autos, $Datos[0]['Id_persona']);
$Replace[3]=utf8_decode($Replace[3]);
$CuentaNombre=utf8_decode($CuentaNombre);
array_push( $Replace, $MONTOACTUAL_LETRA,$Monto,$Cuenta,$CuentaNombre,$JUS,$string2);
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#NOMBRE','#DNI','#DOMICILIO','#ACTA','#MONTOACTUAL_LETRA','#MONTOACTUAL','#NRODESTINOACTUAL','#DESTINOACTUAL','#JUS','#STRING');

$Parrafos = array();
$Parrafos[] = 'SAN JUAN, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = '- - - -AUTOS Y VISTOS: Para resolver en Autos Nº#AUTOS-C c/#CARATULA. Por falta al #CAMPO_LEY, en lo que a fs. 1 obra Acta/Denuncia #ACTA, con fecha #FECHAACTA.-';
for($j=0 ; $j<count($Datos) ; $j++){
	$Parrafos[] = '- - - -CONSIDERANDO: Que del análisis del Acta/Denuncia y declaración realizada por el Sr/a: '.$Datos[$j]['Nombre'].' en lo que manifiesta: '.$Datos[$j]['Declaracion'].'.-';	
}	
$Parrafos[] = '- - - -FUNDAMENTO: Que habiendo negado el contenido del Acta/Denuncia y no existiendo prueba alguna que permita a los suscriptos determinar culpabilidad corresponde sobreseer a los mismos.-';

if( $Constatacion){
	$Parrafos[] = '- - - -'.$Constatacion;
}

$Parrafos[] = '- - - -Todo ello ha llevado a los suscriptos. De confomidad a las reglas de la sana crítica. Al intimo convencimiento de que los medios de justificación acumulados con el Acta/Denuncia no son suficientes para tener por acreditada la falta. Por lo que corresponde de conformidad al Art. 76 de la Ley LP-941-R del Código de Faltas, sobreseer en la causa.-';
$Parrafos[] = '- - - -RESUELVO: I) Sobreseer en la causa al/la #STRING Dado que los medios de justificación acumulados en el Acta/Denuncia no son suficientes para tener por acreditada la falta y en los términos establecidos en la Ley. La presente resolución se funda en lo establecido en el Art. 84 de la Ley LP-941-R.-';
$Parrafos[] = 'Protocolícese, agréguese copia en Autos y notifíquese.-';

$xcant = count( $Parrafos);
$pdf = new DoubleSided_PDF();
$pdf->SetMargins(38,38,14);
$pdf->SetDoubleSided(38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
$pdf->SetAutoPageBreak( true, 10);

for( $x = 0; $x < $xcant; $x++){ 
	$Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 0; $x < $xcant; $x++){
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

for( $x = 0; $x < $xcant; $x ++){
	$pdf->MultiCell(0,7, $Parrafos[$x],0,'J');
}
$pdf->Output();	

?>