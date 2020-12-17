	
<style>
.badgebox{ opacity: 0;}.badgebox + .badge{text-indent: -999999px;width: 27px;}
.badgebox:focus + .badge{ box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge{text-indent: 0;}
</style>


<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente'))
{ ?>
   
 <a href="<?php echo base_url();?>index.php/vendas/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Doação</a>    
<?php } ?>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
             <div class="widget-title">
                <span class="icon"> <i class="icon-folder-open"></i></span>
                <form method="get" action="<?php echo base_url(); ?>index.php/vendas/gerenciar"> 
                    <div class="span3">
                        <input type="text" name="pesquisa"  id="pesquisa"  placeholder="termo para filtrar por doadores" class="span12" value="" >
                    </div>
                    <div class="span2">           

                          <select class="span8" id="status" name="status">
                        
                            <option value = "">Todos</option>		
                            <option value = "doado">Doado</option>	<!--
                            <option value = "agendado">Agendado</option>
                            <option value = "previsto">Previsto</option> -->
                            <option value = "cancelado">Cancelado</option>	
                            <option value = "devolvido">Devolvido</option>
                          
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
             </div>
            <div class="widget-content nopadding">
            <?php
                $conta = "1";
                $nivel = "1";	
                $tipo_conta_acesso = "1";
                if(!$results && !$resultsConcluidos){?>

                <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-user"></i>
                    </span>
                    <h5>Doações</h5>

                </div>

                <div class="widget-content nopadding">
                    <table class="table table-bordered">
                        <thead>
                           <tr>
                            <th>#</th>
                            <th>Nome </th>
                            <th>Valor</th>
                            <th>Data Agendamento</th>
                            <th>Opções</th>
                            <th></th>
                            <th>Atendente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5">Nenhuma Doação Cadastrada</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

            <?php }else{
            ?>
            <div class="widget-box">
                 <div class="widget-title">                         
                    <ul class="nav nav-tabs">
                        <li class="active" id="divPrev"><a href="#tab1" data-toggle="tab"> Previstas</a></li>
                        <li id="divPrev"><a href="#tab2" data-toggle="tab"> Agendadas</a></li>
                        <li  id="divDoados"><a href="#tab3" data-toggle="tab"> Efetuadas</a></li>
                        <li  id="datas"><a href="#tabX" data-toggle="tab">
                            <h5>                                    
                                <SCRIPT LANGUAGE="JAVASCRIPT">
                        var now = new Date();
                        var mName = now.getMonth() +1 ;
                        var dName = now.getDay() +1;
                        var dayNr = now.getDate();
                        var yearNr=now.getYear();
                        if(dName==1) {Day = "Domingo";}
                        if(dName==2) {Day = "Segunda-feira";}
                        if(dName==3) {Day = "Terça-feira";}
                        if(dName==4) {Day = "Quarta-feira";}
                        if(dName==5) {Day = "Quinta-feira";}
                        if(dName==6) {Day = "Sexta-feira";}
                        if(dName==7) {Day = "Sábado";}
                        if(mName==1){Month = "Janeiro";}
                        if(mName==2){Month = "Fevereiro";}
                        if(mName==3){Month = "Março";}
                        if(mName==4){Month = "Abril";}
                        if(mName==5){Month = "Maio";}
                        if(mName==6){Month = "Junho";}
                        if(mName==7){Month = "Julho";}
                        if(mName==8){Month = "Agosto";}
                        if(mName==9){Month = "Setembro";}
                        if(mName==10){Month = "Outubro";}
                        if(mName==11){Month = "Novembro";}
                        if(mName==12){Month = "Dezembro";}
                        if(yearNr < 2000) {Year = 1900 + yearNr;}
                        else {Year = yearNr;}
                        var todaysDate =(" " + Day + ", " + dayNr + "/" + Month + "/" + Year);
                        document.write('  '+todaysDate);
                             document.getElementById('datahora') = todaysDate.value;
                        </SCRIPT>
                            </h5></a></li>
                        <li  id="horas"><a href="#tabY" data-toggle="tab"> 
                       <h5> <SPAN ID="Clock">00:00:00</SPAN></h5></a></li>

                        <SCRIPT LANGUAGE="JavaScript">
                          var Elem = document.getElementById("Clock");
                          function Horario(){ 
                            var Hoje = new Date(); 
                            var Horas = Hoje.getHours(); 
                            if(Horas < 10){ 
                              Horas = "0"+Horas; 
                            } 
                            var Minutos = Hoje.getMinutes(); 
                            if(Minutos < 10){ 
                              Minutos = "0"+Minutos; 
                            } 
                            var Segundos = Hoje.getSeconds(); 
                            if(Segundos < 10){ 
                              Segundos = "0"+Segundos; 
                            } 
                            Elem.innerHTML = Horas+":"+Minutos+":"+Segundos; 
                            } 
                            window.setInterval("Horario()",1000);
                        </SCRIPT>


                    </ul>                    
                </div>
            </div> 
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="span12 well" id="divPrev" style="padding: 1%; margin-left: 0">
                        <div class="widget-content nopadding">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome </th>
                                    <th>Pendencias </th>
                                    <th>Valor</th>
                                    <th>Data Previsão</th>
                                    <th>Opções</th>
                                    <th>Atendente</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($results as $r) {

                            if($r->statusDoador == 'Ativo') 
                            {                              
                            {// Calcular idade do Doador
                            $data = $r->dat_nasciD;   // Separa em dia, mês e ano
                            list($ano, $mes, $dia) = explode('-', $data); // Descobre que dia é hoje e retorna a unix timestamp
                            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));// Descobre a unix timestamp da data de nascimento do fulano
                            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano); // Depois apenas fazemos o cálculo já citado :)
                            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                            }
                                $status = $r->tipo_Registro;                                 
                                switch ($status) 
                                        {						    
                                            case 'agendado':	$cor = '#3a0f9b';	break;    
                                            case 'doado':	    $cor = '#0f9b3f';	break;  
                                            case 'previsto':	$cor = '#8A9B0F';	break;  
                                            case 'cancelado':	$cor = '#9b1a0f';	break;  
                                            case 'devolvido':	$cor = '#452c2a';	break;	
                                        }
                                $bt_Agend =0;
                                $valorExibe  =    number_format(str_replace(",",".",$r->valor_doar), 2, ',', '.');
                                $dataDoa = explode('-', $r->data_Previsao);
                                $data_Doac = $dataDoa[2].'/'.$dataDoa[1].'/'.$dataDoa[0];
                                $data_Amanha = date('Y-m-d', strtotime("+1 day", strtotime( date('Y-m-d'))));
                                $data_Mais3Dias = date('Y-m-d', strtotime("+3 day", strtotime( date('Y-m-d'))));
                                $data_Aman = explode('-', $data_Amanha);
                                $data_Aman = $data_Aman[2].'/'.$data_Aman[1].'/'.$data_Aman[0];
                                
                                
                                if( $r->data_Previsao <= $data_Mais3Dias){
                                $bt_Agend =1;
                                    }
                                    echo '<tr>';
                                    echo '<td>'.$r->idDoacao.' 
                                     <span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->tipo_Registro.'</span></td>';
                                echo '<td>'.$r->nomeCliente.'</td>';
                                if( $r->data_Previsao < $data_Amanha){
                                    
                                ?>
                                    <td>
                                    <span class="badge" style="background-color:#9b1a0f; border-color: #9b1a0f"> Pendente.</span></td>
                                <?php
                                    } else 
                                if( $r->data_Previsao == $data_Amanha){
                                ?>
                                    <td>
                                    <span class="badge" style="background-color:#f42207; border-color: #9b1a0f"> Confirmar!</span>
                                    </td>
                                <?php
                                    } else { echo '<td></td>';}
                                
                                    echo '<td  style="text-align:right;vertical-align:middle;" >R$ '.$valorExibe.'</td>';
                                    echo '<td>'.$data_Doac.'</td>';
                                    echo '<td>';

                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                        echo '<a href="'.base_url().'index.php/vendas/visualizar/'.$r->idDoacao.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                                        echo '<a href="'.base_url().'index.php/vendas/editar/'.$r->idDoacao.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Doação"><i class="icon-pencil icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda') && 
                                $bt_Agend == 1){
                                  
                                foreach ($result_mensg as $r_msg) 
                                {	
                               if($r_msg->cod_DoadorMensagem == $r->idClientes){ 
                                   $descricao_Mensagem = $r_msg->descricao_Mensagem;
                                }
                                } ?>
                                        <a href="#modal-editar" role="button" data-toggle="modal" 
                                       idDoacao="<?php echo $r->idDoacao?>"  
                                       nomeDoador="<?php echo $r->nomeCliente?>"  
                                       doador_id="<?php echo $r->idClientes?>"  
                                       data_Prev="<?php echo $data_Doac?>" 
                                       data_Doar="<?php echo $data_Aman?>"  
                                       valorDoa="<?php echo $r->valor_doar?>"  
                                       data_Age="<?php echo $r->data_Agendamento?>"
                                       formaPgto="<?php echo $r->forma_Pag?>"
                                       atendente_id="<?php echo $r->atendente_id?>" 
                                       historico="<?php echo $descricao_Mensagem?>" 
                                       style="margin-right: 1%" class="btn btn-success" 
                                       title="Confirmar agendamento"><i class="icon-save icon-select"> Agendar</i></a>
                                <?php
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
                                        ?>
                                <a href="<?php  echo base_url() ?>index.php/clientes/visualizar/<?php  echo $r->idClientes ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Ver Histórico"><i >Historico</i></a>
                                
                                
                                <?php 
                                    }
                                    echo '</td><td>'.$r->nome.'</td>';
                                    echo '</tr>';
                                } 
                                
                                
                                }?>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                        </div>
      

                    </div>
                </div>
                
                <div class="tab-pane" id="tab2">
                    <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                        <div class="widget-content nopadding">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome </th>
                                    <th>Pendencias </th>
                                    <th>Valor</th>
                                    <th>Data Confirmada</th>
                                    <th>Opções</th>
                                    <th>Atendente</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($resultsAgen as $r) {

                            if($r->statusDoador == 'Ativo' && $r->tipo_Registro == 'agendado') 
                            {                              
                            {// Calcular idade do Doador
                            $data = $r->dat_nasciD;   
                            // Separa em dia, mês e ano
                            list($ano, $mes, $dia) = explode('-', $data);   
                            // Descobre que dia é hoje e retorna a unix timestamp
                            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                            // Descobre a unix timestamp da data de nascimento do fulano
                            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);   
                            // Depois apenas fazemos o cálculo já citado :)
                            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                            }
                                $status = $r->tipo_Registro; 
                                
                                switch ($status) 
                                        {						    
                                            case 'agendado':	$cor = '#3a0f9b';	break;    
                                            case 'doado':	     $cor = '#0f9b3f';	break;  
                                            case 'previsto':	$cor = '#8A9B0F';	break;  
                                            case 'cancelado':	$cor = '#9b1a0f';	break;  
                                            case 'devolvido':	$cor = '#452c2a';	break;	
                                        }       

                            $valorExibe  =    number_format(str_replace(",",".",$r->valor_doar), 2, ',', '.');     
                            $dataDoa = explode('-', $r->dataDoacao);
                             $data_Doac = $dataDoa[2].'/'.$dataDoa[1].'/'.$dataDoa[0];

                                    echo '<tr>';
                                    echo '<td>'.$r->idDoacao.' 
                                     <span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->tipo_Registro.'</span></td>';
                                    echo '<td>'.$r->nomeCliente.'</td>';
                                if( $r->dataDoacao < date('Y-m-d')){
                                    
                                ?>
                                    <td>
                                    <span class="badge" style="background-color:#9b1a0f; border-color: #9b1a0f"> Pendente.</span></td>
                                <?php
                                    } else 
                                if( $r->dataDoacao == date('Y-m-d')){
                                ?>
                                    <td>
                                    <span class="badge" style="background-color:#f42207; border-color: #9b1a0f"> Com mensageiro!</span>
                                    </td>
                                <?php
                                    } else { echo '<td></td>';}
                                
                                    echo '<td  style="text-align:right;vertical-align:middle;" >R$ '.$valorExibe.'</td>';
                                    echo '<td>'.$data_Doac.'</td>';
                                    echo '<td>';

                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                        echo '<a href="'.base_url().'index.php/vendas/visualizar/'.$r->idDoacao.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                                    }
                                    
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda') && $usuario->conta_Usuario > 4){
                                       
                                        echo '<a href="'.base_url().'index.php/vendas/editar/'.$r->idDoacao.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Doação"><i class="icon-pencil icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
                                     //   echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->id_idoso.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Cliente"><i class="icon-remove icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
                                        ?>
                                <a href="<?php  echo base_url() ?>index.php/clientes/visualizar/<?php  echo $r->idClientes ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Ver Histórico"><i >Historico</i></a>
                                <?php 
                                    }


                                    
                                    echo '</td><td>'.$r->nome.'</td>';
                                    echo '</tr>';
                                } 
                                
                                
                                }?>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
                
                <div class="tab-pane" id="tab3">
                    <div class="span12 well" id="divDoados" style="padding: 1%; margin-left: 0">

                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome </th>
                                    <th>Valor</th>
                                    <th>Data Doação</th>
                                    <th>Opções</th>
                                    <th>Atendente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultsConcluidos as $r) {

                            if($r->statusDoador == 'Ativo') 
                            {
                            
                                $status = $r->tipo_Registro; 
                                
                                switch ($status) 
                                        {						    
                                            case 'agendado':	$cor = '#3a0f9b';	break;    
                                            case 'doado':	     $cor = '#0f9b3f';	break;  
                                            case 'previsto':	$cor = '#8A9B0F';	break;  
                                            case 'cancelado':	$cor = '#9b1a0f';	break;  
                                            case 'devolvido':	$cor = '#452c2a';	break;	
                                        }

                            $valorExibe  =    number_format(str_replace(",",".",$r->valor_doar), 2, ',', '.');     
                            $dataDoa = explode('-', $r->dataDoacao);
                             $data_Doac = $dataDoa[2].'/'.$dataDoa[1].'/'.$dataDoa[0];

                            
                           // if($r->statusDoador == 'Ativo') $cor = '#8A9B0F'; else  $cor = '#9b0f1f';
                                  echo '<tr>';
                                    echo '<td>'.$r->idDoacao.' 
                                     <span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->tipo_Registro.'</span></td>';
                                    echo '<td>'.$r->nomeCliente.'</td>';
                                    echo '<td  style="text-align:right;vertical-align:middle;" >R$ '.$valorExibe.'</td>';
                                    echo '<td>'.$data_Doac.'</td>';
                                    echo '<td>';

                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                        echo '<a href="'.base_url().'index.php/vendas/visualizar/'.$r->idDoacao.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                                        echo '<a href="'.base_url().'index.php/vendas/editar/'.$r->idDoacao.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
                                     //   echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->id_idoso.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Cliente"><i class="icon-remove icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
                                        ?>
                                <a href="<?php  echo base_url() ?>index.php/clientes/visualizar/<?php  echo $r->idClientes ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Ver Histórico"><i >Histórico</i></a>
                                <?php 
                                    }
                                    echo '</td><td>'.$r->nome.'</td>';
                                    echo '</tr>';
                                }}?>
                                <tr>

                                </tr>
                            </tbody>
                        </table>   
                    </div>
                </div>
            <?php echo $this->pagination->create_links();}?>
            </div>
            </div>
        </div>
            </div>
        </div>
    
    <!-- Modal AGENDAR-->
    <div id="modal-editar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="span12" id="divEditarVenda">
      <!--   <form action="<?php echo current_url(); ?>" method="post" id="formDoar">-->
            <?php //echo form_hidden('idDoacao',$result->idDoacao) ?>
        <form action="<?php echo base_url() ?>index.php/vendas/agendar" method="post">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-save"></i>
                </span>
                <h5>Confirmar agendamento de </h5>
                    <input id="doador" type="text"  readonly name="doador"   value=""  />
                    <input id="doador_id" type="hidden"  name="doador_id"   value=""  />
            </div>
            <input id="idDoacao" name="idDoacao"  type="hidden" value=""/>

        <div class="span5" id="divCadastrar" style="padding: 0px 0px; margin-top: 0">

                            <?php     
                            $data_Max = date('d/m/Y', strtotime("+6 month", strtotime( date('d/m/Y'))));
                            $data_Amanha = date('d/m/Y', strtotime("+1 day", strtotime( date('d/m/Y'))));
              //  echo $data_Amanha; 
                                
                                          
                        ?>
                    <div class="control-group" style="padding: 0px 0px; margin: 0px">
                                <label for="dataInicial">Data prevista para contribuição<span class="required"></span></label>
                                <input id="data_Prev"  class="datepicker2" type="Text" name="data_Prev" value="" readonly  />
                    </div>
                    <div class="control-group"  style="padding: 0px 0px; margin: 0px">
                        <label for="dataFinal">Confirmar Data da doação para:</label>
                        <div class="controls" style="padding: 0px 0px; margin: 0px">
                            <input id="data_Doacao" class="datepicker1"  type="Text"  placeholder="Quando será feita a doação" name="data_Doacao" value=""  readonly /><font color=red></font>
                        </div>
                    </div>
                        <div class="control-group" style="padding: 0px 0px; margin: 0px">
                            <label for="valor">Valor R$ /  Forma da doação<span class="required"></span></label>
                            <div class="controls" style="padding: 0px 0px; margin: 0px">
                                <input text-align="right"  class="span4" id="valorDoa"  type="Text"  name="valorDoa" placeholder="0,00" class="money"  value= ""  ><font color=red></font> 


                                <select name="formaPgto" id="formaPgto"   class="span8"  >  
                                    <option value="1">Dinheiro</option>    
                                    <option value="1">Dinheiro</option>
                                    <option value="2">Cartâo Crédito</option>
                                    <option value="3">Cheque</option>
                                    <option value="4">Boleto</option>
                                    <option value="5">Depósito</option>
                                    <option value="6">Débito</option>
                                </select>
                            </div>

                        </div>
                    
                    <div class="control-group">
                                <label for="dataInicial">Observações para o mensageiro<span class="required"></span></label>
                        <textarea id="obsMensag" class="span12" name="obsMensag"rows="3" cols="300"></textarea>
                    </div>


                </div>
                <div class="span6" id="divCadastrar">  

                    <div class="span12">

                            <label for="tipCont">Status</label>

                               <label  class="btn btn-default"   submit><input  checked   name="status" type="radio" value="previsto"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Previsto</label>
                               <label  class="btn btn-default"   submit><input     name="status" type="radio" value="agendado"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Agendado</label><br/>

                               <label  class="btn btn-default"   submit><input  name="status" type="radio" value="cancelado"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Cancelado</label><br/>

                    </div>
                    <div class="span12" style="padding: 1%; margin-left: 0">                               

                        <div class="control-group">                                
                                <label for="data_Age">Data do agendamento<span class="required"></span></label>
                        <div class="controls">
                                <input id="data_Age" class="datepicker" readonly type="Text"  name="data_Age" value=""  /><font color=red> *</font>
                        </div>  
                        <div class="control-group">
                            <label for="atendente"> Atendente<span class="required">*</span></label>
                            <input id="atendente"  readonly  class="span10"   type="text" name="atendente" value="<?php echo $usuario->nome .' | RG: '.$usuario->rg.' | id '.$usuario->idUsuarios; ?>"  />
                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $usuario->idUsuarios; ?>"  />
                        </div> 
                        </div>  


                    <div class="span8 offset2" style="text-align: center">
                    <!--       
                        <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> aturar</a>
                        --> 
                        <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>


                        <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>
                    

                    </div>     

                </div>
                <div class="span12" style="padding: 1%; margin-left: 0">
                    <div class="widget-box">
                         <div class="widget-title">
                             <span class="icon"><i class="icon-list"></i></span><h5> Histórico de observações</h5> 
                        </div>
                        <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">

                        <textarea id="histor" class="span12" name="histor" readonly rows="3" cols="300"></textarea>
                        <textarea id="historico" class="span12" name="historico"rows="2" cols="300"></textarea>
                    </div>


                    </div>


                </div>

            </form>

                                
                                    
                            </div></div>

    <!-- Modal ADICIONAR-->
                    <div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <form action="<?php echo base_url() ?>index.php/vendas/adicionar" method="post">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 id="myModalLabel">Hora da medicação ministrada a 
                        <input type="text" id="nome_idoso" name="nome_idoso" readonly value="" /></h5>
                                 
                        <div class="controls">
                            <input type='text' class="form-control" id='datetimepicker2' name="data_Hora" value="<?php echo date('d/m/Y H:m:s'); ?>"  onkeypress="formatar_mascara(this,'##/##/#### ##:##:##')"/>
                        </div>
                    </div>      
                      <div class="modal-body">
                    <div class="control-group">
                        <label for="nomeCliente" class="control-label">Medicamento<span class="required">*</span></label>
                        <div class="controls">  
                           <select id="medicamento" name="medicamento" class="span8">
                             <option value = "">Selecione...</option>
                            <?php   
                                  
                                foreach ($result_medic as $r_med) 
                                {	
                               if($r_med->status_Uso =='1'){ ?>
                                <option value = "<?php echo $r_med->idEquipamentos; ?>"><?php echo $r_med->nome_referencia. " | ".$r_med->principio_Ativo. " | ".$r_med->forma_Farmaceutica. " ".$r_med->concentracao; ?></option>
                            <?php   
                                }
                                } ?>
                            </select> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="nomeCliente" class="control-label">Profissional que ministrou o medicamento<span class="required">*</span></label>
                        <div class="controls"> 
                           <select id="tecnica" name="tecnica" class="span8">                            
                             <option value = "">Selecione...</option>
                            <?php   
                                foreach ($result_usuarios as $r_use) 
                                {	 ?>
                                <option value = "<?php echo $r_use->idUsuarios; ?>"><?php echo $r_use->nome." | ".$r_use->celular; ?></option>
                            <?php                                 
                                } ?>
                            </select> 
                        <input type="hidden" id="idIdoso" name="idosomed" value="" />
                        </div>
                    </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <button class="btn btn-success">Registrar</button>
                      </div>
                      </form>
                    </div>



                    <!-- Modal -->
                    <div id="modal-exc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      
                    </div>




<script>
 $(function () {
    $('#datetimepicker1').datetimepicker({           
       format: 'DD/MM/YYYY HH:mm:ss', 
       locale: 'PT-BR'             
});
    $('#datetimepicker2').datetimepicker({           
       format: 'DD/MM/YYYY HH:mm:ss', 
       locale: 'PT-BR'             
});
 });
   
</script>


<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var idDoacao = $(this).attr('idDoacao');
        $('#idDoacao').val(idDoacao);
       
        var nomeDoador = $(this).attr('nomeDoador');
        $('#doador').val(nomeDoador);
       
        var doador_id = $(this).attr('doador_id');
        $('#doador_id').val(doador_id);       
        
        var data_Prev = $(this).attr('data_Prev');
        $('#data_Prev').val(data_Prev);
        
        var data_Doar = $(this).attr('data_Doar');
        $('#data_Doacao').val(data_Doar);
       
        var valorDoa = $(this).attr('valorDoa');
        $('#valorDoa').val(valorDoa);
       
        var data_Age = $(this).attr('data_Age');
        $('#data_Age').val(data_Age);
       
        var formaPgto = $(this).attr('formaPgto');
        $('#formaPgto').val(formaPgto);
       
        var historico = $(this).attr('historico');
        $('#histor').val(historico);

    });

       $(".datepicker2" ).datepicker({ dateFormat: 'dd/mm/yy', maxDate: 180, minDate: 2, 
    dayNames: ["Domingo", "Segunda", "Terca", "Quarta", "Quinta", "Sexta", "S&aacute;bado"],
    dayNamesMin: ["Dom", "S", "T", "Q","Q", "S", "Sab"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    monthNames: ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan","Fev", "Mar","Abr", "Mai","Jun", "Jul","Ago", "Set","Out", "Nov","Dez"]});
       $(".datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy', maxDate: 3, minDate: 1, 
    dayNames: ["Domingo", "Segunda", "Terca", "Quarta", "Quinta", "Sexta", "S&aacute;bado"],
    dayNamesMin: ["Dom", "S", "T", "Q","Q", "S", "Sab"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    monthNames: ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan","Fev", "Mar","Abr", "Mai","Jun", "Jul","Ago", "Set","Out", "Nov","Dez"] });
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy', 
    dayNames: ["Domingo", "Segunda", "Terca", "Quarta", "Quinta", "Sexta", "S&aacute;bado"],
    dayNamesMin: ["Dom", "S", "T", "Q","Q", "S", "Sab"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    monthNames: ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan","Fev", "Mar","Abr", "Mai","Jun", "Jul","Ago", "Set","Out", "Nov","Dez"] });
});

</script>