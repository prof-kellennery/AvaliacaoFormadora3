<?php
require_once 'Conexao.php';

class EditoraDAO {
    private $con;

    public function __construct() {
        $this->con = Conexao::getConexao();
    }

    private function carregarObjeto($item) {
        $obj = new EditoraModel();
        $obj->setIdEditora($item['id_editora']);
        $obj->setNome($item['nome']);
        $obj->setUf($item['uf']);
        return $obj;
    }

    public function listar()
    {
        $qry = $this->con->query('SELECT * FROM editora');
        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaEditoras = array();
        foreach($dados as $dado)
        {
            $listaEditoras[] = $this->carregarObjeto($dado);
        }
        return $listaEditoras;
    }

    public function inserir(EditoraModel $e) 
    {
        $sql = "INSERT INTO editora (nome, uf) VALUES (?, ?)";
        $stmt = $this->con->prepare($sql);

        // Bind por posição
        $stmt->bindValue(1, $e->getNome());
        $stmt->bindValue(2, $e->getUf());

        // Execução
        $stmt->execute();
    }

    public function retornar($id) 
    {
        $stm = $this->con->prepare("SELECT * FROM editora WHERE id_editora=?");
        $stm->execute([$id]);
        $dado = $stm->fetch(PDO::FETCH_ASSOC);

        if ($dado) {
            return $this->carregarObjeto($dado);
        }
        return null;
    }

    public function atualizar(EditoraModel $e) {
        try {
            $sql = "UPDATE editora 
                    SET nome = :nome, 
                        uf   = :uf 
                    WHERE id_editora = :id";

            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':nome', $e->getNome());
            $stmt->bindValue(':uf',   $e->getUf());
            $stmt->bindValue(':id',   $e->getIdEditora(), PDO::PARAM_INT);

            $stmt->execute(); 

        } catch (PDOException $ex) {
            // aqui você pode logar o erro ou lançar exceção
            throw new Exception("Erro ao atualizar editora: " . $ex->getMessage());
        }
    }

    public function deletar($id) {
        $sql = "DELETE FROM editora WHERE id_editora = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
    }

    public function buscar($parametro)
    {
        $qry = $this->con->prepare('SELECT * FROM editora WHERE nome LIKE :parametro OR uf LIKE :parametro');
        $qry->bindValue(':parametro', "%".$parametro."%");
        $qry->execute();

        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaEditoras = array();
        foreach($dados as $dado)
        {
            $listaEditoras[] = $this->carregarObjeto($dado);
        }
        return $listaEditoras;
    }


}
