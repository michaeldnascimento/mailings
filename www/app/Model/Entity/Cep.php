<?php

namespace App\Model\Entity;

use \App\Db\Database;
use App\Http\Request;
use \PDO;
use PDOStatement;

class Cep {

    /*
     * CEP
     */
    public string $cep;

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
     * Método responsável por verifica os ceps net
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepNetNacional(string $cep)
    {
        return self::getCepNet(
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar depoimentos
     */
    public static function getCepNet(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'cep_net_nacional'))->select($fields, $join, $where, $order, $limit);
    }

}