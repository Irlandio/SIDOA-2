  
<html>
    <head>
        <title>CISCOD</title>
        <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/blue.css" class="skin-color" />
        <script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

  <body style="background-color: transparent">
      
     
      <?php
     {
           $html = "";
           $html .= '<meta http-equiv="pragma" content="no-cache" />';
           $html .= '<meta http-equiv="cache-control" content="no-cache" />';
           $html .= '<meta http-equiv="content-type" content="application/x-msexcel" />';
           $html .= '<meta http-equiv="content-disposition" content="attachment; filename=\\"{$arquivo}\\"" />';
            
       
           $mediaDiaria = $_SESSION['mediaDiaria'];  $mediaMes = $_SESSION['mediaMes'];
           $dataIMed = $_SESSION['dataIMedia'];  $dataFMed = $_SESSION['dataFMedia'];  

            $mediaDiariaExibe  =    number_format(str_replace(",",".",$mediaDiaria), 2, ',', '.');
            $mediaMesExibe  =    number_format(str_replace(",",".",$mediaMes), 2, ',', '.');       
       
             $dataI_M = explode('-', $dataIMed); $dataIMedia = $dataI_M[2].'/'.$dataI_M[1].'/'.$dataI_M[0];
             $data_D = explode('-', $dataFMed); $dataFMedia = $data_D[2].'/'.$data_D[1].'/'.$data_D[0];             
    ?>       
    <div class="span12">
        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-list-alt"></i>
            </span>            
            <h5>Relatório gerado: <?php echo 'Referênte ao periodo de '.$dataIMedia.' ate '.$dataFMedia ?>
             <span class="badge" style="background-color: #0f9b3f; border-color: #0f9b3f"> <?php echo 'MÉDIA DIÁRIA = R$ '.$mediaDiariaExibe ?></span>
             <span class="badge" style="background-color: #0f9b3f; border-color: #0f9b3f"> <?php echo '  MÉDIA MENSAL = R$ '.$mediaMesExibe ?></span></h5>
             
        </div>
      <div class="container-fluid">
    
          <div class="row-fluid">
            <div style="overflow-x:scroll;height:700px; width:100%; ">
                <div class="span12">
                  <?php     
                       $dataInicial = $_SESSION['dataI1'];
                       $dataFinal  = $_SESSION['dataF1'];
                        setlocale(LC_TIME, 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                { ?>
                <table class="table "  id="dvData">
                    <tbody >
                        <tr>
                            <?php
                                $j = 1;
                             for ($j = 1; $j <= 7; $j++) 
                              {                        
                            ?>
                          <td>              
                                <?php                     
                                 $n_mes = ' ';
                                  $dataI = date('Y-m-d')  ; 
                                   $dataF = date('Y-m-d')   ;
                                 if($_SESSION['dataI'.$j]){
                                   $dataI = $_SESSION['dataI'.$j];
                                 $n_mes = strftime("%B de %Y", strtotime($dataI));                   
                                 }

                                $dataInicial = explode('-', $dataI);
                                $mess = $dataInicial[1];
                                $ano = $dataInicial[0];

                                $diass = cal_days_in_month(CAL_GREGORIAN, $mess, $ano);

                                 $media_TExibe  =  0; $v_TotalMExibe  = 0; $mediaExibe  =  0;  $valorExibe  =  0;
                                 $t_Qtd = 0; $v_TotalM = 0; 
                                   $diaA = 0;
                                   for ($i = 1; $i <= $diass; $i++) 
                                   {
                                       $n_Qtd = 0;
                                    if($i ==1)
                                        { 

                                $html .= '<table class="table ">
                                        <thead ><tr bgcolor="White">  <th colspan="3"  style="font-size:120%">'.$n_mes.'  </th>   </tr>		
                                        <tr><th colspan="3" style="font-size:70%"></th>
                                        </tr>
                                        <tr  bgcolor="White" style="font-size:70%">
                                            <th style="width=5%"> DIA</th>
                                            <th width="45%">VALOR R$</th>
                                            <th width="45%">MÉDIA R$</th></tr>
                                        </thead>';                  
                              ?>
                        <table class="table ">
                            <thead ><tr bgcolor="Gainsboro">  <th colspan="3"  style="font-size:120%"><?php echo $n_mes ?>  </th>   </tr>		
                                <tr><th colspan="3" style="font-size:70%"></th>
                                </tr>
                                <tr  bgcolor="Gainsboro" style="font-size:70%">
                                    <th style="width=5%"> DIA</th>
                                    <th width="45%">VALOR R$</th>
                                    <th width="45%">MÉDIA R$</th>
                                </tr>
                            </thead>
                                <tbody >
                                      <?php
                                        } 
                                        $valor_doar = 0;
                                   //    $res = '$results'.$j
                                      switch ($j) 
                                        {						    
                                            case '0':	 
                                                 foreach ($results0 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;   ++$n_Qtd; } 
                                                  }	break;      
                                            case '1':	 
                                                 foreach ($results1 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd;} 
                                                  }	break;      
                                            case '2':	 
                                                 foreach ($results2 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd; } 
                                                  }	break;      
                                            case '3':	 
                                                 foreach ($results3 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd;} 
                                                  }	break;      
                                            case '4':	 
                                                 foreach ($results4 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd;} 
                                                  }	break;      
                                            case '5':	 
                                                 foreach ($results5 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd;} 
                                                  }	break;       
                                            case '6':	 
                                                 foreach ($results6 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd;} 
                                                  }	break;      
                                            case '7':	 
                                                 foreach ($results7 as $rS)
                                                 { $dataInicial = explode('-', $rS->dataDoacao);   $dia = $dataInicial[2];
                                                     if( $dia == $i ){ $valor_doar =  $valor_doar + $rS->valor_doar;  ++$n_Qtd;} 
                                                  }	break;    
                                                    } 
                                        $media = 0; $cor_0 = " ";
                                       $cor_1 = "bgcolor='#14ff00'";
                                       if($n_Qtd <> 0) $media = $valor_doar / $n_Qtd; else $cor_0 = "bgcolor='#f7eee8'";
                                       $t_Qtd += $n_Qtd; $v_TotalM += $valor_doar; //***Total acumulado do Mês
                                        $mediaExibe  =    number_format(str_replace(",",".",$media), 2, ',', '.');
                                        $valorExibe  =    number_format(str_replace(",",".",$valor_doar), 2, ',', '.');
                                        ?>
                                         <tr <?php echo $cor_0; ?>>
                                             <td  width="5%"><?php echo   $i; ?></td><td   align="right">
                                             <strong><?php echo   $valorExibe; ?></strong></td><td><?php echo $mediaExibe; ?></td>
                                        </tr>
                                             <?php
                                     }
                                 if($i ==31) echo '<tr><td></td><td></td><td>##</td></tr>';

                                        if($t_Qtd <> 0) $media_T = ($v_TotalM / $t_Qtd);else $media_T = 0;

                                        $media_TExibe  =    number_format(str_replace(",",".",$media_T), 2, ',', '.');
                                        $v_TotalMExibe  =    number_format(str_replace(",",".",$v_TotalM), 2, ',', '.');
                                    ?>
                                         <tr <?php echo $cor_1; ?>>
                                             <td>Total</td><td   align="right">
                                             <strong><?php echo   $v_TotalMExibe; ?></strong></td><td><strong><?php echo $media_TExibe; ?></strong></td>
                                        </tr>
                                  <?php
                                    $total = 0;	$inicio = 1; $totalG = 0; $totalData = 0; $contaY = 0;
                                    $html .=    '<tr><td colspan="4"></td> </tr>';
                                    $html .=   '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante

                                     $dtI = 'dataI'.$j;  $dtF = 'dataF'.$j;
                                     echo '<tr '.$cor_1.'><td colspan="4" align="center" ><strong> '.$t_Qtd.'</strong> Doações</td> </tr>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                            ?>
                            </tbody>
                          </table>
</td>
                      <?php
                     }
                    ?>
                    </tr>
                  </tbody>
                </table>
                      </div>        
          </div>                 
          <?php
         $html .=   "<br>";
            echo '<br>';
            $_SESSION['html'] = $html;

          if(isset($_POST["excel"]))
          {
           // session_start();
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <head>
                    <meta charset="utf-8">
                    <title>Comparativo Mensal</title>
                </head>
                <body>
                    <?php
                    // Definimos o nome do arquivo que será exportado
                    $arquivo = 'relatorio_Comparativo.xls';
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
              </html>
            <?php 
          }
            } 
        ?>

      </div>
</div>
     </div>
    </div>
    
    <?php
     }?>
  </body>
</html>

