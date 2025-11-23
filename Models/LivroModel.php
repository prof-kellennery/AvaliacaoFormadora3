<?php
class LivroModel {
    private $idLivro;
    private $isbn;
    private $titulo;
    private $anoPublicacao;
    private $qtdeEstoque;
    private $valor;
    private EditoraModel $editora;
    /** @var AutorModel[] */
    private array $autores = [];


    public function __construct(?EditoraModel $editora = null, array $autores = [], $idLivro = "", $isbn = "", $titulo = "", $anoPublicacao = "", $qtdeEstoque = "", $valor = "") {
        $this->idLivro = $idLivro;
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->anoPublicacao = $anoPublicacao;
        $this->qtdeEstoque = $qtdeEstoque;
        $this->valor = $valor;
        $this->editora = $editora ?? new EditoraModel();
        $this->autores = $autores;
    }

    public function getIdLivro() { return $this->idLivro; }
    public function setIdLivro($idLivro) { $this->idLivro = $idLivro; }

    public function getIsbn() { return $this->isbn; }
    public function setIsbn($isbn) { $this->isbn = $isbn; }

    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }

    public function getAnoPublicacao() { return $this->anoPublicacao; }
    public function setAnoPublicacao($anoPublicacao) { $this->anoPublicacao = $anoPublicacao; }

    public function getQtdeEstoque() { return $this->qtdeEstoque; }
    public function setQtdeEstoque($qtdeEstoque) { $this->qtdeEstoque = $qtdeEstoque; }

    public function getValor() { return $this->valor; }
    public function setValor($valor) { $this->valor = $valor; }

    public function getEditora() { return $this->editora; }
    public function setEditora(EditoraModel $editora) { $this->editora = $editora; }

    public function getAutores() { return $this->autores; }
    public function setAutores(array $autores) { $this->autores = $autores; }

    //******** OPCIONAL */
    // public function setAutores(array $autores) {
    // foreach ($autores as $autor) {
    //     if (!$autor instanceof AutorModel) {
    //         throw new InvalidArgumentException("Todos os autores devem ser instâncias de AutorModel.");
    //     }
    // }
    // $this->autores = $autores;
    // }


    public function toArray() {
        return [
            'idLivro' => $this->idLivro,
            'isbn' => $this->isbn,
            'titulo' => $this->titulo,
            'anoPublicacao' => $this->anoPublicacao,
            'qtdeEstoque' => $this->qtdeEstoque,
            'valor' => $this->valor,
            'editora' => $this->editora ? $this->editora->toArray() : null,
            'autores' => array_map(function($autor) {
                            return $autor->toArray();
                        }, $this->autores ?? [])
        ];
    }
}
?>