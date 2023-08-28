<?php
require_once "fpdf/fpdf.php";
require_once "../../controller/session_seguridad.php";
require_once "../../controller/_ccore.php";
require_once "../../model/planes_pago.php";
require_once "../../model/cuotas.php";
require_once "../../model/escritos.php";
require_once "../../model/actuaciones.php";
require_once "../../model/expedientes.php";
require_once "../../model/cuentas.php";
require_once "../../model/personas.php";

$Id_plan = isset($_GET['p'])? trim( $_GET['p']): 0;
$Id_cuota = isset($_GET['c'])? trim( $_GET['c']): 0;

$juzgado ="";
switch($_SESSION["JmZj07_juzgado"]){
	case 3: $juzgado = "JUZGADO DE FALTAS - TERCERA NOMINACION";
}

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
}



$Datos['usuario'] = $_SESSION["JmZj07_nombre"];


$Replace = array($Datos['autos'],$Datos['cuenta'],$Datos['fecha_acta'],$Datos['multa1'],$Datos['persona'], $Datos['detalle'], $juzgado, $Datos['usuario']);


for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
$Search = array( '#AUTOS','#CUENTA','#FECHAACTA','#MONTO','#PERSONA','#DETALLE','#JUZGADO','#USUARIO');

//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Parrafos = array();
$Parrafos[] = '#JUZGADO';
$Parrafos[] = 'SAN JUAN, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'RECIBO DE PAGO AUTOS Nº#AUTOS.';
$Parrafos[] = 'PERSONA: #PERSONA.';
$Parrafos[] = 'USUARIO: #USUARIO.';
$Parrafos[] = '#DETALLE.';
$Parrafos[] = 'MONTO: $#MONTO - SON: ' . strtoupper( DoubleToString( $Datos ['multa1']));
$Parrafos[] = 'CUENTA DE DESTINO: #CUENTA.';

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

$pdf->SetFont( 'Courier', 'B', 12);
$pdf->MultiCell( 0, 6, $Parrafos[0], 0, 'C');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell( 0, 6, $Parrafos[1], 0, 'C');
$pdf->MultiCell( 0, 4, "", 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[2], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[3], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[4], 0, 'L');
$pdf->MultiCell( 0, 4, "",0,'J');
$pdf->SetFont( 'Courier', 'B', 12);
$pdf->MultiCell( 0, 6, $Parrafos[5], 0, 'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell( 0, 6, $Parrafos[6], 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[7], 0, 'L');
$pdf->Image("../imagen/sello_juzgado.png", 165, $my - -38, 33 , 0, 'PNG');
//$pdf->Image("../imagen/sello_belen.png", 130, $my + 10, 39 , 0, 'PNG');

$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');

// $pdf->MultiCell( 0, 6, "---", 0, 'J');

$pdf->SetFont( 'Courier', 'B', 12);
$pdf->MultiCell( 0, 6, $Parrafos[0], 0, 'C');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell( 0, 6, $Parrafos[1], 0, 'C');
$pdf->MultiCell( 0, 4, "", 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[2], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[3], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[4], 0, 'L');
$pdf->MultiCell( 0, 4, "",0,'J');
$pdf->SetFont( 'Courier', 'B', 12);
$pdf->MultiCell( 0, 6, $Parrafos[5], 0, 'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell( 0, 6, $Parrafos[6], 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[7], 0, 'L');
$pdf->Image("../imagen/sello_juzgado.png", 165, $my - -110, 33 , 0, 'PNG');


$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');
$pdf->MultiCell( 0, 6, "", 0, 'L');

// $pdf->MultiCell( 0, 6, "---", 0, 'J');

$pdf->SetFont( 'Courier', 'B', 12);
$pdf->MultiCell( 0, 6, $Parrafos[0], 0, 'C');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell( 0, 6, $Parrafos[1], 0, 'C');
$pdf->MultiCell( 0, 4, "", 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[2], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[3], 0, 'L');
$pdf->MultiCell( 0, 6, $Parrafos[4], 0, 'L');
$pdf->MultiCell( 0, 4, "",0,'J');
$pdf->SetFont( 'Courier', 'B', 12);
$pdf->MultiCell( 0, 6, $Parrafos[5], 0, 'J');
$pdf->SetFont('Courier','',12);
$pdf->MultiCell( 0, 6, $Parrafos[6], 0, 'J');
$pdf->MultiCell( 0, 6, $Parrafos[7], 0, 'L');
$pdf->Image("../imagen/sello_juzgado.png", 165, $my - -205, 33 , 0, 'PNG');
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
$pdf->Output();