<?php
class ClienteController extends Controller {

    public function index(){
        $this->listarTodos();
    }

    public function listarTodos() {
        $dao = new ClienteDAO();
        $dados = $dao->listar();

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);

        $dadosJson = json_encode($dadosArray, JSON_UNESCAPED_UNICODE);
        $this->carregarEstrutura('ClienteView', $dadosJson);
    }

    public function visualizar() {

        $id = $_POST['id'];
        $dao = new ClienteDAO();
        $cliente = $dao->retornar($id);

        if ($cliente->getTipoCliente() === 'Físico'){
            echo json_encode(array(
                'idCliente' => $cliente->getIdCliente(),
                'cpf' => $cliente->getCpf(),
                'nome' => $cliente->getNome(),
                'endereco' => $cliente->getEndereco(),
                'tipoCliente' => $cliente->getTipoCliente()
            ));
        }else{
            echo json_encode(array(
                'idCliente' => $cliente->getIdCliente(),
                'cnpj' => $cliente->getCnpj(),
                'razaoSocial' => $cliente->getRazaoSocial(),
                'endereco' => $cliente->getEndereco(),
                'tipoCliente' => $cliente->getTipoCliente()
            ));
        }

    }

    public function incluir() {
        // espera receber tipoCliente = 'F' ou 'J' e demais campos via POST
        $tipo = isset($_POST['tipoCliente']) ? $_POST['tipoCliente'] : '';
        $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
        $credito = isset($_POST['credito']) ? $_POST['credito'] : 0.0;

        if ($tipo === 'Físico') {
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
            $obj = new ClienteFisicoModel('', $endereco, $credito, $nome, $cpf);
        } else {
            $razao = isset($_POST['razaoSocial']) ? $_POST['razaoSocial'] : '';
            $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '';
            $obj = new ClienteJuridicoModel('', $endereco, $credito, $razao, $cnpj);
        }

        $dao = new ClienteDAO();
        $id = $dao->inserir($obj);

        echo json_encode(['sucesso' => true, 'id' => $id]);
    }

    public function alterar() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
        $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
        $credito = isset($_POST['credito']) ? $_POST['credito'] : 0.0;

        if ($tipo === 'Físico') {
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
            $obj = new ClienteFisicoModel($id, $endereco, $credito, $nome, $cpf);
        } else {
            $razao = isset($_POST['razaoSocial']) ? $_POST['razaoSocial'] : '';
            $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '';
            $obj = new ClienteJuridicoModel($id, $endereco, $credito, $razao, $cnpj);
        }

        $dao = new ClienteDAO();
        $dao->atualizar($obj);

        echo json_encode(['sucesso' => true]);
    }

    public function excluir() {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        if ($id) {
            $dao = new ClienteDAO();
            $dao->deletar($id);
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['erro' => 'ID não informado']);
        }
    }

    public function pesquisar() {
        $filtro = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
        $dao = new ClienteDAO();
        $dados = $dao->buscar($filtro);
        $dadosArray = array_map(function($obj) { return $obj->toArray(); }, $dados);
        echo json_encode($dadosArray, JSON_UNESCAPED_UNICODE);
    }
}




?>