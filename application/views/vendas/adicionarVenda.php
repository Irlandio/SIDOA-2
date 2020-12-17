
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
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>
<div class="row-fluid" style="margin-top:0">
    
    <div id="blCabeca" title="sitename">  
         
    <div class="widget-content nopadding">

        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <ul class="nav nav-tabs">
                <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da Doação</a></li>
                <li id="tabAnexos"><a href="#tab2" data-toggle="tab"></a></li>
                <li id="tabAnexos"><a href="" data-toggle="tab"></a></li>
            </ul>
            <div class="tab-content">
            <?php
              //  if($usuario->conta_Usuario == 99) 
                {
            ?>
                <div class="tab-pane active" id="tab1">

                    <div class="span10" id="divCadastrar">
                        <?php if($custom_error == true){ ?>
                        <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente Doador e Atendente.</div>
                        <?php } ?>
                        <form action="<?php echo current_url(); ?>" method="post" id="formVendas" >
                            <div class="span12" style="padding: 1%; margin-left: 0">


                                <div class="control-group">
                                    <label for="doador">Doador<span class="required"></span></label>
                                    <div class="controls">
                                    <input id="doador" type="text" focus class="span11" name="doador"   value="" placeholder="Digite parte e selecione o nome do doador." /><font color=red> *</font>
                                    </div>                                    
                                    <input id="doador_id" class="span12" type="hidden" name="doador_id" value=""  />                     
                                    <input id="atendente_ID" class="span4" type="hidden" name="atendente_ID" value=""  />
                                </div>
                                <label for="doador" id="" ></label>
                            </div>
                        
                    <div class="span5" id="divCadastrar">
                            <div class="control-group">
                                
                                    <label for="dataFinal">Data da doação<span class="required"></span></label>
                                
                            <div class="controls">
                                    <input id="data_Prev" class="datepicker6" type="Text"  readonly name="data_Prev" value="<?php echo set_value('data_Prev'); ?>"  /><font color=red> *</font>
                            </div>
                            </div>
                            <div class="span12" >
                                          
                            <div class="control-group">
                                <p class="VALOR">
                                <label for="valor">Valor da doação R$ </label>
                                <span class="style1"></span>
                            <div class="controls">
                                    <input text-align="right" name="valorDoa" placeholder="0,00" class="money"  value= "<?php echo set_value('valorDoa') ?>"  ><font color=red> *</font>
                            </div>
                            </div>
                                <div class="control-group">
                                    <label for="repete">Executar esta doação<span class="required">*</span></label>
                                    <div class="controls">
                                    <input id="repet" type='number' class="span2" min='1' max='12' name="repet" value="1"  /> </div>                                    
                                </div>
                            </div>
                            </div>     
                    <div class="span6" id="divCadastrar">                        
                        <div class="span5" style="padding: 1%; margin-left: 0">                               
                                                  
                            <div class="control-group">                                
                                    <label for="data_Age">Data do agendamento<span class="required"></span></label>
                            <div class="controls">
                                    <input id="data_Age" class="datepicker" type="Text" readonly name="data_Age" value="<?php echo date('d/m/Y'); ?>"  /><font color=red></font>
                            </div>
                            </div>  
                            <div class="control-group">
                                <p class="Forma">
                                    <label for="forma">Forma da doação</label>
                                    <select name="formaPgto" id="formaPgto" >                                    
                                        <option value="1">Dinheiro</option>
                                        <option value="2">Cartão de Crédito</option>
                                        <option value="3">Cheque</option>
                                        <option value="4">Boleto</option>
                                        <option value="5">Depósito</option>
                                        <option value="6">Débito</option>
                                    </select>
                                </p> 
                            </div> 
                            <div class="control-group">
                                <label for="atendente"> Atendente<span class="required">*</span></label>
                                <input id="atendente"  type="text" name="atendente" value="<?php echo $usuario->nome .' | RG: '.$usuario->rg.' | id '.$usuario->idUsuarios; ?>"  />
                                <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $usuario->idUsuarios ?>"  />
                            </div> 
                                  
  
                        </div>     

                    </div>     

                            <div class="form-actions">
                                <div class="span2"  style="text-align: center; background: #000;">                                    
                                 <h5> Doações</h5>
                                    <input id="doados" style="text-align: center; font-weight: bold; font-size: 16px" class="span10" type="text" readonly name="doac" value=""  /> 
                                </div>
                                <div class="span2"  style="text-align: center; background: #000;">                                   
                                 <h5> Total Doado R$</h5>
                                    <input id="TotalDoado" style="text-align: center; font-weight: bold; font-size: 16px" class="span10" type="text"  readonly  value=""  />
                                </div>
                                <div class="span3"  style="text-align: center; background: #000;">                                  
                                  <h5> Prox Agendamento</h5>
                                    <input id="proxAgend" style="text-align: center; font-weight: bold; font-size: 16px" class="span10" type="text" readonly value=""  />
                                </div>
                                <div class="span2"  style="text-align: center; background: #000;">                                 
                                 <h5> Prox Previsão</h5>
                                    <input id="proxPrevisao" style="text-align: center; font-weight: bold; font-size: 16px"  class="span10" type="text" readonly value=""  />
                                </div>
                                <div class="span3"  style="text-align: center; background: #000;">                                 
                                 <h5> Ult. valor Doado R$</h5>
                                    <input id="ultDoacaoV" style="text-align: center; font-family: Tahoma;  font-weight: bold; font-size: 16px" class="span10" type="text" readonly value=""  />
                                </div>
                            </div>   
                                  
                            <div class="form-actions">
                                <div class="span12">
                                    <div class="span6 offset3">
                                        <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                        <a href="<?php echo base_url() ?>index.php/clientes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                    </div>
                                </div>
                            </div>


                        </form>

                    </div>

                </div>
                <?php }
            ?>
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


		<div class="span12">		
			<div id="blRodape">  	
								<h5 text-align=center>Utilidade pública federal</h5>		
                                     
			</div>                    
        </div>                    
    </div>                     
    </div>                    
</div> 
		



<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $(".money").maskMoney();
    
      $("#doador1").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente1",
            minLength: 1,
            select: function( event, ui ) {
                 $("#doador_id").val(ui.item.id);
                
            }
      });
      $("#doador").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {
                 $("#doador_id").val(ui.item.id);
                $("#atendente_ID").val(ui.item.atendente_ID);    
                 $("#doados").val(ui.item.doad);     
                 $("#TotalDoado").val(ui.item.Tdoad);     
                 $("#proxAgend").val(ui.item.proxAgend);     
                 $("#proxPrevisao").val(ui.item.proxPrevisao);     
                 $("#ultDoacaoV").val(ui.item.ultDoacaoV);     
                 $("#diaRotas").val(ui.item.diaRotas); 
            }
      });
        /*                                                         
        'age'       Agendados Total
        'doad'      doados -
        'prev'      previstos 
        'cancel'    cancelados -
        'devo'      devolvidos -
        'Tage'      Agendados Valor total 
        'Tdoad'     Doados valor total -
        'Tprev'     Previstos valor total 
        'Tcancel'   Cancelados valor total 
        'Tdevol'    Devolvidos valor total 
        'ultAgend'  Agendado Ultimo 
        'proxAgend' Agendado Proximo -
        'ultDoacao' Doado Ultimo -
        'ultPrevisao'Previsto Ultimo 
        'proxPrevisao'Previsão Proximo -
        'ultCanc'   Cancelado Ultimo 
        'ultDevol'  Devolvido Ultimo 
        ultDoacaoV     Doação Ultimo Valor -
        proxPrevisaoV   Preivisão Prox Valor -
        */
      $("#atendente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteUsuario",
            minLength: 1,
            select: function( event, ui ) {
                 $("#usuarios_id").val(ui.item.id);
            }
      });
      $("#formVendas").validate({
          rules:{
                  doador:{ required: true},
                  atendente:{ required: true},
                  valorDoa:{ required: true},
                  data_Prev:{ required: true}
          },
          messages:{
             doador: {required: 'Campo Requerido.'},
             atendente: {required: 'Campo Requerido.'},
             valorDoa: {required: 'Campo Requerido.'},
             data_Prev: {required: 'Campo Requerido.'}
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

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy', 
    dayNames: ["Domingo", "Segunda", "Terca", "Quarta", "Quinta", "Sexta", "S&aacute;bado"],
    dayNamesMin: ["Dom", "S", "T", "Q","Q", "S", "Sab"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    monthNames: ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan","Fev", "Mar","Abr", "Mai","Jun", "Jul","Ago", "Set","Out", "Nov","Dez"] });
       $(".datepicker6" ).datepicker({ dateFormat: 'dd/mm/yy', maxDate: 180, minDate: 1,
    dayNames: ["Domingo", "Segunda", "Terca", "Quarta", "Quinta", "Sexta", "S&aacute;bado"],
    dayNamesMin: ["Dom", "S", "T", "Q","Q", "S", "Sab"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    monthNames: ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan","Fev", "Mar","Abr", "Mai","Jun", "Jul","Ago", "Set","Out", "Nov","Dez"] });
   
});

</script>

