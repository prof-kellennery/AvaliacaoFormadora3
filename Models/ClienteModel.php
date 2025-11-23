<?php
class ClienteModel {
    protected $idCliente;
    protected $endereco;
    protected $tipoCliente; 

    public function __construct($idCliente = "", $endereco = "", $tipoCliente = "") {
        $this->idCliente = $idCliente;
        $this->endereco = $endereco;
        $this->tipoCliente = $tipoCliente;
    }

    public function getIdCliente() { return $this->idCliente; }
    public function setIdCliente($idCliente) { $this->idCliente = $idCliente; }

    public function getEndereco() { return $this->endereco; }
    public function setEndereco($endereco) { $this->endereco = $endereco; }

    public function getTipoCliente() { return $this->tipoCliente; }
    public function setTipoCliente($tipoCliente) { $this->tipoCliente = $tipoCliente; }

    public function toArray() {
        return [
            'idCliente' => $this->idCliente,
            'endereco' => $this->endereco,
            'tipoCliente' => $this->tipoCliente
        ];
    }
}
