<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOException;
use PDOStatement;

class Recover {

    /**
     * ID do Usuário
     * @var integer
     */
    public int $id;

    /**
     * E-mail do Usuário
     */
    public ?string $login = null;

    /**
     * Token do Usuário
     */
    public ?string $token = null;

    /**
     * Data Solicitacão
     */
    public ?string $date_recover = null;


    /**
     * Data Atualizacão solicitação
     */
    public ?string $date_update = null;


    /**
     * Status Solicitação
     */
    public ?int $status = null;

    /**
     * Método responsável por cadastrar a instancia atual no banco de dados
     * @return bool
     */
    public function cadastrar()
    {

        $this->date_recover = date('Y-m-d H:i:s');

        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'recover'))->insert([
            'login' => $this->login,
            'token' => $this->token,
            'date_recover' => $this->date_recover,
            'status' => 1
        ]);

        //echo $this->id;
        //exit;

        //SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar os dados no banco
     * @return bool
     */
    public function atualizar()
    {

        $this->date_update = date('Y-m-d H:i:s');

        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('db_mailings', 'recover'))->update('id = '. $this->id, [
            'login'  => $this->login,
            'token' => $this->token,
            'status' => $this->status,
            'date_update' => $this->date_update
        ]);
    }

    /**
     * Método responsável por excluir um usuário do banco de dados
     * @return boolean
     */
    public function excluir()
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
    public static function getUserById($id)
    {
        return self::getUsers('id = '.$id)->fetchObject(self::class);
    }




    /**
     * Método responsavel por consultar se o token está valido
     * @param string $token
     * @return false|mixed|object
     */
    public static function tokenValidation(string $token)
    {
        return self::getRecover(
            '*',
             '',
            'token = "'. $token.'" AND status = 1',
            '',
             ''
        )->fetchObject(self::class);
        //return (new Database('usuarios'))->select('email = "'. $email.'"')->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar
     */
    public static function getRecover(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'recover'))->select($fields, $join, $where, $order, $limit);
    }

}