<?php
	function geraCodigoBarra($numero){
		$fino = 1;
		$largo = 3;
		$altura = 20;
		
		$barcodes[0] = '00110';
		$barcodes[1] = '10001';
		$barcodes[2] = '01001';
		$barcodes[3] = '11000';
		$barcodes[4] = '00101';
		$barcodes[5] = '10100';
		$barcodes[6] = '01100';
		$barcodes[7] = '00011';
		$barcodes[8] = '10010';
		$barcodes[9] = '01010';
		
		for($f1 = 9; $f1 >= 0; $f1--){
			for($f2 = 9; $f2 >= 0; $f2--){
				$f = ($f1*10)+$f2;
				$texto = '';
				for($i = 1; $i < 6; $i++){
					$texto .= substr($barcodes[$f1], ($i-1), 1).substr($barcodes[$f2] ,($i-1), 1);
				}
				$barcodes[$f] = $texto;
			}
		}
		
		echo '<img src="'.base_url().'assets/img/p.png"  height="'.$altura.'"     border="0" />';
		echo '<img src="'.base_url().'assets/img/b.png"  height="'.$altura.'"    border="0" />';
		echo '<img src="'.base_url().'assets/img/p.png"  height="'.$altura.'"    border="0" />';
		echo '<img src="'.base_url().'assets/img/b.png"  height="'.$altura.'"    border="0" />';
		
		echo '<img ';
		
		$texto = $numero;
		
		if((strlen($texto) % 2) <> 0){
			$texto = '0'.$texto;
		}
		
		while(strlen($texto) > 0){
			$i = round(substr($texto, 0, 2));
			$texto = substr($texto, strlen($texto)-(strlen($texto)-2), (strlen($texto)-2));
			
			if(isset($barcodes[$i])){
				$f = $barcodes[$i];
			}
			
			for($i = 1; $i < 11; $i+=2){
				if(substr($f, ($i-1), 1) == '0'){
  					$f1 = $fino ;
  				echo 'src="'.base_url().'assets/img/p.png"  height="'.$altura.'"  border="0">';
  				}else{
  					$f1 = $largo ;
  				echo 'src="'.base_url().'assets/img/pLarga.png"  height="'.$altura.'"  border="0">';
  				}
  				
  				//echo 'src="'.base_url().'assets/img/p.png"  height="'.$altura.'"  width="'.$f1.'" border="0">';
  				echo '<img ';
  				
  				if(substr($f, $i, 1) == '0'){
					$f2 = $fino ;
  				echo 'src="'.base_url().'assets/img/b.png"  height="'.$altura.'"  border="0">';
				}else{
					$f2 = $largo ;
  				echo 'src="'.base_url().'assets/img/bLarga.png"  height="'.$altura.'"  border="0">';
				}
				
			//	echo 'src="'.base_url().'assets/img/b.png"  height="'.$altura.'"  width="'.$f2.'" border="0">';
				echo '<img ';
			}
		}
		echo 'src="'.base_url().'assets/img/pLarga.png"  height="'.$altura.'"   border="0" />';
		echo '<img src="'.base_url().'assets/img/b.png"  height="'.$altura.'"    border="0" />';
		echo '<img src="'.base_url().'assets/img/p.png"  height="'.$altura.'"  width="1" border="0" />';
	}

?>