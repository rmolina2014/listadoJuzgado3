<?php
require('fpdf/fpdf.php');
require("../../model/class_expediente.php");
require("../../model/class_escritos_oficio.php");
require("../../model/class_escritos_providencia.php");
require "../../controller/v1.php";

$codigo = $_GET['tipo_escrito'];
// todas las personas para ese autos
$t = expediente::getDatosPersonas( $_GET['CAMPO_AUTOS']);
$Caracteres = array(); 
for( $j = 0; $j < count($t); $j++){
	$Caracteres[$j] = $t[$j][8];
}
$elejidos = $_GET['eleccion'];

if (count($elejidos) != 0)
{	
	$string='';
	$array_datos = array();
	$caracterElegido = array();
	
	for( $j = 0; $j < count($t); $j++){	
		if(in_array($Caracteres[$j],$elejidos)){
			$caracterElegido = oficio::getDatosCitacion($Caracteres[$j]);
			if($caracterElegido != false){
				$p = count($array_datos);
				$array_datos[$p]['ID'] = $Caracteres[$j];
				$array_datos[$p]['fecha_citacion'] = $caracterElegido[0];
				$array_datos[$p]['hora'] = $caracterElegido[1];
				$array_datos[$p]['fecha_escrito'] = $caracterElegido[2];	
			} 
			$string.= $t[$j][1].'; ';
		}
	}
	
}

//grabo los escritos en la db ------->>>> SE DEJA DE GUARDAR EL ESCRITO 27/08/14 
//$var='';
//$id_escrito = providencia::nuevoEscrito( $B[0]['ID'],$codigo,$var,$var,$var);

// Chequeo las fechas de citacion de las personas elegidas para mostrar el mas proximo inmediato..
if(count($array_datos) > 0){
	// busco la menor fecha
	$menor = 0;
	for( $d=1 ; $d < count($array_datos) ; $d++)
	{
		$a = strtotime($array_datos[$menor]['fecha_citacion']);
		$b = strtotime($array_datos[$d]['fecha_citacion']);
		if($b < $a){
			$menor = $d;
		}			 
	}	
	$HORACITATORIO = $array_datos[$menor]['hora'];
	list ($anio_c, $mes_c, $dia_c) = explode("-",$array_datos[$menor]['fecha_citacion']);
	$FECHACITATORIO = $dia_c.' de '.write_month( date($mes_c)).' de '.$anio_c;
	list ($anio_e, $mes_e, $dia_e) = explode("-",$array_datos[$menor]['fecha_escrito']);
	$FECHAESCRITO = $dia_e.' de '.write_month( date($mes_e)).' de '.$anio_e;
}else{
	// No hay fechas de citacion
	$FECHACITATORIO = "...................";
	$HORACITATORIO = ".....";
	$FECHAESCRITO = "...................";
}
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//                               pagina      1
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 

$Replace = expediente::getArraydatosBasicos( $_GET['CAMPO_AUTOS']);
array_push( $Replace, strtoupper($string), $FECHACITATORIO, $HORACITATORIO, $FECHAESCRITO);
for( $i = 0; $i < count( $Replace); $i++){
	$Replace[$i] = utf8_decode( $Replace[$i]);
}
$Search = array( '#AUTOS','#CARATULA','#FECHAACTA','#REPARTICION','#CAMPO_LEY','#ACTA','#PERSONASELEJIDAS','#FECHACITATORIO','#HORACITATORIO','#FECHAESCRITO');
$Parrafos = array();
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
switch($codigo){
	case 1:// a Propietario
		$Parrafos[] = 'Avocado al conocimiento de Autos Nº #AUTOS caratulados #CARATULA #CAMPO_LEY Código de Faltas, se prevée: Emplacese a #PERSONASELEJIDAS con facultad para obligar a la empresa imputada a comparecer audiencia a Juicio en los términos que prevee el Art. 76 del Código de Faltas, a realizarse en este Tercer Juzgado de Faltas: sito en Avda. Libertador Nº 750 -Oeste- Centro Cívico - 3º Piso - Núcleo 5 - Capital; el día y la hora que se fije por Secretaría de conformidad al calendario de audiencias previsto, bajo apercibimiento de clausura, de conformidad a lo establecido en los Art. 75º de la Ley LP-941-R.- ';
		$Parrafos[] = 'San Juan, #FECHAESCRITO - Señálese fecha de audiencia a Juicio para el #FECHACITATORIO a las #HORACITATORIOhs. en los términos de la resolución que antecede.-';	
		break;
	case 2:// a Juicio
		$Parrafos[] = 'Avocado al conocimiento de Autos Nº #AUTOS caratulados #CARATULA #CAMPO_LEY Código de Faltas, se prevée: citesé a #PERSONASELEJIDAS a comparecer audiencia a juicio en los términos que prevée el Art. 76 del Código de Faltas: a realizarse en este Tercer Juzgado de Faltas: sito en Avda. Libertador Nº 750 -Oeste- Centro Cívico - 3º Piso - Núcleo 5 - Capital; el día y la hora que se fije por Secretaría de conformidad al calendario de audiencias previsto, bajo apercibimiento de ser conducido por la fuerza pública en el caso de incomparecencia injustificada, de conformidad a lo establecido en los Art. 71º y 74º de la Ley LP-941-R.- ';
		$Parrafos[] = 'San Juan, #FECHAESCRITO - Señálese fecha de audiencia a Juicio para el #FECHACITATORIO a las #HORACITATORIOhs. en los términos de la resolución que antecede.-';	
		break;
	case 3:// a Informativa
		$Parrafos[] = 'Avocado al conocimiento de Autos Nº #AUTOS caratulados #CARATULA #CAMPO_LEY Código de Faltas, se prevée: citesé a #PERSONASELEJIDAS a acompañar o indicar los aportes probatorios y elementos de convicción que posea y hagan a su derecho, todo a audiencia informativa, a realizarse ante este Tercer Juzgado de Faltas: sito en Avda. Libertador Nº 750 -Oeste- Centro Cívico - 3º Piso - Núcleo 5 - Capital; el día y la hora que se fije por Secretaría de conformidad al calendario de audiencias previsto.- ';
		$Parrafos[] = 'San Juan, #FECHAESCRITO - Señálese fecha de audiencia Informativa para el #FECHACITATORIO a las #HORACITATORIOhs. en los términos de la resolución que antecede.-';	
		break;
}

$pdf = new FPDF();
$pdf->SetMargins(38,38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);

$xcant = count( $Parrafos);
for( $x = 0; $x < $xcant; $x ++){ 
   $Parrafos[$x] = str_replace( $Search, $Replace, $Parrafos[$x]);
}
$plus = ' -';
for( $x = 0; $x < $xcant; $x++){
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
}

for( $x = 0; $x < ($xcant-1); $x ++){
	$pdf->MultiCell(0,7, $Parrafos[$x],0,'J');
	$pdf->MultiCell(0,1, '',0,'J');
}
$pdf->MultiCell(0,60, '',0,'J');
$pdf->MultiCell(0,7, $Parrafos[$xcant-1],0,'J');
$pdf->Output();
?>