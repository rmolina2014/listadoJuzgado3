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
$Parrafos[] = 'AL SE�OR';
$Parrafos[] = 'GERENTE DE LA COMPA��A';
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
$Parrafos[] = '���������������Me dirijo a Ud. En mi car�cter de titular del Juzgado de Faltas de Tercera Nominaci�n, en Autos N� #AUTOS C c/#CARATULA - Expediente Contravencional N� 120/11- Inf. Art. 109-113 INC.3 de la Ley LP-941-R - C�digo de Faltas, instruido ante la COMISARIA #NROCOMISARIA�, que tramitan por ante el juzgado a mi cargo, con el objeto de solicitarle remita en forma urgente datos personales del propietario, si es que corresponde a su empresa y un listado de #TIPO correspondientes a los meses #DESDEM hasta #HASTAM del corriente a�o, realizadas al abonado telef�nico N� #NROTEL.-';
$Parrafos[] = '���������������Todo ello se funda en tareas investigativas.-';
$Parrafos[] = '���������������Diligenciado el presente s�rvase remitirlo al Juzgado de origen, en Centro C�vico Piso 3�- N�cleo 5, sito en: Avda. Libertador San Mart�n N� 750 (oeste)- Capital- San Juan- (C.P. 5400).- ';
$Parrafos[] = 'Sin otro particular le saluda a Ud. atentamente.-';

/* ----- */

$Parrafos2 = array();
$Parrafos2[] = 'San Juan, '.date(d).' de '.write_month( date(m)).' de '.date(Y).'.- Autos N� #AUTOS-C c/#CARATULA - Expediente Contravencional N� #ACTA- Inf. Art. 109-113 INC.3 de la Ley LP-941-R - C�digo de Faltas, instruido ante la COMISARIA #NROCOMISARIA, que tramitan por ante el juzgado a mi cargo, con el objeto de solicitarle remita en forma urgente un listado de #TIPO correspondientes a los meses #DESDEM hasta #HASTAM del corriente a�o, realizadas al abonado telef�nico N� #NROTEL.�';

?>