<?php
class EditoraController extends Controller{

    public function index(){
        $this->listarTodos();
        //$this->carregarEstrutura('EditoraView'); 
    }

    public function listarTodos()
    {
        $dao = new EditoraDAO();
        $dados = $dao->listar();

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);
        $dadosJson = json_encode($dadosArray);
        $this->carregarEstrutura('EditoraView', $dadosJson); 
    }

    public function incluir()
    {
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $uf = isset($_POST['uf']) ? $_POST['uf'] : '';

        $objEditora = new EditoraModel();
        $objEditora->setNome($nome);
        $objEditora->setUf($uf);

        $dao = new EditoraDAO();
        $dao->inserir($objEditora);

        //echo json_encode("sucesso");
    }

    public function alterar()
    {
        $idEditora = isset($_POST['id']) ? $_POST['id'] : '';
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $uf = isset($_POST['uf']) ? $_POST['uf'] : '';

        $objEditora = new EditoraModel();
        $objEditora->setIdEditora($idEditora);
        $objEditora->setNome($nome);
        $objEditora->setUf($uf);

        $dao = new EditoraDAO();
        $dao->atualizar($objEditora);

        //echo json_encode("sucesso");
    }

    public function visualizar()
    {
        $id = $_POST['idEditora'];
        $dao = new EditoraDAO();
        $editora = $dao->retornar($id);

        echo json_encode(array(
            'idEditora' => $editora->getIdEditora(),
            'nome' => $editora->getNome(),
            'uf' => $editora->getUf()
        ));
    }

    public function excluir()
    {
        $id = $_POST['idEditora'];
        $dao = new EditoraDAO();
        $dao->deletar($id);
    }

    public function pesquisar()
    {
        $filtro = $_POST['pesquisa'];

        $dao = new EditoraDAO();
        $dados = $dao->buscar($filtro);

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);

        $dadosJson = json_encode($dadosArray);
        echo $dadosJson;
    }

}



?>