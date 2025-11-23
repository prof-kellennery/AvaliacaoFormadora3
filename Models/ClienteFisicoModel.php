<?php
require_once 'ClienteModel.php';

class ClienteFisicoModel extends ClienteModel {
    private $nome;
    private $cpf;

    public function __construct($idCliente = "", $endereco = "", $nome = "", $cpf = "") {
        parent::__construct($idCliente, $endereco, 'Físico');
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; }


    public function toArray() {
        return [
            'idCliente' => $this->idCliente,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'endereco' => $this->endereco,
            'tipoCliente' => 'Físico', // adiciona tipo Físico
        ];
    }
}
