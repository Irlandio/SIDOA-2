

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
                <h5>Cadastro de Usuário</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" value="<?php echo set_value('nome'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="rg" class="control-label">RG<span class="required">*</span></label>
                        <div class="controls">
                            <input id="rg" type="text" name="rg" value="<?php echo set_value('rg'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="cpf" class="control-label">CPF<span class="required">*</span></label>
                        <div class="controls">
                            <input name="cpf" id="cpf"  method="post" type="text" maxlength="14" size="40" value="<?php echo set_value('cpf'); ?>" onkeypress="formatar_mascara(this,'###.###.###-##')">
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                        <div class="controls">
                            <input id="rua" type="text" name="rua" value="<?php echo set_value('rua'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="numero" class="control-label">Numero<span class="required">*</span></label>
                        <div class="controls">
                            <input id="numero" type="text" name="numero" value="<?php echo set_value('numero'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                        <div class="controls">
                            <input id="bairro" type="text" name="bairro" value="<?php echo set_value('bairro'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                        <div class="controls">                             
                           <select id="cidade" name="cidade" class="span2">
                            <option value = "">Selecione...</option>
                            <?php foreach ($result_cidades as $cid) {?>		
                                            <option value = "<?php echo $cid->nome; ?>"><?php echo $cid->nome; ?></option>
                            <?php  } ?>
                            </select> 
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                        <div class="controls">                             
                           <select id="estado" name="estado" class="span2">
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
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Email para acesso<span class="required">*</span></label>
                        <div class="controls">
                            <input id="email" type="text" name="email" value="<?php echo set_value('email'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="senha" class="control-label">Senha para acesso<span class="required">*</span></label>
                        
                        <div class="controls">
                            <input id="senha" type="password" name="senha" value="" value="<?php echo set_value('senha'); ?>"  placeholder="Não preencha se não for usuário."  />
                            <i class="icon-exclamation-sign tip-top" title="Se não quiser alterar a senha, não preencha esse campo."></i>
                       
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="função" class="control-label">Função<span class="required">*</span></label>
                        <div class="controls">
                            <select id="funcao" name="funcao">   
                                        <option value = "">Selecione...</option>                                           
                                       <option value = "1">Operadores de telemarketing</option>
                                        <option value = "3">Operadores virtual (vis)</option>
                                        <option value = "4">Operadores virtual (Invis)</option>
                                        <option value = "5">Supervosor(a)</option>
                                        <option value = "7">Administrativo</option>
                                        <option value = "9">Administrador Sistema</option>
                                        </select>
                          <!--  <input id="telefone" type="text" name="telefone" value="<?php echo set_value('conta_Usuario'); ?>"  />-->
                        </div>
                    </div>
<!--  
                    <div class="control-group">
                        <label for="celular" class="control-label">Tipo de acesso</label>
                        <div class="controls">
                            <select id="tipo_Acesso" name="tipo_Acesso">   
                                        <option value = "">Selecione a conta do usuário</option> 
                                        <option value = "1">1 - Sem restrições</option>  
                                        <option value = "2">2 - Poucas restrições</option>  
                                        <option value = "3">3 - muitas restrições</option>  
                                        <option value = "4">4 - todas restrições</option> 
                                        </select>
                        </div>
                    </div>-->

                    <div class="control-group">
                        <label  class="control-label">Situação*</label>
                        <div class="controls">
                            <select name="situacao" id="situacao">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Permissões<span class="required">*</span></label>
                        <div class="controls">
                            <select name="permissoes_id" id="permissoes_id">
                                  <?php foreach ($permissoes as $p) {
                                      echo '<option value="'.$p->idPermissao.'">'.$p->nome.'</option>';
                                  } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/usuarios" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


<script  src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){

           $('#formUsuario').validate({
            rules : {
                  nome:{ required: true},
                  rg:{ required: true},
                  cpf:{ required: true},
                //  telefone:{ required: true},
                  email:{ required: true},
                  rua:{ required: true},
                  funcao:{ required: true},
                  numero:{ required: true},
                  bairro:{ required: true},
                  cidade:{ required: true},
                  estado:{ required: true},
                  cep:{ required: true}
            },
            messages: {
                  nome :{ required: 'Campo Requerido.'},
                  rg:{ required: 'Campo Requerido.'},
                  cpf:{ required: 'Campo Requerido.'},
             //     telefone:{ required: 'Campo Requerido.'},
                  email:{ required: 'Campo Requerido.'},
                  rua:{ required: 'Campo Requerido.'},
                  funcao:{ required: 'Campo Requerido.'},
                  numero:{ required: 'Campo Requerido.'},
                  bairro:{ required: 'Campo Requerido.'},
                  cidade:{ required: 'Campo Requerido.'},
                  estado:{ required: 'Campo Requerido.'},
                  cep:{ required: 'Campo Requerido.'}

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

      });
</script>




