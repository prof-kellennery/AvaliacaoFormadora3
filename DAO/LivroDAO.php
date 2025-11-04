<?php
require_once 'Conexao.php';

class LivroDAO {
    private $con;

    public function __construct() {
        $this->con = Conexao::getConexao();
    }

    private function carregarObjeto($item) {
        $obj = new LivroModel();
        $obj->setIdLivro($item['id_livro']);
        $obj->setIsbn($item['isbn']);
        $obj->setTitulo($item['titulo']);
        $obj->setAnoPublicacao($item['ano_publicacao']);
        $obj->setQtdeEstoque($item['quantidade_estoque']);
        $obj->setValor($item['valor']);

        $editoraDAO = new EditoraDAO();
        $editora = $editoraDAO->retornar($item['id_editora']);
        $obj->setEditora($editora);
        return $obj;
    }

    public function listar()
    {
        $qry = $this->con->query('SELECT * FROM livro');
        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaLivros = array();
        foreach($dados as $dado)
        {
            $listaLivros[] = $this->carregarObjeto($dado);
        }
        return $listaLivros;
    }

    public function inserir(LivroModel $e) 
    {
        $sql = "INSERT INTO livro (isbn, titulo, ano_publicacao, quantidade_estoque, valor, id_editora) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);

        // Bind por posição
        $stmt->bindValue(1, $e->getIsbn());
        $stmt->bindValue(2, $e->getTitulo());
        $stmt->bindValue(1, $e->getAnoPublicacao());
        $stmt->bindValue(2, $e->getQtdeEstoque());
        $stmt->bindValue(1, $e->getValor());
        $stmt->bindValue(2, $e->getEditora()->getIdEditora());      

        // Execução
        $stmt->execute();
    }

    public function retornar($id) 
    {
        $stm = $this->con->prepare("SELECT * FROM livro WHERE id_livro=?");
        $stm->execute([$id]);
        $dado = $stm->fetch(PDO::FETCH_ASSOC);

        if ($dado) {
            return $this->carregarObjeto($dado);
        }
        return null;
    }

    public function atualizar(LivroModel $e) {
        try {
            $sql = "UPDATE livro 
                    SET isbn = :isbn, 
                        titulo = :titulo,
                        quantidade_estoque = :quantidade_estoque, 
                        valor = :valor,
                        ano_publicacao = :ano_publicacao,
                        id_editora = :id_editora
                    WHERE id_livro = :id";

            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':isbn', $e->getIsbn()); 
            $stmt->bindValue(':titulo', $e->getTitulo());
            $stmt->bindValue(':quantidade_estoque', $e->getQtdeEstoque()); 
            $stmt->bindValue(':valor', $e->getValor());
            $stmt->bindValue(':ano_publicacao', $e->getAnoPublicacao());
            $stmt->bindValue(':id_editora', $e->getEditora()->getIdEditora());
            $stmt->bindValue(':id',   $e->getIdLivro(), PDO::PARAM_INT);
            $stmt->execute(); 

        } catch (PDOException $ex) {
            // aqui você pode logar o erro ou lançar exceção
            throw new Exception("Erro ao atualizar livro: " . $ex->getMessage());
        }
    }

    public function deletar($id) {
        $sql = "DELETE FROM livro WHERE id_livro = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
    }

    public function buscar($parametro)
    {
        $qry = $this->con->prepare('SELECT * FROM livro WHERE titulo LIKE :parametro');
        $qry->bindValue(':parametro', "%".$parametro."%");
        $qry->execute();

        $dados = $qry->fetchAll(PDO::FETCH_ASSOC);

        $listaLivros = array();
        foreach($dados as $dado)
        {
            $listaLivros[] = $this->carregarObjeto($dado);
        }
        return $listaLivros;
    }


}
