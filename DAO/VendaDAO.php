<?php
require_once 'Conexao.php';

class VendaDAO {
    private $con;

    public function __construct() {
        $this->con = Conexao::getConexao();
    }

    private function carregarObjeto($item) {
        $venda = new VendaModel();
        $venda->setIdVenda($item['id_venda']);
        $venda->setDataVenda($item['data_venda']);
        $venda->setFormaPagto($item['forma_pagto']);

        // Carrega o cliente vinculado
        if ($item['tipo_cliente'] === 'Físico') {
            // Cliente Físico
            $cliente = new ClienteFisicoModel();
            $cliente->setIdCliente($item['id_cliente']);
            $cliente->setNome($item['nome']);
        } else {
            // Cliente Jurídico
            $cliente = new ClienteJuridicoModel();
            $cliente->setIdCliente($item['id_cliente']);
            $cliente->setRazaoSocial($item['razao_social']);
        }

        $venda->setCliente($cliente);


        // Carrega os itens da venda
        $sqlItens = "SELECT iv.qtde_vendida, l.id_livro, l.titulo, l.valor 
                     FROM livro_venda iv
                     INNER JOIN livro l ON iv.id_livro = l.id_livro
                     WHERE iv.id_venda = :id_venda";

        $stmtItens = $this->con->prepare($sqlItens);
        $stmtItens->bindValue(':id_venda', $item['id_venda']);
        $stmtItens->execute();
        $dadosItens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

        $itens = array();
        foreach ($dadosItens as $dado) {
            $livro = new LivroModel();
            $livro->setIdLivro($dado['id_livro']);
            $livro->setTitulo($dado['titulo']);
            $livro->setValor($dado['valor']);

            $itemVenda = new ItemVendaLivroModel();
            $itemVenda->setLivro($livro);
            $itemVenda->setVenda($venda);
            $itemVenda->setQtdeVendida($dado['qtde_vendida']);

            $itens[] = $itemVenda;
        }

        $venda->setItens($itens);
        return $venda;
    }

    public function listar() {
        $qry = $this->con->query('
            SELECT v.*, c.tipo_cliente, f.nome, j.razao_social
            FROM venda v
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente
            LEFT JOIN cliente_fisico f ON c.id_cliente = f.id_cliente
            LEFT JOIN cliente_juridico j ON c.id_cliente = j.id_cliente
            ORDER BY v.id_venda ASC
        ');
        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaVendas = array();
        foreach ($dados as $dado) {
            $listaVendas[] = $this->carregarObjeto($dado);
        }
        return $listaVendas;
    }
}
?>