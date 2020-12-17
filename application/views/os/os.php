<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<style>
.badgebox{ opacity: 0;}
.badgebox + .badge{
    text-indent: -999999px;
	width: 27px;}
.badgebox:focus + .badge{ box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge{text-indent: 0;}
</style>
<div class="row-fluid" style="margin-top:0">
<div class="span12" style="margin-left: 0">
    <?php if(1==1) { ?>
<div class="span12" style="margin-left: 0">
    <form method="get" action="<?php echo base_url(); ?>index.php/os/gerenciar">
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')){ ?>
       <!-- <div class="span3">
                <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="btn btn-success span12"><i class="icon-plus icon-white"></i> Adicionar OS</a>
            </div>-->
        <?php } ?>

    <?php if(1==0) { ?>
        <div class="span3">
            <input type="text" name="pesquisa"  id="pesquisa"  placeholder="Nome do cliente a pesquisar" class="span12" value="" >
        </div>
        <?php } ?>
        <div class="span2">
            <select name="status" id="status" class="span12">
                <option value="1">Ativo</option>
                <option value="2">Todos</option>
            </select>

        </div>

        <div class="span3">
            <input type="text" name="data"  id="data"  placeholder="Data Inicial" class="span6 datepicker" value="">
            <input type="text" name="data2"  id="data2"  placeholder="Data Final" class="span6 datepicker" value="" >
        </div>
        <div class="span1">
            <button class="span12 btn"> <i class="icon-search"></i> </button>
        </div>
    </form>
</div><?php  }?>
     <form method="get" action="<?php echo base_url(); ?>index.php/os/imprimir"  target="_blank">
   
        <div class="span5">
            <button class="btn btn-inverse tip-top"> <i class="icon-print"></i>  Gerar arquivo para impressão dos cupons de doação </button>
        </div>
        <div class="span2">
   <input type="text" name="data3"  id="data3"  placeholder="Data Impressão" class="span10 datepicker" value="" title="Imprimir">
       
        </div>
    <!--     <a style="margin-right: 1%" href="<?php echo base_url(); ?>index.php/os/imprimir" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print">  Gerar arquivo para impressão dos cupons de doação</i></a>
  -->
    </form>
</div>
<?php

if(!$results && 1==2){?>
    <div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Controle de doações</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Cliente</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="6">Nenhuma OS Cadastrada</td>
        </tr>
    </tbody>
</table>
</div>
</div>
<?php } else{
    
     foreach ($resultPeriodo as $rPer)
     {
         if( $rPer->id_reconc == 1){ $de =  $rPer->data_Pag; $ate = $rPer->status ;  }
     }
    
     $Exibede = explode('-', $de);
                    $Exibe_de = $Exibede[2].'/'.$Exibede[1].'/'.$Exibede[0];
     $Exibeate = explode('-', $ate);
                    $Exibe_ate = $Exibeate[2].'/'.$Exibeate[1].'/'.$Exibeate[0];
    ?>


<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Lançamentos no périodo de <?php echo  $Exibe_de.' até '.$Exibe_ate;   ?> </h5>


     </div>

<div class="widget-content nopadding">

            
<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Operador</th>
            <th>Meta</th>
            <th>Qtd Doações</th>
            <th>Doações no periodo</th>
            <th>Comissãos no periodo</th>
            <th>Cancelados</th>
            <th>Devolvidos</th>
            <th>Previstos</th>
            <th></th>
        </tr>
    </thead>  
    <tbody>
        <?php 
             
    
    $contAnterior = 0;
                        $corDoad = '#438906';
                        $corDoa = '#438906';
                        $corPrev = '#4b4e07';
                        $corCanc = '#9b1a0f';
                        $corDev = '#9b1a0f';
            foreach ($results_Usuarios as $r) 
            {
                
                 $conta = $r->conta_Usuario;
                        $age = 0;$doad = 0;$prev = 0;$cancel = 0;$devol = 0;
                        $Tage = 0.00 ;$Tdoad = 0.00;$Tprev = 0.00;$Tcancel = 0.00;$Tdevol = 0.00; $ultDoacaoV = 0.00;
                        $ultAgend = date('2000-01-01'); $proxAgend = date('2050-01-01');
                        $ultDoacao = date('2000-01-01'); 
                        $ultPrevisao = date('2000-01-01'); $proxPrevisao = date('2050-01-01');
                        $ultCanc = date('2000-01-01'); 
                        $ultDevol = date('2000-01-01');
                if($r->conta_Usuario < 7)
                {
                if($conta <> $contAnterior)
                {
                    
                    switch ($r->conta_Usuario)
                    {		    
                        case '1':	$cor = '#3a0f9b';     $titulo = 'Operadores Comissionados';	break;    
                        case '3':	$cor = '#0f9b3f';     $titulo = 'Operadores Virtual';	break;  
                        case '5':	$cor = '#8A9B0F';     $titulo = 'Supervisão';	break;  
                        case '7':	$cor = '#9b1a0f';     $titulo = 'Administrativo';	break;  
                        case '9':	$cor = '#452c2a';     $titulo = 'Administrador de Sistema';	break;	
                    }?>
                      
                    </tbody>    
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th colspan= 8 style="text-align:left;"><h5><?php echo   $titulo; ?></h5></th>
                        </tr>
                    </thead>  
                    <tbody>
                  
                <?php  
                    
                }
                
                foreach ($results as $rs) 
                {
                    switch ($rs->tipo_Registro)
                    {		    
                        case 'agendado':	$cor = '#3a0f9b';     $tipo_Registro = 'agendado';	break;    
                        case 'doado':	    $cor = '#0f9b3f';     $tipo_Registro = 'doado';	break;  
                        case 'previsto':	$cor = '#8A9B0F';     $tipo_Registro = 'previsto';	break;  
                        case 'cancelado':	$cor = '#9b1a0f';     $tipo_Registro = 'cancelado';	break;  
                        case 'devolvido':	$cor = '#452c2a';     $tipo_Registro = 'devolvido';	break;	
                    }
                    if($rs->idUsuarios ==  $r->idUsuarios  )
                    {
                        $status =  $rs->tipo_Registro;
                        $valor_doar =  $rs->valor_doar;
                        switch ($status)
                                {						    
                                    case 'agendado':	$age++ ; $Tage = $Tage + $valor_doar;	

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultAgend < $rs->data_Previsao)
                                                        { $ultAgend = $rs->data_Previsao; }else 
                                             if( date('Y-m-d') < $rs->data_Previsao &&  $proxAgend > $rs->data_Previsao)
                                                        { $proxAgend = $rs->data_Previsao;   
                                                         $proxPrevV = $rs->valor_doar;}   break;  

                                    case 'doado':	    $doad++; $Tdoad = $Tdoad + $valor_doar;

                                            if( date('Y-m-d') > $rs->dataDoacao &&  $ultDoacao < $rs->dataDoacao)
                                                        { $ultDoacao = $rs->dataDoacao; 
                                                         $ultDoacaoV = $rs->valor_doar;}   break;

                                    case 'previsto':	$prev++; $Tprev = $Tprev + $valor_doar;	

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultPrevisao < $rs->data_Previsao)
                                                        { $ultPrevisao = $rs->data_Previsao; }else 
                                             if( date('Y-m-d') < $rs->data_Previsao &&  $proxPrevisao > $rs->data_Previsao)
                                                        { $proxPrevisao = $rs->data_Previsao;  
                                                         $proxPrevV = $rs->valor_doar;}   break;

                                    case 'cancelado':	$cancel++; $Tcancel = $Tcancel + $valor_doar;	

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultCanc < $rs->data_Previsao)
                                                        { $ultCanc = $rs->data_Previsao; }  break;

                                    case 'devolvido':	$devol++; $Tdevol = $Tdevol + $valor_doar;		

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultDevol < $rs->data_Previsao)
                                                        { $ultDevol = $rs->data_Previsao; }   break;
                                }
                        
                    } 
                }
            //    if($selecionado == 1)
                {
                    
                        $metaMes = '0';
                        $taxa = '0'; $codF = '0';
                        foreach ($metas as $met) 
                        {
                        if($met->statusMetas == 1 && $r->idUsuarios == $met->cod_Funcionario)
                        {   $metaMes = $met->metaMes;
                            $taxa = $met->taxaComicao;
                            $codF = $met->codF;
                         
                        }}
                    $Tcomissao = $Tdoad * $taxa / 100;
                    //   $data_Previsao = date(('d/m/Y'),strtotime($r->data_Previsao));
                    // $dataFinal = date(('d/m/Y'),strtotime($r->data_Previsao));
                    //  if($selecionado == 1) $cor = '#8A9B0F';
                    //  $core = '#9b1a0f';
                        $metaMesExibe  =    number_format(str_replace(",",".",$metaMes), 2, ',', '.');
                        $comissaoExibe  =    number_format(str_replace(",",".",$Tcomissao), 2, ',', '.');
                        $valorExibe  =    number_format(str_replace(",",".",$Tdoad), 2, ',', '.');
                        $TprevrExibe  =    number_format(str_replace(",",".",$Tprev), 2, ',', '.');
                        $TcancrExibe  =    number_format(str_replace(",",".",$Tcancel), 2, ',', '.');
                        $TdevrExibe  =    number_format(str_replace(",",".",$Tdevol), 2, ',', '.');
                    if( $r->situacao == 1) { $situacao = 'Ativo'; $cors = '#0f9b3f';  } else { $situacao = 'Inativo'; $cors = '#9b1a0f';  } 

                    echo '<tr>';
               //     echo '<td>'.$r->idUsuarios.'</td>';
                    echo '<td><span class="badge" style="background-color: '.$cors.'; border-color: '.$cors.'">'.$r->idUsuarios.' '.$situacao.'</span> </td>'; 
                    echo '<td>'.$r->nome.'</td>';
                    echo '<td>'.$metaMesExibe.'</td>';
                    echo '<td style="text-align:right;vertical-align:middle;" ><span class="badge" style="background-color: '.$corDoad.'; border-color: '.$corDoad.'"> '.$doad.'</span></td>';
                    echo '<td style="text-align:right;" ><span class="badge" style="background-color: '.$corDoa.'; border-color: '.$corDoa.'">R$ '.$valorExibe.'</span></td>';
                    echo '<td style="text-align:right;" ><span class="badge" style="background-color: '.$corDoa.'; border-color: '.$corDoa.'">R$ '.$comissaoExibe.'</span></td>';
                    echo '<td style="text-align:right;" ><span class="badge" style="background-color: '.$corCanc.'; border-color: '.$corCanc.'">'.$cancel.' R$ '.$TcancrExibe.'</span></td>';
                    echo '<td style="text-align:right;" ><span class="badge" style="background-color: '.$corDev.'; border-color: '.$corDev.'">'.$devol.' R$ '.$TdevrExibe.'</span></td>';
                    echo '<td style="text-align:right;" ><span class="badge" style="background-color: '.$corPrev.'; border-color: '.$corPrev.'">   R$ '.$TprevrExibe.'</span> </td>';   

                    echo '<td>';
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs') && 1 ==2){
                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/os/visualizar/'.$r->idUsuarios.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/os/imprimir/'.$r->idUsuarios.'" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print"></i></a>'; 
                    }
                    
                    if($r->bloqueio == 1 ){
                        echo '<a href="#modal-bloc" role="button" data-toggle="modal" user_id="'.$r->idUsuarios.'" user_N="'.$r->nome.'" blok="0" class="btn btn-success tip-top" title="Liberar"><i class="icon-flag icon-white"></i></a>  ';
                    }else {
                        echo '<a href="#modal-bloc" role="button" data-toggle="modal" user_id="'.$r->idUsuarios.'"  user_N="'.$r->nome.'" blok="1" class="btn btn-danger tip-top" title="Liberar"><i class="icon-lock icon-white"></i></a>  '; 
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            }
           $contAnterior = $conta;
            }?>
        <tr>
            
        </tr>
    </tbody>
</table>    
</div>
</div>
</div> 

 <div class="span12" id="divEditarVenda">
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')){ ?>
            <div class="span3">
                <a href="#modal-rotas" role="button" data-toggle="modal"  class="btn btn-success span12" title="Rotas"><i class="icon-arrow-up icon-white"> Rotas</i></a> 
            </div>
            <div class="span3">
                <a href="#modal-Metas" role="button" data-toggle="modal"  class="btn btn-success span12" title="Comissões e Metas"><i class="icon-money icon-white"> Comissões e Metas</i></a> 
            </div>
            <div class="span3">
                <a href="#modal-ausent" role="button" data-toggle="modal"  class="btn btn-success span12" title="Ausências"><i class="icon-circle-arrow-left icon-white">Ausências</i></a> 
            </div>
        <?php } ?>
</div>


<div class="span12" ></div>
 <div class="span12" id="divEditarBD">
        <?php if($usuario->idUsuarios == 20){ ?>
            <div class="span3">
                <a href="#modal-bdOBS" role="button" data-toggle="modal"  class="btn btn-success span12" title="Rotas"><i class="icon-arrow-up icon-white"> Alimentar BD OBS</i></a> 
            </div>
            <div class="span3">
                <a href="#modal-ausent" role="button" data-toggle="modal"  class="btn btn-success span12" title="Ausências"><i class="icon-circle-arrow-right icon-white"> Ultima OBS: <?php echo $ultimaOBS->IdObs.' - '.$ultimaOBS->data_Obs.' - Doador: '.$ultimaOBS->cod_doador;   ?></i></a> 
            </div>
            <div class="span3">
                <a href="#modal-ausent" role="button" data-toggle="modal"  class="btn btn-success span12" title="Ausências"><i class="icon-circle-arrow-right icon-white"> Ultima concatenada: <?php echo $ultimaMsgs->IdObsMsg.' -  '.$ultimaMsgs->dataMensagem.' - Doador: '.$ultimaMsgs->cod_DoadorMensagem;   ?></i></a> 
            </div>
        <?php } ?>
</div>
<?php echo $this->pagination->create_links();}
             $cont=0; $anterior = 0; $contU =0;
            foreach ($results_Usuarios as $r) 
            { //      echo  $r->idUsuarios.' '.$r->nome.' '.$r->situacao.'</br>';+
                    $contU++;                
            } //    echo $contU;    echo  '</br>';
                foreach ($results as $rs) 
                {
                    if($anterior <> $rs->idUsuarios){
             //  echo  $rs->idUsuarios.' '.$rs->nome.' '.$rs->situacao.'</br>';
                    $cont++;}
                    $anterior = $rs->idUsuarios;
                }
 ?>
<!-- Modal Rotas-->
<div id="modal-rotas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="span12" id="divEditarVenda">
  <!--   <form action="<?php echo current_url(); ?>" method="post" id="formDoar">-->
        <?php //echo form_hidden('idDoacao',$result->idDoacao) ?>
        <form action="<?php echo base_url() ?>index.php/os/agendar" method="post">
          <!--
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-save"></i>
                </span>
                <h5>Confirmar agendamento de </h5>
            </div>-->
            <input id="idDoacao" name="idDoacao"  type="hidden" value=""/>

        <div class="span5" id="divCadastrar">

            <?php     
            $data_Max = date('d/m/Y', strtotime("+6 month", strtotime( date('d/m/Y'))));
            $data_Amanha = date('d/m/Y', strtotime("+1 day", strtotime( date('d/m/Y'))));
      //  echo $data_Amanha; 
             foreach ($results_Rotas as $rR) 
                {
                 
                  switch ($rR->diaRota) {
                case 'segunda':
                    $cidade21 = $rR->cidaade1Rota;
                    $cidade22 = $rR->cidaade2Rota;
                    $cidade23 = $rR->cidaade3Rota;
                    break;
                case 'terça':
                    $cidade31 = $rR->cidaade1Rota;
                    $cidade32 = $rR->cidaade2Rota;
                    $cidade33 = $rR->cidaade3Rota;
                    break;
                case 'quarta':
                    $cidade41 = $rR->cidaade1Rota;
                    $cidade42 = $rR->cidaade2Rota;
                    $cidade43 = $rR->cidaade3Rota;
                    break;
                case 'quinta':
                    $cidade51 = $rR->cidaade1Rota;
                    $cidade52 = $rR->cidaade2Rota;
                    $cidade53 = $rR->cidaade3Rota;
                    break;
                case 'sexta':
                    $cidade61 = $rR->cidaade1Rota;
                    $cidade62 = $rR->cidaade2Rota;
                    $cidade63 = $rR->cidaade3Rota;
                    break;
        
             }}
                ?>
            <div class="widget-box">
                 <div class="widget-title">
                     <span class="icon"><i class="icon-list"></i></span><h5> Segunda-Feira</h5> 
                </div>
                <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                  
                            <div class="controls">
                                <select id="cidade21" name="cidade21" class="span10">$cidade21
                                            <option value = "<?php echo $cidade21; ?>"><?php echo $cidade21; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade22" name="cidade22" class="span10">
                                            <option value = "<?php echo $cidade22; ?>"><?php echo $cidade22; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade23" name="cidade23" class="span10">
                                            <option value = "<?php echo $cidade23; ?>"><?php echo $cidade23; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>

            </div>


            </div>

            <div class="widget-box">
                 <div class="widget-title">
                     <span class="icon"><i class="icon-list"></i></span><h5> Terça-Feira</h5> 
                </div>
                <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                  
                            <div class="controls">
                                <select id="cidade31" name="cidade31" class="span10">
                                            <option value = "<?php echo $cidade31; ?>"><?php echo $cidade31; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade32" name="cidade32" class="span10">
                                            <option value = "<?php echo $cidade32; ?>"><?php echo $cidade32; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade33" name="cidade33" class="span10">
                                            <option value = "<?php echo $cidade33; ?>"><?php echo $cidade33; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
  
                    
                </div>


            </div>

            <div class="widget-box">
                 <div class="widget-title">
                     <span class="icon"><i class="icon-list"></i></span><h5> Quarta-Feira</h5> 
                </div>
                <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                 
                            <div class="controls">
                                <select id="cidade41" name="cidade41" class="span10">
                                            <option value = "<?php echo $cidade41; ?>"><?php echo $cidade41; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade42" name="cidade42" class="span10">
                                            <option value = "<?php echo $cidade42; ?>"><?php echo $cidade42; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade43" name="cidade43" class="span10">
                                            <option value = "<?php echo $cidade43; ?>"><?php echo $cidade43; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
   
                    
                </div>


            </div>

        </div>
        <div class="span6" id="divCadastrar">  

            <div class="widget-box">
                 <div class="widget-title">
                     <span class="icon"><i class="icon-list"></i></span><h5> Quinta-Feira</h5> 
                </div>
                <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                  
                            <div class="controls">
                                <select id="cidade51" name="cidade51" class="span10">
                                            <option value = "<?php echo $cidade51; ?>"><?php echo $cidade51; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade52" name="cidade52" class="span10">
                                            <option value = "<?php echo $cidade52; ?>"><?php echo $cidade52; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade53" name="cidade53" class="span10">
                                            <option value = "<?php echo $cidade53; ?>"><?php echo $cidade53; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
  
                    
                </div>


            </div>

            <div class="widget-box">
                 <div class="widget-title">
                     <span class="icon"><i class="icon-list"></i></span><h5> Sexta-Feira</h5> 
                </div>
                <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                   
                            <div class="controls">
                                <select id="cidade61" name="cidade61" class="span10">
                                            <option value = "<?php echo $cidade61; ?>"><?php echo $cidade61; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade62" name="cidade62" class="span10">
                                            <option value = "<?php echo $cidade62; ?>"><?php echo $cidade62; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
                            <div class="controls">
                                <select id="cidade63" name="cidade63" class="span10">
                                            <option value = "<?php echo $cidade63; ?>"><?php echo $cidade63; ?></option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->nome; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                            <option value = "">Livre</option>
                                              </select>
                            </div>
 
                    
                </div>


            </div>
        <div class="span12" style="padding: 1%; margin-left: 0">

            <div class="span8 offset2" style="text-align: center">
            <!--       
                <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> aturar</a>
                --> 
                <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>


                <a href="<?php echo base_url() ?>index.php/os" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
            </div>

        </div>


        </div>

    </form>


</div>         
</div>
<!-- Modal Metas-->
<div id="modal-Metas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="span12" id="divEditarVenda">
      <div class="widget-box">
         <div class="widget-title">
             <span class="icon"><i class="icon-money"></i></span><h5> Metas e Comissões </h5> 
         </div>
        <!--   <form action="<?php echo current_url(); ?>" method="post" id="formDoar">-->
        <?php //echo form_hidden('idDoacao',$result->idDoacao) ?>
        <form action="<?php echo base_url() ?>index.php/os/metas" method="post">
          <!--
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-save"></i>
                </span>
                <h5>Confirmar agendamento de </h5>
            </div>-->
            <input id="idDoacao" name="idDoacao"  type="hidden" value=""/>

            <div class="span11" id="divCadastrar">  

                <div class="widget-box">
                     <div class="widget-title">
                         <span class="icon"><i class="icon-list"></i></span><h5> Usuários</h5> 
                    </div>
                    <div >
                        <table class="table table-bordered ">
                        <thead >
                       <tr  bgcolor="Gainsboro" style="font-size:70%"> <th width="20%" >Seleção</th>	
                        <th width="50" ><h5>Meta R$</h5></th>			
                        <th width="60" ><h5>Comissão %</h5></th>		
                        <th width="80" ><h5>Data</h5></th></tr>
                        </thead>
                        </table>
                    <div style="overflow:scroll;height:500px;width:100%;overflow:auto">
                        <table class="table table-bordered ">
                            <tbody >
                                <tr bgcolor='#e5c2ac'>
                                    <td rowspan=2 vertical-align:center;><label  class="btn btn-default"  submit><input name="atendenteTd"  type="checkbox" value="doado"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span></label></td>
                                    <td colspan=3><input id="atendente_Td" class="span12" type="text" name="atendente_Td" value="TODOS ATENDENTES"/></td>
    </tr>

                                <tr bgcolor='#e5c2ac'>
                                    <td ><input id="metaTd" class="span12" type="text" name="metaTd" value=""/></td>
                                    <td ><input id="taxaTd" class="span12" type="text" name="taxaTd" value=""/></td>
                                     <td><input id="dataComTd" class="span12" type="date" name="dataComTd" value="<?php echo date('d/m/Y') ?>"/></td>
    </tr>

                                <?php 

                            foreach ($usuarios as $usu) 
                            {
                                if($usu->situacao == 1)
                                {
                                    $metaMes = '';
                                        $taxa = ''; $codF = '0';
                                    foreach ($metas as $met) 
                                    {
                                    if($met->statusMetas == 1 && $usu->idUsuarios == $met->cod_Funcionario)
                                    {   $metaMes = $met->metaMes;
                                        $taxa = $met->taxaComicao;
                                        $codF = $met->codF;
                                    }}
                                ?>
                                <tr>
                                    <td rowspan=2   style="vertical-align:center;"><label  class="btn btn-default"  submit><input name="atendente[]"  type="checkbox" value="<?php echo $usu->idUsuarios; ?>"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span></label></td>
                                    <td colspan=3><input id="nome<?php echo $usu->idUsuarios; ?>" readonly class="span12" type="text" name="nome<?php echo $usu->idUsuarios; ?>" value="<?php echo $usu->nome; ?>"/></td>
    </tr>

                                <tr>
                                    <td ><input id="meta<?php echo $usu->idUsuarios; ?>" class="span12" type="text" name="meta<?php echo $usu->idUsuarios; ?>" value="<?php echo $metaMes; ?>"/>
                                        </td>
                                    <td ><input id="taxa<?php echo $usu->idUsuarios; ?>" class="span12" type="text" name="taxa<?php echo $usu->idUsuarios; ?>" value="<?php echo $taxa; ?>"/></td>
                                     <td><input id="dataCom<?php echo $usu->idUsuarios; ?>" class="span12" type="date" name="dataCom<?php echo $usu->idUsuarios; ?>" value="<?php echo date('d/m/Y') ?>"/></td>
    </tr>

                                <input id="codFuncionario<?php echo $usu->idUsuarios; ?>" class="span12" type="hidden" name="codFuncionario<?php echo $usu->idUsuarios; ?>" value="<?php echo $usu->idUsuarios; ?>"/>

                                <input id="codF<?php echo $usu->idUsuarios; ?>" class="span12" type="hidden" name="codF<?php echo $usu->idUsuarios; ?>" value="<?php echo $codF; ?>"/>

                                <input id="nomeSup<?php echo $usu->idUsuarios; ?>" class="span12" type="hidden" name="nomeSup<?php echo $usu->idUsuarios; ?>" value="<?php echo $usuario->nome; ?>"/>

                                <input id="idSup<?php echo $usu->idUsuarios; ?>" class="span12" type="hidden" name="idSup<?php echo $usu->idUsuarios; ?>" value="<?php echo $usuario->idUsuarios; ?>"/>
                                <?php }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                <div class="span12" style="padding: 1%; margin-left: 0">
                    <div class="span8 offset2" style="text-align: center">
                <!--       
                    <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> aturar</a>
                    --> 
                    <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>


                    <a href="<?php echo base_url() ?>index.php/os" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                </div>

    </div>

                </div>
            </div>
        </form>

      </div>
</div>    
</div>
    
<!-- Modal Ausências-->
<div id="modal-ausent" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="span12" id="divEditarVenda">
        <form action="<?php echo base_url() ?>index.php/os/metas" method="post">
         
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-save"></i>
                </span>
                <h5>Habilitar acesso a usuário ausente </h5>
            </div>
            <input id="idDoacao" name="idDoacao"  type="hidden" value=""/>

            <div class="span11" id="divCadastrar">
                <div class="widget-box">
                     <div class="widget-title">
                         <span class="icon"><i class="icon-list"></i></span><h5> Usuários</h5> 
                    </div>
                    <div >                   
                    <div style="overflow:scroll;height:200px;width:100%;overflow:auto">
                        <table class="table table-bordered ">
                            <tbody >                              
                                <tr>
                                    <td rowspan=1   >  
                                        Usuário ausente
                                    </td>                      
                                    <td rowspan=1>  
                                         <select name="ausente" id="ausente">
                                           <option value=""> Selecione...</option>
                                             <?php 
                                            foreach ($usuarios as $usu) 
                                            {
                                                if($usu->situacao == 1 && $usu->conta_Usuario < 5)
                                                {
                                                    $metaMes = '';
                                                        $taxa = ''; $codF = '0';
                                                  ?>
                                                <option value="<?php echo  $usu->idUsuarios; ?>"><?php echo  $usu->nome; ?></option>
                                              <?php }}
                                              ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan=1   >  
                                        Usuário substituto 1
                                    </td>                      
                                    <td rowspan=1>  
                                         <select name="substituto1" id="substituto1">
                                           <option value=""> Selecione...</option>
                                             <?php 
                                            foreach ($usuarios as $usu) 
                                            {
                                                if($usu->situacao == 1 && $usu->conta_Usuario < 5)
                                                {
                                                    $metaMes = '';
                                                        $taxa = ''; $codF = '0';
                                                  ?>
                                                <option value="<?php echo  $usu->idUsuarios; ?>"><?php echo  $usu->nome; ?></option>
                                              <?php }}
                                              ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan=1   >  
                                        Usuário substituto 2
                                    </td>                      
                                    <td rowspan=1>  
                                         <select name="substituto2" id="substituto2">
                                           <option value=""> Selecione...</option>
                                             <?php 
                                        foreach ($usuarios as $usu) 
                                        {
                                            if($usu->situacao == 1 && $usu->conta_Usuario < 5)
                                            {
                                                $metaMes = '';
                                                    $taxa = ''; $codF = '0';
                                              ?>
                                            <option value="<?php echo  $usu->idUsuarios; ?>"><?php echo  $usu->nome; ?></option>
                                              <?php }}
                                              ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="span12" style="padding: 1%; margin-left: 0">
                    <div class="span8 offset2" style="text-align: center">
                    <!--       
                        <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> aturar</a>
                     --> 
                        <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>


                        <a href="<?php echo base_url() ?>index.php/os" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>

                </div>

                </div>
            </div>
        </form>

      </div>
</div>

<!-- Modal bloquear-->
<div id="modal-bloc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/bloqueio" method="post" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Bloquear / Desbloquear</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="user_id" name="user_id" value=""/>
        <input type="hidden" id="blok" name="blok" value=""/>       
          <h5 style="text-align: center">Desbloquear / Bloquear  o acesso de <input type="text" readonly id="user_N" name="user_N" value=""/></h5>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
          <button class="btn btn-danger"><i class="icon-lock icon-white"> Alterar acesso</i></button>
      </div>
  </form>
</div>


<!-- Modal BD Obs-->
<div id="modal-bdOBS" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/bdObs" method="post" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alimentar Tabela OBS</h5>
      </div>  
      
      <div class="modal-body"> 
            <td rowspan=1>  
                 <select name="obsM" id="obsM">
                   <option value=""> Selecione...</option>                      
                        <option value="1">criar cadastro de obs inexistentes</option>
                        <option value="2">Concatenar Mensagens</option>
                      
                </select>
            </td>
      </div>
      <div class="modal-body">      
          <h5 style="text-align: center">Concatenar Tabela OBS apartir de: 
              <input type="number"  id="numero" name="numero" value=""/></h5>
          <h5 style="text-align: right">Até <input type="number"  id="numeroFim" name="numeroFim" value=""/></h5>
      </div>
      
      <div class="modal-body">      
          <h5 style="text-align: right">Apartir do cadastro <input type="number"  id="idDoadd" name="idDoadd" value=""/></h5>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
          <button class="btn btn-danger"><i class="icon-lock icon-white"> Alterar acesso</i></button>
      </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
   $(document).on('click', 'a', function(event) {        
        var os = $(this).attr('os');
        $('#idUsuarios').val(os);
      
        var user_N = $(this).attr('user_N');
        $('#user_N').val(user_N);
       
        var user_id = $(this).attr('user_id');
        $('#user_id').val(user_id); 
       
        var blok = $(this).attr('blok');
        $('#blok').val(blok); 
    });
   $(document).on('click', '#excluir-notificacao', function(event) {
       event.preventDefault();       
       $.ajax({
           url: '<?php echo site_url() ?>/os/excluir_notificacao',
           type: 'GET',
           dataType: 'json',
       })
       .done(function(data) {
           if(data.result == true){
              alert('Notificação excluída com sucesso');
              location.reload();
           }else{ alert('Ocorreu um problema ao tentar exlcuir notificação.');}
       });
    
   });

   $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

</script>