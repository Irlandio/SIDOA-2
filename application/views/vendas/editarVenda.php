
    <style>
.badgebox
{ opacity: 0;}
.badgebox + .badge
{text-indent: -999999px;
    width: 27px;}
.badgebox:focus + .badge
{ box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge
{text-indent: 0;}
</style>

<style  type="text/css"> /* INPUT {text-transform: uppercase;}   </style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-folder-open"></i>
                </span>
                <h5>Editar Doação</h5>
                 <h4>#Doação: <?php echo $result->idDoacao.' | Lançado por '.$result->nome ?></h4>
            </div>
            <div class="widget-content nopadding">
                
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da Doação</a></li>
                        <li id="tabAnexos"><a href="#tab2" data-toggle="tab"></a></li>
                                      

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divEditarVenda">
                                <form action="<?php echo current_url(); ?>" method="post" id="formDoar">
                                    <?php echo form_hidden('idDoacao',$result->idDoacao) ?>
                                    <input id="idDoacao" name="idDoacao"  type="hidden" value="<?php echo $result->idDoacao ?>"/>
                                     
                                    <div class="span5" id="divCadastrar">
                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                                <?php                                                     
                                                    $dataDoa = explode('-', $result->dataDoacao);
                                                     $data_Doac = $dataDoa[2].'/'.$dataDoa[1].'/'.$dataDoa[0];

                                                    $dataAge = explode('-', $result->data_Agendamento);
                                                     $data_Age = $dataAge[2].'/'.$dataAge[1].'/'.$dataAge[0];

                                                    $dataPre = explode('-', $result->data_Previsao);
                                                     $data_prevAge = $dataPre[2].'/'.$dataPre[1].'/'.$dataPre[0];

                                                    if($data_Doac == "00/00/0000")
                                                    { $data_Doac = 'Não efetuada';
                                                    }
                                                $data_Max = date('d/m/Y', strtotime("+6 month", strtotime( date('d/m/Y'))));
                                                $data_Amanha = date('d/m/Y', strtotime("+1 day", strtotime( date('d/m/Y'))));
                                  //  echo $data_Amanha;
                                                $chekd = $chekag = $chekpre = $chekde = $chekcan = '';
                                                $ativd = $ativag = $ativpre = $ativde = $ativcan = '';
                                                $named = $nameag = $namepre = $namede = $namecan = 'status';
                                    
                                                $ativensagem =   "hidden";
                                                switch ($result->tipo_Registro) 
                                                        {						    
                                                            case "doado" :	$chekd = "checked";	
                                                                $ativcan = $ativag = $ativpre  = $ativde =  "hidden"; break;    
                                                            case "agendado":	$chekag = "checked";	
                                                                $ativpre =   "hidden"; $ativensagem =   ""; break;  
                                                            case "previsto":	$chekpre = "checked";
                                                                $ativd =   $ativde = "hidden";break; 
                                                            case "devolvido":	$chekde = "checked";	
                                                                $ativd = $ativag = $ativpre  = $namecan = "hidden"; break;  
                                                            case "cancelado":	$chekcan = "checked";	
                                                                $ativd = $ativag = $ativpre  = $ativde =  "hidden"; break;  
                                                        }     
                                            ?>
                                            <div class="control-group">
                                                <label for="doador">Doador<span class="required"></span></label>
                                                <div class="controls">
                                                <input id="doador" type="text"  focus class="span8" name="doador"   value="<?php echo $result->nomeCliente; ?>"  /><font color=red> *</font>
                                                </div>
                                                <input id="doador_id" class="span12" type="hidden" name="doador_id" value="<?php echo $result->idClientes; ?>"  />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                                    <label for="dataInicial">Data prevista para a contribuição<span class="required"></span></label>
                                                    <input id="data_Prev"  class="datepicker6" type="Text" name="data_Prev" value="<?php echo $data_prevAge; ?>" readonly  />
                                        </div>
                                        <div class="control-group">
                                            <label for="dataFinal">Confirmar Data da doação para:</label>
                                            <div class="controls">
                                                <input id="data_Doacao" class="datepicker1"  type="Text"  placeholder="Quando será feita a doação" name="data_Doacao" value="<?php echo $data_Doac; ?>"  readonly /><font color=red> *</font>
                                            </div>
                                        </div>
                                        <div class="span12" >
                                            <div class="control-group">
                                                <label for="valor">Valor da doação R$ <span class="required"></span></label>
                                                <div class="controls">
                                                    <input text-align="right" id="valorDoa"  type="Text"  name="valorDoa" placeholder="0,00" class="money"  value= "<?php echo number_format($result->valor_doar, 2, ',', '.')  ?>"  ><font color=red> *</font>                                            
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <?php   $descricao_Mensagem = '' ;
                                            foreach ($result_mensg as $r_msg) 
                                            {	
                                           if($r_msg->cod_DoadorMensagem == $result->idClientes){ 
                                               $descricao_Mensagem = $r_msg->descricao_Mensagem;
                                            }
                                            }
                                        ?>
                                        <div class="widget-box">
                                                 <span class="icon"><i class="icon-list"></i></span>Histórico de observações
                                            <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">

                                            <textarea id="histor" class="span10" name="histor" readonly rows="3" cols="300"><?php echo $descricao_Mensagem; ?></textarea>
                                            <textarea id="historico" class="span10" name="historico"rows="3" cols="300"></textarea>

                                        </div>
                                        </div>
                                    </div>
                                    <div class="span6" id="divCadastrar">  
                                        
                                        <div class="span12">
                                          
                                                <label for="tipCont">Status</label>
                                                   <label  class="btn btn-default" style= "visibility:<?php echo $ativd ?>" submit><input <?php echo $chekd ?> name="status"  type="radio" value="doado"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Doado  ..</label>

                                                   <label  class="btn btn-default"  style= "visibility:<?php echo $ativag ?>" submit><input  <?php echo $chekag ?>  name="status" type="radio" value="agendado"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Agendado</label><br/>
                                            
                                                   <label  class="btn btn-default"  style= "visibility:<?php echo $ativpre ?>" submit><input  <?php echo $chekpre ?>  name="status"  type="radio" value="previsto"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Previsto</label>

                                                   <label  class="btn btn-default"  style= "visibility:<?php echo $ativde ?>" submit><input  <?php echo $chekde ?>  name="status" type="radio" value="devolvido"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Devolvido</label>
                                                  
                                                   <label  class="btn btn-default"  style= "visibility:<?php echo $ativcan ?>" submit><input  <?php echo $chekcan ?>  name="status" type="radio" value="cancelado"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Cancelado</label><br/>
                                     
                                    </div>
                                        <div class="span12" style="padding: 1%; margin-left: 0">                               
                                                             
                            <div class="control-group">                                
                                    <label for="data_Age">Data do agendamento<span class="required"></span></label>
                            <div class="controls">
                                    <input id="data_Age" class="datepicker" readonly type="Text"  name="data_Age" value="<?php echo $data_Age; ?>"  /><font color=red> *</font>
                            </div>
                            </div>    
                                            <?php $forma = $result->forma_Pag ;
                                            
                                            switch ($forma)
                                            {		    
                                                case '1':	$forma_Pg = 'Dinheiro';       break;    
                                                case '2':	$forma_Pg = 'Cartâo Crédito'; break;  
                                                case '3':	$forma_Pg = 'Cheque';     	   break;  
                                                case '4':	$forma_Pg = 'Boleto';     	   break;  
                                                case '5':	$forma_Pg = 'Depósito';        break; 
                                                case '6':	$forma_Pg = 'Débito';         break;
                                                default:    $forma_Pg = 'Não cadastrado';
                                            }
                                            ?>
                                            <div class="control-group">
                                                <p class="Forma">
                                                    <label for="forma">Forma da doação</label>
                                                    <select name="formaPgto" id="formaPgto" >                                    
                                                        <option value="<?php echo $result->forma_Pag ?>"><?php echo $forma_Pg ?></option>     
                                                        <option value="1">Dinheiro</option>
                                                        <option value="2">Cartâo Crédito</option>
                                                        <option value="3">Cheque</option>
                                                        <option value="4">Boleto</option>
                                                        <option value="5">Depósito</option>
                                                        <option value="6">Débito</option>
                                                    </select>
                                                </p> 
                                            </div> 
                                            <div class="control-group">
                                                <label for="atendente"> Atendente<span class="required">*</span></label>
                                                <input id="atendente"   class="span8"   type="text" name="atendente" value="<?php echo $usuario->nome .' | RG: '.$usuario->rg.' | id '.$usuario->idUsuarios; ?>"  />
                                                <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $usuario->idUsuarios ?>"  />
                                            </div> 
                                             <?php if(!$res_obsMensageiro){
                                                $obsMensageiro = '';
                                                }else  $obsMensageiro = $res_obsMensageiro->obsMensageiro;  ?>
                                            <div class="control-group" style= "visibility:<?php echo $ativensagem ?>">
                                                        <label  for="dataInicial">Observações para o mensageiro<span class="required"></span></label>
                                                <textarea  id="obsMensag" class="span12" name="obsMensag"rows="1" cols="300"><?php echo $obsMensageiro;?></textarea>
                                            </div>
                                        </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span8 offset2" style="text-align: center">
                                        <!--       
                                            <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> aturar</a>
                                            --> 
                                            <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>

                                            <a href="<?php echo base_url() ?>index.php/vendas/visualizar/<?php echo $result->idDoacao; ?>" class="btn btn-inverse"><i class="icon-eye-open"></i> Visualizar Lançamento</a>

                                            <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>

                                    </div>
                                    </div>

                                </form>
                                
                                    
                            </div>

                        </div>
                        
       <!--Anexos-->
                     <div class="tab-pane" id="tab2">
                        <div class="span12" style="padding: 1%; margin-left: 0">
                     <div class="span12 well" style="padding: 1%; margin-left: 0" id="form-anexos">
                         <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8"s method="post">                             
                         <div class="span10">                           
                            <input type="hidden" id="fin_id" name="fin_id" value="<?php echo $result->idDoacao ?>" />
                            <label for="">Anexo</label>
                            <input type="file" class="span12" name="userfile[]" multiple="multiple" size="20" />
                         </div>
                         <div class="span2">
                            <label for="">.</label>                             
                            <button class="btn btn-success span12"><i class="icon-white icon-plus"></i> Anexar</button>
                        </div>           
                        </form>
                        </div>
                        
                        <div class="span12" id="divAnexos" style="margin-left: 0">
                            <?php 
                            $cont = 1;
                            $flag = 5;
                            foreach ($anexos as $a) {
                                if($a->thumb == null){
                                    $thumb = base_url().'assets/img/icon-file.png';
                                    $link = base_url().'assets/img/icon-file.png';
                                }
                                else{
                                    $thumb = base_url().'assets/anexos/thumbs/'.$a->thumb;
                                    $link = $a->url.$a->anexo;
                                }
                                if($cont == $flag){
                                   echo '<div style="margin-left: 0" class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                   $flag += 4;
                                }
                                else{
                                   echo '<div class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                }
                                $cont ++;
                            } ?>
                        </div>
                    </div>
                    </div> 

                    </div>

                </div>


.

        </div>

    </div>
</div>
</div>


<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="formFaturar" action="<?php echo current_url() ?>" method="post">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Faturar Venda</h3>
</div>
<div class="modal-body">
    
    <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
    <div class="span12" style="margin-left: 0"> 
      <label for="descricao">Descrição</label>
      <input class="span12" id="descricao" type="text" name="descricao" value="Fatura de Venda - #<?php echo $result->idDoacao; ?> "  />
      
    </div>  
    <div class="span12" style="margin-left: 0"> 
      <div class="span12" style="margin-left: 0"> 
        <label for="cliente">Cliente*</label>
        <input class="span12" id="cliente" type="text" name="cliente" value="<?php echo $result->idDoacao ?>" />
        <input type="hidden" name="clientes_id" id="clientes_id" value="<?php echo $result->idDoacao ?>">
        <input type="hidden" name="vendas_id" id="vendas_id" value="<?php echo $result->idDoacao; ?>">
      </div>
      
      
    </div>
    <div class="span12" style="margin-left: 0"> 
      <div class="span4" style="margin-left: 0">  
        <label for="valor">Valor*</label>
        <input type="hidden" id="tipo" name="tipo" value="receita" /> 
        <input class="span12 money" id="valor" type="text" name="valor" value="<?php echo number_format($total,2); ?> "  />
      </div>
      <div class="span4" >
        <label for="vencimento">Data Vencimento*</label>
        <input class="span12 datepicker" id="vencimento" type="text" name="vencimento"  />
      </div>
      
    </div>
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span4" style="margin-left: 0">
        <label for="recebido">Recebido?</label>
        &nbsp &nbsp &nbsp &nbsp<input  id="recebido" type="checkbox" name="recebido" value="1" /> 
      </div>
      <div id="divRecebimento" class="span8" style=" display: none">
        <div class="span6">
          <label for="recebimento">Data Recebimento</label>
          <input class="span12 datepicker" id="recebimento" type="text" name="recebimento" /> 
        </div>
        <div class="span6">
          <label for="formaPgto">Forma Pgto</label>
          <select name="formaPgto" id="formaPgto" class="span12">    
            <option value="1">Dinheiro</option>
            <option value="2">Cartâo Crédito</option>
            <option value="3">Cheque</option>
            <option value="4">Boleto</option>
            <option value="5">Depósito</option>
            <option value="6">Débito</option>   
          </select>
        </div>
      </div>
      
    </div>
    
    
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn-cancelar-faturar">Cancelar</button>
  <button class="btn btn-primary">Faturar</button>
</div>
</div>
</form>
</div>
 
<!-- Modal visualizar anexo -->
<div id="modal-anexo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Visualizar Anexo</h3>
  </div>
  <div class="modal-body">
    <div class="span12" id="div-visualizar-anexo" style="text-align: center">
        <div class='progress progress-info progress-striped active'>
            <div class='bar' style='width: 100%'>
            </div></div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
    <a href="" id-imagem="" class="btn btn-inverse" id="download">Download</a>
 <a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>
  </div>
</div> 



<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){

     $(".money").maskMoney(); 

     $('#recebido').click(function(event) {
        var flag = $(this).is(':checked');
        if(flag == true){
          $('#divRecebimento').show();
        }
        else{
          $('#divRecebimento').hide();
        }
     });

     $(document).on('click', '#btn-faturar', function(event) {
       event.preventDefault();
         valor = $('#total-venda').val();
         valor = valor.replace(',', '' );
         $('#valor').val(valor);
     });

      $("#formDoar").validate({
          rules:{
                  doador:{ required: true},
                  atendente:{ required: true},
                  valorDoa:{ required: true}
          },
          messages:{
             doador: {required: 'Campo Requerido.'},
             atendente: {required: 'Campo Requerido.'},
             valorDoa: {required: 'Campo Requerido.'}
          },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
       });
/*
     $("#formFaturar").validate({
          rules:{
             descricao: {required:true},
             numeroDoc: {required:true},
             valorDoa: {required:true},
             razaoSoc: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             numeroDoc: {required: 'Campo Requerido.'},
             valorDoa: {required: 'Campo Requerido.'},
             razaoSoc: {required: 'Campo Requerido.'}
          },
          submitHandler: function( form ){       
            var dados = $( form ).serialize();
            $('#btn-cancelar-faturar').trigger('click');
            $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>index.php/vendas/faturar",
              data: dados,
              dataType: 'json',
              success: function(data)
              {
                if(data.result == true){
                    
                    window.location.reload(true);
                }
                else{
                    alert('Ocorreu um erro ao tentar faturar venda.');
                    $('#progress-fatura').hide();
                }
              }
              });

              return false;
          }
     });*/
      $("#doador").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {
                 $("#doador_id").val(ui.item.id);    
            }
      });
      $("#atendente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteUsuario",
            minLength: 1,
            select: function( event, ui ) {
                 $("#usuarios_id").val(ui.item.id);
            }
      });
    
      $("#formProdutos").validate({
          rules:{
             quantidade: {required:true}
          },
          messages:{
             quantidade: {required: 'Insira a quantidade'}
          },
          submitHandler: function( form ){
             var quantidade = parseInt($("#quantidade").val());
             var estoque = parseInt($("#estoque").val());
             if(estoque < quantidade){
                alert('Você não possui estoque suficiente.');
             }
             else{
                 var dados = $( form ).serialize();
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/adicionarProduto",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        $("#quantidade").val('');
                        $("#produto").val('').focus();
                    }
                    else{
                        alert('Ocorreu um erro ao tentar adicionar produto.');
                    }
                  }
                  });

                  return false;
                }

             }
             
       });

        $("#formAnexos").validate({
         
          submitHandler: function( form ){       
                //var dados = $( form ).serialize();
                var dados = new FormData(form); 
                $("#form-anexos").hide('1000');
                $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/anexar",
                  data: dados,
                  mimeType:"multipart/form-data",
                  contentType: false,
                  cache: false,
                  processData:false,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                        $("#userfile").val('');

                    }
                    else{
                        $("#divAnexos").html('<div class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> '+data.mensagem+'</div>');      
                    }
                  },
                  error : function() {
                      $("#divAnexos").html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> Ocorreu um erro. Verifique se você anexou o(s) arquivo(s).</div>');      
                  }
                  });
                  $("#form-anexos").show('1000');
                  return false;
                }
        });      

       $(document).on('click', 'a', function(event) {
            var idProduto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            if((idProduto % 1) == 0){
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/excluirProduto",
                  data: "idProduto="+idProduto+"&quantidade="+quantidade+"&produto="+produto,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $( "#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        
                    }
                    else{
                        alert('Ocorreu um erro ao tentar excluir produto.');
                    }
                  }
                  });
                  return false;
            }
            
       });
        
       $(document).on('click', '.anexo', function(event) {
           event.preventDefault();
           var link = $(this).attr('link');
           var id = $(this).attr('imagem');
           var url = '<?php echo base_url(); ?>vendas/excluirAnexo/';
           $("#div-visualizar-anexo").html('<img src="'+link+'" alt="">');
           $("#excluir-anexo").attr('link', url+id);

           $("#download").attr('href', "<?php echo base_url(); ?>index.php/vendas/downloadanexo/"+id);

       });

       $(document).on('click', '#excluir-anexo', function(event) {
           event.preventDefault();

           var link = $(this).attr('link'); 
           $('#modal-anexo').modal('hide');
           $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");

           $.ajax({
                  type: "POST",
                  url: link,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                    }
                    else{
                        alert(data.mensagem);
                    }
                  }
            });
       });

       $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy'});
       $(".datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy', maxDate: 4, minDate: 1 });
       $(".datepicker6" ).datepicker({ dateFormat: 'dd/mm/yy', maxDate: 180, minDate: 1 });

});

</script>

