$(function(){
    var dados = $('#dados-cliente').data('cliente')
    CarregarDados(dados);

    //* Botão Visualizar Registro */
    $('.visualiza').click(function(event) {
        event.preventDefault(); // Previne o comportamento padrão do link
        $("#boxLocalizar").hide();
        $("#boxCadastro").show();
        $('#salvar').attr("disabled", "disabled");
        $('#formulario :input').attr("disabled", "disabled");

        var id = $(this).data('id');  
        Visualizar(id);
    });  
    /** */

    //* Botão Editar Registro */
    $('.altera').click(function(event) {
        event.preventDefault(); // Previne o comportamento padrão do link
        $("#boxLocalizar").hide();
        $("#boxCadastro").show();
        $('#salvar').removeAttr('disabled');
        $('#formulario :input').removeAttr("disabled");
        $('#id_cliente').prop("readonly", true);

        var id = $(this).data('id');  
        Visualizar(id);
        $("#acao").val("alterar");
    }); 
    /** */

    //* Botão Excluir Registro */
    var idParaExclusão;
    $('.exclui').click(function(event) {
        event.preventDefault();
        idParaExclusão = $(this).data('id');
        $('#confirmacaoExclusaoModal').modal('show');
    });

    $('#btnConfirmarExclusao').click(function() {
        Excluir(idParaExclusão);
    });
    /** */

});

/**
 * FUNÇÕES EXECUTADAS FORA DO Document Ready Handler
 */

/** Carregar tabela com Registros */
function CarregarDados(dados) { 
    $('#linhas').empty();
    dados.forEach(function(dado, index) { 
        var row = '<tr>' +
            '<td>' + dado.idCliente + '</td>' +
            '<td>' + (dado.cpf ? dado.cpf : "---") + '</td>' +
            '<td>' + (dado.nome ? dado.nome : "---") + '</td>' +
            '<td>' + (dado.cnpj ? dado.cnpj : "---") + '</td>' +
            '<td>' + (dado.razaoSocial ? dado.razaoSocial : "---") + '</td>' +
            '<td>' + dado.endereco + '</td>' +
            '<td><a href="#" class="visualiza" data-id="' + dado.idCliente + '"><i class="fa fa-search"></i></a></td>' +
            '<td><a href="#" class="altera" data-id="' + dado.idCliente + '"><i class="fa fa-pencil"></i></a></td>' +
            '<td><a href="#" class="exclui" data-id="' + dado.idCliente + '"><i class="fa fa-trash"></i></a></td>' +
            '</tr>';
        $('#linhas').append(row);
    });
}
/** */

/** Desabilitar campos conforme seleção de Tipo de Cliente */
function SelecionarTipoCliente(opcao) {
    if (opcao === 'Físico') {
        LimparCampos();
        $('#cnpj').attr("disabled", "disabled");
        $('#razao_social').attr("disabled", "disabled");

        $('#cpf').removeAttr("disabled");
        $('#nome').removeAttr("disabled");
      
    } else if (opcao === 'Jurídico') {
        LimparCampos();
        $('#cnpj').removeAttr("disabled");
        $('#razao_social').removeAttr("disabled");

        $('#cpf').attr("disabled", "disabled");
        $('#nome').attr("disabled", "disabled");
    }
}
/** */

/** Preencher formulário para novo Cliente */
function Adicionar(){
    $("#boxLocalizar").hide();
    $("#boxCadastro").show();
    $('#salvar').removeAttr('disabled');
    $('#formulario :input').removeAttr("disabled");
    $('#id_cliente').prop("readonly", true);
    $('#cnpj').attr("disabled", "disabled");
    $('#razao_social').attr("disabled", "disabled");

    $("#acao").val("incluir");
}
/** */

/** Cancelar Operação */
function Cancelar(){
    LimparCampos();
    $('#tipoFisico').prop('checked', true);
    $('#tipoJuridico').prop('checked', false);
    $("#boxLocalizar").show();
    $("#boxCadastro").hide();
    $('#alerta').fadeOut();   

    var baseUrl = window.location.origin + '/AvaliacaoFormadora3/Cliente'; // Base URL
    history.replaceState(null, null, baseUrl); 
}
/** */

/** Limpar campos do formulário de Cadastro de Cliente */
function LimparCampos(){
    $('#id_cliente').val('');
    $('#cnpj').val('');
    $('#razao_social').val('');
    $('#cpf').val('');
    $('#nome').val('');
    $('#endereco').val('');
}
/** */

/** Desabilitar todos os campos do Formulário */
function DesabilitarCampos(){
    $('#cnpj').attr("disabled", "disabled");
    $('#razao_social').attr("disabled", "disabled");
    $('#cpf').attr("disabled", "disabled");
    $('#nome').attr("disabled", "disabled");
    $('#endereco').attr("disabled", "disabled");
}
/** */

/** Validar os campos obrigatórios no formulário de clientes */
function ValidarCampos(){

    //Validação de campos
    if ( $('#tipoFisico').prop('checked') ){ 
        //valida cliente físico
        if ($('#cpf').val() == '' || $('#nome').val() == '' || $('#endereco').val() == ''){
            $('#alertaW').fadeIn();
            setTimeout(function(){
                $('#alertaW').fadeOut();
            }, 3000);
            return false;
        }
    }else{
        //valida cliente jurídico
        if ($('#cnpj').val() == '' || $('#razao_social').val() == '' || $('#endereco').val() == '') {
            $('#alertaW').fadeIn();
            setTimeout(function(){
                $('#alertaW').fadeOut();
            }, 3000);
            return false;
        }
    }
    return true;
}
/** */

/** Carregar o Registro que deseja visualizar no formulário */
function CarregarCliente(resposta){
    
    $('#id_cliente').val(resposta.idCliente);
    $('#endereco').val(resposta.endereco);

    if(resposta.tipo == 'Físico'){
        $('#tipoFisico').prop('checked', true);
        $('#tipoJuridico').prop('checked', false);   
        $('#cpf').val(resposta.cpf);
        $('#nome').val(resposta.nome);
    }else{
        $('#tipoFisico').prop('checked', false);
        $('#tipoJuridico').prop('checked', true);
        $('#cnpj').val(resposta.cnpj);
        $('#razao_social').val(resposta.razaoSocial);
    }
}
/** */


/**
 * 
 * REQUISIÇÕES AJAX 
 */

/** Salvar um NOVO registro de Cliente ou uma ATUALIZAÇÃO de Cliente */
function Salvar(){

    if (!ValidarCampos()){
        return;
    }

    //Verifica ação: Incluir ou Editar
    if ($("#acao").val() == "incluir"){
        var metodo = 'incluir';
    }else{
        var metodo = 'alterar';
    }

    var href = window.location.origin + '/AvaliacaoFormadora3/Cliente/' + metodo;
    history.replaceState(null, null, href);

    // Serializa os dados do formulário
    var formData = $('#formCadastroCliente').serialize();

    // Envia o formulário usando $.ajax
    $.ajax({
        url: href,  // URL que inclui a classe e o método
        type: 'POST',
        data: formData,
        success: function() {
            $('#alerta').fadeIn();
            $('#salvar').attr("disabled", "disabled");
            DesabilitarCampos();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Processa erros
            alert('Erro: ' + textStatus + " - " + errorThrown);
        }
    });      
}
/** */

/** Visualizar um Registro de Cliente */
function Visualizar(id){
    
    LimparCampos();
    var parametro = id;  
    var href = window.location.origin + '/AvaliacaoFormadora3/Cliente/visualizar/' + parametro;
    history.replaceState(null, null, href); 

    $.ajax({
        url: href,
        type: "POST",
        dataType: "json",
        data: {id: parametro},
        success: function(resposta){
            CarregarCliente(resposta);
        }
    });
}
/** */

/** Excluir um registro de Cliente */
function Excluir(id){

    var parametro = id;  
    var href = window.location.origin + '/AvaliacaoFormadora3/Cliente/excluir/' + parametro;
    history.replaceState(null, null, href); 

    $.ajax({
        url: href,
        method: 'POST',
        data: { id: parametro },
        success: function() {
            $('#confirmacaoExclusaoModal').modal('hide');
            $('#alerta').fadeIn();
            setTimeout(function(){
                $('#alerta').fadeOut();
            }, 3000);

            // Remover a linha da tabela correspondente ao cliente excluído
            $('a.exclui[data-id="' + parametro + '"]').closest('tr').remove();
        },
        error: function(xhr, status, error) {
            // Tratamento de erro
            console.error("Erro ao excluir cliente:", error);
        }
    });

    var baseUrl = window.location.origin + '/AvaliacaoFormadora3/Cliente'; // Base URL
    history.replaceState(null, null, baseUrl); 

}
/** */

/** Realizar um pesquisa de Clientes a partir de um filtro */
function Pesquisar(){

    var parametro = $('#txtpesquisa').val();
    var href = window.location.origin + '/AvaliacaoFormadora3/Cliente/pesquisar/' + parametro;
    //history.replaceState(null, null, href); 

    $.ajax({
        url: href,
        type: 'POST',
        dataType: 'json',
        data: { pesquisa: parametro },
        success: function(resposta) {
            CarregarDados(resposta);
        },
        error: function(xhr, status, error) {
            // Lide com erros
            console.error(error);
        }
    });
}
/** */

