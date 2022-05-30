<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;

class Files {

    /*
     * ID da Arquivo
     */
    public int $id;

    /*
    * Caminho arquivo
    */
    public string $path;

    /*
    * Descricao arquivos
    */
    public string $description;

    /*
    * Caminho arquivo
    */
    public string $date_created;

    /*
    * ID Empresa
    */
    public int $id_company;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'files'))->insert([
            'path'  => $this->path,
            'date_created' => $this->date_created,
            'description' => $this->description,
            'id_company' => $this->id_company
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
        return (new Database('db_mailings', 'files'))->update('id = '. $this->id, [
            'path' => $this->path,
            'date_created' => $this->date_created,
            'description' => $this->description,
            'id_company' => $this->id_company
        ]);
    }

    /**
     * Método responsável por excluir uma empresa do banco de dados
     * @return boolean
     */
    public function excluir(): bool
    {
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('files'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por verifica buscar arquivos por empresa
     *
     * @param string $company
     * @return false|mixed|object
     */
    public static function getFilesByIdCompany(string $company)
    {
        return self::getFiles(
            '*',
            '',
            'id_company = '.$company,
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar depoimentos
     */
    public static function getFiles(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'files'))->select($fields, $join, $where, $order, $limit);
    }

}