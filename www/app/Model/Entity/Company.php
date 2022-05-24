<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;

class Company {

    /*
     * ID da EMPRESA
     */
    public int $id;

    /*
    * Nome empresa
    */
    public string $company;

    /*
    * Status User
    */
    public string $status;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'company'))->insert([
            'company'  => $this->company,
            'status' => $this->status
        ]);

        //SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar os dados no banco
     */
    public function atualizar(): bool
    {
        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('db_mailings', 'company'))->update('id = '. $this->id, [
            'company' => $this->company,
            'status' => $this->status
        ]);
    }

    /**
     * Método responsável por excluir uma empresa do banco de dados
     * @return boolean
     */
    public function excluir(): bool
    {
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('company'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por verifica o nome da empresa
     *
     * @param string $name
     * @return false|mixed|object
     */
    public static function getCompanyName(string $name)
    {
        return self::getCompanies(
            '*',
            '',
            'company = "'. $name.'"',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar uma empresa com base no seu ID
     *
     * @param integer $id
     * @return Company
     */
    public static function getCompanyById(int $id): Company
    {
        return self::getCompanies(
            '*',
              '',
            'id = '.$id,
             '',
              ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar depoimentos
     */
    public static function getCompanies(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'company'))->select($fields, $join, $where, $order, $limit);
    }

}