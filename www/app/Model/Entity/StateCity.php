<?php

namespace App\Model\Entity;

use \App\Db\Database;
use App\Http\Request;
use \PDO;
use PDOStatement;

class StateCity {

    /*
     * Estado
     */
    public int $state;

    /*
     * CIDADE
     */
    public int $city;

    /**
     * Método responsável por verifica cidades
     *
     * @param int $city
     * @return false|mixed|object
     */
    public static function getCity(int $city)
    {
        return self::getStateCity(
            'cidades',
            '*',
            '',
            'id = "'. $city.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica estado
     *
     * @param int $state
     * @return false|mixed|object
     */
    public static function getState(int $state)
    {
        return self::getStateCity(
            'estados',
            '*',
            '',
            'id = "'. $state.'"',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar Cidade ou estado
     */
    public static function getStateCity(string $table, string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', $table))->select($fields, $join, $where, $order, $limit);
    }

}