<?php

class Os extends CI_Controller {
    
    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */

    function __construct() {
        parent::__construct();
        
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('os_model','',TRUE);
		$this->data['menuOs'] = 'OS';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        $this->load->library('pagination');
        
        $where_array = array();

        $pesquisa = $this->input->get('pesquisa');
        $status = $this->input->get('status');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');

        if($pesquisa){
           $where_array['pesquisa'] = $pesquisa;
        }
       if($status){  $where_array['status'] = $status; }
        
            $data_Do = date('Y-m-01');
         $data_Doa = date('Y-m-d', strtotime("-1 month", strtotime($data_Do)));
         if($de){
            $de = explode('/', $de);
            $de = $de[2].'-'.$de[1].'-'.$de[0];
            $where_array['de'] = $de;
        }else {
             $de =  $data_Doa;
             $where_array['de']  = $data_Doa;
              }
        if($ate){
            $ate = explode('/', $ate);
            $ate = $ate[2].'-'.$ate[1].'-'.$ate[0];

            $where_array['ate'] = $ate;
        }else $ate = date('Y-m-d');
        
        $config['base_url'] = base_url().'index.php/os/gerenciar/';
        $config['total_rows'] = $this->os_model->count('usuarios');
        $config['per_page'] = 100;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        	
        $this->pagination->initialize($config); 	

		$this->data['results'] = $this->os_model->getOs('vendas','*',$where_array,$config['per_page'],$this->uri->segment(3));
                
         $this->data['usuarios'] = $this->os_model->getMetas('usuarios','*');
         $this->data['metas'] = $this->os_model->get2('funcionarios','codF');
        
        $this->data['usuario'] = $this->os_model->getByIdUser($this->session->userdata('id'));

       
       //*****Guardar variaveis de periodo 
            $data = array(
                'data_Pag' => $de,
                'status' => $ate//set_value('idCliente'),                
            );
            if ($this->os_model->edit('reconc_bank', $data, 'id_reconc', 1) == TRUE) { }
        
        
        
         $this->data['resultPeriodo'] = $this->os_model->get2('reconc_bank','id_reconc');
        
         $this->data['results_Usuarios'] = $this->os_model->getuser('usuarios',$where_array,'nome');
         $this->data['results_Cidade'] = $this->os_model->get2('cidade','nome');
         $this->data['results_Rotas'] = $this->os_model->get2('marcas','diaRota');
         $this->data['ultimaOBS'] = $this->os_model->getObsUltimo('obs_individual','*','IdObs');
         $this->data['ultimaMsgs'] = $this->os_model->getObsUltimo('doar_mensagens','*','idObsMsg');
	    $this->data['view'] = 'os/os';
       	$this->load->view('tema/topo',$this->data);
      
		
    }
	
    function adicionar(){


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aOs')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar O.S.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if ($this->form_validation->run('os') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {
                
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];

                if($dataFinal){
                    $dataFinal = explode('/', $dataFinal);
                    $dataFinal = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];
                }else{
                    $dataFinal = date('Y/m/d');
                }

            } catch (Exception $e) {
               $dataInicial = date('Y/m/d'); 
               $dataFinal = date('Y/m/d');
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),
                'dataFinal' => $dataFinal,
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico'),
                'faturado' => 0
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
                $this->session->set_flashdata('success','OS adicionada com sucesso, você pode adicionar produtos ou serviços a essa OS nas abas de "Produtos" e "Serviços"!');
                redirect('os/editar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
         
        $this->data['view'] = 'os/adicionarOs';
        $this->load->view('tema/topo', $this->data);
    }
    
    public function adicionarAjax(){

        $this->load->library('form_validation');

        if ($this->form_validation->run('os') == false) {
           $json = array("result"=> false);
           echo json_encode($json);
        } else {
            $data = array(
                'dataInicial' => set_value('dataInicial'),
                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),
                'dataFinal' => set_value('dataFinal'),
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico')
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
                $json = array("result"=> true, "id"=> $id);
                echo json_encode($json);

            } else {
                $json = array("result"=> false);
                echo json_encode($json);

            }
        }
         
    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar O.S.');
           redirect(base_url());
        }
/*
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);*/
            $cidade21 = $this->input->post('cidade21');
            $cidade31 = $this->input->post('cidade31');
            $cidade41 = $this->input->post('cidade41');
            $cidade51 = $this->input->post('cidade51');
            $cidade61 = $this->input->post('cidade61');
        
            $cidade22 = $this->input->post('cidade22');
            $cidade32 = $this->input->post('cidade32');
            $cidade42 = $this->input->post('cidade42');
            $cidade52 = $this->input->post('cidade52');
            $cidade62 = $this->input->post('cidade62');
        
            $cidade231 = $this->input->post('cidade23');
            $cidade33 = $this->input->post('cidade33');
            $cidade43 = $this->input->post('cidade43');
            $cidade53 = $this->input->post('cidade53');
            $cidade63 = $this->input->post('cidade63');
        
        
        if (null == $cidade21 && null  == $cidade31 && null  == $cidade41 && null  == $cidade51  && null == $cidade61) {
                $this->session->set_flashdata('error','Nenhuma cidade cadastrada!');
                redirect(base_url() . 'index.php/os/gerenciar/');
                         } else {

	for ($i=2; $i<7; $i++) 
    {
        
            switch ($i) {
                case '2':
                    $dia = 'segunda';
                    break;
                case '3':
                    $dia = 'terça';
                    break;
                case '4':
                    $dia = 'quarta';
                    break;
                case '5':
                    $dia = 'quinta';
                    break;
                case '6':
                    $dia = 'sexta';
                    break;
            }
            $data = array(
                'diaRota' => $dia,
                'cidaade1Rota' =>  $this->input->post('cidade'.$i.'1'),
                'cidaade2Rota' => $this->input->post('cidade'.$i.'2'),
                'cidaade3Rota' => $this->input->post('cidade'.$i.'3')
            );

            if ($this->os_model->edit('marcas', $data, 'diaRota', $dia) == TRUE) {
                $this->session->set_flashdata('success','Rota editada com sucesso!');
                redirect(base_url() . 'index.php/os/gerenciar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
    }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
   
    }

    function agendar() {


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar O.S.');
           redirect(base_url());
        }
/*
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);*/
            $cidade21 = $this->input->post('cidade21');
            $cidade31 = $this->input->post('cidade31');
            $cidade41 = $this->input->post('cidade41');
            $cidade51 = $this->input->post('cidade51');
            $cidade61 = $this->input->post('cidade61');
        
            $cidade22 = $this->input->post('cidade22');
            $cidade32 = $this->input->post('cidade32');
            $cidade42 = $this->input->post('cidade42');
            $cidade52 = $this->input->post('cidade52');
            $cidade62 = $this->input->post('cidade62');
        
            $cidade231 = $this->input->post('cidade23');
            $cidade33 = $this->input->post('cidade33');
            $cidade43 = $this->input->post('cidade43');
            $cidade53 = $this->input->post('cidade53');
            $cidade63 = $this->input->post('cidade63');
        
        
        if (null == $cidade21 && null  == $cidade31 && null  == $cidade41 && null  == $cidade51  && null == $cidade61) {
                $this->session->set_flashdata('error','Nenhuma cidade cadastrada!');
                redirect(base_url() . 'index.php/os/gerenciar/');
                         } else {

	for ($i=2; $i<7; $i++) 
    {
        
            switch ($i) {
                case '2':
                    $dia = 'segunda';
                    break;
                case '3':
                    $dia = 'terça';
                    break;
                case '4':
                    $dia = 'quarta';
                    break;
                case '5':
                    $dia = 'quinta';
                    break;
                case '6':
                    $dia = 'sexta';
                    break;
            }
            $data = array(
                'diaRota' => $dia,
                'cidaade1Rota' =>  $this->input->post('cidade'.$i.'1'),
                'cidaade2Rota' => $this->input->post('cidade'.$i.'2'),
                'cidaade3Rota' => $this->input->post('cidade'.$i.'3')
            );
                $cidade = $this->input->post('cidade'.$i.'1');
            if ($this->os_model->edit('marcas', $data, 'diaRota', $dia) == TRUE) {
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
            
                $this->session->set_flashdata('success','Rotas editadas com sucesso!');
                redirect(base_url() . 'index.php/os/gerenciar/');
    }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
   
    }

    function metas() {


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar O.S.');
           redirect(base_url());
        }
/*      $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);*/
        
        
        $val = 0;
        
        $_checkbox = $this->input->post('atendente');
        foreach($_checkbox as $_valor)
        {
            $idUser = $_valor;
            
        $_nomeF = $this->input->post('nome'.$idUser);
        $_metaMes = $this->input->post('meta'.$idUser);
        $_taxa = $this->input->post('taxa'.$idUser);
        $_codFuncionario = $this->input->post('codFuncionario'.$idUser);
        $_dataCom = $this->input->post('dataCom'.$idUser);
        $_idSup = $this->input->post('idSup'.$idUser);
        $_nomeSup = $this->input->post('nomeSup'.$idUser);
            
           $val .=  ' Nome- '.$_nomeF.' metaMes- '.$_metaMes.' taxa- '.$_taxa.' codF- '.$_codFuncionario.' data- '.$_dataCom;
            
            if($this->input->post('codF'.$idUser) <> 0 ) {
                $codF =$this->input->post('codF'.$idUser);
            $dataM = array(               
                'statusMetas' =>  0
            );
           
            if ($this->os_model->edit('funcionarios', $dataM, 'codF', $codF) == TRUE) {
                $this->session->set_flashdata('success','Meta antiga editada com sucesso!');
            }
            }
            $data = array(
                'nomeF' =>  $_nomeF,
                'cod_Funcionario' =>  $_codFuncionario,
                'metaMes' =>  $_metaMes,
                'taxacomicao' =>  $_taxa,
                'dataComicao' =>  $_dataCom,
                'nome_Supervisor' =>  $_nomeSup,
                'id_Supervisor' =>  $_idSup,
                'statusMetas' =>  1
            );
            
            if (is_numeric($id = $this->os_model->add('funcionarios', $data, true)) ) {
                $this->session->set_flashdata('success','  Metas e taxa de Comição editadas com sucesso!');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
        
         {
                redirect(base_url() . 'index.php/os/gerenciar/');
    }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
   
    }
    function bloqueio() {


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar O.S.');
           redirect(base_url());
        }
        $user_id = $this->input->post('user_id');
        $user_blok = $this->input->post('blok');
        
        
                $data = array(
                        'bloqueio' => $user_blok
                );
			if ($this->os_model->edit('usuarios',$data,'idUsuarios',$user_id) == TRUE)
			{
                $this->session->set_flashdata('success','Bloqueio do Usuário editado com sucesso!');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';

			}
        
         {
                redirect(base_url() . 'index.php/os/gerenciar/');
    }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
   
    }
    
    function bdObs() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar O.S.');
           redirect(base_url());
        }
        
        $val = 0;
                
        if(null != $this->input->post('idDoadd')) $_idDoadd = $this->input->post('idDoadd'); else  $_idDoadd = 0;
        $_obsMens = $this->input->post('obsM');
        $_numero = $this->input->post('numero');
        $_numeroF = $this->input->post('numeroFim');
        $_ObsIndividual = $this->os_model->getObsInd_Distinct('obs_individual','cod_doador');
        $_mensagenss = $this->os_model->getmsg('doar_mensagens','cod_DoadorMensagem');
        $jaTem = 0;
        $adicionados = '';
        $doadorAnterior = '';
        
    if($_obsMens == 1)
    {
        foreach($_ObsIndividual as $_ObsI)
        {
            if($doadorAnterior <> $_ObsI->cod_doador)
            {
                $doadorCadastrado = 0;
                foreach($_mensagenss as $_Msg) //Verifica se todos doadores com mensagens ja possuem seu bloco de mensagens
                {
                    if($_Msg->cod_DoadorMensagem == $_ObsI->cod_doador) $doadorCadastrado = 1;            
                }
                    if($doadorCadastrado == 0)  //Cria o bloco dos doadores que não tem.
                    {         
                            $data = array(
                                'cod_DoadorMensagem' =>   $_ObsI->cod_doador,
                                'descricao_Mensagem' =>   '',
                                'dataMensagem' =>  '2014-01-01'
                            ); 

                    if (is_numeric($id = $this->os_model->add('doar_mensagens', $data, true)) ) {
                        $adicionados = $adicionados.', '.$_ObsI->cod_doador;
                     //   $this->session->set_flashdata('success','  Metas e taxa de Comição editadas com sucesso!');
                    }

                    }
                        $doadorAnterior = $_ObsI->cod_doador;
            }
            
        }
    }else if($_obsMens == 2){
        
                       
        $_mensagens = $this->os_model->getmsg1('doar_mensagens','cod_DoadorMensagem',$_idDoadd);     
        $editados = '';
        $anterior = '';$jaTem = 0;$Tem = 0;
        foreach($_mensagens as $_Msg)
        {
            if($_Msg->cod_DoadorMensagem > $_idDoadd)
            {
            $obsMensagem = $_Msg->descricao_Mensagem;
            $doadID =$_Msg->cod_DoadorMensagem;
            //if($jaTem == 0)
            
        $_ObsIndividual = $this->os_model->getObsI('obs_individual','*',$_numero,$_numeroF,$doadID);
                foreach($_ObsIndividual as $_ObsI)
                {
                    if($_Msg->cod_DoadorMensagem == $_ObsI->cod_doador)
                    {
                        if($_Msg->IdObsMsg > $_ObsI->IdObs)
                        { $jaTem = 1; $editados = 'Doador '.$_Msg->cod_DoadorMensagem.' OBS: '.$_ObsI->IdObs;}else
                        {
                            $obsMensagem = '['.date("d/m/Y",strtotime($_ObsI->data_Obs)).'] '.$_ObsI->usuarioN.': '.$_ObsI->textoObs.' | '.$obsMensagem;
                            $dataobs = date("Y-m-d",strtotime($_ObsI->data_Obs));
                            $idObs = $_ObsI->IdObs;
                             $jaTem = 0; $Tem = 1;
                        }
                    }
                }            
            if($Tem == 1)
            {
                    $data = array(
                        'descricao_Mensagem' =>  $obsMensagem,
                        'dataMensagem' =>  $dataobs,
                        'IdObsMsg' =>  $idObs
                    );
                    if ($this->os_model->edit('doar_mensagens', $data, 'cod_DoadorMensagem', $_Msg->cod_DoadorMensagem) == TRUE) {
                      //  $this->session->set_flashdata('success','Rota editada com sucesso!');
                      //  redirect(base_url() . 'index.php/os/gerenciar/');
                        if($_Msg->cod_DoadorMensagem <> $anterior) 
                        {
                            $editados = $editados.', '.$_Msg->cod_DoadorMensagem;
                            $anterior = $_Msg->cod_DoadorMensagem;
                        }
                    } 
        }$jaTem = 0; $Tem = 0;
        }
        }}
        if($adicionados == '')$add = '<Strong>  Nenhum doador adicionado!</Strong> '; else 
            $add = ' <Strong>  Adicionados com sucesso! Os doadores</Strong> '.$adicionados;
         if($editados == '')$edt = '<Strong>  Nenhum doador editado!</Strong> '; else 
            $edt = ' <Strong>  Adicionados com sucesso! Os doadores</Strong> '.$editados;
        
         $this->session->set_flashdata('success',$add.$edt );
        
        
         {
                redirect(base_url() . 'index.php/os/gerenciar/');
    }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
   
    }
    
    
    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar O.S.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->mapos_model->getEmitente();

        $this->data['view'] = 'os/visualizarOs';
        $this->load->view('tema/topo', $this->data);
       
    }

    public function imprimir(){
        
               /* if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
                    $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
                    redirect('mapos');
                }
        */
                if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
                   $this->session->set_flashdata('error','Você não tem permissão para visualizar O.S.');
                   redirect(base_url());
                }        
                if(NULL != $this->input->get('data3')) 
                { $datIm = $this->input->get('data3');
                
                    $datI = explode('/', $datIm);
                    $datImp = $datI[2].'-'.$datI[1].'-'.$datI[0];
                }
                else {$datI = date('d-m-Y');
                    $datImp = date('Y-m-d', strtotime("+1 day", strtotime($datI)));
             }
             
                $this->data['custom_error'] = '';
                $this->load->model('mapos_model');
        
       if( 1 == 1){        
        $this->data['resultsAgen'] = $this->os_model->getAgen('vendas','*',$datImp);
         $this->data['results_obs_mensageiro'] = $this->os_model->get2('obs_mensageiro','id_Doar');
                $this->data['emitente'] = $this->mapos_model->getEmitente();       
                $this->load->view('os/imprimirOs', $this->data);
       }if( 1 == 3){ 
         $data['resultsAgen'] = $this->os_model->getAgen('vendas','*',$datImp);
         $data['results_obs_mensageiro'] = $this->os_model->get2('obs_mensageiro','id_Doar');
         $data['emitente'] = $this->mapos_model->getEmitente();        
            //    $this->load->view('os/imprimirOs', $this->data);
            $this->load->helper('mpdf');
            $html = $this->load->view('os/imprimirOs', $data, true);
            pdf_create($html, 'Fichas_Doação_' . date('d/m/y H:i'), TRUE);
       }
            }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dOs')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir O.S.');
           redirect(base_url());
        }
        
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir OS.');            
            redirect(base_url().'index.php/os/gerenciar/');
        }

        $this->db->where('os_id', $id);
        $this->db->delete('servicos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('produtos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('anexos');

        $this->os_model->delete('os','idOs',$id);             
        

        $this->session->set_flashdata('success','OS excluída com sucesso!');            
        redirect(base_url().'index.php/os/gerenciar/');


        
    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteProdutoSaida(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProdutoSaida($q);
        }

    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteCliente($q);
        }

    }

    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteUsuario($q);
        }

    }

    public function autoCompleteServico(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteServico($q);
        }

    }

    public function adicionarProduto(){

        
        $preco = $this->input->post('preco');
        $quantidade = $this->input->post('quantidade');
        $subtotal = $preco * $quantidade;
        $produto = $this->input->post('idProduto');
        $data = array(
            'quantidade'=> $quantidade,
            'subTotal'=> $subtotal,
            'produtos_id'=> $produto,
            'os_id'=> $this->input->post('idOsProduto'),
        );

        if($this->os_model->add('produtos_os', $data) == true){
            $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
            $this->db->query($sql, array($quantidade, $produto));
            
            echo json_encode(array('result'=> true));
        }else{
            echo json_encode(array('result'=> false));
        }
      
    }

    function excluirProduto(){
        
            $ID = $this->input->post('idProduto');
            if($this->os_model->delete('produtos_os','idProdutos_os',$ID) == true){
                
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');


                $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";

                $this->db->query($sql, array($quantidade, $produto));
                
                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }           
    }

    public function adicionarServico(){

        
        $data = array(
            'servicos_id'=> $this->input->post('idServico'),
            'os_id'=> $this->input->post('idOsServico'),
        );

        if($this->os_model->add('servicos_os', $data) == true){

            echo json_encode(array('result'=> true));
        }else{
            echo json_encode(array('result'=> false));
        }

    }

    function excluirServico(){
            $ID = $this->input->post('idServico');
            if($this->os_model->delete('servicos_os','idServicos_os',$ID) == true){

                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }
    }


    public function anexar(){

        $this->load->library('upload');
        $this->load->library('image_lib');

        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para anexos de os
            'max_size'      => 0,
            );
    
        $this->upload->initialize( $upload_conf );
        
        foreach($_FILES['userfile'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }
        unset($_FILES['userfile']);
    

        $error = array();
        $success = array();
        
        foreach($_FILES as $field_name => $file)
        {
            if ( ! $this->upload->do_upload($field_name))
            {
       
                $error['upload'][] = $this->upload->display_errors();
            }
            else
            {

                $upload_data = $this->upload->data();
                
                if($upload_data['is_image'] == 1){

                   // set the resize config
                    $resize_conf = array(
    
                        'source_image'  => $upload_data['full_path'], 
                        'new_image'     => $upload_data['file_path'].'thumbs/thumb_'.$upload_data['file_name'],
                        'width'         => 200,
                        'height'        => 125
                        );

                    $this->image_lib->initialize($resize_conf);

                    if ( ! $this->image_lib->resize())
                    {
                        $error['resize'][] = $this->image_lib->display_errors();
                    }
                    else
                    {
                        $success[] = $upload_data;
                        $this->load->model('Os_model');
                        $this->Os_model->anexar($this->input->post('idOsServico'), $upload_data['file_name'] ,base_url().'assets/anexos/','thumb_'.$upload_data['file_name'],realpath('./assets/anexos/'));

                    } 
                }
                else{

                    $success[] = $upload_data;

                    $this->load->model('Os_model');

                    $this->Os_model->anexar($this->input->post('idOsServico'), $upload_data['file_name'] ,base_url().'assets/anexos/','',realpath('./assets/anexos/'));
 
                }
                
            }
        }


        if(count($error) > 0)
        {
            echo json_encode(array('result'=> false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        }
        else
        {
            echo json_encode(array('result'=> true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso .'));
        }
        

    }


    public function excluirAnexo($id = null){
        if($id == null || !is_numeric($id)){
            echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
        }
        else{

            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            unlink($file->path.'/'.$file->anexo);

            if($file->thumb != null){
                unlink($file->path.'/thumbs/'.$file->thumb);    
            }
            
            if($this->os_model->delete('anexos','idAnexos',$id) == true){

                echo json_encode(array('result'=> true, 'mensagem' => 'Anexo excluído com sucesso.'));
            }
            else{
                echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
            }

            
        }
    }


    public function downloadanexo($id = null){
        
        if($id != null && is_numeric($id)){
            
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            $this->load->library('zip');

            $path = $file->path;

            $this->zip->read_file($path.'/'.$file->anexo); 

            $this->zip->download('file'.date('d-m-Y-H.i.s').'.zip'); 

        }
      
    }


    public function faturar() {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
 

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

                if($recebimento != null){
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];

                }
            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }
            
            $data = array(
                'descricao' => set_value('descricao'),
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido') ? : 0,
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
                
                $os = $this->input->post('os_id'); 

                $this->db->set('faturado',1);
                $this->db->set('valorTotal',$this->input->post('valor'));
                $this->db->where('idOs', $os);
                $this->db->update('os'); 

                $this->session->set_flashdata('success','OS faturada com sucesso!');
                $json = array('result'=>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar OS.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar OS.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }

}

