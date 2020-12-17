<?php
class Relatorios_model extends CI_Model {


    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    
    function get2($table){
        
        return $this->db->get($table)->result();
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
    
    public function clientesCustom($dataInicial = null,$dataFinal = null){
        
        if($dataInicial == null || $dataFinal == null){
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        $query = "SELECT * FROM clientes WHERE dataCadastro BETWEEN ? AND ?";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }

    public function clientesRapid(){
        $this->db->order_by('nomeCliente','asc');
        return $this->db->get('clientes')->result();
    }

    public function produtosRapid(){
        $this->db->order_by('descricao','asc');
        return $this->db->get('produtos')->result();
    }

    public function servicosRapid(){
        $this->db->order_by('nome','asc');
        return $this->db->get('servicos')->result();
    }

    public function osRapid(){
        $this->db->select('os.*,clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes','clientes.idClientes = os.clientes_id');
        return $this->db->get()->result();
    }

    public function produtosRapidMin(){
        $this->db->order_by('descricao','asc');
        $this->db->where('estoque < estoqueMinimo');
        return $this->db->get('produtos')->result();
    }

    public function produtosCustom($precoInicial = null,$precoFinal = null,$estoqueInicial = null,$estoqueFinal = null){
        $wherePreco = "";
        $whereEstoque = "";
        if($precoInicial != null){
            $wherePreco = "AND precoVenda BETWEEN ".$this->db->escape($precoInicial)." AND ".$this->db->escape($precoFinal);
        }
        if($estoqueInicial != null){
            $whereEstoque = "AND estoque BETWEEN ".$this->db->escape($estoqueInicial)." AND ".$this->db->escape($estoqueFinal);
        }
        $query = "SELECT * FROM produtos WHERE estoque >= 0 $wherePreco $whereEstoque";
        return $this->db->query($query)->result();
    }

    public function servicosCustom($precoInicial = null,$precoFinal = null){
        $query = "SELECT * FROM servicos WHERE preco BETWEEN ? AND ?";
        return $this->db->query($query, array($precoInicial,$precoFinal))->result();
    }


    public function osCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null,$status = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataInicial BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND clientes_id = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND usuarios_id = ".$this->db->escape($responsavel);
        }
        if($status != null){
            $whereStatus = "AND status = ".$this->db->escape($status);
        }
        $query = "SELECT os.*,clientes.nomeCliente FROM os LEFT JOIN clientes ON os.clientes_id = clientes.idClientes WHERE idOs != 0 $whereData $whereCliente $whereResponsavel $whereStatus";
        return $this->db->query($query)->result();
    }
    
    function getByIdUser($id){
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        
    } 
    
    function getSaldo_Ant($conta,$dataInicial){
        /*$dataInicial = date('Y-m-01');
        
        $this->db->from('aenpfin');
        $this->db->select('aenpfin.*');
        $this->db->where('dataFin',$dataInicial);
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        */
        $query = "SELECT * FROM aenpfin WHERE  conta = '.$conta.' and dataFin > '.$dataInicial.'  and saldo_Mes = 'S'  ORDER BY dataFin limit 1";
        return $this->db->query($query)->row();	
    } 
   
    public function presentes_pagos($conta,$cdiNome,$dataInicial,$dataFinal){
        
        $this->db->select('presentes_especiais.*, aenpfin.dataFin ');
        $this->db->from('presentes_especiais');
       // $this->db->where('SUBSTRING(n_beneficiario,1,6)',$n_Conta);
      //  $this->db->where('n_beneficiario', "'.$cdiNome.'%'");
     //   $this->db->where('data_presente', '> '.$dataInicial);
      //  $this->db->where('data_presente', '< '.$dataFinal);
        $this->db->join('aenpfin','presentes_especiais.id_entrada = aenpfin.id_fin');
        $this->db->order_by('month(data_presente)','nome_beneficiario','n_protocolo','id_presente');
        return $this->db->get()->result();        
        
		return $this->db->query($query)->result();	
    }
	
    function getDoarMes($table,$de, $ate, $dataRef){
        
        $this->db->select('*');
        $this->db->from($table);
        
        $this->db->where($dataRef.' >=' ,$de);    
        $this->db->where($dataRef.' <=' ,$ate);
      
        // condicional data final            
        $this->db->order_by('vendas.data_Previsao','asc');
        return $this->db->get()->result();
    }
	
    function getDoar($table,$fields,$de, $ate){
        
        $this->db->select($fields.', clientes.*, usuarios.*');
        $this->db->from($table);
        $this->db->join('usuarios','usuarios.idUsuarios = vendas.atendente_id','left'); 
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.doador_id');   
        $this->db->where('dataDoacao >=' ,$de);    
        $this->db->where('dataDoacao <=' ,$ate);
        // condicional data final            
        $this->db->order_by('vendas.data_Previsao','asc');
        return $this->db->get()->result();
    }
    public function financeiroRapid($conta,$dataInicial,$dataFinal){        
        
        $this->db->select('vendas.*');
        $this->db->from('vendas');
       $this->db->where('conta',$conta);
        $this->db->order_by('data_Previsao');
        $this->db->order_by('dataFin');
        return $this->db->get()->result();
        
        
    }
	
    public function financeiroCustom($dataInicial, $dataFinal, $tipo = null, $situacao = null){
        
        $whereTipo = "";
        $whereSituacao = "";

        if($dataInicial == null){
            $dataInicial = date('Y-m-01');
        }
        if($dataFinal == null){
            $dataFinal = date("Y-m-t");  
        }

        if($tipo == 'receita'){
            $whereTipo = "AND tipo = 'receita'";
        }
        if($tipo == 'despesa'){
            $whereTipo = "AND tipo = 'despesa'";
        }
        if($situacao == 'pendente'){
            $whereSituacao = "AND baixado = 0";
        }
        if($situacao == 'pago'){
            $whereSituacao = "AND baixado = 1";
        } 
        
        
        $query = "SELECT * FROM lancamentos WHERE data_vencimento BETWEEN ? and ? $whereTipo $whereSituacao";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }


    public function vendasRapid(){
        $this->db->select('vendas.*,clientes.nomeCliente, usuarios.nome');
        $this->db->from('vendas');
        $this->db->join('clientes','clientes.idClientes = vendas.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = vendas.usuarios_id');
        return $this->db->get()->result();
    }


    public function vendasCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataVenda BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND clientes_id = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND usuarios_id = ".$this->db->escape($responsavel);
        }
       
        $query = "SELECT vendas.*,clientes.nomeCliente,usuarios.nome FROM vendas LEFT JOIN clientes ON vendas.clientes_id = clientes.idClientes LEFT JOIN usuarios ON vendas.usuarios_id = usuarios.idUsuarios WHERE idVendas != 0 $whereData $whereCliente $whereResponsavel";
        return $this->db->query($query)->result();
    }
}