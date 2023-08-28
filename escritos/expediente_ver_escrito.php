<?php
error_reporting( 0);
require_once "../../controller/session_seguridad.php";
require_once "../../controller/_ccore.php";
require_once "../../model/escritos.php";
require_once "../../model/actuaciones.php";
require_once "../../model/expedientes.php";
require_once "../../model/parrafos.php";
require_once "../../model/personas.php";
require_once "../../model/infracciones.php";
require_once "../../model/protocolos.php";
require_once "TCPDF/tcpdf.php";
// ---------------------------------------------------------
class MYPDF extends TCPDF {
	public function Header(){
		global $Code;
		if( $Code){
			$style = array('align' => 'C', 'stretch' => false, 'fitwidth' => true, 'border' => true, 'padding' => 2, 'fgcolor' => array(0,0,0), 'bgcolor' => false, 'text' => $Code, 'font' => 'helvetica', 'fontsize' => 6, 'stretchtext' => 4);
			$this->write1DBarcode( $Code, 'EAN13', 125, 15, "", 15, 0.4, $style);
		}
	}
	public function Footer(){
	}
}
// ---------------------------------------------------------
$Ids = isset($_GET['sid']) ? trim( $_GET['sid']) : 0;
$Ids = explode( ",", $Ids);
// ---------------------------------------------------------
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetAuthor('Tercer Juzgado de Faltas');
$Proto = 0;/* eligió protocolizar */
$Sello = 0;
// ---------------------------------------------------------
for( $i = 0, $cant = max( count( $Ids), 2) - 1; $i < $cant; $i ++){
	$Escrito = Escritos::get( $Ids[$i]);		
	$Texto = Parrafos::listar( $Escrito['tipo']);	
	$Actor = Actuaciones::get( $Escrito['actor']);	
	$Expediente = Expedientes::get( $Actor['expediente'], $_SESSION["JmZj07_juzgado"], $_SESSION["JmZj07_id"]);
	$Infraccion = Infracciones::getPrint( $Actor['expediente']);	
	$Persona = Personas::getPorId( $Actor['persona']);
	$Reparticion = explode( "-", $Expediente['reparticion']);
	/* ----- */
	$Tag = array( '#AUTOS','#CARATULA','#FECHA_ACTA','#INFRACCION','#ACTA','#REPARTICION','#ORGANISMO','#SOLO_REPARTICION','#DIA','#MES','#ANO','#FOJA','#NOMBRE','#SOLO_APELLIDO','#DOCUMENTO','#DOMICILIO');
	/* Tags: #FECHA_ESCRITO,#FECHA_AUTOS,#DESCRIPCION,#LUGAR,#DIRECCION,#PERSONAS,#STRING,#DENUNCIADOS,#MEDIDA,#LIBRE1,#LIBRE2,#COMPARENCIA_DESDE,#COMPARENCIA_HASTA,#DEUDA_LETRA,#DEUDA_NUMERO,#PERSONAS_ELEGIDAS */
	$Info = array( $Expediente['autos'],utf8_encode($Expediente['caratula']),$Expediente['fecha_origen'],utf8_encode("ART. ".$Infraccion['art_small']. " de " .$Infraccion['ley_small']),$Expediente['numero_origen'],utf8_encode($Expediente['reparticion']),utf8_encode($Reparticion[0]),utf8_encode($Reparticion[1]),$Escrito['dia'],write_month($Escrito['mes']),$Escrito['ano'],$Escrito['fojas'],utf8_encode($Persona['apellido'].", ".$Persona['nombre']),utf8_encode($Persona['apellido']),$Persona['nombre_tipo_doc'].": ".$Persona['numero_documento'],utf8_encode($Persona['domicilio']));
	$Info = array_map( "utf8_decode", $Info);/* esta linea deberia ir mas abajo */
	/* ----- */
	$aux = (string) $Ids[$i];
	switch( strlen( $aux)){
		case 1: $aux = '000000' . $aux; break;
		case 2: $aux = '00000' . $aux; break;
		case 3: $aux = '0000' . $aux; break;
		case 4: $aux = '000' . $aux; break;
		case 5: $aux = '00' . $aux; break;
		case 6: $aux = '0' . $aux; break;
		case 7: $aux = $aux; break;
	}
	$Code = $_SESSION["JmZj07_juzgado"]."0101".$aux;
	/* ----- */
	$pdf->startPageGroup();
	$pdf->SetMargins( 40, 40, 15);
	$pdf->SetAutoPageBreak( true, 10);
	$pdf->setPrintFooter( false);
	$pdf->AddPage();
	$pdf->SetBooklet( true, 40, 15);
	switch( $Escrito['id_clase']){
		case 1:{/* Cedula */
			array_push( $Tag, '#FECHA_CITACION','#HORA_CITACION');
			array_push( $Info, $Escrito['fecha_citacion'], $Escrito['hora']);
			}break;
		case 2:{/* Descargo */
			if( $Escrito['defensa'] == 0){ $Escrito['defensa'] = "no";}else{ $Escrito['defensa'] = "si";}
			array_push( $Tag, '#CON_DEFENSA','#ABOGADO','#DECLARACION');
			array_push( $Info, $Escrito['defensa'], $Escrito['abogado'], $Escrito['declaracion']);
			}break;
		case 3:{/* Sentencia */
			$Multa_letras = strtoupper( DoubleToString( $Escrito['monto']));
			$Dias_arresto_letras = strtoupper( nro_to_letra( $Escrito['dias_arresto']));
			/* ----- */
			if($Escrito['desdeh'] && $Escrito['hastah']){
				$desde = substr( $Escrito['desdeh'], 0, -3);
				$hasta = substr( $Escrito['hastah'], 0, -3);
				$periodoDetencion = "Desde las $desde del día ".  $Escrito['detencion'] . " hasta las $hasta del día ". $Escrito['liberacion'];
			}
			/* ----- */
			$Denu = Actuaciones::getPersonas( $Actor['expediente'], 3);/* Denunciantes del expediente */
			$Denunciantes = "";
			for( $x = 0, $cd = count( $Denu); $x < $cd; $x ++){
				$Denunciantes .= $Denu[$x]['persona']."; ";
			}
			$Denunciantes = utf8_encode( substr( $Denunciantes, 0 ,-2));
			/* ----- */
			$Jus = ($Escrito['monto'] / 10);
			/* ----- */
			array_push( $Tag,'#MULTA_LETRA','#MULTA_NUMERO','#JUS','#CUENTA_NUMERO','#CUENTA_LETRA','#DENUNCIANTES','#ARRESTO_NUMERO','#ARRESTO_LETRA','#ARRESTO_CUMPLIMIENTO','#FECHA_DETENCION','#INSPECTORES','#LOCAL_NOMBRE','#LOCALDOMICILIO','#CONSTATACION','#PERIODO','#ARTICULO','#FUNDAMENTO','#VALORACION','#FECHA_NOTIFICACION','#CLAUSURA_DIAS','#DEPARTAMENTO','#FECHA_SENTENCIA','#TOMO','#FOLIO','#SECUESTROS_DESTINO','#SECUESTROS_ACCION','#TODOSSECUESTROS','#DECLARACION','#INFORME_FOJA','#INFORME_FECHA');
			array_push( $Info,$Multa_letras,$Escrito['monto'],$Jus,$Escrito['cuenta'],$Escrito['nombre_cuenta'],$Denunciantes,$Escrito['dias_arresto'],$Dias_arresto_letras,$periodoDetencion,$Escrito['detencion'],utf8_encode( $Escrito['inspectores']),utf8_encode($Escrito['nlocal']),utf8_encode($Escrito['dlocal']),utf8_encode($Escrito['constatacion']),"[AÑOS DE INACTIVIDAD]","[ARTICULO]",utf8_encode($Escrito['fundamento']),$Escrito['xxxxxxx'],$Escrito['fecha_notificacion'],$Escrito['dias_clausura'],$Escrito['departamento'],$Escrito['fecha_sentencia'],$Escrito['tomo'],$Escrito['folio'],utf8_encode( $Escrito['accion_secuestros']),utf8_encode( $Escrito['accion']),utf8_encode($Escrito['todos_secuestros']),utf8_encode($Escrito['declaracion']),$Escrito['fojas_descargo'],$Escrito['fecha_informe']);
			/* ----- */
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
			}break;
		case 5:{/* Oficio */  
			$Multa_letras = strtoupper( DoubleToString( $Escrito['monto']));
			
			if( intval( $Escrito['dias_arresto']) < 1){
				$Escrito['dias_arresto'] = min( ($Escrito['monto'] / 100) , 30);
			}
			
			$Dias_arresto_letras = strtoupper( nro_to_letra( $Escrito['dias_arresto']));
			array_push( $Tag, '#DESTINO_AUTORIDAD','#DESTINO_REPARTICION','#PARRAFO_1','#PARRAFO_2','#PARRAFO_3','#PARRAFO_4','#DESTINO_MA_AUTORIDAD','#DESTINO_MA_REPARTICION','#CARGODESTINATARIO','#CAN_FECHA','#CAN_HORA', '#CAN_ACCIDENTE','#CAN_DESCRIPCION','#CAN_LUGAR','#ENCABEZADO_1','#ENCABEZADO_2','#ENCABEZADO_3','#FECHA_DETENCION','#MULTA_LETRA','#MULTA_NUMERO','#ARRESTO_NUMERO','#ARRESTO_LETRA','#EMPRESA','#INVESTIGACION_TIPO','#INVESTIGACION_TELEFONO','#TELEFONIA_DESDE','#TELEFONIA_HASTA');
			
			/* Campos: foja,fecha_informe,fecha_detencion,fecha_ingreso,responsable,fecha_salida,fecha_regreso,fecha_adjunta */
			
			array_push( $Info, $Escrito['autoridad'], $Escrito['reparticion'], strtoupper($Escrito['cadena_1']), strtoupper($Escrito['cadena_2']), strtoupper($Escrito['cadena_3']), strtoupper($Escrito['cadena_4']), strtoupper($Escrito['repart_manual']), strtoupper($Escrito['subrepart_manual']), strtoupper($Escrito['cargo_destinatario']), strtoupper($Escrito['fecha_mordedura']), strtoupper($Escrito['hora_mordedura']), strtoupper($Escrito['descripcion_accidente']), strtoupper($Escrito['descripcion_can']), strtoupper($Escrito['descripcion_lugar']), strtoupper($Escrito['encabezado_1']), strtoupper($Escrito['encabezado_2']), strtoupper($Escrito['encabezado_3']), strtoupper($Escrito['fecha_detencion']), $Multa_letras, $Escrito['monto'], $Escrito['dias_arresto'], $Dias_arresto_letras, strtoupper($Escrito['empresa']),utf8_encode($Escrito['tipo_investigacion']),utf8_encode($Escrito['telefono']),$Escrito['telefonia_desde'],$Escrito['telefonia_hasta']);
			}break;
		case 6:{/* Certificado */  
			}break;
		case 7:{/* Boleta */  
			}break;
		case 8:{/* Caratula */  
			/* No queda en el historial, se grafica directamente desde el archivo print/caratula.php */
			}break;
		case 9:{/* Providencia */  
			array_push( $Tag, '#ACTORES');
			array_push( $Info, $Escrito['actores']);
			}break;
		case 13:{/* NOTIFICACION DE RESOLUCION */  
			array_push( $Tag, '#RESUELVO');
			array_push( $Info, $Escrito['resuelvo']);
			}break;
		default:{/* Escrito no contemplado */
			$Texto[$j]['texto'] = 'Escrito no contemplado: Clase de escrito '.$Escrito['id_clase'];
			}break;
	}
	// -----------------
	//$Info = array_map( "utf8_decode", $Info); /* Esta linea deberia estar aqui y no mas arriba */
	$Parrafos = count( $Texto);
	for( $x = 0; $x < $Parrafos; $x ++){/* Relleno de parrafos con guiones */
		$Parrafo = str_replace( $Tag, $Info, $Texto[$x]['texto']);
		$Parrafo = str_replace( array("<b>","</b>"), array("",""), $Parrafo);
		$Largo_maximo = 154.52;
		if(( $Texto[$x]['relleno'] == 1) && ($Parrafo != "")){
			$Sangria = "";
			for( $s = 0, $Largo_sangria = ( int)$Texto[$x]['sangria']; $s < $Largo_sangria; $s ++){
				$Sangria .= " ";
			}
			$Palabras = explode(" ", $Parrafo);
			$Linea = $Sangria.$Palabras[0];
			$Cantidad_palabras = count( $Palabras);
			$pdf->SetFont( $Texto[$x]['font'], $Texto[$x]['stylo'], $Texto[$x]['size']);
			for( $j = 1; $j < $Cantidad_palabras; $j ++){
				$Largo_actual = $pdf->GetStringWidth( $Linea, $Texto[$x]['font'], $Texto[$x]['stylo'], $Texto[$x]['size']);
				while(( $Largo_actual < $Largo_maximo) and ($j < $Cantidad_palabras)){
					$Linea .= " ".$Palabras[$j];
					$j++;
					$Largo_actual = $pdf->GetStringWidth( $Linea, $Texto[$x]['font'], $Texto[$x]['stylo'], $Texto[$x]['size']);
				}
				if( $j < $Cantidad_palabras){
					$j--;
					$Linea = $Palabras[$j];
				}
			}
			$Plus = " -";
			for( $h = 0, $Largo =(($Largo_maximo - $pdf->GetStringWidth($Linea,$Texto[$x]['font'],$Texto[$x]['stylo'],$Texto[$x]['size']) - 2.2)/4.25); $h < $Largo; $h++){
				$Texto[$x]['texto'] .= $Plus;
			}//		SI  SE  PASA  UN  PLUS  HACIA  ABAJO  HAY  QUE  DISMINUIR  EL  VALOR  154.51  DE  A  UN  CENTESIMO!
		}
	}
	// -----------------
	for( $j = 0; $j < $Parrafos; $j ++){/* Generacion del texto del escrito */
		$Parrafo = str_replace( $Tag, $Info, $Texto[$j]['texto']);
		if($Parrafo != "<b></b>"){
			switch( $Texto[$j]['align']){
				case 'J': $Aling="text-align:justify;line-height:150%;"; break;
				case 'C': $Aling="text-align:center;line-height:150%;"; break;
				case 'R': $Aling="text-align:right;line-height:150%;"; break;
				default : $Aling="text-align:left;line-height:150%;"; break;
			}
			$Sangria = "";
			for( $s = 0, $Largo_sangria = ( int)$Texto[$j]['sangria']; $s < $Largo_sangria; $s ++){
				$Sangria .= " ";
			}
			$pdf->SetFont( $Texto[$j]['font'], $Texto[$j]['stylo'], $Texto[$j]['size']);
			$html = '<div style="'.$Aling.' ">'.$Sangria.''.$Parrafo.'</div>';
			$pdf->writeHTML( $html, true);
		}
	}
	// -----------------
	// if( $Escrito['tipo'] == 61){
		// $pdf->SetAutoPageBreak(TRUE, 0);
	// }
	// -----------------
	if( $pdf->GetY() < 262){/* Colocación de sellos */
		switch( $Escrito['id_clase']){
			case 1:{/* Cedula */
				$my = $pdf->GetY();
				$pdf->Image("../imagen/sello_juzgado.png", 90, $my - 13, 33 , 0, 'PNG');
				$pdf->Image("../imagen/sello_belen.png", 130, $my + 10, 39 , 0, 'PNG');
				}break;
			case 2:{/* Descargo */
				$my = $pdf->GetY();
				$pdf->Image("../imagen/sello_juzgado.png", 90, $my - 13, 33 , 0, 'PNG');
				break;}
			case 3:{/* Sentencia */
				$my = $pdf->GetY();
				if( $Sello){
					if( is_array( $AP)){
						$mm = $pdf->getMargins();
						$Cara = utf8_decode(utf8_encode($Expediente['caratula']));
						$Impu = $Persona['apellido'].", ".$Persona['nombre'];
						if( $mm['left'] == 40){
							$pdf->setXY(33,40);
							$pdf->StartTransform();
							$pdf->Rotate(-90);
							$pdf->SetFont('Courier','B',9);
							$tmp = "AUTOS Nº".$Expediente['autos']." - ACTA Nº".$Expediente['numero_origen']." - CARÁTULA C/$Cara - IMPUTADO:$Impu";
							$pdf->Cell( 0, 5, substr( $tmp, 0, 127),0, 1, 'L');
							$pdf->setX(33);
							$pdf->Cell( 0, 5, "PROTOCOLIZADO EN TOMO:".$AP['letra']." - FOLIO:".$AP['folio']." (Del ".$AP['folio'].' al '.$AP['folio'].") - DEL LIBRO ".$AP['nombre']." - EN FECHA:".$AP['fecha'],0, 1, 'L');
							$pdf->StopTransform();
							$pdf->Rect( 20, 35, 15, 244);
						}else{
							$pdf->setXY(193,40);
							$pdf->StartTransform();
							$pdf->Rotate(-90);
							$pdf->SetFont('Courier','B',9); 
							$pdf->Cell( 0, 5, "AUTOS Nº".$Expediente['autos']." - ACTA Nº".$Expediente['numero_origen']." - CARÁTULA C/$Cara - IMPUTADO:$Impu",0, 1, 'L');
							$pdf->setX(193);
							$pdf->Cell( 0, 5, "PROTOCOLIZADO EN TOMO:".$AP['letra']." - FOLIO:".$AP['folio']." (Del ".$AP['folio'].' al '.$AP['folio'].") - DEL LIBRO ".$AP['nombre']." - EN FECHA:".$AP['fecha'],0, 1, 'L');
							$pdf->StopTransform();
							$pdf->Rect( 180, 35, 15, 240);
						}
					}
					$Proto = 0;
				}
				$pdf->Image("../imagen/sello_secretaria.png", 45, $my + 12, 33 , 0, 'PNG');
				$pdf->Image("../imagen/sello_juzgado.png", 95, $my - 12, 33 , 0, 'PNG');
				$pdf->Image("../imagen/sello_juez.png", 145, $my + 12, 33 , 0, 'PNG');
				/* ----- */
				}break;
			case 5:{/* Oficio */  
				$my = $pdf->GetY();
				$pdf->Image("../imagen/sello_secretaria.png", 45, $my + 12, 33 , 0, 'PNG');
				$pdf->Image("../imagen/sello_juzgado.png", 95, $my - 12, 33 , 0, 'PNG');
				$pdf->Image("../imagen/sello_juez.png", 145, $my + 12, 33 , 0, 'PNG');
				}break;
			default:{/* Sin sellos */
				}break;
		}
	}else{
		switch( $Escrito['id_clase']){
			case 3:{/* Sentencia */
				if( $Sello){
					if( is_array( $AP)){
						$mm = $pdf->getMargins();
						$Cara = utf8_decode(utf8_encode($Expediente['caratula']));
						$Impu = $Persona['apellido'].", ".$Persona['nombre'];
						if( $mm['left'] == 40){
							$pdf->setXY(33,40);
							$pdf->StartTransform();
							$pdf->Rotate(-90);
							$pdf->SetFont('Courier','B',9); 
							$tmp = "AUTOS Nº".$Expediente['autos']." - ACTA Nº".$Expediente['numero_origen']." - CARÁTULA C/$Cara - IMPUTADO:$Impu";
							$pdf->Cell( 0, 5, substr( $tmp, 0, 127),0, 1, 'L');
							$pdf->setX(33);
							$pdf->Cell( 0, 5, "PROTOCOLIZADO EN TOMO:".$AP['letra']." - FOLIO:".$AP['folio']." (Del ".$AP['folio'].' al '.$AP['folio'].") - DEL LIBRO ".$AP['nombre']." - EN FECHA:".$AP['fecha'],0, 1, 'L');
							$pdf->StopTransform();
							$pdf->Rect( 20, 35, 15, 240);
						}else{
							$pdf->setXY(193,40);
							$pdf->StartTransform();
							$pdf->Rotate(-90);
							$pdf->SetFont('Courier','B',9); 
							$pdf->Cell( 0, 5, "AUTOS Nº".$Expediente['autos']." - ACTA Nº".$Expediente['numero_origen']." - CARÁTULA C/$Cara - IMPUTADO:$Impu",0, 1, 'L');
							$pdf->setX(193);
							$pdf->Cell( 0, 5, "PROTOCOLIZADO EN TOMO:".$AP['letra']." - FOLIO:".$AP['folio']." (Del ".$AP['folio'].' al '.$AP['folio'].") - DEL LIBRO ".$AP['nombre']." - EN FECHA:".$AP['fecha'],0, 1, 'L');
							$pdf->StopTransform();
							$pdf->Rect( 180, 35, 15, 240);
						}
					}
					$Proto = 0;
				}
				}break;
			default:{/* Sin sellos */
				}break;
		}
		
	}
}
/* --------------------------------------------------------------------------------- */
$pdf->Output('example_021.pdf', 'I');
?>