<?php
// Função do php para carregar uma classe de outro arquivo quando necessário. 
// Toda vez que for instanciado um objeto, por exemplo.
spl_autoload_register(function($nome_arquivo)
{  
    if(file_exists('Controllers/'.$nome_arquivo.'.php'))
    {
        require 'Controllers/'.$nome_arquivo.'.php';
    }elseif (file_exists('core/'.$nome_arquivo.'.php'))
    {
        require 'core/'.$nome_arquivo.'.php';
    }elseif (file_exists('models/'.$nome_arquivo.'.php'))
    {
        require 'Models/'.$nome_arquivo.'.php';
    }elseif (file_exists('DAO/'.$nome_arquivo.'.php'))
    {
        require 'DAO/'.$nome_arquivo.'.php';
    }
});


?>