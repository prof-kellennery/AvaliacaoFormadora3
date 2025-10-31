<?php
class Controller {

public $dados;

public function __construct()
{
    $this->dados = array();
}

public function carregarEstrutura($nomeView, $dados = array()){
    $this->dados = $dados;
    require_once 'Views/EstruturaView.php';
}

public function carregarViewEstrutura($nomeView, $dados = array()){
    require_once 'Views/' . $nomeView . '.php';
}

}



?>