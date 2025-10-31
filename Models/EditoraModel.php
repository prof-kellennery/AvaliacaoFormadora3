<?php
class EditoraModel {
    private $idEditora;
    private $nome;
    private $uf;

    public function __construct($idEditora = "", $nome = "", $uf = "") {
        $this->idEditora = $idEditora;
        $this->nome = $nome;
        $this->uf = $uf;
    }

    public function getIdEditora() { return $this->idEditora; }
    public function setIdEditora($id) { $this->idEditora = $id; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; }

    public function getUf() { return $this->uf; }
    public function setUf($uf) { $this->uf = $uf; }

    public function toArray() {
        return [
            'idEditora' => $this->idEditora,
            'nome' => $this->nome,
            'uf' => $this->uf
        ];
    }
}
?>
