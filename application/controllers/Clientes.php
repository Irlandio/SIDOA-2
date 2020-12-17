<?php

class Clientes extends CI_Controller {
    
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
            $this->load->helper(array('codegen_helper'));
            $this->load->model('clientes_model','',TRUE);
            $this->data['menuClientes'] = 'clientes';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
        $where_array = array();

        $pesquisa = $this->input->get('pesquisa');
        $status = $this->input->get('status');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');
        $count = 50;
        if($pesquisa){
           $where_array['pesquisa'] = $pesquisa;
        $count = 50;
        }
   
        $config['base_url'] = base_url().'index.php/clientes/gerenciar/';
        $config['total_rows'] = $this->clientes_model->count('clientes');
        $config['per_page'] = 50;
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
        
      $this->data['usuario'] = $this->clientes_model->getByIdUser($this->session->userdata('id'));
        
       $user = $this->clientes_model->getByIdUser($this->session->userdata('id'));
        $adm = 0;
        $id_Usuario = $user->idUsuarios;
        if($user->permissoes_id < 3){$adm = 1;}//Selecionar Por nivel de Usuário
        
        $hoje = date('Y-m-d');
        $substituir = $this->clientes_model->get2('substituir','fim_sub');  
        $i = 0; $idAusent[0] = 0; 
        
        foreach ($substituir as $sub){            
        if($sub->inicio_sub <= $hoje && $sub->fim_sub >= $hoje && $sub->id_substituto == $id_Usuario)
        {  $idAusent[$i] = $sub->id_ausente; $i++; }  
        }
        if($i == 0) $idAusent[0] = $id_Usuario;
        
            $this->data['results'] = $this->clientes_model->get('clientes','*',$id_Usuario,$idAusent,$i,$adm, $where_array,$config['per_page'], $this->uri->segment(3));
         $this->data['results_Bairro'] = $this->clientes_model->get2('bairros','Bairro');
         $this->data['results_Cidade'] = $this->clientes_model->get2('cidade','idC');
       	
       	$this->data['view'] = 'clientes/clientes';
       	$this->load->view('tema/topo',$this->data);		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data_Nasc = $this->input->post('data_Nasc');
            $data_cadastro = $this->input->post('data_cadastro');
            $data_Rg = $this->input->post('data_RgD');
            try {                
             //   echo $dataVenda;
                $data_N     = explode('/', $data_Nasc);
                $data_N    = $data_N[2].'-'.$data_N[1].'-'.$data_N[0];  
                
                $data_ingres     = explode('/', $data_cadastro);
                $dataCadastroD    = $data_ingres[2].'-'.$data_ingres[1].'-'.$data_ingres[0];          
                
                $data_RgD     = explode('/', $data_Rg);
                $data_Rg    = $data_RgD[2].'-'.$data_RgD[1].'-'.$data_RgD[0];          
                
           } catch (Exception $e) {
               $data_ingres = date('Y-m-d');  
            }
            $data = array(
                'nomeCliente'     => set_value('nomeD'),
                'sexo'      => set_value('sexo'),
                'dat_NasciD' => $data_N,
                'dataCadastroD' => $dataCadastroD, 
                'statusDoador'    => set_value('status'),
                'rgDoador'      => set_value('rg_D'),
                'orgExpD'      => set_value('orgExpD'),
                'uf_RGD'      => set_value('uf_RGD'),
                'data_RgD'      => $data_Rg,
                
                'cpf_D'     => $this->input->post('cpf_D'),
                'foneD'     => set_value('foneD'),
                'foneop'    => set_value('foneop'),
                'foneD2'    => set_value('foneD2'),
                'foneop2'   => set_value('foneop2'),
                'foneD3'    => set_value('foneD3'),
                'foneop3'   => set_value('foneop3'),
                'emailD'     => set_value('emailD'),
               'logradD'    => set_value('lograd'),
                'numeroD'    => set_value('numero'),
                
                'complemD'   => set_value('complem'),
                'bairroD'    => set_value('bairro'),
                'cidadeD'    => set_value('cidade'),
                'estadoD'      => set_value('uf'),
                'atendente_ID' => set_value('atendente')
            );

            if ($this->clientes_model->add('clientes', $data) == TRUE) {
                $this->session->set_flashdata('success','Doadores adicionado com sucesso! ');
                redirect(base_url() . 'index.php/clientes/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
      $this->data['usuario'] = $this->clientes_model->getByIdUser($this->session->userdata('id'));
         $this->data['results_Cidade'] = $this->clientes_model->get2('cidade','nome');
         $this->data['results_Atendente'] = $this->clientes_model->get2('usuarios','nome');
       	
         $this->data['results_Bairro'] = $this->clientes_model->get2('bairros','Bairro');
         $this->data['results_Cidade'] = $this->clientes_model->get2('cidade','idC');
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
            $usuari = $this->clientes_model->getByIdUser($this->session->userdata('id'));
            $result_mensg = $this->clientes_model->get2('doar_mensagens','cod_DoadorMensagem');
                $temRegistro = 0;
                foreach ($result_mensg as $r_msg) //Verifica se existe cadastro de mensagens para esse doador
                {	 if($r_msg->cod_DoadorMensagem == $this->uri->segment(3)){  $temRegistro = 1; } }
         $doador_id =  $this->uri->segment(3);

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $historico = $this->input->post('historico');//Obs inserida pelo usuario
            $histor = $this->input->post('histor');//Historico acumulado e existente
            $data_Nasc = $this->input->post('data_Nasc');
            $data_cadastro = $this->input->post('data_cadastro');
            $data_Rg = $this->input->post('data_RgD');
            try {                  
             //   echo $dataVenda;
                $data_N     = explode('/', $data_Nasc);
                $data_N    = $data_N[2].'-'.$data_N[1].'-'.$data_N[0];  
                
                $data_ingres     = explode('/', $data_cadastro);
                $dataCadastroD    = $data_ingres[2].'-'.$data_ingres[1].'-'.$data_ingres[0];          
                
                $data_RgD     = explode('/', $data_Rg);
                $data_Rg    = $data_RgD[2].'-'.$data_RgD[1].'-'.$data_RgD[0];      
           } catch (Exception $e) {
               $data_ingres = date('Y-m-d');  
            }
            
            $mensge = 1;
            $hoje = '['.date('d/m/Y').'] '.$usuari->nome.': ';
            if(null == $histor) //Se não houver registro de Historico anterior
            {
                $histor = '';
            }else 
                $histor = $histor;//Se houvr guarda
            if(null == $historico)//Se não houver mensagem
            {
                $history = $histor; $mensge = 0;
            }else  $history = $hoje.$historico.'&#013'.$histor;
                
                
            $data = array(
                'nomeCliente'     => set_value('nomeD'),
                'sexo'      => set_value('sexo'),
                'dat_NasciD' => $data_N,
                'dataCadastroD' => $dataCadastroD, 
                'statusDoador'    => set_value('status'),
                'rgDoador'      => set_value('rg_D'),
                'orgExpD'      => set_value('orgExpD'),
                'uf_RGD'      => set_value('uf_RGD'),
                'data_RgD'      => $data_Rg,
                
                'cpf_D'     => $this->input->post('cpf_D'),
                'foneD'     => set_value('foneD'),
                'foneop'    => set_value('foneop'),
                'foneD2'    => set_value('foneD2'),
                'foneop2'   => set_value('foneop2'),
                'foneD3'    => set_value('foneD3'),
                'foneop3'   => set_value('foneop3'),
                'emailD'     => set_value('emailD'),
                'logradD'    => set_value('lograd'),
                'numeroD'    => set_value('numero'),
                
              //  'historico'   => set_value('histor').$history,
                'complemD'   => set_value('complem'),
                'bairroD'    => set_value('bairro'),
                'cidadeD'    => set_value('cidade'),
                'estadoD'      => set_value('uf'),
                'atendente_ID' => set_value('atendente')
            );

            if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == TRUE) {
                
               if($temRegistro == 1)
               {                   
                    $data1 = array(
                        'descricao_Mensagem'        => $history,
                        'dataMensagem'        => date('Y-m-d'),
                        'IdObsMsg'        => $result_mensg->IdObs
                    ); 
                if ($this->clientes_model->edit('doar_mensagens', $data1, 'cod_DoadorMensagem', $doador_id) == TRUE) 
                    {  }
               }
                   
                $this->session->set_flashdata('success','Doador editado com sucesso!');
                redirect(base_url() . 'index.php/clientes/editar/'.$this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
        
        if($temRegistro == 0)
            {      
            $dataM = array(
                        'cod_doador'       => $doador_id,
                        'textoObs'        => 'Criado historico de Observações.',
                        'usuarioN'        => $usuari->nome,
                        'data_Obs'        => date('Y-m-d')
                    );           
                     if ($this->clientes_model->add('obs_individual', $dataM) == TRUE)  {  
                     $result_mensg = $this->clientes_model->getmsgUltima('obs_individual','cod_doador',$doador_id,'IdObs');
                        $idObsU = $result_mensg->IdObs;
                $data1 = array(
                    'cod_DoadorMensagem'        => $doador_id,
                    'descricao_Mensagem'        => '['.date('d/m/Y').'] '.$usuari->nome.': Criado historico de Observações.',
                    'dataMensagem'        => date('Y-m-d'),
                    'IdObsMsg'        => $idObsU
                );           
                 if ($this->clientes_model->add('doar_mensagens', $data1) == TRUE)
                    {     } 
                     }
                }
               


      $this->data['usuario'] = $this->clientes_model->getByIdUser($this->session->userdata('id'));
         $this->data['results_Atendente'] = $this->clientes_model->get2('usuarios','nome');
         $this->data['results_Bairro'] = $this->clientes_model->get2('bairros','Bairro');
         $this->data['results_Cidade'] = $this->clientes_model->get2('cidade','idC');
        
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'clientes/editarCliente';
        $this->load->view('tema/topo', $this->data);

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


      $this->data['usuario'] = $this->clientes_model->getByIdUser($this->session->userdata('id'));
        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['result_Hist'] = $this->clientes_model->getHist($this->uri->segment(3));
        $this->data['result_Historic'] = $this->clientes_model->getHistoric($this->uri->segment(3));
        $this->data['results'] = $this->clientes_model->getOsByCliente($this->uri->segment(3));
         $this->data['results_Bairro'] = $this->clientes_model->get2('bairros','Bairro');
         $this->data['results_Cidade'] = $this->clientes_model->get2('cidade','idC');
        $this->data['view'] = 'clientes/visualizar';
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
            $this->db->where('clientes_id', $id);
            $os = $this->db->get('os')->result();

            if($os != null){

                foreach ($os as $o) {
                    $this->db->where('os_id', $o->idOs);
                    $this->db->delete('servicos_os');

                    $this->db->where('os_id', $o->idOs);
                    $this->db->delete('produtos_os');


                    $this->db->where('idOs', $o->idOs);
                    $this->db->delete('os');
                }
            }

            // excluindo Vendas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $vendas = $this->db->get('vendas')->result();

            if($vendas != null){

                foreach ($vendas as $v) {
                    $this->db->where('vendas_id', $v->idVendas);
                    $this->db->delete('itens_de_vendas');


                    $this->db->where('idVendas', $v->idVendas);
                    $this->db->delete('vendas');
                }
            }

            //excluindo receitas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $this->db->delete('lancamentos');



            $this->clientes_model->delete('clientes','idClientes',$id); 

            $this->session->set_flashdata('success','Cliente excluido com sucesso!');            
            redirect(base_url().'index.php/clientes/gerenciar/');
    }
}

