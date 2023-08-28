<?php
require_once "../../controller/session_seguridad.php";
require_once "../../controller/_ccore.php";
require_once "../../model/escritos.php";
require_once "../../model/actuaciones.php";
require_once "../../model/expedientes.php";
require_once "../../model/parrafos.php";
require_once "../../model/personas.php";
require_once "../../model/infracciones.php";
require_once "tcpdf.php";
error_reporting(0);
// ---------------------------------------------------------
class MYPDF extends TCPDF {
	public function Header(){
		global $Tipo_escrito;
		// $this->SetXY( 15, 15);
		$this->SetY( 15);
		$this->SetFont( 'helvetica', '', 10);
		$this->Cell( 0, 0, $Tipo_escrito, 1);
	}
	public function Footer(){
		$this->SetY(-15);// Position at 15 mm from bottom
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
// ---------------------------------------------------------
$pdf = new MYPDF();
$pdf->SetAuthor('Tercer Juzgado de Faltas');
// ---------------------------------------------------------
//$Ids = isset($_GET['Ids'])? trim( $_GET['Ids']): 0;
$Ids = array( 77973,77855,77818,77802,77983,77858,77792,74885,77819,);
// $Ids = array( 77987,77985,77659,77923,77975,77910,77916,77982,77911,77924,77978,77912,77920,77979,77917,77914,77372,77913,63485,77824,77949,56612,77141,77921,57239,77922,77934,21376,47427,49076,49050,76607,76693);
// ---------------------------------------------------------
for( $i = 0, $cant = count( $Ids); $i < $cant; $i ++){
	$Escrito = Escritos::get( $Ids[$i]);
	$Texto = Parrafos::listar( $Ids[$i]);
	$Actor = Actuaciones::get( $Escrito['actor']);
	$Expediente = Expedientes::get( $Actor['expediente'], $_SESSION["JmZj07_juzgado"]);
	$Infraccion = Infracciones::getPrint( $Actor['expediente']);
	$Persona = Personas::getPorId( $Actor['persona']);
	$Reparticion = explode( "-", $Expediente['reparticion']);
	$Tag = array( '<sp>','</sp>','#AUTOS','#CARATULA','#FECHA_ACTA','#INFRACCION','#ACTA','#REPARTICION','#ORGANISMO','#SOLO_REPARTICION','#DIA','#MES','#ANO','#FOJA','#NOMBRE','#DOCUMENTO','#DOMICILIO');
	/* Probablemente sean de escritos personalizados
	$Tag = array('#FECHA_ESCRITO','#FECHA_AUTOS','#DESCRIPCION','#LUGAR','#DIRECCION','#TELEFONO','#INICIO_PERIODO','#FIN_PERIODO','#TIPO_INVESTIGACION','#PERSONAS','#STRING','#DENUNCIADOS','#MEDIDA','#LIBRE1','#LIBRE2','#COMPARENCIA_DESDE','#COMPARENCIA_HASTA','#DEUDA_LETRA','#DEUDA_NUMERO','#PERSONAS_ELEGIDAS');
	*/
	$Info = array( "","","<b>".$Expediente['autos']."</b>","<b>".$Expediente['caratula']."</b>","<b>".$Expediente['fecha_origen']."</b>","<b>".$Infraccion['ley_small']."</b>","<b>".$Expediente['numero_origen']."</b>","<b>".$Expediente['reparticion']."</b>","<b>".$Reparticion[0]."</b>","<b>".$Reparticion[1]."</b>","<b>".$Escrito['dia']."</b>","<b>".write_month( $Escrito['mes'])."</b>","<b>".$Escrito['ano']."</b>","<b>".$Escrito['fojas']."</b>","<b>".$Persona['apellido'].", ".$Persona['nombre']."</b>","<b>".$Persona['numero_documento']."</b>","<b>".$Persona['domicilio']."</b>");
	$Info = array_map( "utf8_decode", $Info);
	// -----------------
	switch( $Escrito['id_clase']){
		case  1: $Tipo_escrito = "CEDULA - ".$Escrito['nombre']; break;
		case  2: $Tipo_escrito = "DESCARGO - ".$Escrito['nombre']; break;
		case  3: $Tipo_escrito = "SENTENCIA - ".$Escrito['nombre']; break;
		case  5: $Tipo_escrito = "OFICIO - ".$Escrito['nombre']; break;
		default: $Tipo_escrito = "ESCRITO NO CONTEMPLADO - ".$Escrito['nombre']; break;
	}
	// $Tipo_escrito = $Escrito['nombre'];
	$pdf->startPageGroup();
	switch( $Escrito['id_clase']){
		case 1:/* Cedula */
			{
			$pdf->SetMargins( 40, 40, 15);
			$pdf->SetAutoPageBreak( true, 15);
			$pdf->setPrintFooter( false);
			$pdf->AddPage();
			array_push( $Tag, '#FECHA_CITACION','#HORA_CITACION');
			array_push( $Info,"<b>".$Escrito['fecha_citacion']."</b>","<b>".$Escrito['hora']."</b>");
			break;
			}
		case 2:/* Descargo */
			{
			$pdf->SetMargins( 40, 40, 15);
			$pdf->SetAutoPageBreak( true, 15);
			$pdf->setPrintFooter( false);
			$pdf->AddPage();
			array_push( $Tag, '#CON_DEFENSA','#ABOGADO','#DECLARACION');
			array_push( $Info,"<b>".$Escrito['defensa']."</b>","<b>".$Escrito['abogado']."</b>","<b>".$Escrito['declaracion']."</b>");
			break;
			}
		case 3:/* Sentencia */ /* `fojas_descargo`,`liberacion`,`ley`,`accion`,`auxiliar`,`tipo_escrito` */
			{
			// $pdf->startPageGroup();
			$pdf->SetMargins( 40, 40, 15);
			$pdf->SetAutoPageBreak( true, 15);
			$pdf->setPrintFooter( false);
			$pdf->AddPage();
			$pdf->SetBooklet( true, 40, 15);
			array_push( $Tag, '#MULTA_LETRA','#MULTA_NUMERO','#JUS','#CUENTA_NUMERO','#CUENTA_LETRA','#DENUNCIANTES','#ARRESTO_NUMERO','#ARRESTO_LETRA','#ARRESTO_CUMPLIMIENTO','#FECHA_DETENCION','#INSPECTORES','#LOCAL_NOMBRE','#LOCAL_DOMICILIO','#CONSTATACION','#PERIODO','#ARTICULO','#FUNDAMENTO','#VALORACION','#FECHA_NOTIFICACION','#CLAUSURA_DIAS','#DEPARTAMENTO','#FECHA_SENTENCIA','#TOMO','#FOLIO','#SECUESTROS_DESTINO','#SECUESTROS','#SECUESTROS_ACCION');
			array_push( $Info,"<b>[MONTO DE LA MULTA EN LETRAS]</b>","<b>".$Escrito['monto']."</b>","<b>[ESTAS SON LAS JUS]</b>","<b>".$Escrito['cuenta']."</b>","<b>".$Escrito['nombre_cuenta']."</b>","<b>[TODOS LOS DENUNCIANTES]</b>","<b>".$Escrito['dias_arresto']."</b>","<b>[DIAS DE ARRESTO EN LETRAS]</b>","<b>[CUMPLIMIENTO DEL ARRESTO]</b>","<b>".$Escrito['detencion']."</b>","<b>".$Escrito['inspectores']."</b>","<b>".$Escrito['nlocal']."</b>","<b>".$Escrito['dlocal']."</b>","<b>".$Escrito['constatacion']."</b>","<b>[AÑOS DE INACTIVIDAD]</b>","<b>[ARTICULO]</b>","<b>".$Escrito['fundamento']."</b>","<b>[VALORACION]</b>","<b>".$Escrito['notificacion']."</b>","<b>".$Escrito['dias_clausura']."</b>","<b>".$Escrito['departamento']."</b>","<b>[FECHA_SENTENCIA]</b>","<b>[TOMO]</b>","<b>[FOLIO]</b>","<b>[DESTINO DE LOS SECUESTROS]</b>","<b>[TODOS LOS SECUESTROS]</b>","<b>[ACCION SOBRE LOS SECUESTROS]</b>");
			break;
			}
		case 5:/* Oficio */  
			{
			$pdf->SetBooklet( true, 15, 40);
			$pdf->SetTopMargin( 40);
			$pdf->SetAutoPageBreak( true, 15);
			$pdf->setPrintFooter( false);
			// $pdf->AddPage();
			/*`foja`,`fecha_informe`,`empresa`,`tipo_investigacion`,`comisaria`,`telefono`,`fecha_mordedura`,`hora_mordedura`,`descripcion_accidente`,`descripcion_can`,`descripcion_lugar`,`fecha_detencion`,`fecha_ingreso`,`repart_manual`,`subrepart_manual`,`cargo_destinatario` */
			$pdf->SetMargins( 40, 40, 15);
			$pdf->AddPage();
			array_push( $Tag, '#DESTINO_AUTORIDAD','#DESTINO_REPARTICION','#PARRAFO_1','#PARRAFO_2','#PARRAFO_3','#PARRAFO_4');
			array_push( $Info,"<b>".$Escrito['autoridad']."</b>","<b>".$Escrito['reparticion']."</b>","<b>".$Escrito['cadena_1']."</b>","<b>".$Escrito['cadena_2']."</b>","<b>".$Escrito['cadena_3']."</b>","<b>".$Escrito['cadena_4']."</b>");
			
			break;
			}
		default:/* Escrito no contemplado */
			{
			$pdf->SetBooklet( true, 15, 40);
			$pdf->SetTopMargin( 40);
			$pdf->SetAutoPageBreak( true, 15);
			$pdf->setPrintFooter( false);
			$pdf->AddPage();
			$Texto[$j]['texto'] = 'Clase de escrito '.$Escrito['id_clase'];
			break;
			}
	}
	$Tipo_escrito = $Temp." - ".$Escrito['nombre'];
	// -----------------
	$Parrafos = count( $Texto);
	for( $x = 0; $x < $Parrafos; $x ++){
		$Parrafo = str_replace( $Tag, $Info, $Texto[$x]['texto']);
		$Parrafo = str_replace( array("<b>","</b>"), array("",""), $Parrafo);
		$Largo_maximo = 154.52;
		if( $Texto[$x]['relleno'] == 1){
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
	for( $j = 0; $j < $Parrafos; $j ++){
		$Parrafo = str_replace( $Tag, $Info, $Texto[$j]['texto']);
		switch( $Texto[$j]['align']){
			case 'J': $Aling="text-align:justify;"; break;
			case 'C': $Aling="text-align:center;"; break;
			case 'R': $Aling="text-align:right;"; break;
			default : $Aling="text-align:left;"; break;
		}
		$Sangria = "";
		for( $s = 0, $Largo_sangria = ( int)$Texto[$j]['sangria']; $s < $Largo_sangria; $s ++){
			$Sangria .= " ";
		}
		$pdf->SetFont( $Texto[$j]['font'], $Texto[$j]['stylo'], $Texto[$j]['size']);
		$html = '<span style="'.$Aling.'">'.$Sangria.''.$Parrafo.'</span>';
		$pdf->writeHTML( $html, true, false, true, false);
		$pdf->writeHTML( '<span></span>', true, false, true, false);
	}
}
/* --------------------------------------------------------------------------------- */
$pdf->Output('example_021.pdf', 'I');
?>