<?php
require_once 'ClienteModel.php';

class ClienteJuridicoModel extends ClienteModel {
    private $razaoSocial;
    private $cnpj;

    public function __construct($idCliente = "", $endereco = "", $razaoSocial = "", $cnpj = "") {
        parent::__construct($idCliente, $endereco, 'Jurídico');
        $this->razaoSocial = $razaoSocial;
        $this->cnpj = $cnpj;
    }

    public function getRazaoSocial() { return $this->razaoSocial; }
    public function setRazaoSocial($razaoSocial) { $this->razaoSocial = $razaoSocial; }

    public function getCnpj() { return $this->cnpj; }
    public function setCnpj($cnpj) { $this->cnpj = $cnpj; }


    public function toArray() {
        return [
            'idCliente' => $this->idCliente,
            'razaoSocial' => $this->razaoSocial,
            'cnpj' => $this->cnpj,
            'endereco' => $this->endereco,
            'tipoCliente' => 'Jurídico', // adiciona tipo Jurídico
        ];
    }
}
