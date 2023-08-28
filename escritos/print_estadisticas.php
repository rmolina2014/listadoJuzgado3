<?php
require_once "../../controller/session_seguridad.php";
require("../../model/estadisticas.php");
require_once('fpdf/fpdf.php');

class MyPDF extends FPDF{
	function Tabla1( $Informe, $Desde, $Hasta){
		// Cabecera
		global $Titulo;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(125,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'ESTADISTICAS: Ranking de Incisos Infringidos',0,1,'R');		
		$this->Cell(236,7,'Período: '.$Desde.' al '.$Hasta,0,1,'R');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(13,6,'Orden',1,0,'C',1);
		$this->Cell(160,6,'Articulo',1,0,'C',1);
		$this->Cell(60,6,'Ley',1,0,'C',1);
		$this->Cell(20,6,'Cantidad',1,0,'C',1);
		$this->Ln(5);
		// Cuerpo
		$cant = count( $Informe);
		$this->setFillColor(255,255,255);
		for( $i = 0; $i < $cant; $i ++){
			$this->Cell(13,5,($i+1),1,0,'R',1);
			$this->Cell(160,5,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
			$this->Cell(60,5,utf8_decode(strtoupper($Informe[$i][1])),1,0,'L',1);
			$this->Cell(20,5,$Informe[$i][2],1,0,'R',1);
			$this->Cell(40,5,"",0,1,'L',1);
		}
	}
	function Tabla2( $Informe, $Cantidad, $Desde, $Hasta){
		// Cabecera
		global $Titulo;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(125,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'ESTADISTICAS: Cantidad de Causas Ingresadas discriminadas por Organismo',0,1,'R');		
		$this->Cell(236,7,'Período: '.$Desde.' al '.$Hasta,0,1,'R');
		$this->Ln(6);
		$this->Cell(236,7,'Cantidad de Causas: '.$Cantidad,0,1,'C');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(13,6,'Orden',1,0,'C',1);
		$this->Cell(160,6,'Organismo',1,0,'C',1);
		$this->Cell(20,6,'Cantidad',1,0,'C',1);
		$this->Ln(5);
		// Cuerpo
		$cant = count( $Informe);
		$this->setFillColor(255,255,255);
		for( $i = 0; $i < $cant; $i ++){
			$this->Cell(13,5,($i+1),1,0,'R',1);
			$this->Cell(160,5,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
			$this->Cell(20,5,utf8_decode(strtoupper($Informe[$i][1])),1,0,'R',1);
			$this->Cell(40,5,"",0,1,'L',1);
		}
	}	
	function Tabla3( $Informe, $Desde, $Hasta){
		// Cabecera
		global $Titulo;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(125,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'ESTADISTICAS: Cantidad de Causas Ingresadas discriminadas por Reparticion Origen',0,1,'R');		
		$this->Cell(236,7,'Período: '.$Desde.' al '.$Hasta,0,1,'R');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(13,6,'Orden',1,0,'C',1);
		$this->Cell(120,6,'Organismo',1,0,'C',1);
		$this->Cell(100,6,'Reparticion',1,0,'C',1);
		$this->Cell(20,6,'Cantidad',1,0,'C',1);
		$this->Ln(5);
		// Cuerpo
		$cant = count( $Informe);
		$this->setFillColor(255,255,255);
		for( $i = 0; $i < $cant; $i ++){
			$this->Cell(13,5,($i+1),1,0,'R',1);
			$this->Cell(120,5,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
			$this->Cell(100,5,utf8_decode(strtoupper($Informe[$i][1])),1,0,'L',1);
			$this->Cell(20,5,utf8_decode(strtoupper($Informe[$i][2])),1,0,'R',1);
			$this->Cell(40,5,"",0,1,'L',1);
		}
	}
	function Tabla4( $Informe, $Desde, $Hasta){
		// Cabecera
		global $Titulo;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(125,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'ESTADISTICAS: Ranking de Incisos Infringidos por Organismo',0,1,'R');		
		$this->Cell(236,7,'Período: '.$Desde.' al '.$Hasta,0,1,'R');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(13,6,'Orden',1,0,'C',1);
		$this->Cell(90,6,'Organismo',1,0,'C',1);
		$this->Cell(110,6,'Articulo',1,0,'C',1);
		$this->Cell(30,6,'Ley',1,0,'C',1);
		$this->Cell(20,6,'Cantidad',1,0,'C',1);
		$this->Ln(5);
		// Cuerpo
		$cant = count( $Informe);
		$this->setFillColor(255,255,255);
		for( $i = 0; $i < $cant; $i ++){
			$this->Cell(13,5,($i+1),1,0,'R',1);
			$this->Cell(90,5,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
			$this->Cell(110,5,utf8_decode(strtoupper($Informe[$i][1])),1,0,'L',1);
			$this->Cell(30,5,utf8_decode(strtoupper($Informe[$i][2])),1,0,'L',1);
			$this->Cell(20,5,utf8_decode(strtoupper($Informe[$i][3])),1,0,'R',1);
			$this->Cell(40,5,"",0,1,'L',1);
		}
	}	
	function Tabla5( $Informe, $Desde, $Hasta){
		// Cabecera
		global $Titulo;
		$this->setXY(25,13);
	    $this->SetFont('Arial','B',11);
		$this->SetTextColor(70);
		$this->Cell(125,7,'TERCER JUZGADO DE FALTAS',0,0,'L');
		$this->Cell(125,7,'ESTADISTICAS: Ranking de Incisos Infringidos por Organismo y Reparticion',0,1,'R');		
		$this->Cell(236,7,'Período: '.$Desde.' al '.$Hasta,0,1,'R');
		$this->Ln(6);
		$this->setFillColor(200,200,200);
		$this->SetFont('Courier','B',11);
		$this->Cell(13,6,'Orden',1,0,'C',1);
		$this->Cell(80,6,'Organismo',1,0,'C',1);
		$this->Cell(70,6,'Reparticion',1,0,'C',1);
		$this->Cell(70,6,'Articulo',1,0,'C',1);
		$this->Cell(20,6,'Cantidad',1,0,'C',1);
		$this->Ln(5);
		// Cuerpo
		$cant = count( $Informe);
		$this->setFillColor(255,255,255);
		for( $i = 0; $i < $cant; $i ++){
			$this->Cell(13,5,($i+1),1,0,'R',1);
			$this->Cell(80,5,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
			$this->Cell(70,5,utf8_decode(strtoupper($Informe[$i][1])),1,0,'L',1);
			$this->Cell(70,5,utf8_decode(strtoupper($Informe[$i][2])),1,0,'L',1);
			$this->Cell(20,5,utf8_decode(strtoupper($Informe[$i][3])),1,0,'R',1);
			$this->Cell(40,5,"",0,1,'L',1);
		}
	}	
	function Footer(){
		$this->setXY(25,190);
	    $this->SetFont('Arial','B',10);
		$this->SetTextColor(70);
		$this->Cell( 0, 2,'_______________________________________________________________________________________________________________________________',0,1,'L');
		$this->Cell(125,7,'Fecha de impresión: '.date(d).'/'.date(m).'/'.date(Y),0,0,'L');
		$this->Cell(125,7,'Página '.$this->PageNo().'/{nb}',0,1,'R');
		$this->Ln(25);
	}
}
// - - - - - - - - - - - - - - - - - - - - - -
isset($_GET['desde']) ? $Desde = trim( $_GET['desde']) : $Desde = 0;
isset($_GET['hasta']) ? $Hasta = trim( $_GET['hasta']) : $Hasta = 0;
list( $yearD, $monD, $dayD) = explode( '-', $Desde);
list( $yearH, $monH, $dayH) = explode( '-', $Hasta);
$InformeDesde= $dayD.'/'.$monD.'/'.$yearD;
$InformeHasta= $dayH.'/'.$monH.'/'.$yearH;
//$estadistica = new estadistica();
$juzgado = $_SESSION["JmZj07_juzgado"];
$pdf=new MyPDF('L', 'mm', 'A4');
$pdf->SetMargins(25,25,8);
$pdf->AliasNbPages();
$Informe = array();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
// - - - - - - - - INFORME 1: Ranking de Incisos Infringidos en materia contravencional- - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$pdf->AddPage();
$Informe = Estadisticas::getRankingIncisosInfringidos($Desde, $Hasta,$juzgado);
$pdf->Tabla1($Informe, $InformeDesde, $InformeHasta);
 

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
// - - - - - - - - INFORME 2: Cantidad de Causas Ingresadas en el periodo  - - - - - - - - - - - - - - 
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

$pdf->AddPage();
$Cantidad = Estadisticas::getCausasIngresadas($Desde, $Hasta ,$juzgado);

$Informe = Estadisticas::getCausasIngresadasXOrganismo($Desde, $Hasta ,$juzgado);

$pdf->Tabla2($Informe, $Cantidad, $InformeDesde, $InformeHasta);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
// - - - - - - - - INFORME 3: Cantidad de Causas segun Reparticion en la cual se originan  - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

$pdf->AddPage();
$Informe = Estadisticas::getCausasSegunReparticionOrigen($Desde, $Hasta ,$juzgado);

$pdf->Tabla3($Informe, $InformeDesde, $InformeHasta);

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// // - - - - - - - - INFORME 4: Ranking de Incisos Infringidos en materia contravencional x Organismo  -
// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$pdf->AddPage();
$Informe = Estadisticas::getRankingIncisosInfringidosXOrganismo($Desde, $Hasta ,$juzgado);
$pdf->Tabla4($Informe, $InformeDesde, $InformeHasta);

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// // - - - - - - - - INFORME 5: Ranking de Incisos Infringidos en materia contravencional x Org y Rep  -
// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$pdf->AddPage();
$Informe = Estadisticas::getRankingIncisosInfringidosXOrgYRep($Desde, $Hasta ,$juzgado);
$pdf->Tabla5($Informe, $InformeDesde, $InformeHasta);

// - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - INFORME 6: Expedientes en archivo  -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$pdf->AddPage();
$pdf->SetFont( 'Courier', 'BU', 12);
$pdf->MultiCell( 0, 12, "INFORMACIÓN ADICIONAL", 0, 'C');

$Informe = Estadisticas::getEnArchivo($Desde, $Hasta,$juzgado);

$pdf->SetFont( 'Courier', '', 12);
$pdf->MultiCell( 0, 6, "Cantidad de expedientes en archivo (no incluye OSSE): $Informe", 0, 'J');

$Informe = Estadisticas::getEnArchivoOSSE($Desde, $Hasta,$juzgado);
$pdf->MultiCell( 0, 6, "Cantidad de expedientes de OSSE en archivo: $Informe", 0, 'J');

$Informe = Estadisticas::getSentencias($Desde, $Hasta,$juzgado);

$pdf->Ln(6);
$pdf->setFillColor(200,200,200);
$pdf->SetFont('Courier','B',11);
$pdf->Cell(130,6,'SENTENCIA (no incluye OSSE)',1,0,'C',1);
$pdf->Cell(40,6,'CANTIDAD',1,0,'C',1);
$pdf->Ln(5);
$cant = count( $Informe);
$pdf->setFillColor(255,255,255);
$pdf->SetFont('Courier','',9);
for( $i = 0; $i < $cant; $i ++){
	$pdf->Cell(130,4,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
	$pdf->Cell(40,4,utf8_decode(strtoupper($Informe[$i][1])),1,0,'L',1);
	$pdf->Cell(80,4,"",0,1,'L',1);
}

$Informe = Estadisticas::getSentenciasOSSE($Desde, $Hasta,$juzgado);



$pdf->Ln(6);
$pdf->setFillColor(200,200,200);
$pdf->SetFont('Courier','B',11);
$pdf->Cell(130,6,'SENTENCIA OSSE',1,0,'C',1);
$pdf->Cell(40,6,'CANTIDAD',1,0,'C',1);
$pdf->Ln(5);
$cant = count( $Informe);
$pdf->setFillColor(255,255,255);
$pdf->SetFont('Courier','',9);
for( $i = 0; $i < $cant; $i ++){
	$pdf->Cell(130,4,utf8_decode(strtoupper($Informe[$i][0])),1,0,'L',1);
	$pdf->Cell(40,4,utf8_decode(strtoupper($Informe[$i][1])),1,0,'L',1);
	$pdf->Cell(80,4,"",0,1,'L',1);
}

// - - - - - - - - - - - - - - - - - - - - - -


$pdf->Output();
?>
