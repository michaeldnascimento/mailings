<?php

require_once "db_config.php";

class CityModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getCityDataByCode($cityCode)
    {
        $sql = "SELECT cidade, uf, regiao, cluster FROM cod_cid_solar WHERE cod_cidade = :cityCode";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":cityCode", $cityCode);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            return array(
                'cidade' => "Cidade não encontrada!",
                'uf' => "",
                'regiao' => "",
                'cluster' => ""
            );
        }
    }

    public function getCityDataByName($cityName)
    {
        $sql = "SELECT cod_cidade, cidade, uf, regiao, cluster FROM cod_cid_solar WHERE cidade LIKE :cityName";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":cityName", "%{$cityName}%");
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            return array(
                'cod_cidade' => "Codigo não encontrado!",
                'cidade' => "",
                'uf' => "",
                'regiao' => "",
                'cluster' => ""
            );
        }
    }
}
?>





