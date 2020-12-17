<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-medkit"></i>
                </span>
                <h5>Editar Aferição</h5>
            </div>
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Dados do Ponto</a></li>
                    <li class="active" id="tabDetalhes"><a href="#tabX" data-toggle="tab"><h5>                                    
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
                        </SCRIPT></h5></a></li>
                        <li class="active" id="tabDetalhes"><a href="#tabY" data-toggle="tab"> 
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
                    
            
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formServico" method="post" class="form-horizontal" >
                    <?php echo form_hidden('id_AfericaoDiaria',$result->id_AfericaoDiaria) ?>
                                                    
                    <div class="control-group">
                        <label for="nomeCliente" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">  
                           <select id="idoso" name="idoso" class="span3">
                            
                             <option value = "<?php echo $result->idoso_id; ?>"><?php echo $result->nomeI; ?></option>
                            <?php  
                               foreach ($result_idososN as $r_ido) { 
                                   $ok = 0;
                                foreach ($result_idososP as $r_idoP) 
                                {	
                               if($r_ido->id_idoso == $r_idoP->id_idoso)
                                { ?>
                                <option value = "<?php echo $r_ido->id_idoso; ?>"><?php echo $r_ido->nomeI. " | ".$r_idoP->peso. " Kg"; ?></option>
                            <?php $ok = 1; break; 
                                }
                                } 
                                if( $ok <> 1) {?>
                                <option value = "<?php echo $r_ido->id_idoso; ?>"><?php echo $r_ido->nomeI; ?></option> 
                            <?php
                               }
                                } ?>
                            </select> 
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="documento" class="control-label">Peso (Kg)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="peso" type='number'  min='20' max='200' name="peso" value="<?php echo $result->peso; ?>"  />
                        </div>
                    </div>

                            <input id="id_AfericaoDiaria" type='hidden' name="id_AfericaoDiaria" value="<?php echo $result->id_AfericaoDiaria; ?>"  />
                      

                    <div class="control-group">
                        <label for="documento" class="control-label">Glicemia (mg/dL)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="glicemia" type='number'  min='10' max='400' name="glicemia" value="<?php echo $result->glicemia; ?>"  />
                        </div>
                    </div>

                    
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-medkit"></i>
                            </span>
                            <h5>Pressão</h5>
                        </div>


                    <div class="control-group">
                        <label for="celular" class="control-label">Sistólica (mmHg)</label>
                        <div class="controls">
                            <input id="sistolica"  type='number'  min='10' max='400' step="5" name="sistolica" value="<?php echo $result->p_sistolica; ?>"  />
                        </div>
                    </div>
                                
                    <div class="control-group">
                        <label for="email" class="control-label">Diastólica (mmHg)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="diastolica"  type='number'  min='10' max='400' step="5"  name="diastolica" value="<?php echo $result->p_diastolica; ?>"  />
                        </div>
                    </div>
                        </div>
          
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-medkit"></i>
                            </span>
                            <h5>Detalhes da aferição</h5>
                        </div>


                    <div class="control-group">
                        <label for="email" class="control-label">Hora da aferição<span class="required">*</span></label>
                        <div class="controls">
                            <input type='text' class="form-control" id='datetimepicker1' name="data_Hora" value="<?php echo date('Y-m-d H:m:s'); ?>"/>
                        </div>
                    </div>
                         
                    <div class="control-group">
                        <label for="email" class="control-label">Observação<span class="required">*</span></label>
                        <div class="controls">
                            <textarea name ="obs_Aferir" id ="obs_Aferir" type="text" maxlength=100 ><?php echo $result->obs_Aferir; ?></textarea>
                        </div>
                    </div>
                                                     
                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Aferido por:<span class="required">*</span></label>
                        <div class="controls"> 
                           <select id="aferidor" name="aferidor" class="span3">
                               <?php foreach ($result_funcio as $rfuncio) {
                               if($result->cadastrador == $rfuncio->idUsuarios) { ?>		
                                <option value = "<?php echo $rfuncio->idUsuarios; ?>"><?php echo $rfuncio->nome; ?></option>  
                               <?php  }} ?>
                            <?php foreach ($result_funcio as $rfuncio) {?>		
                                <option value = "<?php echo $rfuncio->idUsuarios; ?>"><?php echo $rfuncio->nome; ?></option>
                            <?php  } ?>
                            </select> 
                        </div>
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
    </div>
</div>
    
<!-- Modal visualizar anexo -->
<div id="modal-visualizar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Visualizar Anexo</h3>
  </div>
  <div class="modal-body">
    <div class="span12" id="div-visualizar-anexo" style="text-align: center">
        <div class='progress progress-info progress-striped active'>
            <div class='bar' style='width: 100%'>
            </div>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
    <a href="" id-imagem="" class="btn btn-inverse" id="download">Download</a>
  </div>
</div> 
<script>
  $(function () {
    $('#datetimepicker1').datetimepicker({           
       format: 'YYYY-MM-DD HH:mm:ss',
       locale: 'PT-BR'             
});
    $('#datetimepicker2').datetimepicker({           
       format: 'YYYY-MM-DD HH:mm:ss',
       locale: 'PT-BR'             
});
 });
   
</script>
<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
          $(".money").maskMoney();
           $('#formServico').validate({
            rules :{
                  nome:{ required: true},
                  preco:{ required: true}
            },
            messages:{
                  nome :{ required: 'Campo Requerido.'},
                  preco :{ required: 'Campo Requerido.'}
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



