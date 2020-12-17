<a href="<?php echo base_url()?>index.php/usuarios/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Usuário</a>
<?php
if(!$results){?>
        <div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Usuários</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome | e-mail p/ acesso</th>
            <th>Cidade</th>
            <th>Função</th>
            <th>Nível</th>
            <th></th>
        </tr>
    </thead>
    <tbody>    
        <tr>
            <td colspan="5">Nenhum Usuário Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>


<?php } else{?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Usuários</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome | e-mail p/ acesso</th>
            <th>Cidade</th>
            <th>Função</th>
            <th>Nível</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
           if($r->situacao == 1) $status = "Ativo";
           if($r->situacao == 0) $status = "Inativo";
            switch ($r->conta_Usuario) 
            {		    
                case '1':	$fun = 'Operadores de telemarketing';  break;      
                case '3':	$fun = 'Operadores virtual (vis)';  break;  
                case '4':	$fun = 'Operadores virtual (Invis)';  break;  
                case '5':	$fun = 'Supervosor(a)';  break;
                case '7':	$fun = 'Administrativo';  break; 
                case '9':	$fun = 'Administrador Sistema';  break;
                default:    $fun = 'Não definido'; 
            }
            echo '<tr>';
            echo '<td>'.$r->idUsuarios.'</td>';
            echo '<td>'.$r->nome.' | '.$r->email.'</td>';
            echo '<td>'.$r->cidade.'</td>';
            echo '<td>'.$fun.'</td>';
            echo '<td>'.$status.'</td>';
            echo '<td>'.$r->permissao.'</td>';
            echo '<td>
                      <a href="'.base_url().'index.php/usuarios/editar/'.$r->idUsuarios.'" class="btn btn-info tip-top" title="Editar Usuário"><i class="icon-pencil icon-white"></i></a>
                  </td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>

	
<?php echo $this->pagination->create_links();}?>
