<?php

////////---------------PDF----------------//////////

require_once('doublesided.php');
$pdf = new DoubleSided_PDF();
$pdf->SetMargins(38,38,14);
$pdf->SetDoubleSided(38,14);
$pdf->AddPage();
$pdf->SetFont('Courier','',12);
$pdf->SetAutoPageBreak( true, 10);
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
$xcant = count($Parrafos);
$plus = ' -';
for( $x = 0; $x < $xcant; $x ++){
	if( ( $Parrafos[$x][2] == 1) || (($Parrafos[$x][2] == 7) && (strlen($Parrafos[$x][0])>10))){
		$palabras = explode(' ', $Parrafos[$x][0]);
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
			$Parrafos[$x][0] .= $plus;
		}//		SI  SE  PASA  UN  PLUS  HACIA  ABAJO  HAY  QUE  DISMINUIR  EL  VALOR  154.93  DE  A  UN  CENTESIMO!
	}
}
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
for( $x = 0; $x < $xcant; $x ++){
	switch( $Parrafos[$x][2]){
		case  7: 
			if(strlen($Parrafos[$x][0])>10)
				$pdf->MultiCell( 0, 6, $Parrafos[$x][0], 0, $Parrafos[$x][1]); 
			else
				$pdf->MultiCell(0,-2, '',0,'J');
			break;
		case  6: $pdf->SetMargins(14,38,38); break;
		case  5: $pdf->SetMargins(38,38,14); break;
		case  4: $pdf->SetFont('Courier','BU',12);
			 $pdf->MultiCell( 0, 8, $Parrafos[$x][0], 0, $Parrafos[$x][1]);
			 $pdf->SetFont('Courier','',12);
		break;	
		case  3: $pdf->Ln( $Parrafos[$x][0]); break;
		case  2: $pdf->AddPage(); break;
		default: $pdf->MultiCell( 0, 10, $Parrafos[$x][0], 0, $Parrafos[$x][1]); break;

	}
	$pdf->MultiCell(0,2, '',0,'J');
}
//  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
$pdf->Output();

////////-------------------------------//////////


?>