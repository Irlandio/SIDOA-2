<?php
$config = array('clientes' => array(array(
                                	'field'=>'nomeD',
                                	'label'=>'Nome do Doador',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'foneD',
                                	'label'=>'Telefone',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'data_Nasc',
                                	'label'=>'Data de Nascimento',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'rg_D',
                                	'label'=>'RG',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'sexo',
                                	'label'=>'Sexo',
                                	'rules'=>'required|trim'
                                ),array(
                                	'field'=>'data_cadastro',
                                	'label'=>'Data do cadastro',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'status',
                                	'label'=>'Status',
                                	'rules'=>'required|trim'
                                ))
                ,
                'servicos' => array(//array(
                                  //  'field'=>'glicemia',
                                //    'label'=>'glicemia',
                              //      'rules'=>'required|trim'
                              //  ),
                                array(
                                    'field'=>'sistolica',
                                    'label'=>'sistolica',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'diastolica',
                                    'label'=>'diastolica',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'aferidor',
                                    'label'=>'aferidor',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'datetimepicker1',
                                    'label'=>'Hora de aferição',
                                    'rules'=>'trim'
                                ))
                ,
                'produtos' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'unidade',
                                    'label'=>'Unidade',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'precoCompra',
                                    'label'=>'Preo de Compra',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'precoVenda',
                                    'label'=>'Preo de Venda',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'estoque',
                                    'label'=>'Estoque',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'estoqueMinimo',
                                    'label'=>'Estoque Mnimo',
                                    'rules'=>'trim'
                                ))
                ,
                'usuarios' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'rg',
                                    'label'=>'RG',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'cpf',
                                    'label'=>'CPF',
                                    'rules'=>'required|trim|is_unique[usuarios.cpf]'
                                ),
                                array(
                                    'field'=>'rua',
                                    'label'=>'Rua',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'numero',
                                    'label'=>'Numero',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'estado',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'email',
                                    'label'=>'Email',
                                    'rules'=>'required|trim|valid_email|is_unique[usuarios.email]'
                                ),
                                array(
                                    'field'=>'funcao',
                                    'label'=>'Funão',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'situacao',
                                    'label'=>'Situacao',
                                    'rules'=>'required|trim'
                                ))
                ,      
                'os' => array(array(
                                    'field'=>'dataInicial',
                                    'label'=>'DataInicial',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'dataFinal',
                                    'label'=>'DataFinal',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'garantia',
                                    'label'=>'Garantia',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'descricaoProduto',
                                    'label'=>'DescricaoProduto',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'defeito',
                                    'label'=>'Defeito',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'status',
                                    'label'=>'Status',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'observacoes',
                                    'label'=>'Observacoes',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'clientes_id',
                                    'label'=>'clientes',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'usuarios_id',
                                    'label'=>'usuarios_id',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'laudoTecnico',
                                    'label'=>'Laudo Tecnico',
                                    'rules'=>'trim'
                                ))

                  ,
				'tiposUsuario' => array(array(
                                	'field'=>'nomeTipo',
                                	'label'=>'NomeTipo',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'situacao',
                                	'label'=>'Situacao',
                                	'rules'=>'required|trim'
                                ))

                ,
                'receita' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim'
                                ),
                        
                                array(
                                    'field'=>'cliente',
                                    'label'=>'Cliente',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim'
                                ))
                ,
                'despesa' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'fornecedor',
                                    'label'=>'Fornecedor',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim'
                                ))
                ,
                'vendas' => array(array(

                                    'field' => 'data_Prev',
                                    'label' => 'Data dePrevisão',
                                    'rules' => 'required|trim'
                                ),
                                array(
                                    'field'=>'doador',
                                    'label'=>'Doador',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'atendente',
                                    'label'=>'Atendente',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'valorDoa',
                                    'label'=>'Valor da Doação',
                                    'rules'=>'trim|required'
                                ))
		);
			   