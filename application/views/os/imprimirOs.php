<?php $totalServico = 0; $totalProdutos = 0;?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>SISCOD</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>

</head>
<body  style="background: white; ">
  <div class="container-fluid" style="padding-top: 0px; margin-top: 0px">
    <div class="row-fluid" style="padding-top: 0px; margin-top: 0px">
      <div class="span12"  style="padding-top: 0px; margin-top: 0px">
       
        <div class="invoice-content" style="padding-top: 0px; margin-top: 0px">
                <div class="invoice-head"  style="padding-top: 0px; margin-top: 0px">
                            <?php 
                    include 'geraCodigoBarra.php';
                    if($resultsAgen == null) {?>
                    <table class="table">
                        <tbody>      
                            <tr>
                                <td colspan="4" class="alert">Não existem doações progrmadas para a data selecionada. ></td>
                            </tr>
                        </tbody>
                    </table>
                        <?php } else {
                         foreach ($resultsAgen as $r) 
                        {
                        $valorExibe  =    number_format(str_replace(",",".",$r->valor_doar), 2, ',', '.');     
                        $dataDoa = explode('-', $r->data_Previsao);
                         $data_Doac = $dataDoa[2].'/'.$dataDoa[1].'/'.$dataDoa[0];
                             
                            $aux    =   base_url()."assets/qr_img0.50j/php/qr_img.php?";
                            $aux    .=  'd='.$r->idDoacao.' | '.$r->nomeCliente .' | R$ '.$valorExibe.'&';
                            $aux    .=  'e=H&';
                            $aux    .=  's=3&';
                            $aux    .=  't=P';
                              $obss = 0;
                         foreach ($results_obs_mensageiro as $r_Obs) 
                        {
                             
                             if($r->idDoacao == $r_Obs->id_Doar ){ $obsMensg = $r_Obs->obsMensageiro; $obss = 1;}
                         }
                             if($obss == 0)$obsMensg = ' ';
                            ?>                    
                    <div class="span12" id="divAgen" style="padding: 1%; margin-left: 0;   text-align: right;">
                        <span style="font-size: 24px; "> <strong><?php echo $r->idDoacao; ?></strong></span><br/>
                    </div><br/><br/><br/><br/>
                    
                    <div class="span12" id="divAgen" style="padding: 1%; margin-left: 0;  text-align: right">
                       
                                     <span style="font-size: 24px; "><strong><?php echo  'R$ '.$valorExibe; ?></strong></span> <br/>
                    </div>                    
                    <table class="table" style="background: white;">
                        <tbody>
                            <tr >
                                <td style="height: 15%;  border: none;"></td>
                                <td style="height:30%; border: none;" ></td>
                                <td style="height:20%;  border: none;"></td>
                                <td style="height:10%; border: none;"></td>
                                <td style="height:5%; border: none;"></td>  
                            </tr>
                            <tr>
                                <td colspan="5"  style="height:5%; border: none;"> 
                                    <span style="font-size: 14px;  height: 100px;  border: none;">Recebemos de <strong><?php echo $r->nomeCliente; ?></strong>  </span>               
                                </td>
                            </tr>
                            <tr >
                                <td colspan="2"  style="height:5%; border: none;">
                                    <span style="font-size: 14px; ">a importância de <?php echo 'R$ '.$valorExibe; ?>, referente a doação. </span>
                                </td>
                                <td colspan="3" style="font-size: 11px;  text-align: right; border: none;">
                                    <span style="font-size: 11px;  text-align: right">Abreu e Lima, <?php echo date('d').' de '.date('M').' de '.date('Y'); ?>  </span> 
                                </td> 
                            </tr>                            
                            <tr>
                                <td  colspan="2"  style="vertical-align:super;  border: none;"> <span style="font-size: 16px;">
                                    <strong>A AENPAZ AGRADECE SUA CONTRIBUIÇÃO!</strong></span> <br/><br/>
                                    <span style="font-size: 7px; ">AS DOAÇÕES AFETUADAS A INSTITUIÇÕES FILANTROPICAS NÃO SÃO DEDUTIVEIS, POR FALTA DE PREVISÃO LEGAL.</span> <br/><br/>
                                </td>
                                <td  colspan="3"  rowspan="4" tyle="width: 40%; align: right; border: none;">                                     
                                    <img src="<?php echo base_url()?>assets/img/Asspresidente.jpg" alt="Logo" style="position: relative; z-index: 0; width: 6cm; height: 2.5cm;"/>
                                    <br/><br/> <br/>
                                </td> 
                            </tr>
                            <tr>
                                <td colspan="3"   style="    border: none;"></td>                                
                            </tr>
                            <tr>
                                <td colspan="3"  style="    border: none;" ></td>
                            </tr>
                            <tr>
                                <td style=" line-height: 100%; height: 100%;   border: none;" colspan="3">
                                    <span style="font-size: 14px; "><strong><?php echo $r->idClientes.' - '.$r->nomeCliente; ?></strong></span> <br/><br/>
                                    <span style="font-size: 12px; ">Telefone(s): <?php echo $r->foneD.' ',$r->foneD2.' '.$r->foneD3; ?></span>  <br/><br/>
                                    <span style="font-size: 12px;">End.: <?php echo $r->logradD.', ',$r->numeroD; ?></span>  <br/><br/>
                                    <span style="font-size: 12px;"><strong>Bairro: <?php echo $r->bairroD.' - Cidade: '.$r->cidadeD; ?></strong></span> <br/><br/>
                                    <span style="font-size: 12px;">Complemento: <?php echo $r->complemD; ?></span> <br/><br/>
                                    <span style="font-size: 12px;;"><strong>Obs.:</strong> <?php echo $obsMensg; ?></span> 
                                </td>
                                <td  colspan="2" style="width: 20%; text-align: right; vertical-align:super; line-height: 10%; height: 10%;    border: none; "> 
                                    <span style="font-size: 24px; "> <strong><?php echo $r->idDoacao; ?></strong></span> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table  class="table" style="margin:0px;   border: none;">
                        <tbody>
                            <tr>
                                <td rowspan="5" style="width: 11%; vertical-align:super; text-align: center;  line-height: 100%;   width: 20%;   border: none;">
                                    <img src="<?php echo $aux; ?>" /><br/>
                                    <span style="font-size: 10px;;">* <?php echo $r->idDoacao; ?> *</span> 
                                </td>
                                <td colspan="3"  style="  line-height: 10%;   vertical-align:super;   border: none; ">
                                    <span style="font-size: 10px; ">Operador(a): <strong><?php echo $r->atendente_ID.' - '.$r->nome; ?></strong>
                                     - Mensageiro: 8 -<strong>  Rogério</strong></span>
                                </td>
                                <td style=" width: 20%; text-align: right; line-height: 80%;  border: none;"  rowspan="2" ><span style="font-size: 18px; "><strong><?php echo  'R$ '.$valorExibe; ?></strong></span> <br/> <br/>
                                    <span style="font-size: 11px; ">Data Prev.: <?php echo date('d/m/Y'); ?>  </span> 
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2"  style=" width: 12%;  line-height: 70%;   border: none; "> 
                                    <span style="  font-size: 10px; "><strong>Recolher recibo: INTEGRAL</strong></span> <br/><br/>
                                    <span style="font-size:10px;;">Doador Novo: </span> 
                                </td>
                                <td   colspan="2"  style=" width: 31%;  line-height: 100%;   border: none;">
                                    <span style="font-size: 9px; ">Ficha Nova: </span> <br/>
                                    <span style="font-size: 9px;;">Ultima Doação Recebida: <?php echo date('d/m/Y'); ?></span> 
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="4" style="vertical-align:super;  line-height: 100%;  border: none;"> 
                                    <span style="font-size: 9px; ">Codigo Devolução: _________  </span>
                                    <span style="font-size: 9px;;">Atendido por: ___________________________   </span>  
                                    <span style="font-size: 9px;;">Horário: ____:_____</span> <br/> <br/>
                                    <span style="font-size: 9px;;"><strong>Contato: </strong><?php echo $r->nome; ?> *</span>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="4" style="vertical-align:super;  line-height: 100%;  border: none;"> 
                                    .
                                </td>
                            </tr>
                            
        
                        </tbody>
                    </table>
        <div style="page-break-after: always"></div>
                            
                            <?php } 
                                }?>
                </div>

                
            </div>                
      </div>
    </div>
  </div>



<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 

<script>
    window.print();
</script>

</body>
</html>







