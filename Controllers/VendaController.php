<?php

class VendaController extends Controller {

    public function index() {
        $this->listarTodos();
    }

    public function listarTodos() {
        $dao = new VendaDAO();
        $dados = $dao->listar();

        $dadosArray = array_map(function($obj) {
            return $obj->toArray();
        }, $dados);

        $dadosJson = json_encode($dadosArray);
        $this->carregarEstrutura('VendaView', $dadosJson);
    }
}
?>