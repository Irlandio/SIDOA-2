<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Idoso</a></li>
            <li><a data-toggle="tab" href="#tab2">Histórico</a></li>
            <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/servicos/editar/'.$result->id_AfericaoDiaria.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">

            <div class="accordion" id="collapse-group">
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dados Pessoais</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 20%"><strong> Idoso avaliado</strong></td>
                                                    <td><?php echo $result->nomeI ?></td>
                                                </tr><tr><td colspan= 2></td></tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Peso</strong></td>
                                                    <td><?php echo $result->peso ?> Kg</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Valor Glicemico</strong></td>
                                                    <td><?php echo $result->glicemia ?> mg/dL</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> p_sistolica</strong></td>
                                                    <td><?php echo $result->p_sistolica.' / '.$result->p_diastolica ?></td>
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
                                            <span class="icon"><i class="icon-list"></i></span><h5> Situação da aferição</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right"><strong> Data e Hora da aferição</strong></td>
                                                    <td><?php echo $result->data_Hora ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong> observações da Aferição</strong></td>
                                                    <td><?php echo $result->obs_Aferir ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> cadastrador</strong></td>
                                                    <td><?php echo $result->cadastrador ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong> Usuário que registrou</strong></td>
                                                    <td><?php echo $result->usuario_id ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


          
        </div>


    </div>
</div>