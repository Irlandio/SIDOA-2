<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){ ?>
   
 <a href="<?php echo base_url();?>index.php/clientes/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Doador</a>    
<?php } ?>
<?php

          
 
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Doador</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                         <th>Atendente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Doador Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">
 <div class="widget-title">
     -   <?php
                             // echo 'Usuário: '.$usuario->nome.' | Nivel: '. $nivel.' '.$usuario->permissao;
                    ?>
    <span class="icon">
        <i class="icon-user"></i>
     </span>
                             
    <form method="get" action="<?php echo base_url(); ?>index.php/clientes/gerenciar">      

        <div class="span3">
            <input type="text" name="pesquisa"  id="pesquisa"  placeholder="Nome do Doador a pesquisar" class="span12" value="" >
        </div>
        
        <div class="span1">
            <button class="span12 btn"> <i class="icon-search"></i> </button>
        </div>
    </form>
                           
                         </div>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>#</th>
            <th>Nome</th>
            <th>Idade</th>
            <th>Data Cadastro</th>
            <th></th>
           <th>Atendente</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
        
    $dataN = $r->dat_nasciD;   
     if($dataN < '1910-12-31' || $dataN > date('Y-m-d', strtotime('-10 years'))) 
     {
       $idade = 'N/I' ;          
     }else
     {
	$hoje = new DateTime(date('Y-m-d'));
	$nascimento = new DateTime($dataN);
                        
	$idad = $hoje->diff($nascimento);
     $idade = $idad->y.' anos.';    
     }
      $dataCadastroD = date(('d/m/Y'), strtotime($r->dataCadastroD));
                   
        
       foreach ($results_Bairro as $rb) 
                {              
                    if($r->bairroD == $rb->idBairro){ $nomeBai = $rb->Bairro; }
                } 
            foreach ($results_Cidade as $rc) 
                {              
                    if($r->cidadeD == $rc->idC){ $nomeCid = $rc->nome; }
                }                 

    if($r->statusDoador == 'Ativo') $cor = '#8A9B0F'; else  $cor = '#9b0f1f';
          echo '<tr>';
            echo '<td>'.$r->idClientes.'</td><td>
             <span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->statusDoador.'</span></td>';
            echo '<td>'.$r->nomeCliente.'</td>';
            echo '<td>'.$idade.'</td>';
            echo '<td>'.$dataCadastroD.'</td>';
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
                echo '<a href="'.base_url().'index.php/clientes/visualizar/'.$r->idClientes.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                echo '<a href="'.base_url().'index.php/clientes/editar/'.$r->idClientes.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
             //   echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->id_idoso.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Cliente"><i class="icon-remove icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
                ?>
        <a href="<?php  echo base_url() ?>index.php/clientes/visualizar/<?php  echo $r->idClientes ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Ver Histórico"><i >Histórico</i></a>
        <?php 
            }

           echo $nomeBai.', '.$nomeCid.'</td><td>'.$r->nome.'</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>

<?php echo $this->pagination->create_links();}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/clientes/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Cliente</h5>
  </div>
  <div class="modal-body">
    <input type="text" id="idCliente" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este cliente e os dados associados a ele (OS, Vendas, Receitas)?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>






<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var cliente = $(this).attr('cliente');
        $('#idCliente').val(cliente);

    });

});

</script>
