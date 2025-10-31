<?php
require_once 'Conexao.php';

class AutorDAO {
    private $con;

    public function __construct() {
        $this->con = Conexao::getConexao();
    }

    private function carregarObjeto($item) {
        $obj = new AutorModel();
        $obj->setIdAutor($item['id_autor']);
        $obj->setNome($item['nome']);
        $obj->setNacionalidade($item['nacionalidade']);
        return $obj;
    }

    public function listar()
    {
        $qry = $this->con->query('SELECT * FROM autor');
        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaAutores = array();
        foreach($dados as $dado)
        {
            $listaAutores[] = $this->carregarObjeto($dado);
        }
        return $listaAutores;
    }

    public function inserir($obj)
    {
        $qry = $this->con->prepare(
            'INSERT INTO autor (nome, nacionalidade) VALUES (:nome, :nacionalidade)'
        );

        $qry->bindValue(':nome', $obj->getNome());
        $qry->bindValue(':nacionalidade', $obj->getNacionalidade());
        $qry->execute();
    }

    public function retornar($id)
    {
        $qry = $this->con->prepare('SELECT * FROM autor WHERE id_autor = :id');
        $qry->bindValue(':id', $id);
        $qry->execute();

        $dado = $qry->fetch(PDO::FETCH_ASSOC);

        if ($dado) {
            return $this->carregarObjeto($dado);
        }
        return null;
    }

    public function atualizar($obj) 
    {
        $qry = $this->con->prepare(
            'UPDATE autor SET nome = :nome, nacionalidade = :nacionalidade WHERE id_autor = :id'
        );

        $qry->bindValue(':nome', $obj->getNome());
        $qry->bindValue(':nacionalidade', $obj->getNacionalidade());
        $qry->bindValue(':id', $obj->getIdAutor());
        $qry->execute();
    }

    public function deletar($id)
    {
        $qry = $this->con->prepare('DELETE FROM autor WHERE id_autor = :id');
        $qry->bindValue(':id', $id);
        $qry->execute();
    }

    public function buscar($parametro)
    {
        $qry = $this->con->prepare('SELECT * FROM autor WHERE nome LIKE :parametro OR nacionalidade LIKE :parametro');
        $qry->bindValue(':parametro', "%".$parametro."%");
        $qry->execute();

        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaAutores = array();
        foreach($dados as $dado)
        {
            $listaAutores[] = $this->carregarObjeto($dado);
        }
        return $listaAutores;
    }


}