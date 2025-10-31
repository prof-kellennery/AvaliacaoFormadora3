<?php

class AutorModel {

    private $idAutor;
    private $nome;
    private $nacionalidade;

    public function __construct($idAutor = "", $nome = "", $nacionalidade = "") {
        $this->idAutor = $idAutor;
        $this->nome = $nome;
        $this->nacionalidade = $nacionalidade;
    }

    public function getIdAutor() {
        return $this->idAutor;
    }
    public function setIdAutor($idAutor) {
        $this->idAutor = $idAutor;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNacionalidade() {
        return $this->nacionalidade;
    }
    public function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    public function toArray() {
        return [
            'idAutor' => $this->idAutor,
            'nome' => $this->nome,
            'nacionalidade' => $this->nacionalidade
        ];
    }

}

?>
