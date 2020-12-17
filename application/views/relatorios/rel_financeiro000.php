
    <style>
.badgebox
{
    opacity: 0;
}
.badgebox + .badge
{
    text-indent: -999999px;
	width: 27px;
}
.badgebox:focus + .badge
{
    box-shadow: inset 0px 0px 5px;
}
.badgebox:checked + .badge
{
	text-indent: 0;
}
</style>

<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-list-alt"></i>
                            </span>
                            <h5>Relatórios Mensais</h5>
                        </div>
                        <div class="widget-content">
                            <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiro" method="post">
                            <div class="span12 well">
                            <div class="span3">
                         <?php    
                           /* $conta = $usuario->conta_Usuario;
                            $nivel = $usuario->permissoes_id;	
                            $tipo_conta_acesso = $usuario->celular;
                            echo 'Conta '. $conta.' Nivel '. $nivel.' Acesso de conta '. $tipo_conta_acesso ;*/
                               ?>
                            <p class="conta">                    
                            <label for="conta">Conta</label>
                              <select id="conta" name="conta">
                                
                             <?php
                                    foreach ($result_caixas as $rcx) {  
                                          
                                   
                                        
                                     if(isset($_SESSION['contA'] ))
                                    {
                                    foreach ($result_caixas as $rcxx)
                                    {                                        
                                        if($_SESSION['contA'] == $rcxx->id_caixa) 
                                        {?>
                                       <option value = "<?php echo $rcxx->id_caixa ?>"><?php echo $rcxx->id_caixa." | ".$rcxx->nome_caixa ?></option>
                                       <?php 
                                    }}
                                        unset($_SESSION['contA']) ;
                                    }
                                      if($usuario->conta_Usuario == 99)
                                      {                                     
                                      ?>
                                <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa; ?></option>
                                        <?php
                                    }else
                                      if($usuario->conta_Usuario == $rcx->id_caixa){
                                          ?>
                                <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                        <?php
                                      }
                                    }
                                  ?>														
                                  </select>
                                <font color=red><span class="style1"> * </span></font>	                    
                      </p>
                        </div>
                        <div class="span3">             
                            <label for="conta">Ano</label>
                                  <?php 
                                  $ano =date("Y");
                                  $anoIni = 2009;
                                  ?>	
                                    <select id="ano" name="ano">
                                            <option value ='<?php echo $ano?>'><?php echo $ano ?></option>
                                            <?php --$ano;
                                                while($anoIni < $ano) {?>
                                            <option value = '<?php echo $ano ?>'><?php echo $ano?></option>										
                                            <?php --$ano;} ?>														
                                            </select><span class="style1">*</span>

                        </div>
                                <div class="span3">
                                <label for="conta">Mês</label>	
                                  <?php
                                        $meses = array("", "janeiro", "fevereiro", "março", "abril",
                                        "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
                                        $data = date("m");
                                        $data <= 9 ? $data = $data[1] : $data = $data;
                                        ?>
                                        <select id="mes" name="mes">
                                        <option value='<?php echo $data ?>'><?php echo ' '.$meses[$data] ?></option>
                                        <?php                                            
                                        for($i = 1; $i <= count($meses)-1; $i++) {
                                        $i == $data ? $valor = "selected" : $valor = "";
                                       // $i <= 9 ? $ii = "'0'.$i." : $ii = $i;
                                        ?>
                                        <option value='<?php echo $i ?>'><?php echo ' '.$meses[$i] ?></option>
                                        <?php
                                  }
                                        ?>
                                        </select>												
                                             <span class="style1">*</span>
                                </div>      
                             <div class="span3">              
                              <div class="widget-content">                 
                                 <button class="btn btn-success span12"><i class="icon-white icon-user"></i> Relatório mensal</button>
				<div class="pull-right">
                     <label  class="btn btn-default" submit><input  name="excel"  type="checkbox" value="Corrente"   class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Gerar Excel</label>
                      
                </div>
                            </div>	                       
                            </div>

                            </div>

                            </form>
                            &nbsp
                        </div>
                    </div>
                </div>
                  <?php
                 if(!(isset($lancamentos)))        
                    {
                    ?>
        </div>
    </div>
    <div class="span12">
      <div class="widget-box">
            
         <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-list-alt"></i>
                    </span>
                    <h5>Relatórios Customizáveis</h5>
                </div>
                <div class="widget-content">
                    <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiroCustom" method="get">
                    <div class="span12 well">

                        <div class="span3">
                            <label for="">Lançamento de:</label>
                            <input type="date" name="dataInicial" class="span8" />
                        </div>
                        <div class="span3">
                            <label for="">até:</label>
                            <input type="date" name="dataFinal" class="span8" />
                        </div>


                        <div class="span3">
                            <label for="">Tipo:</label>
                            <select name="tipo" class="span8">
                                <option value="todos">Todos</option>
                                <option value="receita">Receita</option>
                                <option value="despesa">Despesa</option>
                            </select>
                        </div>
                        <div class="span3">

                            <p class="conta">                    
                                    <label for="conta">Conta</label>
                                      <select id="conta" name="conta">
                                     <?php
                                            foreach ($result_caixas as $rcx) {                   
                                          if($usuario->conta_Usuario == 99)
                                          {?>

                                        <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                                <?php
                                            }else
                                              if($usuario->conta_Usuario == $rcx->id_caixa){
                                                  ?>
                                        <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                                <?php
                                              }
                                            }
                                          ?>														
                                          </select>
                                        <font color=red><span class="style1"> * </span></font>	                    
                                      </p>
                                </div>

                    </div>
                    <div class="span3" style="margin-left: 0; text-align: center">
                            <input type="reset" class="btn" value="Limpar" />
                            <button class="btn btn-inverse"><i class="icon-print icon-white"></i> Imprimir</button>
 </div>
                    </form>
                    &nbsp
                </div>
            </div>
        </div>
            
       </div>
    </div>
    <?php
         }else
   if((isset($lancamentos)))
     {
         
        // echo 'ok';
    ?>
       
 <div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-list-alt"></i>
            </span>
            <h5>Relatórios gerado</h5>
            <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiro" method="post">
                   <input id="excel" name="excel"  type="hidden" value="1"/>
                <div class="row espaco">
                </div>
           </form> 
        </div>
      <div class="container-fluid">
    
          <div class="row-fluid">
          <?php    
               $adm =  "cod_compassion";
              $html = '';
              $total =  0;
            if($adm == "cod_compassion" )
             {
                $mesN = 'mês';
                $ano = 'ano';
                $tipo_Contas = 0;
           $dataInicial = $_SESSION['dataInicial'];
           $dataFinal  = $_SESSION['dataFinal'];
				foreach ($lancamentos as $l)                                   
				{	// echo 'CONTA '.$l->conta;
               /*     $id_fin     => $l->id_fin;
                    $tipo_Conta     => $l->tipo_Conta;
                    $cod_compassion     => $l->cod_compassion;
                    $cod_assoc     => $l->cod_assoc;
                    $num_Doc_Banco     => $l->num_Doc_Banco;
                     $historico     => $l->historico;
                    $descricao     => $l->descricao;
                     $dataFin     => $l->dataFin;
                    $valorFin     => $l->valorFin;
                     $tipo_Pag     => $l->tipo_Pag;
                    $conta_Destino     => $l->conta_Destino;
                     $saldo     => $l->saldo;
                   */   
                    $conta   = $l->conta;
                    $cdiNome = "CDI NOVAS DE PAZ"; $cidadeNome = "sede"; $caixaNome = '0000'; 
                    $saldo_Mes     = $l->saldo_Mes;
               // echo    $l->valorFin;
                    if($dataInicial <= $l->dataFin && $dataFinal >= $l->dataFin)
                   {
                       
                //  $conta   = $l->conta; 
                           
                    switch ($conta) 
					{						 
						case 1:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break;  
						case 2:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break;  
						case 3:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break;  
						case 4:	$cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; break;  
						case 5:	$cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; break;  
						case 6:	$cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542';  break;  
						case 7:	$cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; break;  
						case 8:	$cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; break; 	 
						case 9:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = '000'; break; 	 
						case 10:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = '000'; break; 		
					}	
					if( $l->tipo_Conta == "Corrente"){$saldo_Ant = 	0;//$saldo_Ant->saldo;	
                                                      $tipo_Conta_Atual = 1;	$abrev = "C/C:";}else		
					if( $l->tipo_Conta == "Suporte")	{$saldo_Ant = 	0;//$saldo_Ant->saldo;		
                                                         $tipo_Conta_Atual = 2;	$abrev = "C/S:";}else
					if( $l->tipo_Conta == "Poupança"){$saldo_Ant = 	0;//$saldo_Ant->saldo;	
                                                      $tipo_Conta_Atual = 3;	$abrev = "C/P:";}	
                    
					/*{$admN = "Compassion"; $adm_C = "cod_compassion";  $admCod = "cod_Comp";  $admArea = "area_Cod";  $admDescri = "descricao";}*/
                   // echo $adm.' - codigo do registro $row[$adm} - ] '.$l->$adm.' -  $admCod '.$admCod.' - ';
                   /* $sqlCod = 'SELECT * FROM  '.$adm.' WHERE   '.$admCod.'  = "'.$l->$adm.'" limit 1';
                        $queryCodigo = mysqli_query($conex, $sqlCod);
                    
                    if (!$queryCodigo ) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									//exit;
					}
				if (mysqli_num_rows($queryCodigo) == 0 ) 
				{	echo '<br>Linha: ' . __LINE__ . '<br>Nao foi encontrado nenhum Item com estes criterios. Tente novamente!';  // exit;
				}
				
                    while($cod_row = mysqli_fetch_assoc($queryCodigo)) */
                       { $admAr = "Admin"; $admDesc = "Admin Desc"; }
                    
                   // echo '<br /><font color=red size="3"> Coluna '.$adm_C. ' | Area '.$admAr.' | descri '.$admDesc.' | Codigo '.$l->$adm.' | <td></font><br /><br />';
                   
					if($tipo_Contas == 0)
						{
                        $primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; $total = $saldo_Ant;
						}else	
                        if($tipo_Contas <> $tipo_Conta_Atual)
						{	$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; 
							$total =  number_format($total, 2, ',', '.');
						  $html .=  '<td></td> <td></td> <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>'; 
                         
							$html .=  '<td><h4 align="right" valign=bottom >'.$total.'</h4></td>';
				            $html .=  '</tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
 
							echo '<td></td> <td></td> <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;	
						}	
						if($primeiroReg == "S") 
						{
							
							$html .= '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							  if( $l->tipo_Conta == "Corrente")
                            {
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >CONTA CORRENTE - BANCO
							         </th> <th align="center" >Folha Nº4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >CAIXA PEQUENO
							         </th> <th align="center" >Folha Nº5</th>  </tr>';							
							$html .=   '<tr><th colspan="3">Projeto</th> <th colspan="3" align="center"  align="center" >'.$cdiNome.'</th>';
							$html .=   '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							$html .=   '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';
                            $html .=   '<tr><th colspan="9" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha               Compassion. Copie apenas os campos em "amarelo".</th>';
                            $html .=    ' </tr>';
                            
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro" ><th width="30" rowspan="3"> Registro</th>';	
							$html .=   '<th width="30" rowspan="3">Data</th>';	
							$html .=   '<th width="30" rowspan="3">Conta</th>';	
							$html .=   '<th width="30" rowspan="3">Forma ou cheque</th>';	
							$html .=   '<th rowspan="3"> Área </th> <th rowspan="3"> Descrição </th>';	
							$html .=   '<th width="100" rowspan="3">Histórico</th>';	
							$html .=   '<th width="80" rowspan="3">Entrada(R$)</th>';	
							$html .=   '<th width="50" rowspan="3">Saída(R$)</th>';	
							$html .=   '<th width="50" rowspan="1">Saldo MÊS</th>';	
							$html .=   '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr> </tr><tr>';
							$html .=  '<td  colspan="9" ></td>  ';
							$html .=  '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=  '</tr>';		
                            
                            
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="100%">';
                            if( $l->tipo_Conta == "Corrente")
                            {
                                echo '<thead ><tr bgcolor="Gainsboro" ><th ROWSPAN="5"></th> <th colspan="8" >CONTA CORRENTE - BANCO
							         </th> <th align="center" >Folha No4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							     echo '<thead ><tr bgcolor="Gainsboro"><th ROWSPAN="5"></th> <th colspan="8" >CAIXA PEQUENO
							         </th> <th align="center" >Folha No5</th>  </tr>';							
							echo '<tr><th colspan="3">Projeto</th> <th colspan="3" align="center"  align="center" >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							echo '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="9" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';		
							//echo '<tr><th rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';
                            
							//echo '<tr><th width="60" rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th></tr>';	
							echo '<tr rowspan="3" bgcolor="Gainsboro" style="font-size:70%" ><th  rowspan="3"> Registro</th>';	
							echo '<th rowspan="3">Data</th>';	
							echo '<th  rowspan="3">Conta</th>';	
							echo '<th  rowspan="3">Forma ou cheque</th>';	
							echo '<th  rowspan="3"> Área </th> <th rowspan="3">Descrição</th>';	
							echo '<th width="150" rowspan="3"> Histórico</th>';	
							echo '<th width="50" rowspan="3">Entrada(R$)</th>';	
							echo '<th width="50" rowspan="3">Saída(R$)</th>';	
							echo '<th width="50" rowspan="1">Saldo MÊS</th>';	
							echo '</tr> <tr><th> ',number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							echo '<tbody style="font-size:100%">';														
							echo '<tr>';
							echo '<td  colspan="9" ></td>  ';
							echo '<td bgcolor="yellow"  >',number_format($saldo_Ant, 2, ',', '.').'</td>';
                            echo '</tr>';							
													
					$primeiroReg = "N";
						}					
						if($l->ent_Sai == 0) {		$Sai = number_format($l->valorFin, 2, ',', '.'); $ent = "";	}
						else if($l->ent_Sai == 1){ 	$ent = number_format($l->valorFin, 2, ',', '.'); $Sai = "";}
							$val = $l->valorFin;
							if($l->ent_Sai == 0) $total = $total - $val;
							else $total = $total + $val;
								$datX= implode('/',array_reverse(explode('-',$l->dataFin)));
						
                    
						$html .=  '<tr heigth="100" >';
						$html .=  '<td>' . $l->id_fin . '</td>';                      
						$html .=  '<td bgcolor="yellow">' . $datX . '</td>';                      
						$html .=  '<td bgcolor="yellow">' .$l->$adm. '</strong></td>';
						$html .=  '<td bgcolor="yellow">' .$l->num_Doc_Banco . '</td>';
                        $html .=  ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
						$html .=  '<td bgcolor="yellow" >' .$l->historico . '</td>';
						if($ent == 0) 
                            $html .=  '<td align="right">'.$ent.'</td>';
                        else 
                            $html .=  '<td bgcolor="yellow" align="right">'.$ent.'</td>';
						if($Sai == 0) 
                            $html .=  '<td align="right">'.$Sai.'</td>';
                        else 
                            $html .=  '<td bgcolor="yellow" align="right">'.$Sai.'</td>';
						$html .=  '<td align="right">'.number_format($total, 2, ',', '.').'</td>';
						$html .=  '</tr>';
                    
						echo '<tr>';
						echo '<td  > ' . $l->id_fin . ' </td>';                      
						echo '<td  heigth="100" bgcolor="yellow"  > ' . $datX . ' </td>';                      
						echo '<td  heigth="100" bgcolor="yellow"> ' .$l->$adm. '</strong> </td>';
						echo '<td  heigth="100" bgcolor="yellow"> ' .$l->num_Doc_Banco . ' </td>';
                        echo ' <td  heigth="100"> '.$admAr.' </td> <td> '.$admDesc.' </td>';
                        
                        $ok = 0;
                        $bR = " ";
                        foreach ($presentes_pagos as $pPr) 
                    {	
                            if($pPr->id_saida == $l->id_fin){ $bR = " - ".$pPr->n_beneficiario; }
                        }
                       if($l->num_Doc_Fiscal == "RECIBO" || $l->num_Doc_Fiscal == "S/N") {$docFiscal = " ";} else $docFiscal = " - ".$l->num_Doc_Fiscal;
                        
                        $historico = $l->historico.$docFiscal.$bR;
                        
                        
                        
						echo '<td  heigth="100" bgcolor="yellow" > ' .$historico.' </td>';
                        if($ent == 0) 
                            echo '<td  heigth="100" align="right"> '.$ent.' </td>';
                        else 
                            echo '<td  heigth="100" bgcolor="yellow" align="right"> '.$ent.' </td>';
                        if($Sai == 0) 
                            echo '<td  heigth="100x" align="right"> '.$Sai.' </td>';
                        else 
                            echo '<td  heigth="100" bgcolor="yellow" align="right"> '.$Sai.' </td>';
						echo '<td  heigth="100" align="right"> '.number_format($total, 2, ',', '.').' </td>';
						echo '</tr>';
                }
                
				}
                            
							$total =  number_format($total, 2, ',', '.');
                            $html .=  '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';
							$html .=  '<td bgcolor="white"  ><h5 align="right" valign=bottom > '.$total.' </td></tr>';
							$html .=  '</tbody></table></br>';
                    
							echo '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td bgcolor="white"  ><h5 align="right" valign=bottom > ',$total.' </td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                
                $html .=   '<br>';
                    echo '<br>';
                
                    $conta   = 5;
                foreach ($lancamentos as $l){  $conta   = $l->conta; }
          //PRESENTES PAGOS NO MÊS      >>>>>WHERE SUBSTRING(n_beneficiario,1,6) LIKE "'.$contN.'"  and valor_pendente < 1  
                                                 //   and data_presente >= "'.$data_x1.'" and data_presente <= "'.$data_x2.'"
                
                        switch ($conta) 
					{	
						case 1:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "1";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 2:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 3:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 4:	$contN = "BR0214"; $cidadde = "Abreu e Lima"; $cdi = "000";     $cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; break; 
						case 5:	$contN = "BR0518"; $cidadde = "Paulista";     $cdi = "2";     $cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; break;   
						case 6:	$contN = "BR0542"; $cidadde = "Bezerros";     $cdi = "3";     $cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542';  break;  
						case 7:	$contN = "BR0549"; $cidadde = "Catende";      $cdi = "4";     $cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; break;
						case 8:	$contN = "BR0579"; $cidadde = "Jurema";       $cdi = "5";     $cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; break;  
                        case 9:	$contN = "000"; $cidadde = "Abreu e Lima";       $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "JUREMA";  $caixaNome = '000'; break;  
                        case 10:	$contN = "000"; $cidadde = "Abreu e Lima";       $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "JUREMA";  $caixaNome = '000'; break;  
                        case 99:$contN = "Todas contas"; break;  				
					}
                       					 
                
              
            if (!$presentes_pagos ) 
                {	echo "<br>Linha: ". __LINE__ ."<br><center><font color = red >Nao existem registros de presentes especiais!</font>";
                }
                else
                { 
                    
							$html .=   '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="4"></th> <th colspan="7" >PAGAMENTOS DE PRESENTES ESPECIAIS
							         </th> <th align="center" >Folha Nº6-1</th>  </tr>';							
							$html .=   '<tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							$html .=   '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							$html .=   '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							$html .=   '<tr><th colspan="9" style="font-size:70%"></th>';
							$html .=   ' </tr>';								
							$html .=   ' </tr >';
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro"><th width="60" rowspan="2"> Registro</th>';	
							$html .=   '<th width="60" >DATA</th>';	
							$html .=   '<th width="50" >NÚMERO DA CRIANÇA</th>';	
							$html .=   '<th width="360">NOME DA CRIANÇA</th>';	
							$html .=   '<th width="130" >MÊS/ANO DA LISTAGEM</th>';	
							$html .=   '<th width="80" >NÚMERO DO PROTOCOLO</th>';	
							$html .=   '<th width="80">VALOR RECEBIDO (ENTRADAS)</th>';	
							$html .=   '<th width="80">VALOR PAGO (SAÍDAS)</th>';	
							$html .=   '<th width="80">SALDO</th></tr>';	
							$html .=   '</thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr>';
							$html .=   '<td  colspan="7" align="right">SALDO INICIAL DO MÊS > > > > ></td>  ';
							$html .=   '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=   '</tr>';		
                   
                    
							echo '<table  border=1 cellspacing=0 bgcolor="white">';
							echo '<thead ><tr bgcolor="Gainsboro"><th ROWSPAN="5"></th> <th colspan="7" >PAGAMENTOS DE PRESENTES ESPECIAIS
							         </th> <th align="center" >Folha Nº6-1</th>  </tr>';							
							echo '<tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							echo '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="8" style="font-size:70%"></th>';
							echo ' </tr>';
							echo '<tr rowspan="3" bgcolor="Gainsboro" style="font-size:70%"><th width="60" rowspan="3"> Registro</th>';	
							echo '<th width="60" >DATA</th>';	
							echo '<th width="50" >NÚMERO DA CRIANÇA</th>';	
							echo '<th width="360" >NOME DA CRIANÇA</th>';	
							echo '<th width="130">MÊS/ANO DA LISTAGEM</th>';	
							echo '<th width="80">NÚMERO DO PROTOCOLO</th>';	
							echo '<th width="80">VALOR RECEBIDO (ENTRADAS)</th>';	
							echo '<th width="80">VALOR PAGO (SAÍDAS)</th>';	
							echo '<th width="80" >SALDO</th></tr>';	
							echo '</thead>';
							echo '<tbody >';														
							echo '<tr>';
							echo '<td></td><td  colspan="7" align="right">SALDO INICIAL DO MÊS > > > > ></td>  ';
							echo '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            echo '</tr>';		
                   

                    $total = 0;	$inicio = 1; $totalG = 0; $totalData = 0; $contaY = 0;
                   foreach ($presentes_pagos as $pP) 
                    {	
                       
                    if($dataInicial <= $pP->data_presente)
                        if((substr($pP->n_beneficiario,-11,6) == $contN ))
                    {
                          //$data_Ch= implode('/',array_reverse(explode('-',$pP->dataFin )));
                        $val_Ch= number_format($pP->valor_entrada , 2, ',', '.');
                        $valor_pendente= number_format($pP->valor_pendente , 2, ',', '.');
                        $mesPresente_Entrada =  $pP->dataFin;
                        $anoE =  date('Y', strtotime($mesPresente_Entrada));
                           $mes_extenso = array(
                            'Jan' => 'Janeiro', 'Feb' => 'Fevereiro', 'Mar' => 'Marco', 'Apr' => 'Abril', 
                            'May' => 'Maio', 'Jun' => 'Junho', 'Jul' => 'Julho', 'Aug' => 'Agosto', 
                            'Sep' => 'Setembro', 'Oct' => 'Outubro', 'Nov' => 'Novembro', 'Dec' => 'Dezembro'
                        );
                        $mesPresente_Entrada = date('M', strtotime($mesPresente_Entrada));

                        $mes_extenso = $mes_extenso[$mesPresente_Entrada] ;
                        	
                        if($pP->valor_saida == 0) $cor = "#F7F8E0"; else $cor = "Yellow";
                            $html .=    '<tr  bgcolor=   '.$cor.'>';
                            $html .=    ' <td bgcolor="white">'.$pP->id_presente .'</td> 
                            <td><strong>'.$pP->data_presente .'</td>';
                            $html .=    '<td align="right">'.$pP->n_beneficiario .'</td> <td>'.$pP->nome_beneficiario .'</td>';
                            $html .=    '<td align="right">'.$mes_extenso.' -- '.$anoE.'</td>';
                            $html .=    '<td align="right">'.$pP->n_protocolo .'</td>';
                           	$html .=    '<td align="right">'.number_format($pP->valor_entrada, 2, ',', '.') .'</td> 
                            <td align="right">'.number_format($pP->valor_saida, 2, ',', '.') .'</td> <td bgcolor="white"></td> </tr>';
                           		
                            echo '<tr  bgcolor='.$cor.'>';
                            echo ' <td bgcolor="white">'.$pP->id_presente .'</td> 
                            <td><strong>'.$pP->data_presente .'</td>';
                            echo '<td align="right">'.$pP->n_beneficiario .'</td> <td>'.$pP->nome_beneficiario .'</td>';
                            echo '<td align="right">'.$mes_extenso.' -'.$anoE.'</td>';
                            echo '<td align="right">'.$pP->n_protocolo .'</td>';
                           	echo '<td align="right">'.number_format($pP->valor_entrada, 2, ',', '.') .'</td> 
                            <td align="right">'.number_format($pP->valor_saida, 2, ',', '.') .'</td> <td bgcolor="white"></td></tr>';
                           							
                              //  $total += $pP->valor_pendente;
                            
                    } 	
                   //    echo $pP->n_beneficiario.'  '.$contN.'  - ';
                   }
                   $html .=    '<tr><td colspan="9"></td> </tr>';
                            
                    
                    $html .=   '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                    echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante

                }
                 $html .=   '<br>';
                    echo '<br>';
                
                /*
                
          //RECONCILIAÇÃO BANCÁRIA      >>>>>
           	$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
                            WHERE id_fin = id_aenp and  conta like '.$caixa.' and status like 0 ORDER BY dataFin ');
            if (mysqli_num_rows($cheques_abertos) == 0 ) 
                {	echo "<center><font color = red >Nao existem registros de cheques á compensar!</font>";
                }else
                if (mysqli_num_rows($cheques_abertos) > 0 )
                {
                   
							$contaBanco = mysqli_query($conex, 'SELECT * FROM caixas
                                                        WHERE id_caixa like '.$caixa.' LIMIT 1');
                        if (mysqli_num_rows($contaBanco) == 0 ) 
                            {	echo "<center><font color = red >Nao encontrada conta!</font>"; exit;
                            }
                    
                            while ($rows_contaBanco = mysqli_fetch_assoc($contaBanco)) 
                                {
                                $nomecaixa = $rows_contaBanco['nome_caixa'];
                                $banco = $rows_contaBanco['banco'];
                                $agencia = $rows_contaBanco['agencia'];
                                $n_conta = $rows_contaBanco['n_conta'];
                                }
                    
                            $html .=  '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							$html .=  '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th bgcolor="white"  ROWSPAN="9"></th> <th colspan="7" >RECONCILIAÇÃO BANCARIA
							         </th> <th align="center" >Folha Nº3</th>  </tr>';							
							$html .=  '<tr><th colspan="8">.</th></tr><tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							$html .=  '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=  '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							$html .=  '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							$html .=  '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							$html .=  '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							$html .=  '<tr><th colspan="8">.</th> </tr>';
							$html .=  '<tr bgcolor="Gainsboro"><th colspan="8" >SALDO DO EXTRATO BANCÁRIO <br> (Conforme aparece no extrato) </th>  </tr>';		
							$html .=  '<tr><th width="130">BANCO</th> <th bgcolor="yellow" >'.$banco.'</th> <th width="130">AGENCIA</th> <th bgcolor="yellow" >'.$agencia.'</th>';		
							$html .=  '<th width="130">CONTA Nº</th> <th bgcolor="yellow" width="130">'.$n_conta.'</th> <th>SALDO</th> <th bgcolor="yellow" >SALDO</th> </tr>';		
							$html .=  '<tr><th colspan="8" >.</th> </tr>';
							
							$html .=  ' </tr >';
							$html .=  '<tr bgcolor="Gainsboro" ><th width="60" > Registro</th>';	
							$html .=  '<th width="60" >DATA</th>';	
							$html .=  '<th width="50" colspan="5">HISTÓRICO</th>';	
							$html .=  '<th width="360" >Nº CHEQUE</th>';	
							$html .=  '<th width="130" >VALOR</th>';
							$html .=  '</tr>';	
							$html .= '</thead>';		
                            $html .=  '<tbody bgcolor="yellow"  style="font-size:100%">';
                    
                    
                            echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							echo '<thead ><tr bgcolor="Gainsboro"><th bgcolor="white"  ROWSPAN="9"></th> <th colspan="7" >RECONCILIAÇÃO BANCARIA
							         </th> <th align="center" >Folha Nº3</th>  </tr>';							
							echo '<tr><th colspan="8">.</th></tr><tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							echo '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="8" style="font-size:70%">.</th> </tr>';
							echo '<tr bgcolor="Gainsboro"><th colspan="9" >SALDO DO EXTRATO BANCÁRIO <br> (Conforme aparece no extrato) </th>  </tr>';		
							echo '<tr style="font-size:80%"><th width="130">BANCO</th> <th bgcolor="yellow" >'.$banco.'</th> <th width="130">AGENCIA</th> <th bgcolor="yellow" >'.$agencia.'</th>';		
							echo '<th width="130">CONTA Nº</th> <th bgcolor="yellow" width="130">'.$n_conta.'</th> <th>SALDO</th> <th bgcolor="yellow" >SALDO</th> </tr>';		
							echo '<tr><th colspan="8" style="font-size:70%">.</th> </tr>';							
							echo ' </tr >';
							echo '<tr bgcolor="Gainsboro" style="font-size:70%"><th width="60" > Registro</th>';	
							echo '<th width="60" >DATA</th>';	
							echo '<th width="50" colspan="5">HISTÓRICO</th>';	
							echo '<th width="360" >Nº CHEQUE</th>';	
							echo '<th width="130" >VALOR</th>';
							echo '</tr>';	
							echo '</thead>';		
                            echo '<tbody bgcolor="yellow"  style="font-size:70%">';
                    
                    
                    $total = 0;	$inicio = 1; 
                    while ($rows_chek = mysqli_fetch_assoc($cheques_abertos)) 
                    {	switch ($rows_chek['conta']) 
                        {
                            case 1:	$contaN = "IEADALPE - 1444-3"; $cor = '#9b0f0f';  break;    
                            case 2:	$contaN = "22360-3"; $cor = '#dd9431'; break;  
                            case 3:	$contaN = "ILPI"; $cor = '#B266FF';break;  
                            case 4:	$contaN = "BR214"; $cor = '#aa3636'; break;  
                            case 5:	$contaN = "BR518"; $cor = '#B266FF'; break;  
                            case 6:	$contaN = "BR542";$cor = '#2d3607'; break;  
                            case 7:	$contaN = "BR549"; $cor = '#23862e'; break;  
                            case 8:	$contaN = "BR579"; $cor = '#7562c3'; break;  
                            case 9:	$contaN = "BB 28965-5"; break;  
                            case 10:$contaN = "CEF 1948-4"; break;
                            case 99:$contaN = "Todas contas"; break;  				
                        }		
                        $data_Ch= implode('/',array_reverse(explode('-',$rows_chek['dataFin'])));
                        $val_Ch= number_format($rows_chek['valorFin'], 2, ',', '.');
                        $total = $total + $rows_chek['valorFin'];
                        {	
                            $html .=  '</td> <td>'.$rows_chek['id_fin'].'</td> <td>'.$data_Ch.'</td>';
                            $html .=  '<td colspan="5">'.$rows_chek['historico'].'</td> <td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$val_Ch.'</td>';
                            $html .=  '</tr>';
                            
                            echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td>'.$data_Ch.'</td>';
                            echo '<td colspan="5">'.$rows_chek['historico'].'</td> <td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$val_Ch.'</td>';
                            echo '</tr>';
                            $total = $total + $rows_chek['valorFin'];
                          //  $inicio = 0;
                        }
                            }	
                    } 	
                        $val_Ch= number_format($total, 2, ',', '.');
                
                        $html .= '<tr bgcolor="Gainsboro"> <td></td> <td colspan="7">TOTAL DE CHEQUES PENDENTES:.....................................</td>';	
                        $html .= '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                         $html .= '<tr><td colspan="8"  bgcolor="white">.</td> </tr>';
				        $html .= '<tr bgcolor="Gainsboro" > <td></td> <td colspan="7">SALDO BANCÁRIO AJUSTADO:.....................................</td>';	
                        $html .= '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                        $html .= '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                        echo '<tr bgcolor="Gainsboro"> <td></td> <td colspan="7">TOTAL DE CHEQUES PENDENTES:.....................................</td>';	
                        echo '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                         echo '<tr><td colspan="8"  bgcolor="white">.</td> </tr>';
				        echo '<tr bgcolor="Gainsboro" > <td></td> <td colspan="7">SALDO BANCÁRIO AJUSTADO:.....................................</td>';	
                        echo '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                        echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                */
                
                
                    $_SESSION['html'] = $html;
                
              if(isset($_POST["excel"]))
              {
                session_start();
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <head>
                    <meta charset="utf-8">
                    <title>Contato</title>
                </head>
                <body>
                    <?php
                    // Definimos o nome do arquivo que será exportado
                    $arquivo = 'relatorio_Compassion.xls';
                    // Configurações header para forçar o download
                    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                    header ("Cache-Control: no-cache, must-revalidate");
                    header ("Pragma: no-cache");
                    header ("Content-type: application/x-msexcel");
                    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
                    header ("Content-Description: PHP Generated Data" );
                    // Envia o conteúdo do arquivo
                    echo $_SESSION['html'];
                    exit; ?>
                </body>
            <?php 
              }
                } 
        /*    else if($adm == "cod_assoc" )
            {
				while ($row = mysqli_fetch_assoc($result)) 
				{ 				
					if( $l->tipo_Conta == "Corrente"){$saldo_Ant = 	$saldo_Ant_Corr;	$tipo_Conta_Atual = 1;	$abrev = "C/C:";}else		
					if( $l->tipo_Conta == "Suporte")	{$saldo_Ant = 	$saldo_Ant_Sup;		$tipo_Conta_Atual = 2;	$abrev = "C/S:";}else
					if( $l->tipo_Conta == "Poupança"){$saldo_Ant = 	$saldo_Ant_Poup;	$tipo_Conta_Atual = 3;	$abrev = "C/P:";}	
                    
					/*{$admN = "Compassion"; $adm_C = "cod_compassion";  $admCod = "cod_Comp";  $admArea = "area_Cod";  $admDescri = "descricao";}*/
                    //echo $adm.' - codigo do registro $row[$adm} - ] '.$l->$adm.' -  $admCod '.$admCod.' - ';
                    
               //Procura o nome da Área e da Descrição refente ao código Assoc da linha selecionada     
                  /*  $sqlCod = 'SELECT * FROM  cod_assoc WHERE  cod_Ass  = "'.$l->$adm.'" limit 1';
                        $queryCodigo = mysqli_query($conex, $sqlCod);
                    
                    if (!$queryCodigo ) 
					{
								die ("<center>Desculpe, Erro ao tentar procurar o código IEADALPE ".$l->$adm.", Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									//exit;
					}
				if (mysqli_num_rows($queryCodigo) == 0 ) 
				{	echo '<br>Linha: ' . __LINE__ . '<br> O código '.$l->$adm.' pode não esta registrado devidamente. Tente novamente!';  
                    $admAr = "Não encontrado"; $admDesc = "Não encontrado"; 
                    // exit;
				} else			
                    while($cod_row = mysqli_fetch_assoc($queryCodigo))
                    
                    
                    { $admAr = "Admin"; $admDesc = "Admin Desc"; }
                    
                   // echo '<br /><font color=red size="3"> Coluna '.$adm_C. ' | Area '.$admAr.' | descri '.$admDesc.' | Codigo '.$l->$adm.' | <td></font><br /><br />';
                   
					if($tipo_Contas == 0)
						{$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; $total = $saldo_Ant;
						}else	if($tipo_Contas <> $tipo_Conta_Atual)
						{	$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; 
							$total =  number_format($total, 2, ',', '.');
						  $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          
                            $html .=  '<td colspan="2">Saldo Final R$ </td>';	
							$html .=  '<td bgcolor="green"><h4 align="right" valign=bottom >'.$total.'</h4></td>';
				            $html .=  '</tr>';
							$html .= '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							$html .=  "<div style='page-break-before:always;'> </div>";
 
							echo '<td></td> <td></td> <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;	
						}	
						if($primeiroReg == "S") 
						{
							
							$html .= '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							$html .=  '<thead bgcolor="Gainsboro" ><tr><th></th> <th rowspan="5" colspan="5" bgcolor="white" > 
							<img class="imagefloat" src="aenpazVertical.png" alt="" width="90" height="75" border="0">  				
							</th> <th colspan="4" align="center" >RELATÓRO ANALÍTICO</th>  </tr>';							
							$html .=  '<tr><th></th> <th colspan="4" align="center"  align="center" ><font color="red">Conta contábil '.$admN.' - '.$caixaNome.'</font></th> </tr>';
							$html .=  '<tr><th></th> <th colspan="4" bgcolor="white" align="center" >'.$mesN.' de '.$ano.'</th> </tr>';
							$html .=  '<tr><th></th> <th rowspan="2" colspan="1" align="center" width="100"><font color="red">Conta  '. $l->tipo_Conta.'</font></th> 
							<th colspan="2" align="center" > Banco: <font color="red">'.$banco.'</font></th> 
							<td rowspan="2" align="center" ><strong> '.$abrev.' </br><font color="red">'.$n_conta.'</font></strong></td> </tr>';
							$html .=  '<tr><th></th> <th colspan="2" align="center" > Agência: <font color="red">'.$agencia.'</font></th> </tr>';
							
							//echo '<table border=1 bgcolor="yellow" width="100%">';	
							//echo '<thead><tr>';
							$html .=  '<th width="60"Registro</th>';	
							$html .=  '<th width="60">Data</th>';	
							$html .=  '<th width="50">Código</th>';	
							$html .=  '<th width="60">Doc Bancário</th>';	
							$html .=  '<th> Área </th> <th> Descrição </th>';	
							$html .=  '<th width="350">Histórico</th>';	
							$html .=  '<th width="80">Entrada valor (R$)</th>';	
							$html .=  '<th width="80">Saída valor (R$)</th>';	
							$html .=  '<th width="80">Saldo do mês anterior (R$)</th>';	
							$html .=  '</tr></thead>';
							$html .=  '<tbody style="font-size:70%">';
							$html .=  '<tr>';
							$html .=  '<td></td> <td></td> <td></td>  <td></td> <td></td>';
							$html .=  '<td></td><td></td><td></td><td></td>';
							$html .=  '<td bgcolor="yellow"  ><h4 align="right" valign=bottom >'.number_format($saldo_Ant, 2, ',', '.').'</h4></td>';
                            $html .=  '</tr>';		
                            
                            
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							echo '<thead bgcolor="Gainsboro" ><tr><th></th> <th rowspan="5" colspan="5" bgcolor="white" > 
							<img class="imagefloat" src="aenpazVertical.png" alt="" width="90" height="75" border="0">  				
							</th> <th colspan="4" align="center" >RELATÓRO ANALÍTICO</th>  </tr>';							
							echo '<tr><th></th> <th colspan="4" align="center"  align="center" ><font color="red">Conta contábil '.$admN.' - '.$caixaNome.'</font></th> </tr>';
							echo '<tr><th></th> <th colspan="4" bgcolor="white" align="center" >'.$mesN.' de '.$ano.'</th> </tr>';
							echo '<tr><th></th> <th rowspan="2" colspan="1" align="center" width="100"><font color="red">Conta  '. $l->tipo_Conta.'</font></th> 
							<th colspan="2" align="center" > Banco: <font color="red">'.$banco.'</font></th> 
							<td rowspan="2" align="center" ><strong> '.$abrev.' </br><font color="red">'.$n_conta.'</font></strong></td> </tr>';
							echo '<tr><th></th> <th colspan="2" align="center" > Agência: <font color="red">'.$agencia.'</font></th> </tr>';
							
							//echo '<table border=1 bgcolor="yellow" width="100%">';	
							//echo '<thead><tr>';
							echo '<th width="60"Registro</th>';	
							echo '<th width="60">Data</th>';	
							echo '<th width="50">Código</th>';	
							echo '<th width="60">Doc Bancário</th>';	
							echo '<th> Área </th> <th> Descrição </th>';	
							echo '<th width="350">Histórico</th>';	
							echo '<th width="80">Entrada valor (R$)</th>';	
							echo '<th width="80">Saída valor (R$)</th>';	
							echo '<th width="80">Saldo do mês anterior (R$)</th>';	
							echo '</tr></thead>';
							echo '<tbody style="font-size:50%">';														
							echo '<tr>';
							echo '<td></td> <td></td> <td></td>  <td></td> <td></td>';
							echo '<td></td><td></td><td></td><td></td>';
							echo '<td bgcolor="yellow"  ><h4 align="right" valign=bottom >',number_format($saldo_Ant, 2, ',', '.').'</h4></td>';
							//	echo '<td></td>';
                            echo '</tr>';							
													
								$primeiroReg = "N";
						}					
						if($l->ent_Sai == 0) {		$Sai = number_format($l->valorFin, 2, ',', '.'); $ent = "";	}
						else if($l->ent_Sai == 1){ 	$ent = number_format($l->valorFin, 2, ',', '.'); $Sai = "";}
							$val = $l->valorFin;
							if($l->ent_Sai == 0) $total = $total - $val;
							else $total = $total + $val;
								$datX= implode('/',array_reverse(explode('-',$l->dataFin)));
						
                    
						$html .=  '<tr>';
						$html .=  '<td>' . $l->id_fin . '</td>';                      
						$html .=  '<td>' . $datX . '</td>';                      
						$html .=  '<td>' .$l->$adm. '</strong></td>';
						$html .=  '<td>' .$l->num_Doc_Banco . '</td>';
                        $html .=  ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
                       // echo ' <td>A '.$admAr.'  </td> <td>D '.$admDesc .'</td>';
                    
						//echo '<td>' . $row['num_Doc_Fiscal'] . '</td>';
						$html .=  '<td>' .$l->historico . '</td>';
						$html .=  '<td><h4 align="right" valign=bottom  >'.$ent.'</h4></td>';
						$html .=  '<td><h4 align="right" valign=bottom  >'.$Sai.'</h4></td>';
						$html .=  '<td><h4 align="right" valign=bottom  >'.number_format($total, 2, ',', '.').'</h4></td>';
						$html .=  '</tr>';
                    
						echo '<tr>';
						echo '<td>' . $l->id_fin . '</td>';                      
						echo '<td>' . $datX . '</td>';                      
						echo '<td>' .$l->$adm. '</strong></td>';
						echo '<td>' .$l->num_Doc_Banco . '</td>';
                        echo ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
                       // echo ' <td>A '.$admAr.'  </td> <td>D '.$admDesc .'</td>';
                    
						//echo '<td>' . $row['num_Doc_Fiscal'] . '</td>';
						echo '<td>' .$l->historico . '</td>';
						echo '<td><h4 align="right" valign=bottom  >',$ent.'</h4></td>';
						echo '<td><h4 align="right" valign=bottom  >',$Sai.'</h4></td>';
						echo '<td><h4 align="right" valign=bottom  >',number_format($total, 2, ',', '.').'</h4></td>';
						echo '</tr>';
							
				}
                            $html .=  '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';
							$html .=  '<td bgcolor="green"  ><h4 align="right" valign=bottom >'.$total.'</h4></td></tr>';
							$html .=  '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante 
                    
                    $_SESSION['html'] = $html;
							$total =  number_format($total, 2, ',', '.');
							echo '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                }
               */
            ?>

      </div>
</div>
</div>
</div>
    
    <?php
     }
    ?>
      
</div>