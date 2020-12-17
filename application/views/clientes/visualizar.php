<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Doador</a></li>
            <li><a data-toggle="tab" href="#tab2">Histórico</a></li>
             <li><a data-toggle="tab" href="">
            <?php 
            if($result->statusDoador == 'Ativo') $cor = '#8A9B0F'; else  $cor = '##9b0f1f'; 
            echo '   Doador '.$result->idClientes.' - '.$result->nomeCliente.' - '.$result->nome;
            ?>
            <span class="badge" style="background-color: <?php echo $cor ?>; border-color: <?php echo $cor ?>"><?php echo $result->statusDoador ?></span> <?php 
            echo '   Atendente '.$result->nome;
            ?> 
            </a></li>
            <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/clientes/editar/'.$result->idClientes.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
            <?php
            
            if( $result->dat_nasciD == '1900-01-00')
            { $idade = 'N/I'; $anosText = ''; $data = 'N/I';}else{
            $data = $result->dat_nasciD;      // Calcular idade do Doador         
            list($ano, $mes, $dia) = explode('-', $data);      // Separa em dia, mês e ano         
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));   // Descobre que dia é hoje e retorna a unix timestamp       
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);        // Descobre a unix timestamp da data de nascimento do fulano     
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);       // Depois apenas fazemos o cálculo já citado :) 
                $anosText = ' anos';
            }
            
            ?>
            <div class="accordion" id="collapse-group">
                
                            <?php
                                    $corA = '#3a0f9b';	    
                                    $corD = '#0f9b3f';	 
                                    $corP = '#8A9B0F';	 
                                    $corC = '#9b1a0f';	
                                    $corDev = '#452c2a';
                                    
                                    $agd = 0.00;	$doado = 0.00;	$previsto = 0.00;	$cancel = 0.00;	 $devolv = 0.00;
                                    $valormaior = 0.00; $mediaDoado = 0.00; 
                                    $qtdTotal = 0 ; $qtdPrev = 0 ; $qtdAg = 0 ;  $qtdDo = 0 ;  $qtdDev = 0 ; $qtdCanc = 0 ;
                                    $datas_Previstas =' ';
                                    $datas_PrevistasV =' ';
                                foreach ($result_Hist as $rh) {
                                     $status = $rh->tipo_Registro;
                                    switch ($status) 
                                            {						                                                    
                                                case 'previsto':	$previsto = $previsto +  $rh->valor_doar;	++$qtdPrev; 
                                                                    $data_Previsao = date(('d/m/Y'), strtotime($rh->data_Previsao));
                                                                    if($rh->data_Previsao <= date('Y-m-d'))
                                                                    {
                                                                    $datas_PrevistasV =  $datas_PrevistasV.' - '.$data_Previsao; 
                                                                    }else
                                                                    $datas_Previstas =  $datas_Previstas.' - '.$data_Previsao;   
                                                                    break; 
                                            
                                                case 'agendado':	$agd = $agd           +  $rh->valor_doar;	++$qtdAg ; 
                                                                    $data_Agend = date(('d/m/Y'), strtotime($rh->data_Previsao));
                                                                    if($rh->data_Previsao <= date('Y-m-d'))
                                                                    {
                                                                    $datas_PrevistasV =  $datas_PrevistasV.' - '.$data_Agend; 
                                                                    }else
                                                                    $datas_Previstas =  $datas_Previstas.' - '.$data_Agend;   
                                                                    break;
                                            
                                                case 'doado':	    $doado = $doado       +  $rh->valor_doar;	++$qtdDo ; 
                                                                    if($rh->valor_doar > $valormaior) $valormaior = $rh->valor_doar; break; 
                                            
                                                case 'devolvido':	$devolv = $devolv     +  $rh->valor_doar;	++$qtdDev ; break;
                                            
                                                case 'cancelado':	$cancel = $cancel     +  $rh->valor_doar;	++$qtdCanc ; break;	
                                        }       
                                }
                                   $valPend =  $previsto + $agd;
                                   $valtotal =  $previsto + $agd + $doado ;
                                   $qtdTotal =  $qtdPrev + $qtdAg + $qtdDo + $qtdDev + $qtdCanc;
                                   if($qtdDo <> 0)  $mediaDoado =  $doado / $qtdDo;
                                                        
                                    $valPend_Exibe  =    number_format(str_replace(",",".",$valPend), 2, ',', '.'); 
                                    $doado_Exibe  =    number_format(str_replace(",",".",$doado), 2, ',', '.'); 
                                    $valtotal_Exibe  =    number_format(str_replace(",",".",$valtotal), 2, ',', '.'); 
                                    $mediaDoado_Exibe  =    number_format(str_replace(",",".",$mediaDoado), 2, ',', '.'); 
                                    $valormaior_Exibe  =    number_format(str_replace(",",".",$valormaior), 2, ',', '.'); 
                            ?>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dados Pessoais</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 20%"><strong> Nome</strong></td>
                                                    <td><?php echo $result->nomeCliente ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> CPF</strong></td>
                                                    <td><?php  if($result->cpf_D == 0)echo ' N/I. '; else  echo $result->cpf_D ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> RG</strong></td>
                                                    <td><?php if($result->rgDoador == 0)echo ' N/I. '; else echo $result->rgDoador.' - '.$result->orgExpD.' - '.$result->uf_RGD .' | expedida em'.$result->data_RgD; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Data Nasc. | Idade</strong></td>
                                                    <td><?php echo $data.' | '.$idade.$anosText; ?></td>
                                                </tr>
                                                <?php if($result->sexo =='F') $sex ='Feminino'; else $sex = 'Masculino'; ?>
                                                <tr>
                                                    <td style="text-align: right"><strong> Sexo</strong></td>
                                                    <td><?php echo $sex?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Data de Cadastro</strong></td>
                                                    <td><?php echo date('d/m/Y',  strtotime($result->dataCadastroD)) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5> Dados de Contato</h5>
                                        </a>
                                    </div>
                                </div> 
                                <?php   foreach ($results_Bairro as $rb) 
                                            {              
                                                if($result->bairroD == $rb->idBairro){ $nomeBai = $rb->Bairro; }
                                            } 
                                        foreach ($results_Cidade as $rc) 
                                            {              
                                                if($result->cidadeD == $rc->idC){ $nomeCid = $rc->nome; }
                                            } ?>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right"><strong> Fone 1</strong></td>
                                                    <td><?php echo $result->foneD.' - '.$result->foneop  ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong> Fone 2</strong></td>
                                                    <td><?php echo $result->foneD2.' - '.$result->foneop2  ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Fone 3</strong></td>
                                                    <td><?php echo $result->foneD3.' - '.$result->foneop3  ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> E-mail</strong></td>
                                                    <td><?php echo $result->emailD ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Endereço</strong></td>
                                                    <td><?php echo $result->logradD.', '.$result->numeroD.', '.$result->complemD.', '.$nomeBai.', '.$nomeCid.' - '.$result->estadoD ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title" >
                                        <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><string>Estatistica de doações</string>
                                            <span class="badge" style="background-color: <?php echo $corP?>; border-color: <?php echo $corP ?>"><?php echo $qtdPrev ?> Previstos </span>  
                                            <span class="badge" style="background-color: <?php echo $corA?>; border-color: <?php echo $corA ?>"><?php echo $qtdAg ?> Agendados </span>  
                                            <span class="badge" style="background-color: <?php echo $corD?>; border-color: <?php echo $corD ?>"><?php echo $qtdDo ?> Doados </span>  
                                            <span class="badge" style="background-color: <?php echo $corDev?>; border-color: <?php echo $corDev ?>"><?php echo $qtdDev ?> Devolvidos </span>  
                                            <span class="badge" style="background-color: <?php echo $corC ?>; border-color: <?php echo $corC ?>"><?php echo $qtdCanc ?> Cancelados </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGThree">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right"><strong>Valor total doado</strong></td>
                                                    <td><span class="badge" style="background-color: <?php echo $corD?>; border-color: <?php echo $corD ?>">R$ <?php echo $doado_Exibe ?> </span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; width: 20%"><strong>Maior valor doado</strong></td>
                                                    <td><span class="badge" style="background-color: <?php echo $corD?>; border-color: <?php echo $corD ?>">R$ <?php echo $valormaior ?> </span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Valor Pendente</strong></td>
                                                    <td><span class="badge" style="background-color: <?php echo $corA?>; border-color: <?php echo $corA ?>">R$ <?php echo $valPend_Exibe ?> </span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Datas previstas</strong></td>
                                                    <td>
                                                        <?php if($datas_PrevistasV <> ' ')
                                                            { ?>
                                                        <span class="badge" style="background-color: #f87f05; border-color: #f87f05;"><?php echo $datas_PrevistasV ?> </span>
                                                        <?php }
                                                         if($datas_Previstas <> ' ')
                                                            {  ?>
                                                        <span class="badge" style="background-color: <?php echo $corP?>; border-color: <?php echo $corP ?>"><?php echo $datas_Previstas ?> </span>
                                                    <?php } ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
           
        <div class="widget-box">
             <div class="widget-title">
                 <span class="icon"><i class="icon-list"></i></span><h5> Histórico de observações</h5> 
            </div>
            <div class="span12 well" id="divAgen" style="padding: 1%; margin-left: 0">
                      
            <textarea id="story" class="span12" readonly  name="story"rows="5" cols="300"><?php echo $result->descricao_Mensagem ?></textarea>

        </div>
        </div>

        </div>


        <!--Tab 2-->
        <div id="tab2" class="tab-pane" style="min-height: 300px">
            <?php if (!$result_Hist) { ?>
                
                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#</th>
                                    <th>Data Agendamento</th>
                                    <th>Data Doação</th>
                                    <th>Valor</th>
                                    <th>Atendente</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td colspan="6">Nenhuma Doação Cadastrada</td>
                                </tr>
                            </tbody>
                        </table>
                
                <?php } else { ?>

            <div class="accordion" id="collapse-group">
                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th style="width: 11%; text-align: center; ">#</th>
                                    <th style="width: 19%; text-align: center; ">Data Agendamento</th>
                                    <th style="width: 20%; text-align: center; ">Data Doação</th>
                                    <th style="width: 19%; text-align: center; ">Valor</th>
                                    <th style="width: 24%; text-align: center; ">Atendente</th>
                                    <th style=" text-align: center; "></th>
                                </tr>
                            </thead>
                    </table>
                  <?php
                    $num = 1;
                foreach ($result_Hist as $rh) {
                    
                    $data_Previsao = date(('d/m/Y'), strtotime($rh->data_Previsao));
                       if($rh->dataDoacao == '0000-00-00') 
                     {
                       $dataDoacao = ' '; $dataD = $data_Previsao; 
                    }else  
                       { $dataDoacao = date(('d/m/Y'), strtotime($rh->dataDoacao));  $dataD = $dataDoacao; }
                    $data_A = date(('d/m/Y'), strtotime($rh->data_Agendamento));
                     $valD_Exibe  =    number_format(str_replace(",",".",$rh->valor_doar), 2, ',', '.'); 
                     ?>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseG<?php echo $num ?>" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5><?php echo $dataD ?></h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseG<?php echo $num ?>">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 10%; text-align: center; "><?php echo $rh->idDoacao ?></td>
                                                    <td style="width: 20%; text-align: center; "><?php echo $data_A ?></td>
                                                    <td style="width: 20%; text-align: center; "><?php echo $dataDoacao ?></td>
                                                    <td style="width: 20%; text-align: center; "><?php echo 'R$ '.$valD_Exibe ?></td>
                                                    <td style="width: 25%; text-align: center; "><?php echo $rh->nome ?></td>
                                                    <td><?php echo '' ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                
                    <?php 
                         ++$num;
                    } ?>
                    </div>

              
                <!--
                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#</th>
                                    <th>Data Agendamento</th>
                                    <th>Data Doação</th>
                                    <th>Valor</th>
                                    <th>Atendente</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                foreach ($result_Hist as $rh) {
                    $data_Previsao = date(('d/m/Y'), strtotime($rh->data_Previsao));
                       if($rh->dataDoacao == '0000-00-00') 
                     {
                       $dataDoacao = ' '; 
                    }else  
                         $dataDoacao = date(('d/m/Y'), strtotime($rh->dataDoacao));
                     
                    echo '<tr>';
                    echo '<td>' . $rh->idDoacao . '</td>';
                    echo '<td>' . $data_Previsao . '</td>';
                    echo '<td>' . $dataDoacao . '</td>';
                    echo '<td>' . $rh->valor_doar . '</td>';
                    echo '<td>' . $rh->nome . '</td>';

                    echo '<td>';
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
                        echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $rh->idDoacao . '" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                    }
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
                        echo '<a href="' . base_url() . 'index.php/os/editar/' . $rh->idDoacao . '" class="btn btn-info tip-top" title="Editar OS"><i class="icon-pencil icon-white"></i></a>'; 
                    }
                    
                    echo  '</td>';
                    echo '</tr>';
                } ?>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
            -->

            <?php  } ?>

        </div>
    </div>
</div>