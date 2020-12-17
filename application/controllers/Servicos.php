<?php

class Servicos extends CI_Controller {
    

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

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('servicos_model', '', TRUE);
        $this->data['menuServicos'] = 'Serviços';
    }
	
	function index(){
		$this->gerenciar();
	}

	
	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Lancamentos.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'index.php/clientes/gerenciar/';
        $config['total_rows'] = $this->servicos_model->count('lancamentos');
        $config['per_page'] = 30;
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
        $this->data['usuario'] = $this->servicos_model->getByIdUser($this->session->userdata('id'));
       
        $this->data['results'] = $this->servicos_model->get('lancamentos','*','',$config['per_page'],$this->uri->segment(3));       	
        $this->data['result_funcio'] = $this->servicos_model->get2('usuarios','nome');  
        $this->data['result_idosos'] = $this->servicos_model->get2('idosos','nomeI');  
        $this->data['result_idososN'] = $this->servicos_model->get2Idosos('idosos','nomeI','asc'); 
        $this->data['result_idososP'] = $this->servicos_model->get2Idosos('idosos','data_Hora','desc'); 
	    
	    $this->data['view'] = 'servicos/servicos';
       	$this->load->view('tema/topo',$this->data);
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
             $data_Hora = $this->input->post('data_Hora');
              $dataMed1 = explode(' ', $data_Hora);
              $dataAfer = explode('/', $dataMed1[0]);
                $dataAfericao = $dataAfer[2].'-'.$dataAfer[1].'-'.$dataAfer[0].' '. $dataMed1[1];
            try {
           } catch (Exception $e) {
               $dataAfericao = date('Y-m-d H:m:s');  
            }
            if(set_value('glicem') == null || $this->input->post('tecnic') == null )
            { 
           $this->session->set_flashdata('error','Você não inseriu todas as informações. Por favor tente novamente!');
                redirect(base_url() . 'index.php/servicos');}
            
            $data = array(
                'obs_Aferir' => $this->input->post('obs_Aferi'),
                'data_Hora' => $dataAfericao,  
                'peso' => $this->input->post('pes'),
                'glicemia' => set_value('glicem'),
                'p_sistolica' => set_value('p_sistolic'),
                'p_diastolica' => set_value('p_diastolic'),
                'cadastrador' => $this->input->post('tecnic'),
                'idoso_id' => set_value('idIdoso'),                
                'usuario_id' => ($this->session->userdata('id'))
            );
            if ($this->servicos_model->add('lancamentos', $data) == TRUE) {
                $this->session->set_flashdata('success','Aferição adicionada com sucesso!');
                redirect(base_url() . 'index.php/servicos');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
          
        
        $this->data['usuario'] = $this->servicos_model->getByIdUser($this->session->userdata('id'));
        $this->data['result_idososN'] = $this->servicos_model->get2Idosos('idosos','nomeI','asc'); 
        $this->data['result_idososP'] = $this->servicos_model->get2Idosos('idosos','data_Hora','desc'); 
        $this->data['result_funcio'] = $this->servicos_model->get2('usuarios','nome');  
        $this->data['view'] = 'servicos/adicionarServico';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
            /*$data_Hora = $this->input->post('data_Hora');
              $dataMed1 = explode(' ', $data_Hora);
              $dataAfer = explode('/', $dataMed1[0]);
                $dataAfericao = $dataAfer[2].'-'.$dataAfer[1].'-'.$dataAfer[0].' '. $dataMed1[1];
            try {
           } catch (Exception $e) {
               $dataAfericao = date('Y-m-d H:m:s');  
            }
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3)))*/
        {
           // $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
         //  $this->session->set_flashdata('error','data_Hora '.$this->input->post('data_Hora').' '.$dataAfericao.' id_AfericaoDiaria '.$this->input->post('id_AfericaoDiaria').' idoso '.$this->input->post('idosomed').' peso '.$this->input->post('peso').' glicemia '.$this->input->post('glicemia').' p_sistolica '. $this->input->post('p_sistolica').' p_diastolica '.$this->input->post('p_diastolica').' obs_Aferir '.$this->input->post('obs_Aferir').' tecnica '.$this->input->post('tecnica').' id '.$this->session->userdata('id'));
           // redirect('mapos');         
          //  redirect(base_url().'index.php/servicos/gerenciar/');
        }


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }
/*
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else */
        {
             $data_Hora = $this->input->post('data_Hora');
              $dataMed1 = explode(' ', $data_Hora);
              $dataAfer = explode('/', $dataMed1[0]);
                $dataAfericao = $dataAfer[2].'-'.$dataAfer[1].'-'.$dataAfer[0].' '. $dataMed1[1];
            try {
           } catch (Exception $e) {
               $dataAfericao = date('Y-m-d H:m:s');  
            }
            
            
            $data = array(
                'obs_Aferir' => $this->input->post('obs_Aferir'),
                'data_Hora' => $dataAfericao,  
                'peso' => $this->input->post('peso'),
                'glicemia' => $this->input->post('glicemia'),
                'p_sistolica' => $this->input->post('p_sistolica'),
                'p_diastolica' => $this->input->post('p_diastolica'),
                'obs_Aferir' => $this->input->post('obs_Aferir'),
                'cadastrador' => $this->input->post('tecnica'),
                'idoso_id' => $this->input->post('idosomed'),                
                'usuario_id' => ($this->session->userdata('id'))
            );
            if ($this->servicos_model->edit('lancamentos', $data, 'id_AfericaoDiaria', $this->input->post('id_AfericaoDiaria')) == TRUE) {
                $this->session->set_flashdata('success','Aferição editada com sucesso!');          
            redirect(base_url().'index.php/servicos/gerenciar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->servicos_model->getById($this->uri->segment(3));
        $this->data['results'] = $this->servicos_model->getOsByCliente($this->uri->segment(3));
        $this->data['view'] = 'servicos/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            
            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir clientes.');
               redirect(base_url());
            }

            
            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir cliente.');            
                redirect(base_url().'index.php/clientes/gerenciar/');
            }

            //$id = 2;
            // excluindo OSs vinculadas ao cliente
            $this->db->where('id_idoso', $id);
            $os = $this->db->get('idosos')->result();

            

            $this->servicos_model->delete('idosos','id_idoso',$id); 

            $this->session->set_flashdata('success','Idoso excluido com sucesso!');            
            redirect(base_url().'index.php/servicos/gerenciar/');
    }
}

