<?php
class Servicos_model extends CI_Model {

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){
            if(array_key_exists('pesquisa',$where)){
                $this->db->select('nomeI');
               $this->db->like('nomeI',$where['pesquisa']);
                $this->db->limit(5);
                $clientes = $this->db->get('idosos')->result();
                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->nomeI);
                }
            }
        }        
        $this->db->join('idosos', 'lancamentos.idoso_id = idosos.id_idoso'); 
       $this->db->join('usuarios as uLanc', 'lancamentos.usuario_id = uLanc.idUsuarios');
        $this->db->join('usuarios as uCad', 'lancamentos.cadastrador = uCad.idUsuarios'); 
        $this->db->select('* , idosos.nomeI, uCad.nome as uCada,  uLanc.nome as uLanca');
        $this->db->from($table);
        $this->db->order_by('data_Hora','desc');
        $this->db->limit($perpage,$start);
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function get0($table,$fields,$contaU,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){

            if(array_key_exists('pesquisa',$where)){
                $this->db->select('nomeI');
               $this->db->like('nome',$where['pesquisa']);
                $this->db->limit(5);
                $clientes = $this->db->get0($table)->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->nomeCliente);
                }
            }
        }
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->order_by('id_idoso','desc');
        $this->db->where($table.'.telefone',$contaU);       
        $query = $this->db->get();        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }    

    function get2Idosos($table,$fields,$ord){
       if($fields == 'data_Hora')
       {
        $this->db->select('* , lancamentos.data_Hora, lancamentos.peso');
        $this->db->join('lancamentos', 'lancamentos.idoso_id = idosos.id_idoso'); 
       }else
       {
           
        $this->db->select('*');
       }
        $this->db->from($table);      
        
        $this->db->order_by($fields,$ord);
        $this->db->where($table.'.status',"Ativo");       
        $query = $this->db->get();        
        $result =  $query->result();
        return $result;
    }



    function get2($table,$fields){
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }

    function getById($id){
        
        $this->db->select('* , idosos.*');
        $this->db->join('idosos', 'lancamentos.idoso_id = idosos.id_idoso');
        $this->db->where('id_AfericaoDiaria',$id);
        $this->db->limit(1);
        return $this->db->get('lancamentos')->row();
    }
    
    
    function getByIdUser($id){
        $this->db->from('usuarios');
        $this->db->select('*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
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