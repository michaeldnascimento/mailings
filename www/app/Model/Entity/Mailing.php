<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;

class Mailing {

    /*
     * ID do Mailing
     */
    public int $id;

    /*
    * Nome
    */
    public string $nome;

    /*
     * Fone 1
     */
    public string $fone1;

    /*
     * Fone 2
     */
    public string $fone2;

    /*
    * Doc
    */
    public string $doc;

    /*
    * Endereco
    */
    public string $endereco;

    /*
    * Num
    */
    public string $num;

    /*
    * Compl
    */
    public string $compl;

    /*
    * Bairro
    */
    public string $bairro;

    /*
    * Cidade
    */
    public string $cidade;

    /*
    * Tipo
    */
    public string $tipo;

    /*
    * Obs
    */
    public string $obs;

    /*
    * Lista
    */
    public string $lista;

    /*
    * id do mailing salvo
    */
    public string $id_mailing;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'mailing'))->insert([
            'nome'  => $this->nome,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'doc'  => $this->doc,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'compl'  => $this->compl,
            'bairro' => $this->bairro,
            'tipo' => $this->tipo,
            'obs' => $this->obs,
            'lista' => $this->lista,
            'id_mailing' => $this->id_mailing
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
        return (new Database('db_mailings', 'user'))->update('id = '. $this->id, [
            'name'  => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'status' => $this->status,
            'nivel' => $this->nivel
        ]);
    }

    /**
     * Método responsável por excluir um usuário do banco de dados
     * @return boolean
     */
    public function excluir(): bool
    {
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('usuarios'))->delete('id = '.$this->id);
    }


    /**
     * Método responsável por retornar um usuário com base no seu ID
     *
     * @param integer $id
     * @return User
     */
    public static function getUserById(int $id): User
    {
        return self::getUsers(
            '*',
            '',
            'id = '.$id,
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsavel por retornar um usuário com base em seu e-mail
     * @param string $email
     * @return false|mixed|object
     */
    public static function getUserByEmail(string $email)
    {
        return self::getUsers(
            '*',
            '',
            'email = "'. $email.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar depoimentos
     */
    public static function getUsers(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'user'))->select($fields, $join, $where, $order, $limit);
    }

}