<?php
class VendaModel {
    private $idVenda;
    private $dataVenda;
    private ClienteModel $cliente;
    private $formaPagto;
    private $itens; // array de ItemVendaLivro

    public function __construct() {
        $this->itens = [];
    }

    // public function __construct(int $idVenda, DateTime $dataVenda, string $formaPagto, ClienteModel $cliente) {
    //     $this->idVenda = $idVenda;
    //     $this->dataVenda = $dataVenda;
    //     $this->formaPagto = $formaPagto;
    //     $this->cliente = $cliente;
    // }

    // Getters e Setters
    public function getIdVenda(){ return $this->idVenda; }
    public function setIdVenda($idVenda){ $this->idVenda = $idVenda; }

    public function getDataVenda(){ return $this->dataVenda; }
    public function setDataVenda($dataVenda){ $this->dataVenda = $dataVenda; }

    public function getCliente(){ return $this->cliente; }
    public function setCliente(ClienteModel $cliente){ $this->cliente = $cliente; }

    public function getFormaPagto(){ return $this->formaPagto; }
    public function setFormaPagto($formaPagto){ $this->formaPagto = $formaPagto; }

    public function getItens(){ return $this->itens; }
    public function setItens($itens){ $this->itens = $itens; }

    // 🔹 Calcula o total da venda dinamicamente
    public function getValorTotal(){
        $total = 0;
        foreach ($this->itens as $item) {
            $total += $item->getTotalItem();
        }
        return $total;
    }

    public function toArray() {
        return [
            'idVenda' => $this->idVenda,
            'dataVenda' => $this->dataVenda,
            'formaPagto' => $this->formaPagto,
            'valorTotal' => $this->getValorTotal(), // calculado em tempo de execução
            'cliente' => $this->cliente ? $this->cliente->toArray() : null,
            'itens' => array_map(function($item) {
                return $item->toArray();
            }, $this->itens ?? [])
        ];
    }
}
?>
