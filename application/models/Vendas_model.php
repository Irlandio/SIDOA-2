<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendas_model extends CI_Model {

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */

	function __construct() {
        parent::__construct();
    }

   
    function get($table,$fields,$id_Usuario,$adm,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){

            if(array_key_exists('pesquisa',$where)){
                $this->db->select('idClientes');
               $this->db->like('nomeCliente',$where['pesquisa']);
                $this->db->limit(20);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->idClientes);
                }
            }
        }
        $this->db->select($fields.', clientes.*, usuarios.nome');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($adm == 0)
        $this->db->where('clientes.atendente_ID',$id_Usuario);
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.doador_id');
        $this->db->join('usuarios',' usuarios.idUsuarios = clientes.atendente_ID');
        $this->db->order_by('data_Previsao','asc');
        $this->db->order_by('nomeCliente','asc');
      //  if($where){ $this->db->where($where);   }
         // condicionais da pesquisa

        // condicional de status
        if(array_key_exists('statusPrev',$where)){
            $this->db->where('tipo_Registro',$where['statusPrev']);
        }else 
        { $this->db->where('tipo_Registro =','previsto');
        }

        // condicional de clientes
        if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in('vendas.doador_id',$lista_clientes);
            }
        }

        // condicional data inicial
        if(array_key_exists('de',$where)){
            $this->db->where('data_Previsao >=' ,$where['de']);
        }
        // condicional data final
        if(array_key_exists('ate',$where)){

            $this->db->where('data_Previsao <=', $where['ate']);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
   
    function getAgen($table,$fields,$id_Usuario,$adm,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){

            if(array_key_exists('pesquisa',$where)){
                $this->db->select('idClientes');
               $this->db->like('nomeCliente',$where['pesquisa']);
                $this->db->limit(20);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->idClientes);
                }
            }
        }
        $this->db->select($fields.', clientes.*, usuarios.nome');
        $this->db->from($table);
     //   $this->db->limit($perpage,$start);
        if($adm == 0)//*** SE NÃO FOR ADMINISTRADOR
        $this->db->where('clientes.atendente_ID',$id_Usuario);
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.doador_id');
        $this->db->join('usuarios',' usuarios.idUsuarios = clientes.atendente_ID');
        $this->db->order_by('data_Previsao','asc');
        $this->db->order_by('nomeCliente','asc');

        // condicional de status
        if(array_key_exists('statusPrev',$where)){
            $this->db->where('tipo_Registro',$where['statusPrev']);
        }else 
        { $this->db->where('tipo_Registro =','agendado');
        }

        // condicional de clientes
        if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in('vendas.doador_id',$lista_clientes);
            }
        }

        // condicional data inicial
        if(array_key_exists('de',$where)){
            $this->db->where('data_Previsao >=' ,$where['de']);
        }
        // condicional data final
        if(array_key_exists('ate',$where)){

            $this->db->where('data_Previsao <=', $where['ate']);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
   
    function getConc($table,$fields,$id_Usuario,$adm,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){

            if(array_key_exists('pesquisa',$where)){
                $this->db->select('idClientes');
               $this->db->like('nomeCliente',$where['pesquisa']);
                $this->db->limit(20);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->idClientes);
                }
            }
        }
        $this->db->select($fields.', clientes.*, usuarios.nome');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($adm == 0)
        $this->db->where('clientes.atendente_ID',$id_Usuario);
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.doador_id');
        $this->db->join('usuarios',' usuarios.idUsuarios = clientes.atendente_ID');
        $this->db->order_by('dataDoacao','desc');
      //  if($where){ $this->db->where($where);   }
         // condicionais da pesquisa

        // condicional de status
        if(array_key_exists('statusConc',$where)){
            $this->db->where('tipo_Registro',$where['statusConc']);
        }else 
        { $this->db->where('tipo_Registro !=','agendado');
          $this->db->where('tipo_Registro !=','devolvido');
          $this->db->where('tipo_Registro !=','previsto');
        }
        // condicional de clientes
        if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in('vendas.doador_id',$lista_clientes);
            }
        }

        // condicional data inicial
        if(array_key_exists('de',$where)){
            $this->db->where('dataDoacao >=' ,$where['de']);
        }
        // condicional data final
        if(array_key_exists('ate',$where)){

            $this->db->where('dataDoacao <=', $where['ate']);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function get0($table,$fields,$contaU,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.conta');
        $this->db->order_by('id_fin','desc');
        $this->db->where('aenpfin.conta',$contaU);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function get1($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.conta');
        $this->db->order_by('id_fin','desc');
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function get3($table,$fields){
        
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }

    function get2($table){
        
        return $this->db->get($table)->result();
    }

    function getPresente($id_ouProtocolo, $ent_Sai){
        $this->db->select('presentes_especiais.*');
        $this->db->from('presentes_especiais');
        if($ent_Sai == 1)
        {//Seleciona todos os presentes especiais referentes ao lançamento de entrada com o id recebido
        $this->db->where('id_entrada',$id_ouProtocolo);    
         $this->db->order_by('n_protocolo','id_presente');
        } else if($ent_Sai == 0)
        {
        $this->db->where('n_protocolo',$id_ouProtocolo);        
        $this->db->order_by('id_presente');
        }
        $affect  =   $this->db->affected_rows();
        return $this->db->get()->result();
   
    }

    function getIdpres($id_presentes){
        $this->db->select('presentes_especiais.*');
        $this->db->from('presentes_especiais');
        $this->db->where('id_presente',$id_presentes);
        return $this->db->get()->result();
   
    }
    function getProtocPres($protoc){
        $this->db->select('presentes_especiais.*');
        $this->db->from('presentes_especiais');
        $this->db->where('protocolo',$protoc);
        return $this->db->get()->result();
   
    }

    function getById($id){
	    $this->db->select('vendas.*, clientes.*,usuarios.nome');
        $this->db->from('vendas');
        $this->db->join('clientes', 'clientes.idClientes = vendas.doador_id');
        $this->db->join('usuarios',' usuarios.idUsuarios = vendas.atendente_id');
        $this->db->where('vendas.idDoacao',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function getObs($table,$id){
	    $this->db->select($table.'.*');
        $this->db->from($table);
        $this->db->where('id_Doar',$id);
        $this->db->order_by('id_Obs','desc');         
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    

    function getByIdChek($id){
	    $this->db->select('reconc_bank.* ');
        $this->db->from('reconc_bank');
        $this->db->where('reconc_bank.id_aenp',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    
    function getByIdUser($id){
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        
    }     
    
     public function getIdultimo($conta,$t_conta,$qtd,$saldo){
        $this->db->select('aenpfin.*');
        $this->db->from('aenpfin');
        $this->db->where('conta',$conta);
        $this->db->where('tipo_Conta',$t_conta);
         if($saldo == 1){ $this->db->where('saldo_Mes',"S");} 
        $this->db->order_by('id_fin','desc');         
        $this->db->limit($qtd);
        return $this->db->get()->row();
    }

     public function getmsgUltima($tabela,$campo,$cod,$priori){
        $this->db->select($tabela.'.*');
        $this->db->from($tabela);
        $this->db->where($campo,$cod);
        $this->db->order_by($priori,'desc');         
        $this->db->limit(1);
        return $this->db->get()->row();
    }

     public function getCodIead($id = null){
        $this->db->select('itens_de_vendas.*, produtos.*');
        $this->db->from('itens_de_vendas');
        $this->db->join('produtos','produtos.idProdutos = itens_de_vendas.produtos_id');
        $this->db->where('vendas_id',$id);
        return $this->db->get()->result();
    }
    
    public function getPresentes($conta){
        $this->db->select('presentes_especiais.*, aenpfin.*');
        $this->db->from('presentes_especiais');
        $this->db->join('aenpfin','presentes_especiais.id_entrada = aenpfin.id_fin');
        $this->db->where('presentes_especiais.id_saida','0');
        $this->db->where('aenpfin.conta',$conta);
        $this->db->order_by('dataFin');          
        return $this->db->get()->result();
    }
    
    public function anexar( $fin_id, $anexo, $url, $thumb, $path){
        
        $this->db->set('anexo',$anexo);
        $this->db->set('thumb',$thumb);
        $this->db->set('url',$url);
        $this->db->set('path',$path);
        $this->db->set('fin_id',$fin_id);

        return $this->db->insert('anexos');
    }

    public function getAnexos($idFin){
        
        $this->db->where('fin_id', $idFin);
        return $this->db->get('anexos')->result();
    }
   
    /*
    public function getProdutos($id = null){
        $this->db->select('itens_de_vendas.*, produtos.*');
        $this->db->from('itens_de_vendas');
        $this->db->join('produtos','produtos.idProdutos = itens_de_vendas.produtos_id');
        $this->db->where('vendas_id',$id);
        return $this->db->get()->result();
    }*/

    function add1($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function add($table,$data,$returnId = false){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
                        if($returnId == true){
                            return $this->db->insert_id($table);
                        }
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }   

    function count($table){
	return $this->db->count_all($table);
    }

    public function autoCompleteProduto($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descricao', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoVenda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoVenda']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteCliente1($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeCliente', $q);
       // $this->db->where('situacao',1);
        $query = $this->db->get('clientes');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeCliente']);
            }
            echo json_encode($row_set);
        }
    }


    public function autoCompleteCliente($q){

        $nomeCliente = '-';
        $prim = 1;
        $todas_doacoes = $this->vendas_model->get3('vendas','data_Previsao');
        
        $this->db->select('*, marcas.*, cidade.*');
        $this->db->limit(8);
        $this->db->like('nomeCliente', $q);
       $this->db->join('cidade','cidade.idC = clientes.cidadeD ');
        $this->db->join('marcas','marcas.cidaade1Rota = cidade.nome or marcas.cidaade2Rota = cidade.nome or marcas.cidaade3Rota = cidade.nome');
        $query = $this->db->get('clientes');
        
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                
                if( $row['nomeCliente'] ==  $nomeCliente){
                    $nomeCliente = $row['nomeCliente'];
                    $foneD = $row['foneD'];
                    $cidadeD = $row['nome'];
                    $idClientes = $row['idClientes'];
                    $diaRota = $diaRota.', '.$row['diaRota'];
                    $atendente_ID = $row['atendente_ID'];
                }else
                {
                    
                        $age = 0;$doad = 0;$prev = 0;$cancel = 0;$devol = 0;
                        $Tage = 0.00 ;$Tdoad = 0.00;$Tprev = 0.00;$Tcancel = 0.00;$Tdevol = 0.00; $ultDoacaoV = 0.00;
                        $ultAgend = date('2000-01-01'); $proxAgend = date('2050-01-01');
                        $ultDoacao = date('2000-01-01'); 
                        $ultPrevisao = date('2000-01-01'); $proxPrevisao = date('2050-01-01');
                        $ultCanc = date('2000-01-01'); 
                        $ultDevol = date('2000-01-01');
                    
                    
                        foreach ($todas_doacoes as $tDoa)
                        { 
                            if( $row['idClientes'] ==  $tDoa->doador_id)
                        {
                            
                            $status =  $tDoa->tipo_Registro;
                            $valor_doar =  $tDoa->valor_doar;
                            switch ($status) 
                                    {						    
                                        case 'agendado':	$age++ ; $Tage = $Tage + $valor_doar;	
                                
                                                if( date('Y-m-d') > $tDoa->data_Previsao &&  $ultAgend < $tDoa->data_Previsao)
                                                            { $ultAgend = $tDoa->data_Previsao; }else 
                                                 if( date('Y-m-d') < $tDoa->data_Previsao &&  $proxAgend > $tDoa->data_Previsao)
                                                            { $proxAgend = $tDoa->data_Previsao;   
                                                             $proxPrevV = $tDoa->valor_doar;}   break;  
                                
                                        case 'doado':	    $doad++; $Tdoad = $Tdoad + $valor_doar;
                                
                                                if( date('Y-m-d') > $tDoa->dataDoacao &&  $ultDoacao < $tDoa->dataDoacao)
                                                            { $ultDoacao = $tDoa->dataDoacao; 
                                                             $ultDoacaoV = $tDoa->valor_doar;}   break;
                                
                                        case 'previsto':	$prev++; $Tprev = $Tprev + $valor_doar;	
                                
                                                if( date('Y-m-d') > $tDoa->data_Previsao &&  $ultPrevisao < $tDoa->data_Previsao)
                                                            { $ultPrevisao = $tDoa->data_Previsao; }else 
                                                 if( date('Y-m-d') < $tDoa->data_Previsao &&  $proxPrevisao > $tDoa->data_Previsao)
                                                            { $proxPrevisao = $tDoa->data_Previsao;  
                                                             $proxPrevV = $tDoa->valor_doar;}   break;
                                
                                        case 'cancelado':	$cancel++; $Tcancel = $Tcancel + $valor_doar;	
                                
                                                if( date('Y-m-d') > $tDoa->data_Previsao &&  $ultCanc < $tDoa->data_Previsao)
                                                            { $ultCanc = $tDoa->data_Previsao; }  break;
                                
                                        case 'devolvido':	$devol++; $Tdevol = $Tdevol + $valor_doar;		
                                
                                                if( date('Y-m-d') > $tDoa->data_Previsao &&  $ultDevol < $tDoa->data_Previsao)
                                                            { $ultDevol = $tDoa->data_Previsao; }   break;
                                    }

                        }
                        }
                            $Tdoad = number_format($Tdoad, 2, ',', '.');
                            $ultDoacaoV = number_format($ultDoacaoV, 2, ',', '.');
                               if($prim == 0) 
                                     $row_set[] = array('label'=>$nomeCliente.' | Telefone: '.$foneD.' | Cidade: '.$cidadeD.' | Dia: '.$diaRota,'diaRotas'=>$diaRota,'id'=>$idClientes,'cid'=>$cidadeD, 'atendente_ID'=>$atendente_ID,
                                    'age'=>$aage,'doad'=>$adoad,'prev'=>$aprev,'cancel'=>$acancel,'devo'=>$adevol,'Tage'=>$aTage,'Tdoad'=>$aTdoad,'Tprev'=>$aTprev,'Tcancel'=>$aTcancel,'Tdevol'=>$aTdevol,'ultAgend'=>$aultAgend,'proxAgend'=>$aproxAgend,'ultDoacao'=>$aultDoacao,'ultPrevisao'=>$aultPrevisao,'proxPrevisao'=>$aproxPrevisao,'ultCanc'=>$aultCanc,'ultDevol'=>$aultDevol,'ultDoacaoV'=>$aultDoacaoV);
                                    $prim = 0;
                         if($proxPrevisao == '2050-01-01'){ $proxPrevisao = "Não existe!";}else
                         {
                         $data_Doac = explode('-', $proxPrevisao);
                         $proxPrevisao = $data_Doac[2].'/'.$data_Doac[1].'/'.$data_Doac[0];
                         }
                         if($proxPrevisao == '2000-01-01'){ $proxPrevisao = "Não existe!";}else
                         {
                         $data_Doac = explode('-', $ultDoacao);
                         $ultDoacao = $data_Doac[2].'/'.$data_Doac[1].'/'.$data_Doac[0];
                         }
                         if($proxAgend == '2050-01-01'){ $proxAgend = "Não existe!";}else
                         {
                         $data_Doac = explode('-', $proxAgend);
                         $proxAgend = $data_Doac[2].'/'.$data_Doac[1].'/'.$data_Doac[0];
                         }
                         if($ultDoacaoV == 0.00){ $ultDoacaoV = "Não é doador!";}
                        $aage = $age; $adoad = $doad; $aprev = $prev; $acancel = $cancel; $adevol = $devol;
                        $aTage = $Tage ; $aTdoad = $Tdoad; $aTprev = $Tprev; $aTcancel = $Tcancel; $aTdevol = $Tdevol;
                        $aultAgend = $ultAgend; $aproxAgend = $proxAgend;
                        $aultDoacao = $ultDoacao; 
                        $aultPrevisao = $ultPrevisao; $aproxPrevisao = $proxPrevisao;
                        $aultCanc = $ultCanc; 
                        $aultDevol = $ultDevol;
                        $aultDoacaoV = $ultDoacaoV;
                     //   $aproxPrevV = $proxPrevV;
                    
                    $nomeCliente = $row['nomeCliente'];
                    $foneD = $row['foneD'];
                    $cidadeD = $row['nome'];
                    $idClientes = $row['idClientes'];
                    $diaRota = $row['diaRota'];
                    $atendente_ID = $row['atendente_ID'];
                    
                }
            }  
           $row_set[] = array('label'=>$nomeCliente.' | Telefone: '.$foneD.' | Cidade: '.$cidadeD.' | Dia: '.$diaRota,'diaRotas'=>$diaRota,'id'=>$idClientes,'cid'=>$cidadeD,'atendente_ID'=>$atendente_ID,   'age'=>$aage,'doad'=>$adoad,'prev'=>$aprev,'cancel'=>$acancel,'devo'=>$adevol,'Tage'=>$aTage,'Tdoad'=>$aTdoad,'Tprev'=>$aTprev,'Tcancel'=>$aTcancel,'Tdevol'=>$aTdevol,'ultAgend'=>$aultAgend,'proxAgend'=>$aproxAgend,'ultDoacao'=>$aultDoacao,'ultPrevisao'=>$aultPrevisao,'proxPrevisao'=>$aproxPrevisao,'ultCanc'=>$aultCanc,'ultDevol'=>$aultDevol,'ultDoacaoV'=>$aultDoacaoV);
            echo json_encode($row_set);
        }
        
        /*                                                         
        'age'       Agendados Total
        'doad'      doados 
        'prev'      previstos
        'cancel'    cancelados
        'devo'      devolvidos
        'Tage'      Agendados Valor total
        'Tdoad'     Doados valor total
        'Tprev'     Previstos valor total
        'Tcancel'   Cancelados valor total
        'Tdevol'    Devolvidos valor total
        'ultAgend'  Agendado Ultimo
        'proxAgend' Agendado Proximo
        'ultDoacao' Doado Ultimo
        'ultPrevisao'Previsto Ultimo
        'proxPrevisao'Previsão Proximo
        'ultCanc'   Cancelado Ultimo
        'ultDevol'  Devolvido Ultimo
        ultDoacaoV     Doação Ultimo Valor
        proxPrevisaoV   Preivisão Prox Valor
        */
    }

    public function autoCompleteUsuario($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nome', $q);
        $this->db->where('situacao',1);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | RG: '.$row['rg'],'id'=>$row['idUsuarios']);
            }
            echo json_encode($row_set);
        }
    }



}

/* End of file vendas_model.php */
/* Location: ./application/models/vendas_model.php */