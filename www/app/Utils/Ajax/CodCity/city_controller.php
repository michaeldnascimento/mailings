<?php

require_once "city_model.php";

class CityController
{
    private $model;

    public function __construct()
    {
        $this->model = new CityModel();
    }

    public function getCityDataByCode($cityCode)
    {
        return $this->model->getCityDataByCode($cityCode);
    }

    public function getCityDataByName($cityName)
    {
        return $this->model->getCityDataByName($cityName);
    }
}





