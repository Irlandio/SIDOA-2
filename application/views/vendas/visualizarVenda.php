<?php $totalProdutos = 0;?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Lançamento <?php echo $result->idDoacao?></h5>
                <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/vendas/editar/'.$result->idDoacao.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
                    <a target="_blank" title="Imprimir" class="btn btn-mini btn-inverse" href="<?php echo site_url()?>/vendas/imprimir/<?php echo $result->idDoacao; ?>"><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head">
                        
                          
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                    
                                                <?php
                                                    $tiporegistro = $result->tipo_Registro;
                                                    
                                                    switch ($tiporegistro) 
                                                            {						    
                                                                case 'agendado':	$tipoR = 'agendada'; $cor = '#3a0f9b';	break;    
                                                                case 'doado':	    $tipoR = 'da doação'; $cor = '#0f9b3f';	break;  
                                                                case 'previsto':	$tipoR = 'prevista'; $cor = '#8A9B0F';	break;  
                                                                case 'cancelado':	$tipoR = 'cancelada'; $cor = '#9b1a0f';	break;  
                                                                case 'devolvido':	$tipoR = 'da devolução'; $cor = '#452c2a';	break;	
                                                            }     
                                                ?>
                                                <span>Doador: </span><br/>
                                                <label for="num_Doc_Banco"><h5><?php echo $result->nomeCliente?> </h5></label>
                                                    
                                                <span>Status:</span><br/>                  
                                                 <label for="num_Doc_Fiscal"><h5><?php echo $result->statusDoador?></h5></label>               
                                                
                                                <span>Situação:</span> <br/>
                                                <label for="historico"><span class="badge" style="background-color: <?php echo $cor ?>; border-color: <?php echo $cor ?>"><?php echo $result->tipo_Registro ?></span><h5></h5></label>
                                                <span>Atendente:</span><br/>
                                                <label for="descricao"><h5> <?php echo $result->nome?></h5></label>
                                                
                                                    
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>     
                                                <?php 
                                                    
                                                $dataDoa = explode('-', $result->dataDoacao);
                                                 $data_Doac = $dataDoa[2].'/'.$dataDoa[1].'/'.$dataDoa[0];

                                                $dataAge = explode('-', $result->data_Agendamento);
                                                 $data_Age = $dataAge[2].'/'.$dataAge[1].'/'.$dataAge[0];

                                                $dataPrev = explode('-', $result->data_Previsao );
                                                 $data_Prev = $dataPrev[2].'/'.$dataPrev[1].'/'.$dataPrev[0];


                                                 ?>
                                                <span>Data <?php echo $tipoR ?>:</span>
                                                <label for="dataFin"><h5> <?php echo $data_Prev ?></h5></label>
                                                
                                                <span>Data que foi agendado:</span>
                                                <label for="dataFin"><h5> <?php echo $data_Age ?></h5></label>
                                                
                                                <span>Forma de pagamento:</span><br/>
                                                <label for="numeroDocFiscal"><h5><?php echo $result->forma_Pag; ?></h5></label>
                                                
                                                <span>Valor da doação:</span>
                                                <label for="valorFin"><h5> <?php echo  number_format($result->valor_doar, 2, ',', '.') ?></h5></label>
                                              
                                               
                                                
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
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
      
                    </div>
<!--
                    <div style="margin-top: 0; padding-top: 0">


                        <?php if($produtos != null){?>
              
                        <table class="table table-bordered table-condensed" id="tblProdutos">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 15px">Produto</th>
                                            <th style="font-size: 15px">Quantidade</th>
                                            <th style="font-size: 15px">Sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        foreach ($produtos as $p) {

                                            $totalProdutos = $totalProdutos + $p->subTotal;
                                            echo '<tr>';
                                            echo '<td>'.$p->descricao.'</td>';
                                            echo '<td>'.$p->quantidade.'</td>';
                                            
                                            echo '<td>R$ '.number_format($p->subTotal,2,',','.').'</td>';
                                            echo '</tr>';
                                        }?>

                                        <tr>
                                            <td colspan="2" style="text-align: right"><strong>Total:</strong></td>
                                            <td><strong>R$ <?php echo number_format($totalProdutos,2,',','.');?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                               <?php }?>
                        
                
                        <hr />
                    
                        <h4 style="text-align: right">Valor Total: R$ <?php echo number_format($totalProdutos,2,',','.');?></h4>

                    </div>
            -->

                    
                    
              
                </div>
            </div>
        </div>
    </div>
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
 <!--<a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>-->
  </div>
</div> 


<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){

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
    
     


        
       $(document).on('click', '.anexo', function(event) {
           event.preventDefault();
           var link = $(this).attr('link');
           var id = $(this).attr('imagem');
           var url = '<?php echo base_url(); ?>os/excluirAnexo/';
           $("#div-visualizar-anexo").html('<img src="'+link+'" alt="">');
           $("#excluir-anexo").attr('link', url+id);

           $("#download").attr('href', "<?php echo base_url(); ?>index.php/os/downloadanexo/"+id);

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


       });
</script>