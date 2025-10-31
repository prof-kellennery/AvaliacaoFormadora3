<?php

class Conexao{
    private static $instancia;
    
    private function __construct(){}
    
    public static function getConexao()
    {
        if (!isset(self::$instancia))
        {
            $dbname = 'bd_distribuidora';
            $host = 'localhost';
            $user = 'root';
            $senha = '';
            // fazer a conexão do banco de dados
            try {
                self::$instancia = new PDO('mysql:dbname=' . $dbname . '; host=' . $host, $user, $senha);
            } catch (Exception $e) {
                echo 'O erro é: ' . $e;
            }
        }
        return self::$instancia;
    }
}


?>