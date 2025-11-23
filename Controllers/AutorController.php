<?php
class AutorController extends Controller{

    public function index(){
        $this->listarTodos();
        //$this->carregarEstrutura('AutorView'); 
    }

    public function listarTodos()
    {
        $daoAutor = new AutorDAO();
        $dados = $daoAutor->listar();

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);
        $dadosJson = json_encode($dadosArray);
        $this->carregarEstrutura('AutorView', $dadosJson); 
    }

    public function incluir()
    {
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $nacionalidade = isset($_POST['nacionalidade']) ? $_POST['nacionalidade'] : '';

        $objAutor = new AutorModel();
        $objAutor->setNome($nome);
        $objAutor->setNacionalidade($nacionalidade);

        $daoAutor = new AutorDAO();
        $daoAutor->inserir($objAutor);

        //echo json_encode("sucesso");
    }

    public function alterar()
    {
        $idAutor = isset($_POST['id']) ? $_POST['id'] : '';
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $nacionalidade = isset($_POST['nacionalidade']) ? $_POST['nacionalidade'] : '';

        $objAutor = new AutorModel();
        $objAutor->setIdAutor($idAutor);
        $objAutor->setNome($nome);
        $objAutor->setNacionalidade($nacionalidade);

        $daoAutor = new AutorDAO();
        $daoAutor->atualizar($objAutor);

        //echo json_encode("sucesso");
    }

    public function visualizar()
    {
        $id = $_POST['id'];
        $daoAutor = new AutorDAO();
        $autor = $daoAutor->retornar($id);

        echo json_encode(array(
            'idAutor' => $autor->getIdAutor(),
            'nome' => $autor->getNome(),
            'nacionalidade' => $autor->getNacionalidade()
        ));
    }

    public function excluir()
    {
        $id = $_POST['id'];
        $daoAutor = new AutorDAO();
        $daoAutor->deletar($id);
    }

    public function pesquisar()
    {
        $filtro = $_POST['pesquisa'];

        $daoAutor = new AutorDAO();
        $dados = $daoAutor->buscar($filtro);

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);

        $dadosJson = json_encode($dadosArray);
        echo $dadosJson;
    }

}



?>