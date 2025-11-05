    <!-- Seção Home -->
  <script src="assets/js/venda.js"></script>

  <section class="content-header">
    <h1>
      Vendas
      <small>Consulta de Vendas</small>
    </h1>
  </section>

  <div id="dados-venda" data-venda='<?php echo $dados; ?>'></div>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <!-- ALERTAS -->
        <div class="box-body" id="alerta" style="display:none;">
          <div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
            Operação realizada com sucesso.
          </div>
        </div>

        <div class="box-body" id="alertaW" style="display:none;">
          <div class="alert alert-warning alert-dismissible">
            <h4><i class="icon fa fa-exclamation-triangle"></i> Atenção!</h4>
            Nenhuma venda encontrada.
          </div>
        </div>

        <!-- BOX PRINCIPAL -->
        <div class="box box-primary" id="boxVenda">

          <div class="box-body">
            <!-- NAVEGAÇÃO ENTRE VENDAS -->
            <div class="text-center" style="margin-bottom:20px;">
              <button class="btn btn-default" id="anterior"><i class="fa fa-arrow-left"></i></button>
              <span id="posicaoVenda" style="margin:0 10px; font-weight:bold;">1 / 1</span>
              <button class="btn btn-default" id="proximo"><i class="fa fa-arrow-right"></i></button>
            </div>

            <!-- DADOS DA VENDA -->
            <div class="row">
              <div class="col-md-2">
                <label for="id_venda">ID Venda</label>
                <input type="text" id="id_venda" class="form-control" readonly>
              </div>
              <div class="col-md-5">
                <label for="cliente">Cliente</label>
                <input type="text" id="cliente" class="form-control" readonly>
              </div>
              <div class="col-md-3">
                <label for="data_venda">Data da Venda</label>
                <input type="text" id="data_venda" class="form-control" readonly>
              </div>
              <div class="col-md-2">
                <label for="forma_pagto">Forma de Pagamento</label>
                <input type="text" id="forma_pagto" class="form-control" readonly>
              </div>
            </div>

            <div class="row" style="margin-top:10px;">
              <div class="col-md-3 col-md-offset-9 text-right">
                <label>Total da Venda (R$)</label><br>
                <span id="total_venda">0.00</span>
              </div>
            </div>

          </div>

          <!-- ITENS DA VENDA -->
          <div class="box-body table-responsive no-padding">
            <h4>Itens da Venda</h4>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Título</th>
                  <th class="text-center">Quantidade</th>
                  <th class="text-center">Valor Unitário (R$)</th>
                  <th class="text-center">Total Item (R$)</th>
                </tr>
              </thead>
              <tbody id="itensVenda">
                <!-- Itens carregados via JS -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>
