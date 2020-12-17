<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends CI_Controller{


    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    public function __construct() {
        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        
        $this->load->model('Relatorios_model','',TRUE);
        $this->data['menuRelatorios'] = 'Relatórios';

    }
    public function clientes(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_clientes';
       	$this->load->view('tema/topo',$this->data);
    }

    public function produtos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_produtos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function clientesCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');

        $data['clientes'] = $this->Relatorios_model->clientesCustom($dataInicial,$dataFinal);

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    
    }

    public function clientesRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }
         $data['results_Bairro'] = $this->Relatorios_model->get2('bairros','Bairro');
         $data['results_Cidade'] = $this->Relatorios_model->get2('cidade','idC');
       	
        $data['bairros'] = $this->Relatorios_model->get2('bairros');
        $data['clientes'] = $this->Relatorios_model->clientesRapid();
        $pdf = 0;
        if($pdf == 0)
        $this->load->view('relatorios/imprimir/imprimirClientes', $data);
        else{
        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
            
        }
    }

    public function mesPrevistos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }
        $this->data['usuario'] = $this->Relatorios_model->getByIdUser($this->session->userdata('id'));
        
        if(null !== ($this->input->post('tipo')))
        {       
            if(null !== ($this->input->post('ano'))) 
                $ano  = $this->input->post('ano'); 
            else $ano = date('Y');
            
            if(null !== ($this->input->post('mes')))
                { $mes   = $this->input->post('mes');             
               
                    $me_s = $mes;
                    $ano0 = $ano;
                   // $ii = $mess - 1;
                    $i =1;
                    $datass = 'Datas Todas ';
                    for ($i = 1; $i <= 7; $i++) 
                    {
                        if($i == 1) { $ano0 = $ano0 -1; } //*** SE FOR O PRIMEIRO ele recebe o mês do ano passado
                        if($i == 7) { $dataIMedia =  date($ano0.'-'.$mes.'-01'); }
                        else //***  SE FOR O 7 ele recebe O 1 DIA do sexto mês anterior ao pesquisado 
                        {if($i == 2) //*** SE FOR O SEGUNDO ele recebe O ultimo DIA do mês pesquisado
                        {
                        $diaS = cal_days_in_month(CAL_GREGORIAN, $mes, $ano0);
                        $dataFMedia = date($ano0.'-'.$mes.'-'.$diaS);
                        }
                        }
                            $mes = $me_s;
                      //  $me_s <= 9 ? $mes = '0'.$me_s : $mes = $me_s;
                        $diass = cal_days_in_month(CAL_GREGORIAN, $mes, $ano0);
                        $dataI = date($ano0.'-'.$mes.'-01');
                        $dataF = date($ano0.'-'.$mes.'-'.$diass);
                        $_SESSION['dataI'.$i] = $dataI; $_SESSION['dataF'.$i] = $dataF;
                            $datta = explode('-', $dataI);  
                            $dataIEx = $datta[2].'/'.$datta[1].'/'.$datta[0];
                            $datta = explode('-', $dataF);  
                            $dataFEx = $datta[2].'/'.$datta[1].'/'.$datta[0];
                        $datass = $datass.$dataIEx.' '.$dataFEx.' | '; 
                        $this->data['results'.$i] = $this->Relatorios_model->getDoarMes('vendas','*',$dataI, $dataF);

                        if($i <> 1)
                        {  if($me_s <> 1) $me_s--; else {$ano0 = $ano0 - 1;  $me_s = 12; }                            
                        }else    { $ano0 = $ano;  $me_s = $mes; } //*** SE FOR O PRIMEIRO ele recebe o mês do ano passado
                        }
                 
                 $val_doar = 0;  $n_Qtd = 0;  $mediaDiaria = 0;  $dia_Ant = 0;
                 
                    $r_Media = $this->Relatorios_model->getDoarMes('vendas','*',$dataIMedia, $dataFMedia);
                    foreach ($r_Media as $rM)
                    {
                        $dataIn = explode('-', $rM->dataDoacao); 
                        $dia = $dataIn[2];
                        $val_doar += $rM->valor_doar;
                        if( $dia_Ant <> 0)
                        {
                         if( $dia <> $dia_Ant)
                         { ++$n_Qtd; 
                         }
                        }
                        $dia_Ant = $dia;
                    }                       
                    $mediaDiaria = 0;
                    if( $n_Qtd <> 0)
                    $mediaDiaria = $val_doar / $n_Qtd;
                    $mediaMes = $val_doar / 6;
                    $_SESSION['dataIMedia'] = $dataIMedia; $_SESSION['dataFMedia'] = $dataFMedia;                       
                    $_SESSION['mediaDiaria'] = $mediaDiaria; $_SESSION['mediaMes'] = $mediaMes; 
            $pdf = 0;
            if($pdf == 0)
            $this->load->view('relatorios/imprimir/imprimirPrevisao', $data);
            else{
            $this->load->helper('mpdf');
            $html = $this->load->view('relatorios/imprimir/imprimirPrevisao', $data, true);
            pdf_create($html, 'relatorio_meses_Previsao' . date('d/m/y'), TRUE);

                }
            }

        }
    }

    public function produtosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirProdutos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function produtosRapidMin(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapidMin();

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
        
    }

    public function produtosCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $estoqueInicial = $this->input->get('estoqueInicial');
        $estoqueFinal = $this->input->get('estoqueFinal');

        $data['produtos'] = $this->Relatorios_model->produtosCustom($precoInicial,$precoFinal,$estoqueInicial,$estoqueFinal);

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function servicos(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_servicos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function servicosCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $data['servicos'] = $this->Relatorios_model->servicosCustom($precoInicial,$precoFinal);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function servicosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $data['servicos'] = $this->Relatorios_model->servicosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function os(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_os';
       	$this->load->view('tema/topo',$this->data);
    }

    public function osRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }

        $data['os'] = $this->Relatorios_model->osRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function osCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');
        $status = $this->input->get('status');
        $data['os'] = $this->Relatorios_model->osCustom($dataInicial,$dataFinal,$cliente,$responsavel,$status);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function financeiro(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
        $this->data['usuario'] = $this->Relatorios_model->getByIdUser($this->session->userdata('id'));
        
        if(null !== ($this->input->post('tipo')))
        {
            {
                $tipo = $this->input->post('tipo');
              switch ($tipo) 
                {						    
                    case '0':	if(null !== ($this->input->post('ano'))) 
                                    $ano  = $this->input->post('ano');
                                    else $ano = date('Y'); $dataRef = 'dataDoacao';

                                if(null !== ($this->input->post('mes')))
                                    { $mes   = $this->input->post('mes'); }
                      break;                             					    
                    case '1':	if(null !== ($this->input->post('ano'))) 
                                    $ano  = $this->input->post('ano');
                                    else $ano = date('Y');

                                if(null !== ($this->input->post('mes')))
                                    { $mes   = $this->input->post('mes'); }
                      break;					    
                    case '2':	$data_maisCincoMeses = date("Y-m-d", strtotime("+5 month", strtotime("now")));
                                $datta = explode('-', $data_maisCincoMeses);  
                                $ano  =  $datta[0]; $mes = $datta[1];  $dataRef = 'data_Previsao';
                      break;
                }
                $me_s = $mes;
                $ano0 = $ano;
                   // $ii = $mess - 1;
                    $i =1;
                    $datass = 'Datas Todas ';
                    for ($i = 1; $i <= 7; $i++) 
                    {
                        if($i == 1) { $ano0 = $ano0 -1; } //*** SE FOR O PRIMEIRO ele recebe o mês do ano passado
                        if($i == 7) { $dataIMedia =  date($ano0.'-'.$mes.'-01'); }
                        else //***  SE FOR O 7 ele recebe O 1 DIA do sexto mês anterior ao pesquisado 
                        {if($i == 2) //*** SE FOR O SEGUNDO ele recebe O ultimo DIA do mês pesquisado
                            {
                            $diaS = cal_days_in_month(CAL_GREGORIAN, $mes, $ano0);
                            $dataFMedia = date($ano0.'-'.$mes.'-'.$diaS);
                            }
                        }
                            $mes = $me_s;
                            //  $me_s <= 9 ? $mes = '0'.$me_s : $mes = $me_s;
                            $diass = cal_days_in_month(CAL_GREGORIAN, $mes, $ano0);
                            $dataI = date($ano0.'-'.$mes.'-01');
                            $dataF = date($ano0.'-'.$mes.'-'.$diass);
                            $_SESSION['dataI'.$i] = $dataI; $_SESSION['dataF'.$i] = $dataF;
                            $datta = explode('-', $dataI);  
                            $dataIEx = $datta[2].'/'.$datta[1].'/'.$datta[0];
                            $datta = explode('-', $dataF);  
                            $dataFEx = $datta[2].'/'.$datta[1].'/'.$datta[0];
                            $datass = $datass.$dataIEx.' '.$dataFEx.' | '; 
                            $data['results'.$i] = $this->Relatorios_model->getDoarMes('vendas',$dataI, $dataF, $dataRef);

                        if($i <> 1)
                        {  if($me_s <> 1) $me_s--; else {$ano0 = $ano0 - 1;  $me_s = 12; }                            
                        }else    { $ano0 = $ano;  $me_s = $mes; } //*** SE FOR O PRIMEIRO ele recebe o mês do ano passado
                     }
                    $dataIMedia =  date($ano0.'-'.$mes.'-01');
                    $val_doar = 0;  $n_Qtd = 0;  $mediaDiaria = 0;  $dia_Ant = 0;
                 
                    $r_Media = $this->Relatorios_model->getDoarMes('vendas',$dataI, $dataF, $dataRef);
                    foreach ($r_Media as $rM)
                    {
                        $dataIn = explode('-', $rM->dataDoacao);
                        $dia = $dataIn[2];
                        $val_doar += $rM->valor_doar;
                        if( $dia_Ant <> 0)
                        {
                         if( $dia <> $dia_Ant)
                         { ++$n_Qtd;
                         }
                        }
                        $dia_Ant = $dia;
                    }                 
                    $mediaDiaria = 0;
                    if( $n_Qtd <> 0)
                    $mediaDiaria = $val_doar / $n_Qtd;
                    $mediaMes = $val_doar / 6;
                    $_SESSION['dataIMedia'] = $dataIMedia; $_SESSION['dataFMedia'] = $dataFMedia;                       
                    $_SESSION['mediaDiaria'] = $mediaDiaria; $_SESSION['mediaMes'] = $mediaMes; 
                    $pdf = 0;
                
                    if('0' == ($this->input->post('tipo')))
                    {
                        $this->session->set_flashdata('success',' '.$datass.'<strong> Relatório gerado com sucesso!</strong>');                     
                    if($pdf == 0)
                        $this->load->view('relatorios/imprimir/imprimirComparativo', $data);
                    else{
                        $this->load->helper('mpdf');
                        $html = $this->load->view('relatorios/imprimir/imprimirComparativo', $data, true);
                        pdf_create($html, 'relatorio_Comparativo' . date('d/m/y'), TRUE);
                    }
                    }
                    else
                    if('2' == ($this->input->post('tipo')))
                        {                   
                            if($pdf == 0)
                                $this->load->view('relatorios/imprimir/imprimirPrevisao', $data);
                            else{
                                $this->load->helper('mpdf');
                                $html = $this->load->view('relatorios/imprimir/imprimirPrevisao', $data, true);
                                pdf_create($html, 'relatorio_meses_Previsao' . date('d/m/y'), TRUE);
                            }
                        }
                }
            
            }else {        
           $this->data['view'] = 'relatorios/rel_financeiro';
            $this->load->view('tema/topo',$this->data);    
        }
    }
    
    public function dataParaBR($dt){
                    
             $datta = explode('-', $dt);  $dt = $datta[2].'/'.$datta[1].'/'.$datta[0];
            return $dt;

}   
    

    public function financeiroRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
           
        if(null !== ($this->input->post('conta')))
        {
            
            $conta   = $this->input->post('conta');
            $_SESSION['contA'] = $this->input->post('conta');

        if(null !== ($this->input->post('ano'))) $ano   = $this->input->post('ano');else $ano   = date('Y');
        if(null !== ($this->input->post('mes'))) $mes   = $this->input->post('mes');else $mes   = date('m');
        $dataInicial = date($ano.'-'.$mes.'-01');
        $dataFinal = date($ano.'-'.$mes.'-t');
        
        $this->data['lancamentos'] = $this->Relatorios_model->financeiroRapid($conta,$dataInicial,$dataFinal);
     //   $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
   //     $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
     //   pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
      //  redirect(base_url().'/relatorios/imprimir/imprimirFinanceiro');
        }
	    $this->data['view'] = '/relatorios/imprimir/imprimirFinanceiro';
       	$this->load->view('tema/topo',$this->data);
    }

    public function financeiroCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
        $this->data['result_caixas'] = $this->Relatorios_model->get2('caixas');
        $this->data['usuario'] = $this->Relatorios_model->getByIdUser($this->session->userdata('id'));   
        
        if(null !== ($this->input->post('conta')))
        {       
            $conta   = $this->input->post('conta');
            $_SESSION['contA'] = $this->input->post('conta');
            $tipo =$this->input->post('tipo');
            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');
            // $dataInicial = date('Y-m-01');
        //    $dataFinal = date('Y-m-t');
         
            $_SESSION['dataInicial'] = $dataInicial;
            $_SESSION['dataFinal'] = $dataFinal;
         // $dataInicial = date('Y-m-01');
        //    $dataFinal = date('Y-m-t');
         
        $result_caixas = $this->Relatorios_model->get2('caixas');   
           foreach ($result_caixas as $rC) 
                    {	
                      if($rC->id_caixa == $conta) $n_Conta = $rC->nome_caixa;
           }
             switch ($conta) 
					{						 
						    
				        case 1: $cdiNome = "IEADALPE-1444-3";  break;  
						case 2:	$cdiNome = "IEADALPE-22360-3";   break;    
						case 3:	$cdiNome = "ILPI";   break;  
						case 4: $cdiNome = "BR0214";  break;  
						case 5:	$cdiNome = "BR0518";   break;  
						case 6:	$cdiNome = "BR0542";  break;  
						case 7:	$cdiNome = "BR0549";   break;  
						case 8:	$cdiNome = "BR0579";  break; 
						case 9:	$cdiNome = "BB-28965-5";   break;  
						case 10:	$cdiNome = "CEF-1948-4";  break; 		
					}
        $this->data['saldo_Ant'] = $this->Relatorios_model->getSaldo_Ant($this->input->post('conta'),$dataInicial);
        $this->data['lancamentos'] = $this->Relatorios_model->financeiroRapid($conta,$dataInicial,$dataFinal);
        $this->data['presentes_pagos'] = $this->Relatorios_model->presentes_pagos($conta,$cdiNome,$dataInicial,$dataFinal);
        $this->session->set_flashdata('success',''.$cdiNome.' '.$dataInicial.' '.$dataFinal.'<strong> Relatório gerado com sucesso!</strong>'); 
        }
        
        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
    
    }


    public function vendas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_vendas';
        $this->load->view('tema/topo',$this->data);
    }

    public function vendasRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $data['vendas'] = $this->Relatorios_model->vendasRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }

    public function vendasCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');

        $data['vendas'] = $this->Relatorios_model->vendasCustom($dataInicial,$dataFinal,$cliente,$responsavel);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }
}
