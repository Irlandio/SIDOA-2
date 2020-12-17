<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/dist/excanvas.min.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<!--Action boxes-->
  <div class="container-fluid">
      <h3> CiscoD (Cadastro de Informação e Controle de Doações)</h3>
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
            <li class="bg_lb"> <a href="<?php echo base_url()?>index.php/clientes"> <i class="icon-group"></i> Doador</a> </li>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){ ?>
            <li class="bg_lg"> <a href="<?php echo base_url()?>index.php/vendas"><i class="icon-money"></i> Contribuição</a></li>
        <?php } ?>  <!-- -->
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){ ?>
            <li class="bg_lb"> <a href="<?php echo base_url()?>index.php/servicos"> <i class="icon-list"></i> Contatos</a> </li>
        <?php  } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){ ?>
            <li class="bg_ls"> <a href="<?php echo base_url()?>index.php/os"><i class="icon-list-alt"></i> Administrativo</a></li>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
            <li class="bg_ls"> <a href="<?php echo base_url()?>index.php/usuarios"> <i class="icon-group"></i> Cooperador</a> </li>
        <?php } ?>  <!--
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
            <li class="bg_lo"> <a href="<?php echo base_url()?>index.php/os"> <i class="icon-tags"></i> OS</a> </li>
        <?php } ?>
          -->
      </ul>
    </div>
  </div>  
<!--End-Action boxes-->  
<div class="row-fluid" style="margin-top: 0">
    
    <div class="span12">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Ultimas Doações</h5></div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                          <th>#</th>
                            <th>Nome do Doador</th>
                            <th>Data da doação</th>
                            <th>Atendente</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($produtos != null && 1==2){
                            foreach ($produtos as $p) {
                                echo '<tr>';
                                echo '<td>'.$p->idProdutos.'</td>';
                                echo '<td>'.$p->descricao.'</td>';
                                echo '<td>R$ '.$p->precoVenda.'</td>';
                                echo '<td>'.$p->estoque.'</td>';
                                echo '<td>'.$p->estoqueMinimo.'</td>';
                                echo '<td>';
                                if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
                                    echo '<a href="'.base_url().'index.php/produtos/editar/'.$p->idProdutos.'" class="btn btn-info"> <i class="icon-pencil" ></i> </a>  '; 
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        else{
                            echo '<tr><td colspan="3">Nenhum produto com estoque baixo.</td></tr>';
                        }    

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!--
    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Presentes em aberto</h5></div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Data Inicial</th>
                            <th>Conta</th>
                            <th>BR Beneficiário</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($ordens != null){
                            foreach ($ordens as $o) {
                                echo '<tr>';
                                echo '<td>'.$o->idOs.'</td>';
                                echo '<td>'.date('d/m/Y' ,strtotime($o->dataInicial)).'</td>';
                                echo '<td>'.date('d/m/Y' ,strtotime($o->dataFinal)).'</td>';
                                echo '<td>'.$o->nomeCliente.'</td>';
                                echo '<td>';
                                if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
                                    echo '<a href="'.base_url().'index.php/os/visualizar/'.$o->idOs.'" class="btn"> <i class="icon-eye-open" ></i> </a> '; 
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        else{
                            echo '<tr><td colspan="3">Nenhuma OS em aberto.</td></tr>';
                        }    

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
-->
</div>



<?php if($estatisticas_financeiro != null){ 
      if($estatisticas_financeiro->total_receita != null || $estatisticas_financeiro->total_despesa != null || $estatisticas_financeiro->total_receita_pendente != null || $estatisticas_financeiro->total_despesa_pendente != null){  ?>
<div class="row-fluid" style="margin-top: 0">

    <div class="span4">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas financeiras - Realizado</h5></div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                      <div id="chart-financeiro" style=""></div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>

    <div class="span4">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas financeiras - Pendente</h5></div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                      <div id="chart-financeiro2" style=""></div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>


    <div class="span4">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Total em caixa / Previsto</h5></div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                      <div id="chart-financeiro-caixa" style=""></div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>

</div>
<?php } } ?>

<?php if($os != null){ ?>
<div class="row-fluid" style="margin-top: 0">

    <div class="span12">
                                
        <?php    
                
                $i = 0;
            foreach ($results_Usuarios as $r) 
            {
                $i++; $atend[$i] =   $r->nome;
                $usuarioNome[$i] = $r->nome;
                        $qTD[1] = 0; $qTD[2] = 0; $qTD[3] = 0; $qTD[4] = 0; $qTD[5] = 0; 
                        $age = 0;$doad[$i] = 0;$prev = 0;$cancel = 0;$devol = 0;
                        $Tage = 0.00 ;$Tdoad[$i] = 0.00;$Tprev = 0.00;$Tcancel = 0.00;$Tdevol = 0.00; $ultDoacaoV = 0.00;
                        $ultAgend = date('2000-01-01'); $proxAgend = date('2050-01-01');
                        $ultDoacao = date('2000-01-01'); 
                        $ultPrevisao = date('2000-01-01'); $proxPrevisao = date('2050-01-01');
                        $ultCanc = date('2000-01-01'); 
                        $ultDevol = date('2000-01-01');
                foreach ($os as $rs) 
                {
                    $tipo_R[1] = 'Agendado';$tipo_R[2] = 'Doado';$tipo_R[3] = 'Cancelado';$tipo_R[4] = 'Devolvido';$tipo_R[5] = 'Previsto';

                    switch ($rs->tipo_Registro) 
                    {		    
                        case 'agendado':	$cor = '#3a0f9b';     $tipo_Registro = 'Agendado';	  break;    
                        case 'doado':	    $cor = '#0f9b3f';     $tipo_Registro = 'Doado';	      break;  
                        case 'previsto':	$cor = '#8A9B0F';     $tipo_Registro = 'Previsto';	  break;  
                        case 'cancelado':	$cor = '#9b1a0f';     $tipo_Registro = 'Cancelado';	  break;  
                        case 'devolvido':	$cor = '#452c2a';     $tipo_Registro = 'Devolvido';	  break;	
                    }
                    if($rs->atendente_id ==  $r->idUsuarios  )
                    {
                        $status =  $rs->tipo_Registro;
                        $valor_doar =  $rs->valor_doar;
                        
                        for ($s = 1; $s <= 5; $s++) {$reg[$i][$s]= 1; }
                                                     
                        switch ($status) 
                                {						    
                                    case 'agendado':	 $qTD[1]++;  $age++ ; $Tage = $Tage + $valor_doar;	

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultAgend < $rs->data_Previsao)
                                                        { $ultAgend = $rs->data_Previsao; }else 
                                             if( date('Y-m-d') < $rs->data_Previsao &&  $proxAgend > $rs->data_Previsao)
                                                        { $proxAgend = $rs->data_Previsao;   
                                                         $proxPrevV = $rs->valor_doar;}   break;  

                                    case 'doado':	  $reg[$i][2]++ ;    $qTD[2]++ ; $doad[$i]++; $Tdoad[$i] += $valor_doar;

                                            if( date('Y-m-d') > $rs->dataDoacao &&  $ultDoacao < $rs->dataDoacao)
                                                        { $ultDoacao = $rs->dataDoacao; 
                                                         $ultDoacaoV = $rs->valor_doar;}   break;

                                    case 'previsto':	$reg[$i][5]++ ;   $qTD[5]++ ; $prev++; $Tprev = $Tprev + $valor_doar;	

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultPrevisao < $rs->data_Previsao)
                                                        { $ultPrevisao = $rs->data_Previsao; }else 
                                             if( date('Y-m-d') < $rs->data_Previsao &&  $proxPrevisao > $rs->data_Previsao)
                                                        { $proxPrevisao = $rs->data_Previsao;  
                                                         $proxPrevV = $rs->valor_doar;}   break;

                                    case 'cancelado':	$reg[$i][3]++;    $qTD[3]++; $cancel++; $Tcancel = $Tcancel + $valor_doar;	

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultCanc < $rs->data_Previsao)
                                                        { $ultCanc = $rs->data_Previsao; }  break;

                                    case 'devolvido':	$reg[$i][4]++ ;    $qTD[4]++ ;  $devol++; $Tdevol = $Tdevol + $valor_doar;		

                                            if( date('Y-m-d') > $rs->data_Previsao &&  $ultDevol < $rs->data_Previsao)
                                                        { $ultDevol = $rs->data_Previsao; }   break;
                                }
                        
                    } 
                }
                $reg[$i][1] = $qTD[1] ;
                $reg[$i][2] = $qTD[2] ;
                $reg[$i][3] = $qTD[3] ;
                $reg[$i][4] = $qTD[4] ;
                $reg[$i][5] = $qTD[5] ;
                
                 } $ii = $i;
        /*         for ($u = 1; $u <= $ii; $u++)
                 {  
                 for ($s = 1; $s <= 4; $s++) 
                 {              
                     echo "['".$tipo_R[$s]."', ".$reg[$u][$s]."], ";
                }
                }
    
                 for ($j = 1; $j <= $ii; $j++) {
                     echo "['".$usuarioNome[$j]."', ".$Tdoad[$j]."], ";
                }
            
        
        
         for ($i = 1; $i <= 10; $i++) {
             echo "['".$caixaNome[$i]."', ".$total[$i]."], ";
        }
    
                            */
    
            $data_Do = date('Y-m-01');
            $data_R = date('Y-m-d', strtotime("-0 month", strtotime($data_Do)));
    
                $data_RgD     = explode('-', $data_R);
                $dataInn    = $data_RgD[2].'/'.$data_RgD[1].'/'.$data_RgD[0]; 
                        ?>
       
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas de Lançamentos desde  <?php echo $dataInn  ?></h5></div>
            <div class="widget-content">
                <div class="row-fluid">
                    
                    <?php
                            if($usuario->conta_Usuario > 4  )
                             {?>
                    <div class="span12"><h5>Doações por Atendente </h5>
                        
                      <div id="chart-os" style=""></div>
                    </div>
                    <?php
                                
                         for ($u = 1; $u <= $ii; $u++)
                             {         
                             if($usuario->conta_Usuario > 4 || $usuario->nome == $atend[$u] )
                             {
                        ?>
                            <div class="span5"><h5><?php echo $atend[$u] ?></h5>
                              <div id="chart<?php echo $u ?>-os" style=""></div>
                            </div>
                    <?php
                             }
                         }}
                            
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<div class="row-fluid" style="margin-top: 0">

    <div class="span12">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas do Sistema</h5></div>
            <div class="widget-content">
                <div class="row-fluid">           
                    <div class="span12">
                        <ul class="site-stats">
                            <li class="bg_lh"><i class="icon-group"></i> <strong><?php echo $this->db->count_all('usuarios');?></strong> <small>Usuários</small></li>
                            <li class="bg_lh"><i class="icon-group"></i> <strong><?php echo $this->db->count_all('clientes');?></strong> <small>Doadores </small></li>
                           <!-- 
                            <li class="bg_lh"><i class="icon-hospital"></i> <strong><?php echo $this->db->count_all('os');?></strong> <small>Ba</small></li>
                            <li class="bg_lh"><i class="icon-medkit"></i> <strong><?php echo $this->db->count_all('servicos');?></strong> <small>Aferições</small></li>
                            -->
                        </ul>
                 
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


<?php if($os != null) {?>
<script type="text/javascript">
    
    $(document).ready(function(){
      var data = [
        <?php 
  /*  if($usuario->conta_Usuario > 3 && $usuario->conta_Usuario < 9 ) 
    { 
        for ($i = 4; $i <= 8; $i++) {
             echo "['".$caixaNome[$i]."', ".$total[$i]."],";
        }
       }else
       {*/
         
         for ($j = 1; $j <= $i; $j++) {
             echo "['".$usuarioNome[$j]."', ".$Tdoad[$j]."], ";
        }
     //  }
          ?>
       
      ];
      var plot1 = jQuery.jqplot ('chart-os', [data], 
        { 
          seriesDefaults: {
            renderer: jQuery.jqplot.PieRenderer, 
            rendererOptions: {
              showDataLabels: true
            }
          }, 
          legend: { show:true, location: 'e' }
        }
      );
              
        <?php  for ($t = 1; $t <= $ii; $t++) { ?>
        var data<?php echo $t ?> = [  
            <?php   for ($p = 1; $p <= 4; $p++) {
                     echo "['".$tipo_R[$p]."', ".$reg[$t][$p]."], ";
                } ?>  ];
      var plot<?php echo $t ?> = jQuery.jqplot ('chart<?php echo $t ?>-os', [data<?php echo $t ?>], 
        {  seriesDefaults: {
            renderer: jQuery.jqplot.PieRenderer, 
            rendererOptions: {
              showDataLabels: true   }  }, 
          legend: { show:true, location: 'e' }
        }
      );
 <?php } ?>
    });
 
</script>

<?php } ?>



<?php if(isset($estatisticas_financeiro) && $estatisticas_financeiro != null) { 
         if($estatisticas_financeiro->total_receita != null || $estatisticas_financeiro->total_despesa != null || $estatisticas_financeiro->total_receita_pendente != null || $estatisticas_financeiro->total_despesa_pendente != null){
?>
<script type="text/javascript">
    
    $(document).ready(function(){

      var data2 = [['Total Receitas',<?php echo ($estatisticas_financeiro->total_receita != null ) ?  $estatisticas_financeiro->total_receita : '0.00'; ?>],['Total Despesas', <?php echo ($estatisticas_financeiro->total_despesa != null ) ?  $estatisticas_financeiro->total_despesa : '0.00'; ?>]];
      var plot2 = jQuery.jqplot ('chart-financeiro', [data2],
        {  

          seriesColors: [ "#9ACD32", "#FF8C00", "#EAA228", "#579575", "#839557", "#958c12","#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],   
          seriesDefaults: {
            // Make this a pie chart.
            renderer: jQuery.jqplot.PieRenderer, 
            rendererOptions: {
              // Put data labels on the pie slices.
              // By default, labels show the percentage of the slice.
              dataLabels: 'value',
              showDataLabels: true
            }
          }, 
          legend: { show:true, location: 'e' }
        }
      );


      var data3 = [['Total Receitas',<?php echo ($estatisticas_financeiro->total_receita_pendente != null ) ?  $estatisticas_financeiro->total_receita_pendente : '0.00'; ?>],['Total Despesas', <?php echo ($estatisticas_financeiro->total_despesa_pendente != null ) ?  $estatisticas_financeiro->total_despesa_pendente : '0.00'; ?>]];
      var plot3 = jQuery.jqplot ('chart-financeiro2', [data3], 
        {  

          seriesColors: [ "#90EE90", "#FF0000", "#EAA228", "#579575", "#839557", "#958c12","#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],   
          seriesDefaults: {
            // Make this a pie chart.
            renderer: jQuery.jqplot.PieRenderer, 
            rendererOptions: {
              // Put data labels on the pie slices.
              // By default, labels show the percentage of the slice.
              dataLabels: 'value',
              showDataLabels: true
            }
          }, 
          legend: { show:true, location: 'e' }
        }

      );


      var data4 = [['Total em Caixa',<?php echo ($estatisticas_financeiro->total_receita - $estatisticas_financeiro->total_despesa); ?>],['Total a Entrar', <?php echo ($estatisticas_financeiro->total_receita_pendente - $estatisticas_financeiro->total_despesa_pendente); ?>]];
      var plot4 = jQuery.jqplot ('chart-financeiro-caixa', [data4], 
        {  

          seriesColors: ["#839557","#d8b83f", "#d8b83f", "#ff5800", "#0085cc"],   
          seriesDefaults: {
            // Make this a pie chart.
            renderer: jQuery.jqplot.PieRenderer, 
            rendererOptions: {
              // Put data labels on the pie slices.
              // By default, labels show the percentage of the slice.
              dataLabels: 'value',
              showDataLabels: true
            }
          }, 
          legend: { show:true, location: 'e' }
        }

      );


    });
 
</script>

<?php } } ?>