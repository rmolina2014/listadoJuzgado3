<?php

58
151
59
60
66
22

1160

153

/* ----- */

161
76

/* ----- */

$Parrafos[] = 'OFICIO';
$Parrafos[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.-';
$Parrafos[] = 'AL SEÑOR';
$Parrafos[] = 'GERENTE DE LA COMPAÑÍA';
$Parrafos[] = 'DE TELEFONIA CELULAR';
if($EMPRESA == "AMX"){
	$Parrafos[] = 'AMX-Argentina S.A.';
}else{
	if($EMPRESA == "MOVISTART"){
		$Parrafos[] = 'MOVISTART S.A.';
	}else
		if($EMPRESA == "PERSONAL"){
			$Parrafos[] = 'PERSONAL S.A.';			
		}
}
$Parrafos[] = 'DELEGACION SAN JUAN';
$Parrafos[] = 'S--------/--------D';
$Parrafos[] = '               Me dirijo a Ud. En mi carácter de titular del Juzgado de Faltas de Tercera Nominación, en Autos Nº #AUTOS C c/#CARATULA - Expediente Contravencional Nº 120/11- Inf. Art. 109-113 INC.3 de la Ley LP-941-R - Código de Faltas, instruido ante la COMISARIA #NROCOMISARIAº, que tramitan por ante el juzgado a mi cargo, con el objeto de solicitarle remita en forma urgente datos personales del propietario, si es que corresponde a su empresa y un listado de #TIPO correspondientes a los meses #DESDEM hasta #HASTAM del corriente año, realizadas al abonado telefónico Nº #NROTEL.-';
$Parrafos[] = '               Todo ello se funda en tareas investigativas.-';
$Parrafos[] = '               Diligenciado el presente sírvase remitirlo al Juzgado de origen, en Centro Cívico Piso 3º- Núcleo 5, sito en: Avda. Libertador San Martín Nº 750 (oeste)- Capital- San Juan- (C.P. 5400).- ';
$Parrafos[] = 'Sin otro particular le saluda a Ud. atentamente.-';

/* ----- */

$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.- Autos Nº #AUTOS-C c/#CARATULA - Expediente Contravencional Nº #ACTA- Inf. Art. 109-113 INC.3 de la Ley LP-941-R - Código de Faltas, instruido ante la COMISARIA #NROCOMISARIA, que tramitan por ante el juzgado a mi cargo, con el objeto de solicitarle remita en forma urgente un listado de #TIPO correspondientes a los meses #DESDEM hasta #HASTAM del corriente año, realizadas al abonado telefónico Nº #NROTEL.”';

?>