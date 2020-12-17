
<style>
.badgebox{    opacity: 0;}
.badgebox + .badge{    text-indent: -999999px;	width: 27px;}
.badgebox:focus + .badge{    box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge{	text-indent: 0;}
</style>

<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-list-alt"></i>
                        </span>
                        <h5>Relatórios Mensais</h5>
                    </div>
                    <div class="widget-content">
                        <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiro" method="post">
                            <div class="span12 well">
                                <div class="span3">
                                    <p class="conta">                    
                                        <label for="conta">Tipos</label>
                                          <select id="tipo" name="tipo">
                                            <option value ='0'>Comparativos mensais</option>
                                              <option value ='1'>Mensal Detalhado</option>
                                              <option value ='2'>Mensal previsto</option>
                                              <option value ='3'>Mensal Ranking</option>
                                              <option value ='4'>-</option>
                                             <?php

                                              ?>														
                                          </select>
                                      <font color=red><span class="style1"> * </span></font>	                    
                                    </p>
                                </div>
                                <div class="span3">             
                                    <label for="conta">Ano</label>
                                          <?php 
                                          $ano =date("Y");
                                          $anoIni = 2009;
                                          ?>	
                                            <select id="ano" name="ano">
                                                    <option value ='<?php echo $ano?>'><?php echo $ano ?></option>
                                                <?php --$ano;
                                                    while($anoIni < $ano) {?>
                                                <option value = '<?php echo $ano ?>'><?php echo $ano?></option>										
                                                <?php --$ano;} ?>														
                                                </select><span class="style1">*</span>

</div>
                                <div class="span3">
                            <label for="conta">Mês</label>	
                              <?php
                                    $meses = array("", "janeiro", "fevereiro", "março", "abril",
                                    "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
                                    $data = date("m");
                                    $data <= 9 ? $data = $data[1] : $data = $data;
                                    ?>
                                    <select id="mes" name="mes">
                                    <option value='<?php echo $data ?>'><?php echo ' '.$meses[$data] ?></option>
                                    <?php                                            
                                    for($i = 1; $i <= count($meses)-1; $i++) {
                                    $i == $data ? $valor = "selected" : $valor = "";
                                   // $i <= 9 ? $ii = "'0'.$i." : $ii = $i;
                                    ?>
                                    <option value='<?php echo $i ?>'><?php echo ' '.$meses[$i] ?></option>
                                    <?php
                              }
                                    ?>
                                    </select>												
                                         <span class="style1">*</span>
</div>      
                                <div class="span3">              
                                  <div class="widget-content">                 
                                     <button class="btn btn-success span12"><i class="icon-white icon-user"></i> Relatório mensal</button>
                                    <div class="pull-right">
                                         <label  class="btn btn-default" submit><input  name="excel"  type="checkbox" value="Corrente"   class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Gerar Excel</label>
                                    </div>
                                  </div>	                       
</div>

                             </div>

                        </form>
                        &nbsp
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="span12">
      <div class="widget-box">
        <?php if ( 2 == 2)   { ?>  
         <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-list-alt"></i>
                    </span>
                    <h5>Relatórios em construção</h5>
                </div>
                <div class="widget-content">
                    <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/clientesRapid" method="get">
                    <div class="span12 well">

                        <div class="span3">
                            <label for="">Lançamento de:</label>
                            <input type="date" name="dataInicial" class="span8" />
                        </div>
                        <div class="span3">
                            <label for="">até:</label>
                            <input type="date" name="dataFinal" class="span8" />
                        </div>


                        <div class="span3">
                            <label for="">Tipo:</label>
                            <select name="tipo" class="span8">
                                <option value="todos">Todos</option>
                                <option value="receita">Receita</option>
                                <option value="despesa">Despesa</option>
                            </select>
                        </div>
                        <div class="span3">

                            <p class="conta">                    
                            <label for="conta">Conta</label>
                              <select id="conta" name="conta">
                             <?php
                                  ?>														
                                  </select>
                                <font color=red><span class="style1"> * </span></font>	                    
                              </p>
                        </div>
                    </div>
                    <div class="span3" style="margin-left: 0; text-align: center">
                            <input type="reset" class="btn" value="Limpar" />
                            <button class="btn btn-inverse"><i class="icon-print icon-white"></i> Imprimir</button>
                    </div>
                    </form>
                    &nbsp
                </div>
            </div>
        </div>
            
        <?php } ?> 
       </div>
    </div>
    
    <?php
    ?>
</div>
      

