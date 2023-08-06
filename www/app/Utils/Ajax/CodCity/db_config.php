<?php

class Database
{

    private $conn;

    public function getConnection()
    {

         $host = "162.241.60.55:3306";
         $dbname = "gpagam04_db_mailings";
         $username = "gpagam04_general";
         $password = "DBgeneral@2021";

        try {
            $this->conn = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Conexão falhou: " . $e->getMessage());
        }

    }
}
?>
