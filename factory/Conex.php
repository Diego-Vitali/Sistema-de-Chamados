<?php
class Conex {
    private static $user = "root";
    private static $senha = "";
    public static $connect = null;

    private static function Conectar() {
        try {
            if (self::$connect == null) {
                self::$connect = new PDO(
                    'mysql:host=localhost;port=3306;dbname=dbChamados',
                    self::$user,
                    self::$senha
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
