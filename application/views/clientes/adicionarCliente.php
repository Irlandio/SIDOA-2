

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<script type="text/javascript">
function formatar_mascara(src, mascara) {
 var campo = src.value.length;
 var saida = mascara.substring(0,1);
 var texto = mascara.substring(campo);
 if(texto.substring(0,1) != saida) {
 src.value += texto.substring(0,1);
 }
}
</script>
	<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                 <?php
                
                ?>
                <h5>Cadastro do Doador</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    <div class="span6">                        

                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-user"></i>
                            </span>
                            <h5>Dados pessoais</h5>
                        </div>  
                        
                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Nome do Doador<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nomeD" type="text" focus name="nomeD" value="<?php echo set_value('nomeD'); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="celular" class="control-label">Data de Nascimento<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_Nasc"  class="span3 datepicker" type="text" name="data_Nasc" value="<?php echo set_value('data_Nasc'); ?>"  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="celular" class="control-label">Data de cadastro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_cadastro"  class="span3 datepicker" type="text" name="data_cadastro" value="<?php echo set_value('data_cadastro'); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Contato 1<span class="required">*</span></label>
                            <div class="controls">
                                <input  style="width:100px;"  id="foneD" type="text" focus name="foneD" value="<?php echo set_value('foneD'); ?>"  />
                                  <select style="width:100px;"   name="foneop" id="foneop">
                                    <option value="N/I">N/I</option>
                                    <option value="oi">Oi</option>
                                    <option value="tim">Tim</option>
                                    <option value="vivo">Vivo</option>
                                    <option value="claro">Claro</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Contato 2<span class="required">*</span></label>
                            <div class="controls">
                                <input  style="width:100px;"  id="foneD2" type="text" focus name="foneD2" value="<?php echo set_value('foneD2'); ?>"  />
                                  <select style="width:100px;"   name="foneop2" id="foneop2">
                                    <option value="oi">Oi</option>
                                    <option value="tim">Tim</option>
                                    <option value="vivo">Vivo</option>
                                    <option value="claro">Claro</option>
                                </select>
                            </div>
</div>

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Contato 3<span class="required">*</span></label>
                            <div class="controls">
                                <input  style="width:100px;"  id="foneD3" type="text" focus name="foneD3" value="<?php echo set_value('foneD3'); ?>"  />
                                  <select style="width:100px;"   name="foneop3" id="foneop3">
                                    <option value="oi">Oi</option>
                                    <option value="tim">Tim</option>
                                    <option value="vivo">Vivo</option>
                                    <option value="claro">Claro</option>
                                </select>
                            </div>
</div>


                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-user"></i>
                            </span>
                            <h5>Documentos</h5>
</div>         

                        <div class="control-group">
                            <label for="documento" class="control-label">CPF<span class="required">*</span></label>
                            
                            <div class="controls">
                                <input name="cpf_D" id="cpf_D"  method="post" type="text" maxlength="14" size="40" value="<?php echo set_value('cpf_D'); ?>" onkeypress="formatar_mascara(this,'###.###.###-##')">
                            </div>
</div>

                        <div class="control-group">
                            <label for="rg_D" class="control-label">RG do Doador<span class="required">*</span></label>
                            <div class="controls">
                                <input id="rg_D" type="text" name="rg_D" value="<?php echo set_value('rg_D'); ?>"  />
                            </div>
</div>

                        <div class="control-group">
                            <label for="orgExp" class="control-label">Orgão expedidor<span class="required">*</span></label>
                            <div class="controls">
                                <select id="orgExpD" name="orgExpD" class="span8">
                                            <option value = "">Selecione...</option>	
                                                <option value = "SDS">SDS - Secretaria de Defesa Social</option>	
                                                <option value = "SSP">SSP - Secretaria de Segurança Pública</option>
                                                <option value = "PM">PM - Polícia Militar</option>
                                                <option value = "PC">PC - Policia Civil</option>
                                                <option value = "CNT">CNT - Carteira Nacional de Habilitação</option>
                                                <option value = "DIC">DIC - Diretoria de Identificação Civil</option>
                                                <option value = "CTPS">CTPS - Carteira de Trabaho e Previdência Social</option>
                                                <option value = "FGTS">FGTS - Fundo de Garantia do Tempo de Serviço</option>
                                                <option value = "IFP">IFP - Instituto Félix Pacheco</option>
                                                <option value = "IPF">IPF - Instituto Pereira Faustino</option>
                                                <option value = "IML">IML - Instituto Médico-Legal</option>
                                                <option value = "MTE">MTE - Ministério do Trabalho e Emprego</option>
                                                <option value = "MMA">MMA - Ministério da Marinha</option>
                                                <option value = "MAE">MAE - Ministério da Aeronáutica</option>
                                                <option value = "MEX">MEX - Ministério do Exército</option>
                                                <option value = "POF">POF - Polícia Federal</option>
                                                <option value = "POM">POM - Polícia Militar</option>
                                                <option value = "SES">SES - Carteira de Estrangeiro</option>
                                                <option value = "SJS">SJS - Secretaria da Justiça e Segurança</option>
                                                <option value = "SJTS">SJTS - Secretaria da Justiça do Trabalho e Segurança</option>
                                                <option value = "ZZZ">ZZZ - Outros (inclusive exterior) </option>
                                              </select>

                            </div>
</div>

                        <div class="control-group">
                        <label for="uf_RG" class="control-label">Emissão Data / UF</label>
                            
                        <div class="controls">
                                  
                           <select id="uf_RGD" name="uf_RGD" class="span3">
                                            <option value = "">Selecione...</option>		
                                            <option value = "AC">AC</option>	
                                            <option value = "AM">AM</option>
                                            <option value = "AP">AP</option>
                                            <option value = "BA">BA</option>
                                            <option value = "CE">CE</option>
                                            <option value = "MA">MA</option>
                                            <option value = "MS">MS</option>
                                            <option value = "MT">MT</option>
                                            <option value = "PA">PA</option>
                                            <option value = "PB">PB</option>
                                            <option value = "PE">PE</option>
                                            <option value = "PI">PI</option>
                                            <option value = "PR">PR</option>
                                            <option value = "RN">RN</option>
                                            <option value = "RS">RS</option>
                                            <option value = "SC">SC</option>
                                            <option value = "SP">SP</option>
                                            <option value = "TC">TC</option>
                                            <option value = "ZZZ">ZZZ - exterior </option>
                                          </select> 
                            <input id="data_RgD"  class="span5 datepicker" type="text" name="data_RgD" value="<?php echo set_value('data_ingresso'); ?>"  />
                        </div>                        
                    </div>

                        
                    </div>
                    <div class="span6">

                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-user"></i>
                            </span>
                            <h5>Endereço</h5>
                        </div>  

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">E-mail<span >*</span></label>
                            <div class="controls">
                                <input id="emailD" type="text" focus name="emailD" value="<?php echo set_value('emailD'); ?>"  />
                            </div>
                        </div>  

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Logradouro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="lograd" type="text" focus name="lograd" value="<?php echo set_value('lograd'); ?>"  />
                            </div>
                        </div>  

                        <div class="control-group">
                            <label for="documento" class="control-label">Número<span class="required">*</span></label>
                            <div class="controls">
                                <input name="numero" id="numero"  method="post" type="text" maxlength="14" size="40" value="<?php echo set_value('numero'); ?>" >
                              
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="celular" class="control-label">Complemento<span class="required">*</span></label>
                            <div class="controls">
                                <input id="complem"   method="post" type="text" name="complem" value="<?php echo set_value('complem'); ?>"  />
                            </div>
                        </div>       

                        <div class="control-group">
                            <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                            <div class="controls">
                                <select id="bairro" name="bairro" class="span6">
                                            <option value = "">Selecione...</option>
                                            <?php foreach ($results_Bairro as $rb) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rb->idBairro; ?>"><?php echo $rb->Bairro; ?></option>	
                                                 <?php } ?>
                                              </select>
                            </div>
                        </div>

                        <div class="control-group"  class="span8">
                            <label for="cidade" class="control-label">Cidade/ UF<span class="required">*</span></label>
                            <div class="controls">
                                <select id="cidade" name="cidade" class="span6">
                                            <option value = "">Selecione...</option>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->idC; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                              </select>
                            
                               <select id="uf" name="uf" class="span2">
                                                <option value = "">UF...</option>		
                                                <option value = "AC">AC</option>	
                                                <option value = "AM">AM</option>
                                                <option value = "AP">AP</option>
                                                <option value = "BA">BA</option>
                                                <option value = "CE">CE</option>
                                                <option value = "MA">MA</option>
                                                <option value = "MS">MS</option>
                                                <option value = "MT">MT</option>
                                                <option value = "PA">PA</option>
                                                <option value = "PB">PB</option>
                                                <option value = "PE">PE</option>
                                                <option value = "PI">PI</option>
                                                <option value = "PR">PR</option>
                                                <option value = "RN">RN</option>
                                                <option value = "RS">RS</option>
                                                <option value = "SC">SC</option>
                                                <option value = "SP">SP</option>
                                                <option value = "TC">TC</option>
                                                <option value = "ZZZ">ZZZ - exterior </option>
                                              </select> 
                            </div>


                        </div>

                        <div class="control-group" class="control-label">
                            <label for="sexo" class="control-label">sexo<span class="required">*</span></label>
                            <div class="controls">
                                  <select name="sexo" id="sexo">
                                    <option value="">Selecione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="status" class="control-label">status<span class="required">*</span></label>
                            <div class="controls">
                                <select name="status" id="status">
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="atendente" class="control-label"> Atendente<span > *</span></label>
                            <div class="controls">
                                <select name="atendente" id="atendente">
                                    <option value="<?php echo $usuario->idUsuarios; ?>"><?php echo $usuario->nome; ?></option>
                                    <?php foreach ($results_Atendente as $ra) 
                                                { ?>
                                                <option value = "<?php echo $ra->idUsuarios; ?>"><?php echo $ra->nome; ?></option>	
                                                 <?php } ?>
                                </select>
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
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
   
      $(document).ready(function(){
           $('#formCliente').validate({
            rules :{
                  nomeD:{ required: true},
                  //cpf_D:{ required: true},
                  data_Nasc:{ required: true},
                  data_cadastro:{ required: true},
                  rg_D:{ required: true},
                  sexo:{ required: true},
                  foneD:{ required: true},
                  status:{ required: true}
            },
            messages:{
                  nomeD :{ required: 'Campo Requerido.'},
                  //cpf_D :{ required: 'Campo Requerido.'},
                  data_cadastro:{ required: 'Campo Requerido.'},
                  data_Nasc:{ required: 'Campo Requerido.'},
                  rg_D:{ required: 'Campo Requerido.'},
                  foneD:{ required: 'Campo Requerido.'},
                  status:{ required: 'Campo Requerido.'}
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

          
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
          
      });
</script>




