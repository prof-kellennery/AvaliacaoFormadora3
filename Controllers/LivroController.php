<?php
class LivroController extends Controller{

    public function index(){
        $this->listarTodos();
    }

    public function listarTodos()
    {
        $dao = new LivroDAO();
        $dados = $dao->listar();

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);
        $dadosJson = json_encode($dadosArray);
        $this->carregarEstrutura('LivroView', $dadosJson); 
    }

    public function incluir()
    {
        $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';

        $anoPublicacao = isset($_POST['ano_publicacao']) ? $_POST['ano_publicacao'] : '';
        $valor = isset($_POST['valor']) ? $_POST['valor'] : '';

        $qtdeEstoque = isset($_POST['qtde_estoque']) ? $_POST['qtde_estoque'] : '';
        $editora = isset($_POST['editora']) ? $_POST['editora'] : '';

        $objLivro = new LivroModel();
        $objLivro->setIsbn($isbn);
        $objLivro->setTitulo($titulo);
        $objLivro->setAnoPublicacao($anoPublicacao);
        $objLivro->setValor($valor);
        $objLivro->setQtdeEstoque($qtdeEstoque);
        $objLivro->setEditora($editora);


        $dao = new LivroDAO();
        $dao->inserir($objLivro);

        //echo json_encode("sucesso");
    }

    public function alterar()
    {
        $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
        $qtdeEtoque = isset($_POST['qtde_etoque']) ? $_POST['qtde_etoque'] : '';
        $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
        $anoPublicacao = isset($_POST['ano_publicacao']) ? $_POST['ano_publicacao'] : '';
        $editora = isset($_POST['editora']) ? $_POST['editora'] : '';

        $objLivro = new LivroModel();
        $objLivro->setIsbn($isbn);
        $objLivro->setTitulo($titulo);

        $objLivro->setQtdeEstoque($qtdeEtoque);
        $objLivro->setValor($valor);

        $objLivro->setAnoPublicacao($anoPublicacao);
        $objLivro->setEditora($editora);

        $dao = new LivroDAO();
        $dao->atualizar($objLivro);

        //echo json_encode("sucesso");
    }

    public function visualizar()
    {
        $id = $_POST['id'];
        $dao = new LivroDAO();
        $livro = $dao->retornar($id);

        echo json_encode(array(
            'idLivro' => $livro->getIdLivro(),
            'isbn' => $livro->getIsbn(),
            'titulo' => $livro->getTitulo(),
            'anoPublicacao' => $livro->getAnoPublicacao(),
            'valor' => $livro->getValor(),
            'qtdeEstoque' => $livro->getQtdeEstoque(),
            'editora' => [
                'idEditora' => $livro->getEditora()->getIdEditora(),
                'nome' => $livro->getEditora()->getNome()
            ]
        ));
    }

    public function excluir()
    {
        $id = $_POST['id'];
        $dao = new LivroDAO();
        $dao->deletar($id);
    }

    public function pesquisar()
    {
        $filtro = $_POST['pesquisa'];

        $dao = new LivroDAO();
        $dados = $dao->buscar($filtro);

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);

        $dadosJson = json_encode($dadosArray);
        echo $dadosJson;
    }

}



?>