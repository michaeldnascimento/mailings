<?php

require_once "city_controller.php";
require_once "db_config.php";

$cityController = new CityController();

if (isset($_GET['cityCode'])) {
    $cityCode = $_GET['cityCode'];
    $result = $cityController->getCityDataByCode($cityCode);
    echo json_encode($result);
}

if (isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];
    $result = $cityController->getCityDataByName($searchQuery);
    echo json_encode($result);
}



