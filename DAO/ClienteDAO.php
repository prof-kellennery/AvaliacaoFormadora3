<?php
require_once 'Conexao.php';

class ClienteDAO {
    private $con;

    public function __construct() {
        $this->con = Conexao::getConexao();
    }

    // carrega objeto correto dependendo do tipo
    private function carregarObjeto($row) {
        if (!$row) return null;

        $id = $row['id_cliente'];
        $tipo = $row['tipo_cliente'];

        if ($tipo === 'Físico') {
            // buscar dados em cliente_fisico
            $stm = $this->con->prepare('SELECT nome, cpf, endereco FROM cliente_fisico WHERE id_cliente = ?');
            $stm->execute([$id]);
            $d = $stm->fetch(PDO::FETCH_ASSOC);
            $nome = $d['nome'] ?? '';
            $cpf = $d['cpf'] ?? '';
            $endereco = $d['endereco'] ?? '';
            $obj = new ClienteFisicoModel($id, $endereco, $nome, $cpf);
            return $obj;
        } else {
            // JURIDICO
            $stm = $this->con->prepare('SELECT razao_social, cnpj FROM cliente_juridico WHERE id_cliente = ?');
            $stm->execute([$id]);
            $d = $stm->fetch(PDO::FETCH_ASSOC);
            $razao = $d['razao_social'] ?? '';
            $cnpj = $d['cnpj'] ?? '';
            $endereco = $d['endereco'] ?? '';
            $obj = new ClienteJuridicoModel($id, $endereco, $razao, $cnpj);
            return $obj;
        }
    }

    public function listar() {
        $qry = $this->con->query('SELECT * FROM cliente ORDER BY id_cliente');
        $rows = $qry->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($rows as $r) {
            $lista[] = $this->carregarObjeto($r);
        }
        return $lista;
    }

    public function retornar($id) {
        $stm = $this->con->prepare('SELECT * FROM cliente WHERE id_cliente = ?');
        $stm->execute([$id]);
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row) return $this->carregarObjeto($row);
        return null;
    }

    public function inserir(ClienteModel $c) {
        // inserção na tabela cliente
        $sql = "INSERT INTO cliente (tipo_cliente) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$c->getTipoCliente()]);
        $id = $this->con->lastInsertId();

        // inserir detalhes na tabela específica
        if ($c->getTipoCliente() === 'Físico' && $c instanceof ClienteFisicoModel) {
            $sql2 = "INSERT INTO cliente_fisico (id_cliente, nome, cpf, endereco) VALUES (?, ?, ?, ?)";
            $stm2 = $this->con->prepare($sql2);
            $stm2->execute([$id, $c->getNome(), $c->getCpf(), $c->getEndereco()]);
        } elseif ($c->getTipoCliente() === 'Jurídico' && $c instanceof ClienteJuridicoModel) {
            $sql2 = "INSERT INTO cliente_juridico (id_cliente, razao_social, cnpj, endereco) VALUES (?, ?, ?, ?)";
            $stm2 = $this->con->prepare($sql2);
            $stm2->execute([$id, $c->getRazaoSocial(), $c->getCnpj(), $c->getEndereco()]);
        }

        return $id;
    }

    public function atualizar(ClienteModel $c) {

        // atualiza detalhes
        if ($c->getTipoCliente() === 'Físico' && $c instanceof ClienteFisicoModel) {
            $sql2 = "UPDATE cliente_fisico SET nome = :nome, cpf = :cpf, endereco = :endereco WHERE id_cliente = :id";
            $stm2 = $this->con->prepare($sql2);
            $stm2->bindValue(':nome', $c->getNome());
            $stm2->bindValue(':cpf', $c->getCpf());
            $stm2->bindValue(':endereco', $c->getEndereco());
            $stm2->bindValue(':id', $c->getIdCliente(), PDO::PARAM_INT);
            $stm2->execute();
        } elseif ($c->getTipoCliente() === 'Jurídico' && $c instanceof ClienteJuridicoModel) {
            $sql2 = "UPDATE cliente_juridico SET razao_social = :razao, cnpj = :cnpj, endereco = :endereco WHERE id_cliente = :id";
            $stm2 = $this->con->prepare($sql2);
            $stm2->bindValue(':razao', $c->getRazaoSocial());
            $stm2->bindValue(':cnpj', $c->getCnpj()); 
            $stm2->bindValue(':endereco', $c->getEndereco());
            $stm2->bindValue(':id', $c->getIdCliente(), PDO::PARAM_INT);
            $stm2->execute();
        }
    }

    public function deletar($id) {
        // delete detalhes primeiro (FK)
        $stm = $this->con->prepare('DELETE FROM cliente_fisico WHERE id_cliente = ?');
        $stm->execute([$id]);
        $stm = $this->con->prepare('DELETE FROM cliente_juridico WHERE id_cliente = ?');
        $stm->execute([$id]);

        // delete cliente
        $stm = $this->con->prepare('DELETE FROM cliente WHERE id_cliente = ?');
        $stm->execute([$id]);
    }

    public function buscar($parametro) {
        $qry = $this->con->prepare('SELECT * FROM cliente WHERE tipo_cliente LIKE :param OR endereco LIKE :param');
        $qry->bindValue(':param', "%".$parametro."%");
        $qry->execute();
        $rows = $qry->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($rows as $r) $lista[] = $this->carregarObjeto($r);
        return $lista;
    }
}
