<?php 

class Conex {
    private static $user = "root"; // Changed to static
    private static $senha = "";   // Changed to static
    public static $connect = null;

    private static function Conectar() {
        try {
            if (self::$connect == null) {
                self::$connect = new PDO(
                    'mysql:host=localhost;dbname=dbChamados;',
                    self::$user, // Accessing static properties
                    self::$senha // Accessing static properties
                );                  
            }
        } catch (PDOException $ex) {
            echo '<strong>Erro durante Conexão com Banco: ' . $ex->getMessage() . '</br>';
            die;
        }
        return self::$connect;
    }

    public function getConn() {
        return self::Conectar(); 
    }
}
?>