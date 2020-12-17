<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
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

<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aServico')){ ?>
   <a href="<?php echo base_url()?>index.php/servicos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Avaliação diária</a>

<div class="widget-box">
    
        <div class="widget-title">
            <span class="icon">
                <i class="icon-time"></i>
            </span>
            <h5> Avaliação diária</h5>

        </div>

    
<?php } ?>
<?php

            
                          { $contaNome = "10";
                              
                  }
            $conta = "1";
			$nivel = "1";	
            $tipo_conta_acesso = "1";

           
 
if(!$results){?>

        
        <div class="widget-title">
            <span class="icon">
                <i class="icon-medkit"></i>
            </span>
            <h5>Clientes</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
        <tr>
            <th>#</th>
            <th>Nome do Idoso</th>
            <th>Hora da aferição</th>
            <th>Aferido por:</th>
            <th>Lançado por:</th>
            <th></th>
        </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Idoso Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
	

?>



<div class="widget-content nopadding">

  <div class="accordion" id="collapse-group">   
                        
                       <?php 
                        $n =1;
//*******IDOSOS ATIVOS
                        foreach ($result_idosos as $rI) 
                        {
                          if($rI->status == "Ativo")  
                          {
                            
                        $n = $n+1;
                            ?>
                                 <?php
                                 //       $dataX = date('Y-m-d H:m:s'); $data7 = date('Y-m-d 07:00:00'); $data19 = date('Y-m-d 19:00:00');
                                ?>     
                            
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <td>
                                            <a data-parent="#collapse-group" href="#collapse<?php echo $n; ?>" data-toggle="collapse">
                                                <span class="icon"><i class="icon-list"></i></span> <?php echo $rI->nomeI; ?>
                                            </a></td>
                                            <td style="text-align: right; ">
                                            <?php
                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente'))
                                                { ?>
                                                <a href="#modal-adicionar" class="btn btn-success" data-toggle="modal" idosoM="<?php echo $rI->nomeI?>" idoso="<?php echo $rI->id_idoso?>"  title="Registrar aferição"><i class="icon-time"></i> </a>
                                                <?php 
                                            } ?></td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                                <div class="collapse accordion-body" id="collapse<?php echo $n; ?>">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                          <?php       $posi = 1;   $dataY = ('01/01/2000');  
//*******AFERIÇÕES FEITAS
                                            foreach ($results as $rm)
                                            {
                                                if($rI->id_idoso == $rm->id_idoso )
                                            {
                                                

                                                  $dataAfer1 = explode(' ', $rm->data_Hora);
                                                  $dataAfer = explode('-', $dataAfer1[0]);
                                                    $dataAfericao = $dataAfer[2].'/'.$dataAfer[1].'/'.$dataAfer[0];
                                                    $horaAfericao = $dataAfer1[1];
                                                    $dataAPtb = $dataAfericao.' '.$horaAfericao;
                                                    if($dataY <> $dataAfericao){
                                                     if($posi <> 1)   echo '</td></tr>';
                                             ?> 
                                               
                                                <tr><td style="text-align: right; width:40px;"><?php echo $dataAfericao?></td>
                                                    <td >
                                                <a href="#modal-editar" role="button" data-toggle="modal" 
                                                   id_AfericaoDiaria="<?php echo $rm->id_AfericaoDiaria?>"  
                                                   dt="<?php echo $dataAPtb ?>"  
                                                   idosomed="<?php echo $rI->id_idoso?>"  
                                                   usuar="<?php echo $rm->usuario_id?>"  
                                                   peso="<?php echo $rm->peso?>"   
                                                   glicemia="<?php echo $rm->glicemia?>"   
                                                   p_sistolica="<?php echo $rm->p_sistolica?>"
                                                   p_diastolica="<?php echo $rm->p_diastolica?>"  
                                                   idTecnica="<?php echo $rm->uCada?>"  
                                                   obs_Aferir="<?php echo $rm->obs_Aferir?>"  
                                                   tecnica="<?php echo $rm->cadastrador?>" 
                                                   style="margin-right: 1%" class="btn btn-success" 
                                                   title="Editar Registro">
                                                    <i > <?php echo  $horaAfericao." - ".$rm->p_sistolica." / ".$rm->p_diastolica ?></i></a>
                                                    
                                            <?php 
                                                 $posi = 2;
                                                 $dataY = $dataAfericao; 
                                            }else {
                                             ?>  
                                                    
                                                <a href="#modal-editar" role="button" data-toggle="modal"
                                                   id_AfericaoDiaria="<?php echo $rm->id_AfericaoDiaria?>"  
                                                   dt="<?php echo  $dataAPtb ?>"  
                                                   idosomed="<?php echo $rI->id_idoso?>"  
                                                   usuar="<?php echo $rm->usuario_id?>"  
                                                   peso="<?php echo $rm->peso?>"   
                                                   glicemia="<?php echo $rm->glicemia?>"   
                                                   p_sistolica="<?php echo $rm->p_sistolica?>"
                                                   p_diastolica="<?php echo $rm->p_diastolica?>"  
                                                   idTecnica="<?php echo $rm->uCada?>"  
                                                   obs_Aferir="<?php echo $rm->obs_Aferir?>"  
                                                   tecnica="<?php echo $rm->cadastrador?>" 
                                                   style="margin-right: 1%" class="btn btn-success" 
                                                   title="Editar Registro">
                                                    <i > <?php echo  $horaAfericao." - ".$rm->p_sistolica." / ".$rm->p_diastolica ?></i></a>
                                                   
                                            <?php    
                                                   $posi = 2;  }
                                            }
                                            }
                                                if($posi == 2){ echo '<td></td> '; }
                                                ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                             <?php
                            
                        }
                            }?>

                    </div>

 </div>


 <div class="widget-title">
    
    <span class="icon">
        <i class="icon-medkit"></i>
     </span>
                             
    <form method="get" action="<?php echo base_url(); ?>index.php/servicos/gerenciar">      

        <div class="span3">
            <!--
            <input type="text" name="pesquisa"  id="pesquisa"  placeholder="Nome a pesquisar" class="span3" value="" >
       
            <input type="text" name="pesquisaBR"  id="pesquisaBR"  placeholder="data a pesquisar" class="span3" value="" >
            <button class="span12 btn"> <i class="icon-search"></i> </button>
        -->
        </div>
    </form>
                           
   </div>

    


<?php echo $this->pagination->create_links();}?>

</div>
    
    <!-- Modal Editar-->
                    <div id="modal-editar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <?php /*if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } */ ?>
                <form action="<?php echo base_url() ?>index.php/servicos/editar" id="formServico" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="idosomed" class="control-label">Nome do Idoso<span class="required">*</span></label>
                        <div class="controls">  
                            <select id="idosomed" name="idosomed" class="span8">
                             <option value = ""></option>
                            <?php  
                                foreach ($result_idososN as $r_Inome) 
                                {                                
                          if($rI->status == "Ativo")  
                          {?>
                                <option value = "<?php echo $r_Inome->id_idoso; ?>"><?php echo $r_Inome->nomeI; ?></option> 
                            <?php
                                }
                                }
                              ?>
                            </select> 
                        </div>
                    </div>                    
                    <div class="control-group">
                        <label for="hora" class="control-label">Hora da aferição<span class="required">*</span></label>
                        <div class="controls">
                            <input type='text' class="form_datetime" id='datetimepicker1' name="data_Hora" value=""  onkeypress="formatar_mascara(this,'##/##/#### ##:##:##')"/>
                            
                        <input type="hidden" id="id_AfericaoDiaria" name="id_AfericaoDiaria" value="" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="documento" class="control-label">Peso (Kg)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="peso" type='number'  min='20' max='200' name="peso" value="<?php echo set_value('peso'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="documento" class="control-label">Glicemia (mg/dL)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="glicemia" type='number'  min='10' max='400' name="glicemia" value="<?php echo set_value('glicemia'); ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="celular" class="control-label">Pressão</label>                        
                    </div>
                    <div class="control-group">
                        <label for="p_sistolica" class="control-label">Sistólica (mmHg)</label>
                        <div class="controls">
                            <input id="p_sistolica"  type='number' value='80' min='10' max='400' step="5"  name="p_sistolica" value="<?php echo set_value('p_sistolica'); ?>"  />
                        </div>
                    </div>                               
                    <div class="control-group">
                        <label for="email" class="control-label">Diastólica (mmHg)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="p_diastolica"  type='number' value='80' min='10' max='400' step="5"  name="p_diastolica" value="<?php echo set_value('p_diastolica'); ?>"  />
                        </div>
                    </div>                        
                    <div class="control-group">
                        <label for="email" class="control-label">Observação<span class="required">*</span></label>
                        <div class="controls">
                            <textarea name ="obs_Aferir" id ="obs_Aferir" type="text" maxlength=100 ><?php echo set_value('obs_Aferir'); ?></textarea>
                        </div>
                    </div>
                                                     
                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Aferido por:<span class="required">*</span></label>
                        <div class="controls"> 
                           <select id="tecnica" name="tecnica" class="span6">
                            <option value = ""></option>
                            <?php foreach ($result_funcio as $rfuncio) {?>		
                                <option value = "<?php echo $rfuncio->idUsuarios; ?>"><?php echo $rfuncio->nome; ?></option>
                            <?php  } ?>
                            </select> 
                        </div>
                    </div>


                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/servicos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
                    </div>



    
    <!-- Modal Adicionar-->
                    <div id="modal-adicionar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <?php /*if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } */ ?>
                <form action="<?php echo base_url() ?>index.php/servicos/adicionar" id="formServico" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="idosomed" class="control-label">Nome do Idoso<span class="required">*</span></label>
                        <div class="controls">  
                            <select id="idIdoso" name="idIdoso" class="span8">
                             <option value = ""></option>
                            <?php  
                                foreach ($result_idososN as $r_Inome) 
                                {
                                
                          if($rI->status == "Ativo")  
                          {?>
                                <option value = "<?php echo $r_Inome->id_idoso; ?>"><?php echo $r_Inome->nomeI; ?></option> 
                            <?php
                                }
                                }
                              ?>
                            </select> 
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="hora" class="control-label">Hora da aferição<span class="required">*</span></label>
                        <div class="controls">
                            <input type='text' class="form_datetime" id='datetimepicker2' name="data_Hora" value="<?php echo date('d/m/Y H:m:s'); ?>"  onkeypress="formatar_mascara(this,'##/##/#### ##:##:##')"/>
                            
                        <input type="hidden" id="id_AfericaoDia" name="id_AfericaoDia" value="" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="documento" class="control-label">Peso (Kg)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="pes" type='number' value='70' min='20' max='200' name="pes" value="<?php echo set_value('peso'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="documento" class="control-label">Glicemia (mg/dL)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="glicem" type='number' value='100' min='10' max='400' name="glicem" value="<?php echo set_value('glicemia'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Pressão</label>                        
                    </div>


                    <div class="control-group">
                        <label for="p_sistolica" class="control-label">Sistólica (mmHg)</label>
                        <div class="controls">
                            <input id="p_sistolic"  type='number' value='80' min='10' max='400' step="5"  name="p_sistolic" value="<?php echo set_value('p_sistolic'); ?>"  />
                        </div>
                    </div>
                                
                    <div class="control-group">
                        <label for="email" class="control-label">Diastólica (mmHg)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="p_diastolic"  type='number' value='80' min='10' max='400' step="5"  name="p_diastolic" value="<?php echo set_value('p_diastolic'); ?>"  />
                        </div>
                    </div>
          
                         
                    <div class="control-group">
                        <label for="email" class="control-label">Observação<span class="required">*</span></label>
                        <div class="controls">
                            <textarea name ="obs_Aferi" id ="obs_Aferi" type="text" maxlength=100 ><?php echo set_value('obs_Aferi'); ?></textarea>
                        </div>
                    </div>
                                                     
                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Aferido por:<span class="required">*</span></label>
                        <div class="controls"> 
                           <select id="tecnic" name="tecnic" class="span6">
                            <option value = ""></option>
                            <?php foreach ($result_funcio as $rfuncio) {?>		
                                <option value = "<?php echo $rfuncio->idUsuarios; ?>"><?php echo $rfuncio->nome; ?></option>
                            <?php  } ?>
                            </select> 
                        </div>
                    </div>


                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/servicos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
                    </div>


 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/servicos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Idoso</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCliente" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este cliente e os dados associados a ele (OS, Vendas, Receitas)?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>




<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
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
 $('#formCliente').validate({
            rules :{
                 // glicemia:{ required: true},
                  sistolica:{ required: true},
                  diastolica:{ required: true},
                  aferidor:{ required: true},
                  datetimepicker1:{ required: true},
                 
            },
            messages:{
             //     glicemia :{ required: 'Campo Requerido.'},
                  sistolica :{ required: 'Campo Requerido.'},
                  diastolica:{ required: 'Campo Requerido.'},
                  aferidor:{ required: 'Campo Requerido.'},
                  datetimepicker1:{ required: 'Campo Requerido.'},
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

   $(document).on('click', 'a', function(event) {
        
        var servico = $(this).attr('servico');
        $('#idServico').val(servico);
       
        var idosoE = $(this).attr('idosoE');
        var idosoM = $(this).attr('idosoM');
        var idoso = $(this).attr('idoso');
        $('#idIdosoE').val(idosoE);
        $('#idIdoso').val(idoso);
        $('#nome_idoso').val(idosoM);       
        
        var id_AfericaoDiaria = $(this).attr('id_AfericaoDiaria');
        var dt = $(this).attr('dt');
        var idosomed = $(this).attr('idosomed');
        var usuar = $(this).attr('usuar');
        var peso = $(this).attr('peso');
        var glicemia = $(this).attr('glicemia');
        var p_sistolica = $(this).attr('p_sistolica');
        var p_diastolica = $(this).attr('p_diastolica');
        var obs_Aferir = $(this).attr('obs_Aferir');
        var tecnica = $(this).attr('tecnica');
       
        $('#id_AfericaoDiaria').val(id_AfericaoDiaria);
        $('#datetimepicker1').val(dt);
        $('#idosomed').val(idosomed);
        $('#usuar').val(usuar);
        $('#peso').val(peso);
        $('#glicemia').val(glicemia);
        $('#p_sistolica').val(p_sistolica);
        $('#p_diastolica').val(p_diastolica);
        $('#obs_Aferir').val(obs_Aferir);
        $('#tecnica').val(tecnica);

    });

});

</script>