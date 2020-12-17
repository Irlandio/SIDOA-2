

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
                <h5>Editar Doador - <?php echo $result->nomeCliente ?></h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    
                    <?php  
                    $data_Nasc = $result->dat_nasciD;
                    $data_cadastro = $result->dataCadastroD;
                    $data_Rg = $result->data_RgD;
                    
                    $data_N     = explode('-', $data_Nasc);
                    $data_N    = $data_N[2].'/'.$data_N[1].'/'.$data_N[0];  

                    $data_ingres     = explode('-', $data_cadastro);
                    $dataCadastroD    = $data_ingres[2].'/'.$data_ingres[1].'/'.$data_ingres[0];
                    
                    $data_R     = explode('-', $data_Rg);
                    $data_RgD    = $data_R[2].'/'.$data_R[1].'/'.$data_R[0];  
                    ?>
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
                                <input id="nomeD" type="text" focus name="nomeD" value="<?php echo $result->nomeCliente ?>"  />
                                <input id="idClientes" type="hidden" name="idClientes" value="<?php echo $result->idClientes ?>"  />
                            </div>
                         </div>

                        <div class="control-group">
                            <label for="celular" class="control-label">Data de Nascimento<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_Nasc"  class="span4 datepicker" readonly type="text" name="data_Nasc" value="<?php echo $data_N; ?>"  />
                            </div>
                         </div>
                        <div class="control-group">
                            <label for="celular" class="control-label">Data de cadastro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_cadastro"  class="span4 datepicker" readonly type="text" name="data_cadastro" value="<?php echo $dataCadastroD; ?>"  />
                            </div>
                         </div>

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Contato 1<span class="required">*</span></label>
                            <div class="controls">
                                <input  style="width:100px;"  id="foneD" type="text"  name="foneD"  maxlength="13" value="<?php echo $result->foneD ?>"   onkeypress="formatar_mascara(this,'##-#####-####')"/>
                                  <select style="width:100px;"   name="foneop" id="foneop">
                                    <option value="<?php echo $result->foneop ?>"><?php echo $result->foneop ?></option>
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
                                <input  style="width:100px;"  id="foneD2" type="text"  name="foneD2"   maxlength="13" value="<?php echo $result->foneD2 ?>"  onkeypress="formatar_mascara(this,'##-#####-####')"/>
                                  <select style="width:100px;"   name="foneop2" id="foneop2">
                                     <option value="<?php echo $result->foneop2 ?>"><?php echo $result->foneop2 ?></option>
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
                                <input  style="width:100px;"  id="foneD3" type="text"  name="foneD3"   maxlength="13" value="<?php echo $result->foneD3 ?>"  onkeypress="formatar_mascara(this,'##-#####-####')"/>
                                  <select style="width:100px;"   name="foneop3" id="foneop3">
                                         <option value="<?php echo $result->foneop3 ?>"><?php echo $result->foneop3 ?></option>
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
                                <input name="cpf_D" id="cpf_D"  method="post" type="text" maxlength="14" size="40" value="<?php echo $result->cpf_D ?>" onkeypress="formatar_mascara(this,'###.###.###-##')">
                            </div>
                         </div>

                        <div class="control-group">
                            <label for="rg_D" class="control-label">RG do Doador<span class="required">*</span></label>
                            <div class="controls">
                                <input id="rg_D" type="text" name="rg_D" value="<?php echo $result->rgDoador ?>"  />
                            </div>
                         </div>

                        <div class="control-group">
                            <label for="orgExp" class="control-label">Orgão expedidor<span class="required">*</span></label>
                            <div class="controls">
                                <select id="orgExpD" name="orgExpD" class="span8">
                                            <option value = "<?php echo $result->orgExpD ?>"><?php echo $result->orgExpD ?></option>	
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
                                            <option value = "<?php echo $result->uf_RGD ?>"><?php echo $result->uf_RGD ?></option>		
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
                            <input id="data_RgD"  class="span5 datepicker" readonly type="text" name="data_RgD" value="<?php echo $data_RgD ?>"  />
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
                                <input id="emailD" type="text"  name="emailD" value="<?php echo $result->emailD ?>"  />
                            </div>
                        </div>  

                        <div class="control-group">
                            <label for="nomeCliente" class="control-label">Logradouro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="lograd" type="text"  name="lograd" value="<?php echo $result->logradD ?>"  />
                            </div>
                        </div>  

                        <div class="control-group">
                            <label for="documento" class="control-label">Número<span class="required">*</span></label>
                            <div class="controls">
                                <input name="numero" id="numero"  method="post" type="text" maxlength="14" size="40" value="<?php echo $result->numeroD ?>" >
                              
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="celular" class="control-label">Complemento<span class="required">*</span></label>
                            <div class="controls">
                                <input id="complem"   method="post" type="text" name="complem" value="<?php echo $result->complemD ?>"  />
                            </div>
                        </div>  
                                            <?php foreach ($results_Bairro as $rb) 
                                                {              
                                                    if($result->bairroD == $rb->idBairro){ $nomeBai = $rb->Bairro; }
                                             } ?>

                        <div class="control-group">
                            <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                            <div class="controls">
                                <select id="bairro" name="bairro" class="span6">
                                            <option value = "<?php echo $result->bairroD ?>"><?php echo $nomeBai ?></option>
                                            <?php foreach ($results_Bairro as $rb) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rb->idBairro; ?>"><?php echo $rb->Bairro; ?></option>	
                                                 <?php } ?>
                                              </select>
                            </div>
                        </div>
                                            <?php foreach ($results_Cidade as $rc) 
                                                {              
                                                    if($result->cidadeD == $rc->idC){ $nomeCid = $rc->nome; }
                                             } ?>
                        <div class="control-group">
                            <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                            <div class="controls">
                                <select id="cidade" name="cidade" class="span6">
                                            <option value = "<?php echo $result->cidadeD ?>"><?php echo  $nomeCid ?></option>
                                           <?php foreach ($results_Cidade as $rc) 
                                                {                                            
                                            ?>
                                                <option value = "<?php echo $rc->idC; ?>"><?php echo $rc->nome; ?></option>	
                                                 <?php } ?>
                                              </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="uf" class="control-label">UF </label>
                            <div class="controls">

                               <select id="uf" name="uf" class="span6">
                                                <option value = "<?php echo $result->estadoD ?>"><?php echo $result->estadoD ?></option>		
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
                        <?php
                            if($result->sexo == 'F')?>

                        <div class="control-group" class="control-label">
                            <label for="sexo" class="control-label">sexo<span class="required">*</span></label>
                            <div class="controls">
                                  <select name="sexo" id="sexo">
                                    <option value="<?php echo $result->sexo ?>"><?php echo $result->sexo ?></option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>
                            </div>
                        </div>

                    <div class="control-group">
                        <label for="numero" class="control-label">status<span class="required">*</span></label>
                        <div class="controls">
                            <select name="status" id="status">
                                <option value="<?php echo $result->statusDoador ?>"><?php echo $result->statusDoador ?></option>
                                <option value="Ativo">Ativo</option>
                                <option value="Inativo">Inativo</option>
                            </select>
                        </div>
                    </div>
                    
                        <div class="control-group">
                            <label for="atendente" class="control-label"> Atendente<span > *</span></label>
                            <div class="controls">
                                <select name="atendente" readonly id="atendente">
                                    
                                    <?php foreach ($results_Atendente as $rA) 
                                                { if($rA->idUsuarios == $result->atendente_ID ){?>
                                    <option value="<?php echo $rA->idUsuarios; ?>"><?php echo $rA->nome; ?></option>
                                    <?php } }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){
                ?>
                                    <?php foreach ($results_Atendente as $ra) 
                                                { ?>
                                                <option value = "<?php echo $ra->idUsuarios; ?>"><?php echo $ra->nome; ?></option>	
                                                 <?php } } ?>
                                </select>
                            </div>
                        </div>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/clientes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                        
                    </div>

                        <div class="control-group">
                            <label for="atendente" class="control-label"> Observações<span > *</span></label>
                            <div class="span8 well" id="divAgen" style="padding: 1%; margin-left: 0">

                            <textarea id="histor" class="span12" name="histor" readonly rows="3" cols="300"><?php echo $result->descricao_Mensagem  ?></textarea>
                            <textarea id="historico" class="span12" name="historico"rows="3" cols="300"></textarea>
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
                  foneD:{ required: true},
                  data_Nasc:{ required: true},
                  rg_D:{ required: true},
                  sexo:{ required: true},
                  data_cadastro:{ required: true},
                  status:{ required: true}
            },
            messages:{
                  nomeD :{ required: 'Campo Requerido.'},
                  foneD :{ required: 'Campo Requerido.'},
                  data_Nasc:{ required: 'Campo Requerido.'},
                  rg_I:{ required: 'Campo Requerido.'},
                  data_cadastro:{ required: 'Campo Requerido.'},
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

