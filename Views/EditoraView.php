<script src="assets/js/editora.js"></script>

<div class="box-body" id="alerta" style="display:none;">
  <div class="alert alert-success alert-dismissible">
    <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
    Operação realizada com sucesso.
  </div>
</div>

<div class="box-body" id="alertaW" style="display:none;">
  <div class="alert alert-warning alert-dismissible">
    <h4><i class="icon fa fa-exclamation-triangle"></i> Atenção!</h4>
    Preencha todos os campos.
  </div>
</div>

<section class="content-header">
  <h1>
    Editora
    <small>Cadastro de Editora</small>
  </h1>
</section>

<section class="content">

  <div class="row">
    <div class="col-xs-12">

      <!-- BOX PARA LOCALIZAR EDITORA -->
      <div class="box" id="boxLocalizar">
        <div class="box-header">
          <div class="box-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="txtpesquisa" id="txtpesquisa" class="form-control pull-right" placeholder="Busca">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-default" onclick="Pesquisar()"><i class="fa fa-search"></i></button>
              </div>
            </div>       
          </div>  
        </div>
        <div class="box-footer clearfix">
          <button type="button" id="adicionar" class="btn bg-purple" onclick="Adicionar()">Adicionar Editora</button>
        </div>
      </div>

      <!-- FORMULÁRIO PARA CADASTRO DE EDITORA -->
      <div class="box box-primary" id="boxCadastro" style="display: none;">
        <div class="box-header with-border">
          <h3 class="box-title">Nova Editora</h3>
        </div>

        <form id="formCadastroEditora" method="post">
          <input type="hidden" id="acao" name="acao" value="" />

          <div class="box-body" id="formulario">

            <div class="row">
              <div class="col-md-6">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
              </div>
              <div class="col-md-6">
                <label for="uf">UF</label>
                <input type="text" class="form-control" id="uf" name="uf" maxlength="2" placeholder="Ex: SP">
              </div>
            </div>

          </div>

          <div class="box-footer">
            <button type="button" class="btn btn-primary" id="salvar" onclick="Salvar()">Salvar</button>
            <button type="button" class="btn btn-warning" id="cancelar" onclick="Cancelar()">Cancelar</button>
          </div>

        </form>

      </div>

      <!-- LISTAGEM DE EDITORAS -->
      <div id="dados-editora" data-editora='<?php echo $dados; ?>'></div>
  
      <div class="box">   
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>UF</th>
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
      </div>

    </div>
  </div>    
</section>
