<?php

class Vendas extends CI_Controller {
    

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
		$this->load->model('vendas_model','',TRUE);
		$this->data['menuVendas'] = 'Vendas';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
           redirect(base_url());
        }

        $this->load->library('pagination');
        
        $where_array = array();

        $pesquisa = $this->input->get('pesquisa');
        $stat = $this->input->get('status');
        
            switch ($stat)
                    {						    
                        case 'agendado':	$statusPrev = $stat; $statusConc = "";	break; 
                        case 'previsto':	$statusPrev = $stat; $statusConc = "";	break;   
                        case 'devolvido':	$statusPrev = $stat; $statusConc = "";	break;
                    
                        case 'doado':	     $statusPrev = ""; $statusConc = $stat;	break;  
                        case 'cancelado':	$statusPrev = ""; $statusConc = $stat;	break;	 
                        case '':	$statusPrev = ""; $statusConc = "";	break;	
                    }
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');
        $count = 20;
        if($pesquisa){
           $where_array['pesquisa'] = $pesquisa;
        $count = 20;
        }
        if($statusPrev){
            $where_array['statusPrev'] = $statusPrev;
        $count = 20;
        }
        if($statusConc){
            $where_array['statusConc'] = $statusConc;
        $count = 15;
        }
        if($de){

            $de = explode('/', $de);
            $de = $de[2].'-'.$de[1].'-'.$de[0];
            $where_array['de'] = $de;
        $count = 100;
        }
        if($ate){
            $ate = explode('/', $ate);
            $ate = $ate[2].'-'.$ate[1].'-'.$ate[0];
            $where_array['ate'] = $ate;
        $count = 100;
        }
        
        $config['base_url'] = base_url().'index.php/vendas/gerenciar/';
        $config['total_rows'] = $this->vendas_model->count('vendas');
        $config['per_page'] = $count;
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
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $adm = 0;
        $user = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $id_Usuario = $user->idUsuarios;
        if($user->permissoes_id < 4){$adm = 1;}//Selecionar Por nivel de Usuário
        
        $this->data['results'] = $this->vendas_model->get('vendas','*',$id_Usuario,$adm,$where_array,$config['per_page'],$this->uri->segment(3));
        $this->data['resultsAgen'] = $this->vendas_model->getAgen('vendas','*',$id_Usuario,$adm,$where_array,$config['per_page'],$this->uri->segment(3));
        $this->data['resultsConcluidos'] = $this->vendas_model->getConc('vendas','*',$id_Usuario,$adm,$where_array,$config['per_page'], $this->uri->segment(3));
        
        $this->data['result_mensg'] = $this->vendas_model->get3('doar_mensagens','cod_DoadorMensagem');  
        $this->data['result_usuarios'] = $this->vendas_model->get3('usuarios','nome');  
        $this->data['result_Clientes'] = $this->vendas_model->get3('clientes','nomeCliente');  
        $this->data['result_medic'] = $this->vendas_model->get3('medicamentos','nome_referencia'); 
        
	    $this->data['view'] = 'vendas/vendas';
       	$this->load->view('tema/topo',$this->data);
		
    }
	
    function adicionar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Vendas.');
          redirect(base_url());
        }
        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if ($this->form_validation->run('vendas') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            
             $data_Agend      = $this->input->post('data_Age');
             $data_Doacao   = $this->input->post('data_Prev');
            
             $data_Doac = explode('/', $data_Doacao);
             $data_Doa = $data_Doac[2].'-'.$data_Doac[1].'-'.$data_Doac[0];
            
            $data_Agen = explode('/', $data_Agend);
            $data_Ag = $data_Agen[2].'-'.$data_Agen[1].'-'.$data_Agen[0];
              
                $repet  = $this->input->post('repet');
                $doador   = $this->input->post('doador');
                $doador_id   = $this->input->post('doador_id');
                $valorDoa = $this->input->post('valorDoa');
                $formaPgto = $this->input->post('formaPgto');
                $usuarios_id = $this->input->post('usuarios_id');
                $tipoReg = 'previsto';
            
            $count = 1; $dat = ' ';
           while ($count <= $repet)    
           {
             $dat = $dat.' - '.$data_Doacao;
            $data = array(
                'dataDoacao'        => '',
                'data_Previsao'     => $data_Doa,
                'data_Agendamento'  => $data_Ag,
                'doador_id'         => $this->input->post('doador_id'),
                'atendente_id'      => $usuarios_id,
                'tipo_Registro'     => $tipoReg,
                'forma_Pag'         => $formaPgto,
                'valor_doar'        => $valorDoa
            ); 
//**** se é edição ou adição de lançamento
             if ($this->vendas_model->add1('vendas', $data) == TRUE)
                {                      
                } else 
                    {                        
                        $this->session->set_flashdata('error','Erro no lançamento do registro, Tente novamente!');
                        //    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    }
               ++$count;
               $data_Doa = date('Y-m-d', strtotime("+1 month", strtotime($data_Doa)));
               $data_Doac = explode('-', $data_Doa);
               $data_Doacao = $data_Doac[2].'/'.$data_Doac[1].'/'.$data_Doac[0];

           }
            if($repet == 1)$paraoDia = "o dia"; else $paraoDia = "os dias"; 
                  $this->session->set_flashdata('success','Registro efetuado com sucesso! Doador <strong>'.$doador.'.</strong> doação de <strong>R$ '.$valorDoa.'</strong> agendada no dia - '.$data_Agend.' - para '.$paraoDia.' <strong>'.$dat.'</strong> ');
             redirect(base_url().'index.php/vendas/gerenciar/'); 
        }        
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $this->data['results_Atendente'] = $this->vendas_model->get3('usuarios','nome');
        $this->data['view'] = 'vendas/adicionarVenda';
        $this->load->view('tema/topo', $this->data); 
    }     
    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Lançamento');
          redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('vendas') == false)   
        {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
         } else 
        {
             $tipoReg   = $this->input->post('status');
             $data_Doacao   = $this->input->post('data_Doacao');
             $data_Prev   = $this->input->post('data_Prev');
             $data_Agend   = $this->input->post('data_Age');
            
            if($data_Doacao == "Não efetuada"){
                $data_Doa = ''; 

            }else{      
             $data_Doac = explode('/', $data_Doacao);
             $data_Doa = $data_Doac[2].'-'.$data_Doac[1].'-'.$data_Doac[0];
            }
            $data_Previ = explode('/', $data_Prev);
            $data_Previsao = $data_Previ[2].'-'.$data_Previ[1].'-'.$data_Previ[0];
              
            $dat = 'previsto para o dia'.$data_Doacao;
            
            $usuari = $this->vendas_model->getByIdUser($this->session->userdata('id'));
                $doador   = $this->input->post('doador');
                $doador_id   = $this->input->post('doador_id');
                $valorDoa = $this->input->post('valorDoa');
                $formaPgto = $this->input->post('formaPgto');
                $usuarios_id = $this->input->post('usuarios_id');
            $obsMensag = $this->input->post('obsMensag');
              
            $historico = $this->input->post('historico');
            $histor = $this->input->post('histor');
           $historico = $this->input->post('historico');
            $histor = $this->input->post('histor');
            $mensge = 1;
            $hoje = '['.date('d/m/Y').'] '.$usuari->nome.': ';
            if(null == $histor) //Se não houver registro de obs anterior
            {
                $histor = '';
            }else 
                $histor = $histor;//Se houvr cria um paragrafo antes
            if(null == $historico)//Se não houver mensagem
            {
                $history = $histor; $mensge = 0;
            }else  $history = $hoje.$historico.'&#013'.$histor;
                  
            if(null == $this->input->post('obsMensag'))
            {         
                $obsMens = 0;
            }else
            {
              $obsMens = 1;
              $obsMensag = $this->input->post('obsMensag');
                $data2 = array(
                    'id_Doar'        => $this->input->post('idDoacao'),
                    'data_Doa'        => date('d/m/Y'),
                    'obsMensageiro'        => $obsMensag,
                    'operador'        => $usuari->nome
                ); 
            }
            $data = array(
                'dataDoacao'        => $data_Doa,
                'data_Previsao'     => $data_Previsao,
                'doador_id'         => $this->input->post('doador_id'),
                'atendente_id'      => $usuarios_id,
                'tipo_Registro'     => $tipoReg,
                'forma_Pag'         => $formaPgto,
                'valor_doar'        => $valorDoa
            );
            $result_mensg = $this->vendas_model->get3('doar_mensagens','cod_DoadorMensagem');
                $temRegistro = 0;
                foreach ($result_mensg as $r_msg) //Verifica se existe cadastro de mensagens para esse doador
                {	 if($r_msg->cod_DoadorMensagem == $doador_id){  $temRegistro = 1; } } 
             
            if ($this->vendas_model->edit('vendas', $data, 'idDoacao', $this->input->post('idDoacao')) == TRUE) 
            {            
                if($mensge == 1)
                {
                    
                    $dataM = array(
                        'cod_doador'       => $doador_id,
                        'textoObs'        => $historico,
                        'usuarioN'        => $usuari->nome,
                        'data_Obs'        => date('Y-m-d')
                    );           
                     if ($this->vendas_model->add1('obs_individual', $dataM) == TRUE)  {  
                     $result_mensg = $this->vendas_model->getmsgUltima('obs_individual','cod_doador',$doador_id,'IdObs');
                     }else $iDObs = '';
                }else $iDObs = '';
               if($temRegistro == 1)
               {
                    $data1 = array(
                        'descricao_Mensagem'        => $history,
                        'dataMensagem'        => date('Y-m-d'),
                        'IdObsMsg'        => $iDObs
                    ); 
                if ($this->vendas_model->edit('doar_mensagens', $data1, 'cod_DoadorMensagem', $doador_id) == TRUE) 
                    {  }
               }else
               {         
                $data1 = array(
                    'cod_DoadorMensagem'        => $doador_id,
                    'descricao_Mensagem'        => $history,
                    'dataMensagem'        => date('Y-m-d'),
                    'IdObsMsg'        => $iDObs
                );           
                 if ($this->vendas_model->add1('doar_mensagens', $data1) == TRUE)
                    {     } 
               }
                   
            if($obsMens == 1) 
             if ($this->vendas_model->add1('obs_mensageiro', $data2) == TRUE)
                {     } 
                  $this->session->set_flashdata('success','Registro <strong>'.$tipoReg.'.</strong>  com sucesso! Doador <strong>'.$doador.'.</strong> doação de <strong>R$ '.$valorDoa.'</strong>, <strong>'.$dat.'</strong>. Status : '.$tipoReg); 
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                $this->session->set_flashdata('error','Lançamento não efetuado.');
            }
        }
        
        $this->data['result_mensg'] = $this->vendas_model->get3('doar_mensagens','cod_DoadorMensagem');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));        
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
      //  $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['anexos'] = $this->vendas_model->getAnexos($this->uri->segment(3));
        $this->data['res_obsMensageiro'] = $this->vendas_model->getObs('obs_mensageiro',$this->uri->segment(3));
        $this->data['view'] = 'vendas/editarVenda';
        $this->load->view('tema/topo', $this->data);   
    }
    public function agendar(){
    
         if ($this->input->post('idDoacao') == null)
        {
         } else {
             
            $doador_id   = $this->input->post('doador_id');
            $doador   = $this->input->post('doador');
            $tipoReg   = $this->input->post('status');
            $data_Doacao   = $this->input->post('data_Doacao');
            $data_Prev   = $this->input->post('data_Prev');
            $valorDoa = $this->input->post('valorDoa');
            $formaPgto = $this->input->post('formaPgto');
            
             
            $usuari = $this->vendas_model->getByIdUser($this->session->userdata('id'));
             $data_Doac = explode('/', $data_Doacao);
             $data_Doa = $data_Doac[2].'-'.$data_Doac[1].'-'.$data_Doac[0];
             
            $data_Previ = explode('/', $data_Prev);
            $data_Previsao = $data_Previ[2].'-'.$data_Previ[1].'-'.$data_Previ[0];
             
            
            $historico = $this->input->post('historico');
            $histor = $this->input->post('histor');
            $mensge = 1;
            $hoje = '['.date('d/m/Y').'] '.$usuari->nome.': ';
            if(null == $histor) //Se não houver registro de obs anterior
            {
                $histor = '';
            }else 
                $histor = $histor;//Se houvr cria um paragrafo antes
            if(null == $historico)//Se não houver mensagem
            {
                $history = $histor; $mensge = 0;
            }else  $history = $hoje.$historico.'&#013'.$histor;
            if(null == $this->input->post('obsMensag'))
            {         
                $obsMens = 0;
            }else
            {
              $obsMens = 1;
              $obsMensag = $this->input->post('obsMensag');
                $data2 = array(
                    'id_Doar'        => $this->input->post('idDoacao'),
                    'data_Doa'        => date('d/m/Y'),
                    'obsMensageiro'        => $obsMensag,
                    'operador'        => $usuari->nome
                ); 
            }
             $data = array(
                'dataDoacao'        => $data_Doa,
                'data_Previsao'     => $data_Previsao,
                'tipo_Registro'     => $tipoReg,
                'forma_Pag'         => $formaPgto,
                'valor_doar'        => $valorDoa
            );
             
             
            $result_mensg = $this->vendas_model->get3('doar_mensagens','cod_DoadorMensagem');
                $temRegistro = 0;
                foreach ($result_mensg as $r_msg) //Verifica se existe cadastro de mensagens para esse doador
                {	 if($r_msg->cod_DoadorMensagem == $doador_id){  $temRegistro = 1; } } 
             
            if ($this->vendas_model->edit('vendas', $data, 'idDoacao', $this->input->post('idDoacao')) == TRUE) 
            {            
                if($mensge == 1)
                {
                    $dataM = array(
                        'cod_doador'       => $doador_id,
                        'textoObs'        => $historico,
                        'usuarioN'        => $usuari->nome,
                        'data_Obs'        => date('Y-m-d')
                    );           
                     if ($this->vendas_model->add1('obs_individual', $dataM) == TRUE)  {  
                     $result_mensg = $this->vendas_model->getmsgUltima('obs_individual','cod_doador',$doador_id,'IdObs');}
                }
               if($temRegistro == 1){
                   
                    $data1 = array(
                        'descricao_Mensagem'        => $history,
                        'dataMensagem'        => date('Y-m-d'),
                        'IdObsMsg'        => $result_mensg->IdObs
                    ); 
                if ($this->vendas_model->edit('doar_mensagens', $data1, 'cod_DoadorMensagem', $doador_id) == TRUE) 
                    {  }
               }else
               {         
                $data1 = array(
                    'cod_DoadorMensagem'        => $doador_id,
                    'descricao_Mensagem'        => $history,
                    'dataMensagem'        => date('Y-m-d'),
                    'IdObsMsg'        => $result_mensg->IdObs
                );           
                 if ($this->vendas_model->add1('doar_mensagens', $data1) == TRUE)
                    {     } 
               }
                   
            if($obsMens == 1) 
             if ($this->vendas_model->add1('obs_mensageiro', $data2) == TRUE)
                {     } 
                  $this->session->set_flashdata('success','Registro <strong>'.$tipoReg.'.</strong>  com sucesso! Doador <strong>'.$doador.'.</strong> doação de <strong>R$ '.$valorDoa.'</strong>, <strong>'.$dat.'</strong>. Status : '.$tipoReg); 
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                $this->session->set_flashdata('error','Lançamento não efetuado.');
            }
         }
            redirect(base_url().'index.php/vendas/gerenciar/'); 
    }
    
    public function anexar(){
     //   $this->session->set_flashdata('error','nome de arquivo. - ');   // Linha para testar variavel  
      //  exit;
        $this->load->library('upload');
        $this->load->library('image_lib');
        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para anexos de os
            'max_size'      => 0,
            );
        
        $fin_id = $this->input->post('fin_id');
        $this->upload->initialize( $upload_conf );  
        
              //   $upload_data['file_name'] = $upload_data['file_name'].$id_OsItens."_".$id_OsItens;
               
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
                
                        $this->load->model('Vendas_model');
                        $this->Vendas_model->anexar( $this->input->post('fin_id'), $upload_data['file_name'] ,base_url().'assets/anexos/', 'thumb_'.$upload_data['file_name'],realpath('./assets/anexos/')); 
                    } 
                }
                else{
                    
                    $success[] = $upload_data;
                  //  $arquivo_antigo =  base_url().'assets/anexos/'.$upload_data['file_name'];
                  //    $arquivo_novo =  base_url().'assets/anexos/'.$id_OsItens."_".$id_OsItens."_".$upload_data['file_name'];
                  //  rename($arquivo_antigo, $arquivo_novo);
                    
                    $this->load->model('Vendas_model'); 
                    $this->Vendas_model->anexar( $fin_id, $upload_data['file_name'] ,base_url().'assets/anexos/', '',realpath('./assets/anexos/')); 
                }                
            }
        }
        if(count($error) > 0)
        {
            echo json_encode(array('result'=> false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        }
        else
        {
            //      $arquivo_antigo =  base_url().'assets/anexos/thumbs/'.$upload_data['file_name'];
            //     $arquivo_novo =  base_url().'assets/anexos/thumbs/'.$id_OsItens."_".$id_OsItens."_".$upload_data['file_name'];
             //     rename($arquivo_antigo, $arquivo_novo);
                        
            echo json_encode(array('result'=> true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso .'));
        }
    }
    
    public function excluirAnexo($id = null){
        $this->session->set_flashdata('success','Teste com sucesso!'); 
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
            if($this->vendas_model->delete('anexos','idAnexos',$id) == true){
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

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar lançamentos.');
          redirect(base_url());
        }
        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        
        $this->data['anexos'] = $this->vendas_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'vendas/visualizarVenda';
        $this->load->view('tema/topo', $this->data);
       
    }
    public function imprimir(){
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->mapos_model->getEmitente();
        
        $this->load->view('vendas/imprimirVenda', $this->data);
        
    }	
    public function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir vendas');
          redirect(base_url());
        }
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Erro ao tentar excluir Lançamento.');            
            redirect(base_url().'index.php/vendas/gerenciar/');
        } else
        {
        $ent_Sai =  $this->input->post('ent_Sai');
        $id_reconc =  $this->input->post('id_reconc');
        if ($id_reconc !== null)
        {
            $this->db->where('id_reconc', $id);
            $this->db->delete('reconc_bank');
        }     
        if ($contPre !== null)
        { 
            if($ent_Sai == 1)
            {                
                $contar = 1;
                while ($contar <= $contPre) 
                  {
                    $id_presente =  $this->input->post('id_presente'.$contar);                   
                    $this->db->where('id_presente', $id_presente);
                    $this->db->delete('presentes_especiais');
                }
            } else if($ent_Sai == 0)
            {
              //  $this->data['protocoloPres'] = $this->vendas_model->getProtocPres($this->input->post('protocoloPres'));               
                $valor_pendenteAnt = 0;
                $contar = 1;
                while ($contar <= $contPre) 
                  {                    
                    $id_presente =  $this->input->post('id_presente'.$contar);
                    $id_entrada =  $this->input->post('id_entrada'.$contar);
                    $id_saida =  $this->input->post('id_saida'.$contar);
                    $data_presente =  $this->input->post('data_presente');
                    $valor_saida =  $this->input->post('valor_saida'.$contar);
                    $valor_entrada =  $this->input->post('valor_entrada'.$contar);
                    $contPre =  $this->input->post('contPre'.$contar);
                    
                                   
 //*******Verifica se o valor foi digitado adequadamente.
            {
                     if(formatoRealPntVrg($valor_saida) == true) 
               {//Verific se o numero digitado é com (.) milhar e (,) decimal
                   //serve pra validar  valores acima e abaixo de 1000
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    $valor_saida;   
                   $valor_saida  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valor_saida)) ));
               }else if(formatoRealInt($valorFin) == true)
               {//Verific se o numero digitado é inteiro sem ponto nem virgula
                   //serve pra validar  valores acima e abaixo de 1000
                   //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valor_saida), 2, ',', '.');  
                   $valor_saida  =    number_format(str_replace("." , "" ,$valor_saida), 2, '.', '');
               }else if(formatoRealPnt($valor_saida) == true)
               { 
                   //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                   $valor_saida  =    $valor_saida;
                    $valorFinExibe  =    number_format(str_replace(",",".",$valor_saida), 2, ',', '.');  
               }else if(formatoRealVrg($valor_saida) == true)
               { 
                 //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valor_saida), 2, ',', '.');  
                   $valor_saida  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valor_saida)) ));
               }else
               {
                   echo "O valor digitado não esta nos parametros solicitados";
                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
                                        </script>";	
                      exit;  


               }
            }
    
                    
            {
                     if(formatoRealPntVrg($valor_entrada) == true) 
               {//Verific se o numero digitado é com (.) milhar e (,) decimal
                   //serve pra validar  valores acima e abaixo de 1000
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    $valor_entrada;   
                   $valor_entrada  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valor_entrada)) ));
               }else if(formatoRealInt($valorFin) == true)
               {//Verific se o numero digitado é inteiro sem ponto nem virgula
                   //serve pra validar  valores acima e abaixo de 1000
                   //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valor_entrada), 2, ',', '.');  
                   $valor_entrada  =    number_format(str_replace("." , "" ,$valor_entrada), 2, '.', '');
               }else if(formatoRealPnt($valor_entrada) == true)
               { 
                   //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                   $valor_entrada  =    $valor_entrada;
                    $valorFinExibe  =    number_format(str_replace(",",".",$valor_entrada), 2, ',', '.');  
               }else if(formatoRealVrg($valor_entrada) == true)
               { 
                 //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valor_entrada), 2, ',', '.');  
                   $valor_entrada  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valor_entrada)) ));
               }else
               {
                   echo "O valor digitado não esta nos parametros solicitados";
                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
                                        </script>";	
                      exit;  


               }
            }
    
                    
                    
                    if ( $id_saida == $id )
                    {                
                    $this->db->where('id_presente', $id_presente);
                    $this->db->delete('presentes_especiais');
                    }else 
                    {
                        if( $contar == 1)
                        {  
                            $valor_pendente = $valor_entrada;
                        }else
                        {
                            $valor_pendente = $valor_pendente - $id_saidaAnt;
                            if ( $contar == $contPre )
                            {
                                 $datapresUp = array(
                                    'id_saida'      => $id_saidaAnt,
                                    'data_presente' => $data_presenteAnt,
                                    'valor_saida'   => $valor_saidaAnt,
                                    'valor_pendente'=> $valor_pendente
                                );
                                 $datapresUpFIm = array(
                                    'id_saida'      => 0,
                                    'data_presente' => $data_presente,
                                    'valor_saida'   => $valor_saida,
                                    'valor_pendente'=> $valor_pendente
                                );
                            if ($this->vendas_model->edit('presentes_especiais', $datapresUpFIm, 'id_presente', $id_presente) == TRUE) 
                            {}
                            } else
                               {
                                 $datapresUp = array(
                                    'id_saida'      => $id_saidaAnt,
                                    'data_presente' => $data_presenteAnt,
                                    'valor_saida'   => $valor_saidaAnt,
                                    'valor_pendente'=> $valor_pendente
                                );
                                 }  
                            if ($this->vendas_model->edit('presentes_especiais', $datapresUp, 'id_presente', $id_Ant) == TRUE) 
                            {}
                        }
                        $id_Ant = $id_presente;
                    }
                        $data_presenteAnt = $data_presente;
                        $id_saidaAnt = $id_saida;
                        $valor_saidaAnt = $valor_saida;
                    ++$contar;
                }
                    if ($id_reconc !== null)
                    {
                        $this->db->where('id_reconc', $id);
                        $this->db->delete('reconc_bank');
                    }
            }
        }
            $this->db->where('id_fin', $id);
            $this->db->delete('aenpfin');
            if ($contPre !== null)
            {
            $this->session->set_flashdata('success','Lançamento e registro de presente excluído com sucesso!');
            }else {$this->session->set_flashdata('success','Lançamento  excluído com sucesso!');}
            
            redirect(base_url().'index.php/vendas/gerenciar/');       
}
    }
    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteProduto($q);
        }

    }
    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteCliente($q);
        }

    }
    public function autoCompleteCliente1(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteCliente1($q);
        }

    }
    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteUsuario($q);
        }

    }
    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar vendas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required');
        $this->form_validation->set_rules('idVendasProduto', 'Vendas', 'trim|required');
        
        if($this->form_validation->run() == false){
           echo json_encode(array('result'=> false)); 
        }
        else{

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'quantidade'=> $quantidade,
                'subTotal'=> $subtotal,
                'produtos_id'=> $produto,
                'vendas_id'=> $this->input->post('idVendasProduto'),
            );

            if($this->vendas_model->add('itens_de_vendas', $data) == true){
                $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
                $this->db->query($sql, array($quantidade, $produto));
                
                echo json_encode(array('result'=> true));
            }else{
                echo json_encode(array('result'=> false));
            }

        }
        
      
    }
    function excluirProduto(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

            $ID = $this->input->post('idProduto');
            if($this->vendas_model->delete('itens_de_vendas','idItens',$ID) == true){
                
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
    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
 

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

	        $venda_id = $this->input->post('vendas_id');
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
	            'vendas_id' => $venda_id,
                'descricao' => set_value('descricao'),
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
                
                $venda = $this->input->post('vendas_id');

                $this->db->set('faturado',1);
                $this->db->set('valorTotal',$this->input->post('valor'));
                $this->db->where('idVendas', $venda);
                $this->db->update('vendas');

                $this->session->set_flashdata('success','Venda faturada com sucesso!');
                $json = array('result'=>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }     
    public function cadastrar() {
					$p_Origem = base_url().'index.php/vendas';
                    $contar = 1;
							while (($contar <= $qtd_presentes) ) 
								{
									$nome = 'nome'.$contar;
									$Codigo = 'Codigo'.$contar;
									$Protocolo = 'Protocolo'.$contar;
									$valorPre = 'valorPre'.$contar;
									$_SESSION[$nome] = $_POST[$nome];
									$_SESSION[$Codigo]	= $_POST[$Codigo];								
									$_SESSION[$Protocolo] = $_POST[$Protocolo];
									$_SESSION[$valorPre] = $_POST[$valorPre];	
                                
									$contar = $contar+1;							
				
                                }
                    
						if(!$cod_assoc || !$cod_compassion)
						{ echo 'Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos! Caixa '.$_SESSION[$caixa].$caixa.' tipo '.$_SESSION[$tipoCont].' C comp '.$_SESSION[$cod_compassion].' doc '.$_SESSION[$num_Doc].'- Cod ASS  '.$_SESSION[$numDocFiscal].' '.$numDocFiscal.' - R soc '.$_SESSION[$razaoSoc].' '.$razaoSoc.' '.$cod_assoc.' - cod Comp '.$cod_compassion.' - tipo pag '.$_SESSION[$tipo_Pag].' - ent sai '.$_SESSION[$ent_Sai].' - '.$_SESSION[$cadastrante].' ent sai '.$_SESSION[$entrada_Saida].' '.$_SESSION[$tip_Cont].' qtd pres '.$_SESSION[$qtd_presentes].' ';
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos! - Linha: ". __LINE__ . "\");
											</script>";						  
						 exit; 
						}
						// echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
												
						if(!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin )
                        {echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
						echo "<p><font color=red>Voce nao entrou com os dados necessarios.
								Você não informou todos os dados nescessário. Tente novamente!</font</p>";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Você não informou todos os dados nescessário. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
						}	//URL=PaginaLancamento1.php
                        $datahj = date('Y-m-d');
							//echo $datahj;
						//	$dataF= implode('-',array_reverse(explode('/',$data)));
                                $data_001 =  primeiroDiaMes($datahj);								
								$data_007 =  setimoDiadoMes($datahj);
                    if(($datahj > $data_007) && ($dataF < $data_001) && ($senhaAdm <> "aenp@z18"))
								{echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente ao mês anterior aspirado. <br/> 
								Retorne e altere a data ou contate o administrador.</font><br/>";
                                 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Prazo Limite para lançamento referente ao mês anterior aspirado, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                                }
                                 
                                 
							if($dataF < "2010-01-01" || $dataF > $datahj )
								{
									echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
								 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" A data não é uma data válida, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
								}
                 //   echo "</b></br> Valor recebdo <strong><td> R$  ".$valorFin."</td></strong></br>";            
                     /*  
                    //Verifica se o valor foi digitado adequadamente.
						 if(formatoRealPntVrg($valorFin) == true) 
                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                       //serve pra validar  valores acima e abaixo de 1000
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    $valorFin;   
                       $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                   }else if(formatoRealInt($valorFin) == true)
                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                       //serve pra validar  valores acima e abaixo de 1000
                       //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
                   }else if(formatoRealPnt($valorFin) == true)
                   { 
                       //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                       $valorFin  =    $valorFin;
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   }else if(formatoRealVrg($valorFin) == true)
                   { 
                     //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                   }else
                   {
                       echo "O valor digitado não esta nos parametros solicitados";
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                            
						  
                   }
                    */
								 
						
						if($cod_compassion == ( "R01-020") )//Entrada com presentes especiais
						{
							$contar = 1;
                            $valorFinTotal =   "0.00";
							while (($contar <= $qtd_presentes) ) 
								{
									$n_nome = 'nome'.$contar;// Nomes das variaveis de cada cadastro
									$n_codigo = 'Codigo'.$contar;
									$n_protocolo = 'Protocolo'.$contar;
									$n_valorPre = 'valorPre'.$contar;
                                
									$nome = $_POST[$n_nome];
									$Codigo	= $_POST[$n_codigo];								
									$Protocolo = $_POST[$n_protocolo];
									$valorPre = $_POST[$n_valorPre];								
									if( !$nome  || !$Codigo  || !$Protocolo  || !$valorPre  )
									{				echo "Algum campo do ".$contar."º Presente da lista não foi preenchido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
                                     
									   echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
														<script type=\"text/javascript\">
														alert(\"Algum campo do ".$contar."º Prsente da lista não foi preenchido.Volte a pagina anterior e preencha todos os campos! Linha: ". __LINE__ . "\");
														</script>";	
                                     
									 exit; 
									}	
                                
                               /*
                                    formatoValor == true;
                                 if(formatoRealPntVrg($valorPre) == true) 
                                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                       //serve pra validar  valores acima e abaixo de 1000
                                       //      echo "Ponto e virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPreExibe  =    $valorPre;   
                                       $valorPre  =    (str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else if(formatoRealInt($valorPre) == true)
                                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                       //serve pra validar  valores acima e abaixo de 1000
                                       //      echo "Inteiro!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                      $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                       $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
                                   }else if(formatoRealPnt($valorPre) == true)
                                   { 
                                       //     echo "Ponto!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPre  =    $valorPre;
                                       $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                   }else if(formatoRealVrg($valorPre) == true)
                                   { 
                                        //    echo "Virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                       $valorPre  =   (str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else
                                   {
                                       formatoValor == false;
                                   }
                                */
                                
									if($valorPre = 0 )
									{				echo "Atenção! O valor do  ".$contar."º Presente é inválido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
									  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
														<script type=\"text/javascript\">
														alert(\"Atenção! O valor do  ".$contar."º Prsente é inválido. Volte a pagina anterior e preencha todos os campos!\");
														</script>";						  
									 exit; 
									}
                                 
									$valorFinTotal = $valorFinTotal + $valorPre;
                                    echo "presente ".$contar."  = R$ <strong>".$valorPreExibe."</strong><br>";
									$contar = $contar+1;	
								}
                            $val_Total = $valorFinTotal;
                          
							$valorTotExibe  =    number_format(str_replace(",",".",$val_Total), 2, ',', '.');		
                       //     echo  "<br><font color = #0cb20c size = 2> Verificar valor =  ".$v_Valores;// variavel pra não cadastrar e voltar
                            echo "<br><font color = red size = 2> Soma Total =  R$ <strong>".$valorTotExibe."</strong></font><br><br>";
                        //    echo gettype($valorFinTotal), "<br>";
                            echo "<font color = red size = 2>Valor lançado =  R$ <strong>".$valorFinExibe."</strong></font><br><br>";
                           // echo gettype($valorFin), "<br>";
                             
                            if( ($valorFin !==  $val_Total) )
                        	 echo "<font color = red size = 2>Valor lançado é diferente do somatório</strong></font><br><br>";
                            
                            
                            if(formatoValor == false)
                            {
                             echo "Um ou mais valores inseridos não esta nos parametros solicitados";
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Um ou mais valores inseridos não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						      exit;
                            }
							if($qtd_presentes > 0 )
							{
							}else{				echo "Não há presentes especiais.
												Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
							  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
												<script type=\"text/javascript\">
												alert(\"Não há presentes especiais.	Volte a pagina anterior e preencha todos os campos! <br>Linha: ". __LINE__ . "\");
												</script>";						  
							 exit; 
							}
                            
                             if($v_Valores == "1")                                
                            {
							if( ($valorFin !==  $val_Total) )
                        	{
                               
                                echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=".$p_Origem."'> 
												<script type=\"text/javascript\">
												alert(\"Verifique se o somatório  é igual ao valor total do lançamento. Preencha todos os campos! - Linha: ". __LINE__ . "\");
												</script>";						  
							 exit; 
							}}
                            
                            
						}	
//*****se for presente especial faz um lançamento 
						if($cod_compassion == ( "D06-010"))//Saída com presentes especiais
						{
						//	echo 'linha '. __LINE__;
							if(!$id_presentes)//Saída com presentes especiais
							{						
							//echo "cod_compassion: ".$cod_compassion." qtd_presentes: ".$qtd_presentes."<br>";
							echo "Linha: ". __LINE__ . "<br>Nenhum Beneficiário foi selecionado para este presente especial.
												Volte a pagina anterior e preencha todos os campos!";
							  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos! Linha: ". __LINE__ . "\");
											</script>";						  
							 exit; 
							}	
							if($id_presentes == 0 ) 
								{	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=".$p_Origem."'> 
												<script type=\"text/javascript\">
												alert(\"Desculpe, Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos!\");
												</script>";			
										exit;
								}
                          
								$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado o ultimo registro. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");
											exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum ultimo registro. Tente novamente!"; //exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
								{	$id_Maxaenp = $id_ultimo['id_fin'] +1; }
							
								$presentes_saida = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE  id_presente =  '.$id_presentes.' LIMIT 1');
								if (!$presentes_saida  ) 
								{			die ("<center>Desculpe, Nao foi encontrado o registro de presente ".$id_presentes.". Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");											
								}	
								if (mysqli_num_rows($presentes_saida) == 0 ) 
									{	echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";exit;
									}							
								
								while ($rows_presentes = mysqli_fetch_assoc($presentes_saida)) 
								{							
									  if ( $valorFin > $rows_presentes['valor_pendente'] + 1.5)
								        {echo "Linha: ". __LINE__ . "<br>Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento!";
                                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento! Linha: ". __LINE__ . "\");
											</script>";	
                                        		
										exit;
                                
                                        }
                                    
                                    
                                    $val_Restante = $rows_presentes['valor_pendente'] - $valorFin;
									
									$upd = "UPDATE presentes_especiais 
									SET id_saida = '".$id_Maxaenp."',data_presente= '".$dataF."',valor_saida = '".$valorFin."',valor_pendente = '".$val_Restante."'
									WHERE (id_presente =  ".$rows_presentes['id_presente'].")";
												$atualiz = mysqli_query($conex, $upd);
												if ($atualiz) 
												{					
												}else {
													die ("<center>Desculpe, Erro na atualização.:  " 
													. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
													<a href='menuF.php'>Voltar ao Menu</a></center>");	exit;												
													}
												$id_entrada = $rows_presentes['id_entrada'];
												$data_presente = $rows_presentes['data_presente'];
												$n_beneficiario = $rows_presentes['n_beneficiario'];
												$nome_beneficiario = $rows_presentes['nome_beneficiario'];
												$n_protocolo = $rows_presentes['n_protocolo'];
												$valor_entrada = $rows_presentes['valor_entrada'];
								}			
									if($val_Restante > 0 )
									{
										$crud = new Inserir('presentes_especiais');				
										$crud->inserir("id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario,
                                        n_protocolo, valor_entrada, valor_pendente", 
										"'','$id_entrada','$id_saida','$data_presente','$n_beneficiario','$nome_beneficiario','$n_protocolo',
										'$valor_entrada','$val_Restante'"); 
                                        
                                      //  $razaoSoc = $razaoSoc." - ".$n_beneficiario;
									}
						}
				 
						echo "Conta lançaento - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
						//exit;	
					/*		
						$crud = new Inserir('aenpfin');				
						$crud->inserir("id_fin, conta,tipo_Conta,cod_compassion,cod_assoc,num_Doc_Banco,num_Doc_Fiscal,
						historico,	descricao, dataFin,	valorFin,	ent_Sai, 	saldo,		saldo_Mes, cadastrante", 
						"'','$caixa','$tipoCont','$cod_compassion','$cod_assoc','$num_Doc','$numDocFiscal',
						'$razaoSoc','$descri','$dataF','$valorFin','$ent_Sai','$saldo_Final','$saldo_mes_lancamento','$cadastrante'"); 
						*/
//******busca do ultimo registro com o saldo do mês marcado *********
						$sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2019-01-01" and 
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
						$result_Saldo_Atual = mysqli_query($conex, $sql_Saldo_Atual );
						if (!$result_Saldo_Atual) 
							{
										die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_Saldo_Atual) == 0  ) 
						{
							echo "Nao existem lançamentos</br>";
						   
						}		
						while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) 
						{//ID, valor do saldo e a data do registro com o ultimo saldo marcado
							$id_Ultimo_Saldo = $row_Saldo['id_fin']; 
							$saldo_Atual = $row_Saldo['saldo']; 	
							$dataUlt_saldo = $row_Saldo['dataFin'];
												
						}
//*****se pagamento for em cheque faz um lançamento de reconciliação bancária
						
						if($tipo_Pag == "cheque") 
						{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
							if (!$res_max  ) 
							{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($res_max ) == 0 ) 
							{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
							}
							while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
							{	$id_Maxaenp = $id_ultimo['id_fin']; }
						
							$data_Pag = $dataF;
							//$id_Maxaenp = $id_Maxaenp + 1;//guarda o id do registro atual pra referenciar o id do cheque
                         //Ja marca se o cheque ja foi compensado
                         if(isset($_POST["chequeCompen"])) { $status = 1;} else $status = 0;
                         
							$crud = new Inserir('reconc_bank');				
							$crud->inserir("id_reconc, id_aenp, data_Pag, status, operador", 
							"'','$id_Maxaenp','$data_Pag','$status','$cadastrante'"); 							
						}
						

//*****se for presente especial faz um lançamento 
											
						if($cod_compassion == ( "R01-020"))//Entrada com presentes especiais
						{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
							if (!$res_max  ) 
							{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($res_max ) == 0 ) 
							{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
							}
							while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
							{	$id_Maxaenp = $id_ultimo['id_fin']; }
						
						 	$contar = 1;
							while (($contar <= $qtd_presentes) || $contar == 50) 
							{
								
								
                                $n_nome = 'nome'.$contar;// Nomes das variaveis de cada cadastro
								$n_codigo = 'Codigo'.$contar;
								$n_protocolo = 'Protocolo'.$contar;
								$n_valorPre = 'valorPre'.$contar;
                                									
                                $nome = $_POST[$n_nome];
								$Codigo	= $_POST[$n_codigo];								
								$Protocolo = $_POST[$n_protocolo];
								$valorPre = $_POST[$n_valorPre];	
                              							
								$data_presente = $dataF;
                                
                                
                                 if(formatoRealPntVrg($valorPre) == true) 
                                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                       //serve pra validar  valores acima e abaixo de 1000
                                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                        $valorPre  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else if(formatoRealInt($valorPre) == true)
                                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                       //serve pra validar  valores acima e abaixo de 1000
                                      //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                        $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
                                   }else if(formatoRealPnt($valorPre) == true)
                                   { 
                                       //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                       $valorPre  =    $valorPre;
                                 }else if(formatoRealVrg($valorPre) == true)
                                   { 
                                     //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                       $valorPre  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }
                                
                                
                                
                                
								$crud = new Inserir('presentes_especiais');				
								$crud->inserir("id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo,
                                valor_entrada, valor_pendente", 
								"'','$id_Maxaenp','$id_saida','$data_presente','$Codigo','$nome','$Protocolo', '$valorPre', '$valorPre'"); 
													
										
								$contar = $contar+1;							
							}
						}	
// ******* Se a data do ultimo saldo for maior que a do lançamento altera todos saldos posteriores			
						//$saldo_mes_lancamento = "S";
						//if( $dataF < $dataUlt_saldo)
					 //	{**** primeiro dia do mês do lançamento
							$dia_1_mes = primeiroDiaMes($dataF);
						//	$saldo_mes_lancamento = "N";
	//******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********				
                $id_anterior = null;
                $saldo_mes = 'N';
							$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin < "2019-01-01" and
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';	
                    
						$result_saldo_Penultimo = mysqli_query($conex, $saldo_Penultimo);
						if (!$result_saldo_Penultimo) 
							{				die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_saldo_Penultimo) == 0  ) 
							{	echo "Nao existem lançamentos</br>";}		
						while ($row_saldo_Penultimo = mysqli_fetch_assoc($result_saldo_Penultimo)) 
						{//ID, valor do saldo e a data do registro com o penultimo saldo marcado
							$id_saldo_Penultimo = $row_saldo_Penultimo['id_fin']; 
							$saldo_Penultimo = $row_saldo_Penultimo['saldo']; 	
							$data_saldo_Penultimo = $row_saldo_Penultimo['dataFin'];
												
						}
//******busca de todos registro, após o penultimo saldo *********						
									$maisRecentes = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, dataFin, ent_Sai, valorFin, saldo FROM aenpfin 
															WHERE  dataFin > "'.$data_saldo_Penultimo.'" 
															and conta like "'.$caixa.'" and tipo_Conta like "'.$tipoCont.'" 
															ORDER BY dataFin, id_fin ');
								if (!$maisRecentes) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
											//exit;
								}
								if (mysqli_num_rows($maisRecentes) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro após o penultimo saldo. Tente novamente!";
								}								
	//inicia variavel do dia final do mes do registro anterior com o dia fim do mês do lançamento								
								$fim_mes = ultimoDiaMes($dataF);
								
								$s_anterior =	$saldo_Penultimo;
								while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) 
								{	
									//if ($maisRecent['dataFin'] > $dataF) 
									//{
										$ent_Sai = $maisRecent['ent_Sai'];
										if ($ent_Sai == 0) {
										$s_Atual = $s_anterior - $maisRecent['valorFin'];//$valorFin;
										}else if ($ent_Sai == 1){
											$s_Atual = $s_anterior + $maisRecent['valorFin'];
										}										
											$upd = "UPDATE aenpfin SET saldo = ".$s_Atual." WHERE (id_fin =  ".$maisRecent['id_fin'].")";
											$atualiz = mysqli_query($conex,$upd);
											if ($atualiz) 
											{
																	
											}else {
												die ("<center>Desculpe, Erro na atualização.:  " 
												. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
												<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
												}					
									//}
									$s_anterior =	$s_Atual;
									$dataX = $maisRecent['dataFin'];
									$d_anterior = $dataX;
									$data_ultimo_dia = ultimoDiaMes($dataX);//inicia variavel do dia final do mes do registro atual
									
									if(null !== $id_anterior)
									
									{							
										if($dataX > $fim_mes)
										{	$saldo_mes = "S";// Marca se for o ultimos registro de saldos de cada mes 
										}else $saldo_mes = "N";
										
											$upd = "UPDATE aenpfin SET saldo_Mes = '".$saldo_mes."' WHERE (id_fin =  ".$id_anterior.")";
											$atualiz = mysqli_query($conex, $upd);
											if ($atualiz) {
																	
											}else {
											die ("<center>Desculpe, Erro na atualização.:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
											<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
											}										
									}
									if(	$saldo_mes == "S") $s_mes = "| Saldo do mês."; else $s_mes = "";
									echo '<font color=red size="2"> Conta '.$maisRecent['conta'];
									echo ' | Tipo '.$maisRecent['tipo_Conta']. ' | Data </font> <font color=green>'.$d_anterior. ' </font> <font color=red>
									| Registro '.$id_anterior. ' | Saldo alterado para '.$s_Atual. '  
									'.$s_mes. ' <td></font><br />';	
									
									$id_anterior = $maisRecent['id_fin'];
									$fim_mes = $data_ultimo_dia;
								}
								
									$_SESSION['tE_S_N'] = $entrada_S;
									$_SESSION['tE_S'] = $entrada_Saida;
									$_SESSION['t_Cont'] = $tip_Cont;
									$_SESSION['Cont'] = $contaX;
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Alterações realizada com sucesso. Novo lançamento. \");										
											</script>";	
									//		formulario.submit();
									//		</script>";	
					}


}


