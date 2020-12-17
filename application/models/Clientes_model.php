<?php
class Clientes_model extends CI_Model {

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$id_Usuario,$idAusent,$i,$adm,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){

            if(array_key_exists('pesquisa',$where)){
                $this->db->select('nomeCliente');
               $this->db->like('nomeCliente',$where['pesquisa']);
                $this->db->limit(50);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->nomeCliente);
                }

            }
        }
        $this->db->select($fields.', usuarios.nome');
        $this->db->from($table);
        
        
        
        if($adm == 0){  
            
            if($i == 0)$this->db->where('clientes.atendente_ID',$id_Usuario);
            if($i == 1) $this->db->where('clientes.atendente_ID IN ('.$idAusent[0].','.$id_Usuario.')'); else
            if($i == 2) $this->db->where('clientes.atendente_ID IN ('.$idAusent[0].','.$idAusent[1].','.$id_Usuario.')');
        
        }
             
   //     $this->db->where('clientes.atendente_ID',$id_Usuario);
        $this->db->join('usuarios',' usuarios.idUsuarios = clientes.atendente_ID');
        $this->db->order_by('nomeCliente');
        $this->db->limit($perpage,$start);
        //if($where){    $this->db->where($where);      }
       
        // condicional de clientes
        if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in($table.'.nomeCliente',$lista_clientes);
            }
        }
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function get0($table,$fields,$contaU,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){

            if(array_key_exists('pesquisa',$where)){
                $this->db->select('nomeCliente');
               $this->db->like('nomeCliente',$where['pesquisa']);
                $this->db->limit(25);
                $clientes = $this->db->get0($table)->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->nomeCliente);
                }

            }
        }
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
  //      $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.telefone');
        $this->db->order_by('idClientes','desc');
        $this->db->where($table.'.telefone',$contaU);
       
       /* if($where){
            $this->db->where($where);
        }
        */
        // condicional de clientes
      /*  if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in($table.'.nomeCliente',$lista_clientes);
            }
        }*/
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    

    function get2($table,$fields){
        
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }

    function getById($id){
        $this->db->select('usuarios.*, clientes.*, doar_mensagens.*');
        $this->db->join('usuarios',' usuarios.idUsuarios = clientes.atendente_ID');
        $this->db->join('doar_mensagens', 'clientes.idClientes = doar_mensagens.cod_DoadorMensagem');
        $this->db->where('idClientes',$id);
        $this->db->limit(1);
        return $this->db->get('clientes')->row();
    }    
    
    function getByIdUser($id){
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
       // $this->db->join('caixas', 'usuarios.conta_Usuario = caixas.id_caixa', 'left');
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();        
    } 
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    public function getHist($id){  
        $this->db->select('usuarios.*, clientes.*, vendas.*');
        $this->db->join('vendas', 'clientes.idClientes = vendas.doador_id');
        $this->db->join('usuarios',' usuarios.idUsuarios = clientes.atendente_ID');
        $this->db->where('idClientes',$id);
        $this->db->order_by('nomeCliente','asc');
        $this->db->limit(10);
        return $this->db->get('clientes')->result();
    }
    
    
    public function getHistoric($id){  
        $this->db->select('clientes.*, doar_mensagens.*');
        $this->db->join('doar_mensagens', 'clientes.idClientes = doar_mensagens.cod_DoadorMensagem');
        $this->db->where('idClientes',$id);
        $this->db->order_by('nomeCliente','asc');
        $this->db->limit(1);
        return $this->db->get('clientes')->result();
    }
    
     public function getmsgUltima($tabela,$campo,$cod,$priori){
        $this->db->select($tabela.'.*');
        $this->db->from($tabela);
        $this->db->where($campo,$cod);
        $this->db->order_by($priori,'desc');         
        $this->db->limit(1);
        return $this->db->get()->row();
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

    function count($table) {
        return $this->db->count_all($table);
    }
    
    public function getOsByCliente($id){
        $this->db->where('clientes_id',$id);
        $this->db->order_by('idOs','desc');
        $this->db->limit(10);
        return $this->db->get('os')->result();
    }

}