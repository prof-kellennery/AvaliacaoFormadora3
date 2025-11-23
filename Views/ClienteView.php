    <script src="assets/js/cliente.js"></script>

    <div class="box-body" id="alerta" style="display:none;" >
      <div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
        Operação realizada com sucesso.
      </div>
    </div>

    <div class="box-body" id="alertaW" style="display:none;" >
      <div class="alert alert-warning alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Atenção!</h4>
        Preencha todos os campos.
      </div>
    </div>

    <section class="content-header">
      <h1>
        Cliente
        <small>Cadastro de Cliente</small>
      </h1>
    </section>

    <section class="content">

      <div class="row">
        <div class="col-xs-12">

          <!-- BOX PARA LOCALIZAR CLIENTE -->
          <div class="box" id="boxLocalizar">
            <!-- /buscar cabeçalho do box -->
            <div class="box-header">
              <div class="box-tools">
                <div class="input-group input-group-sm">
                  <input type="text" name="txtpesquisa" id= "txtpesquisa" class="form-control pull-right" placeholder="Busca">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" onclick="Pesquisar()"><i class="fa fa-search"></i></button>
                  </div>
                </div>				
              </div>	
            </div>
            <!-- /adicionar rodapé do box -->
            <div class="box-footer clearfix" >
              <button type="button" id="adicionar" class="btn bg-purple" onclick="Adicionar()">Adicionar Cliente</button>
            </div>
          </div>

          <!-- FORMULÁRIO PARA CADASTRO DE CLIENTE -->
          <div class="box box-primary" id="boxCadastro" style="display: none;">
            <div class="box-header with-border">
              <h3 class="box-title">Novo Cliente</h3>
            </div>

            <form id="formCadastroCliente" method="post">
              <input type="hidden" id="acao" name="acao" value="" />

              <div class="box-body" id="formulario">

                <div class="form-group">
                  <label class="form-check-label">
                    <input type="radio" id="tipoFisico" name="tipo" value="Físico" class="minimal" onclick="SelecionarTipoCliente('Físico')" checked>
                    Cliente Físico
                  </label>
                  <label class="form-check-label">
                    <input type="radio" id="tipoJuridico" name="tipo" value="Jurídico" class="minimal" onclick="SelecionarTipoCliente('Jurídico')">
                    Cliente Jurídico
                  </label>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <label for="id_cliente">ID</label>
                    <input type="text" class="form-control" id="id_cliente" name="id_cliente" readonly>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                  </div>
                  <div class="col-md-6">
                    <label for="cnpj">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" disabled>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                  </div>
                  <div class="col-md-6">
                    <label for="razao_social">Razão Social</label>
                    <input type="text" class="form-control" id="razao_social" name="razao_social" disabled>
                  </div>
                </div>

                <div class="form-group">
                  <label for="endereco">Endereço</label>
                  <input type="text" class="form-control" id="endereco" name="endereco">
                </div>
                
              </div>

              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="salvar" onclick="Salvar()" >Salvar</button>
                <button type="button" class="btn btn-warning" id="cancelar" onclick="Cancelar()">Cancelar</button>
              </div>

            </form>

          </div>

          <!-- LISTAGEM DE CLIENTES PARA CADASTRO DE CLIENTE -->
          <div id="dados-cliente" data-cliente='<?php echo $dados; ?>'></div>
      
          <div class="box">   
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>CPF</th>
                    <th>NOME</th>
                    <th>CNPJ</th>
                    <th>RAZÃO SOCIAL</th>
                    <th>ENDEREÇO</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>	
                <tbody id="linhas">
                <!-- espaço reservado para preenchimento da tabela com os registros -->
                </tbody>			
              </table>  
            </div>
            <!-- /.box-body -->
          </div>

        </div>
      </div>	  
    </section>


    <!-- Modal para confirmar exclusão -->
    <div class="modal fade" id="confirmacaoExclusaoModal" role="dialog" aria-labelledby="confirmacaoExclusaoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmacaoExclusaoModalLabel">Confirmação de Exclusão</h5>
          </div>
          <div class="modal-body">
              Tem certeza de que deseja excluir este registro?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cancelar</button>
            <button id="btnConfirmarExclusao" type="button" class="btn btn-danger">Confirmar</button>
          </div>
        </div>
      </div>
    </div>



