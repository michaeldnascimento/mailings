<?php
class ClassConect
{
    public function conectaDB()
    {

        try{
            return $con=new \PDO("mysql:host=162.241.60.55:3306;dbname=gpagam04_db_mailings","gpagam04_general","DBgeneral@2021");
        }catch (\PDOException $erro){
            return $erro->getMessage();
        }
    }
}