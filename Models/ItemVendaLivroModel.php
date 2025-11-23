<?php

class ItemVendaLivroModel {
    private LivroModel $livro;
    private VendaModel $venda;
    private $qtdeVendida;

    public function getLivro(){ return $this->livro; }
    public function setLivro(LivroModel $livro){ $this->livro = $livro; }
    
    public function getVenda(){ return $this->livro; }
    public function setVenda(VendaModel $venda){ $this->venda = $venda; }

    public function getQtdeVendida(){ return $this->qtdeVendida; }
    public function setQtdeVendida($qtdeVendida){ $this->qtdeVendida = $qtdeVendida; }

    public function getTotalItem(){
        return $this->qtdeVendida * $this->livro->getValor();
    }

    public function toArray() {
        return [
            'livro' => $this->livro ? $this->livro->toArray() : null,
            'qtdeVendida' => $this->qtdeVendida,
            'valorTotalItem' => $this->getTotalItem() // calculado
        ];
    }
}
?>
