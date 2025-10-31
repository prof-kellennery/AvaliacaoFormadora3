<?php
class App{

  public function __construct()
  {
    $this->inicio();
  }

  function inicio()
  {
     $parametros = array();
    if (isset($_GET['pagina']))
    {
      $rota = $_GET['pagina'];
    }

    if (!empty($rota))
    {
      $rota = explode('/', $rota);
      $controle = $rota[0].'Controller';
      array_shift($rota);

      if (isset($rota[0]) && !empty($rota[0]))
      {
        $metodo = $rota[0];
        array_shift($rota);
      }else
      {
        $metodo = 'index';
      }

      if (count($rota) > 0)
      {
        $parametros = $rota;
      }

    }else
    {
      $controle = 'DashboardController';
      $metodo = 'index';
    }

    $caminho = 'AvaliacaoFormadora3/Controllers/'.$controle.'php';
    if (!file_exists($caminho) && !method_exists($controle, $metodo))
    {
      $controle = 'ErroController';
      $metodo = 'index';
    }

    $objControle = new $controle;

    call_user_func_array(array($objControle, $metodo), $parametros);

  }

}
?>