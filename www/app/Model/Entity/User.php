<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;

class User {

    /*
     * ID do Usuário
     */
    public int $id;

    /*
    * Número empresa
    */
    public string $company;

    /*
     * Nome do Usuário
     */
    public string $name;

    /*
     * E-mail do Usuário
     */
    public string $email;

    /*
    * Senha do Usuário
    */
    public string $password;

    /*
    * Status User
    */
    public string $status;

    /*
    * Status User CEP
    */
    public ?string $cep = null;

    /*
    * Status User CLIENTE
    */
    public ?string $client = null;

    /*
    * Status User CALLED
    */
    public ?string $call_client = null;

    /*
    * Nivel User
    */
    public string $nivel;

    /*
    * ID Companies
    */
    public ?int $companies = null;

    /*
    * Lists Input
    */
    public ?string $input = null;

    /*
    * Lists Algar
    */
    public ?string $algar = null;

    /*
    * Lists Net
    */
    public ?string $net = null;

    /*
    * Lists Net
    */
    public ?string $claro = null;

    /*
    * Lists Net
    */
    public ?string $americanet = null;

    /*
    * Lists Net
    */
    public ?string $vero = null;

    /*
    * Lists Desktop GET
    */
    public ?string $desktop_get = null;

    /*
    * Lists Desktop SIS
    */
    public ?string $desktop_sis = null;

    /*
    * Lists Desktop NET BARRETOS
    */
    public ?string $desktop_netbarretos = null;



    /**
     * Método responsável por cadastrar a instancia atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'user'))->insert([
            'company'  => $this->company,
            'name' => $this->name,
            'email' => $this->email,
            'password'  => $this->password,
            'status' => $this->status,
            'cep' => $this->cep,
            'client' => $this->client,
            'call_client' => $this->call_client,
            'nivel' => $this->nivel,
            'companies' => $this->companies,
            'input' => $this->input,
            'algar' => $this->algar,
            'net' => $this->net,
            'claro' => $this->claro,
            'americanet' => $this->americanet,
            'vero' => $this->vero,
            'desktop_get' => $this->desktop_get,
            'desktop_sis' => $this->desktop_sis,
            'desktop_netbarretos' => $this->desktop_netbarretos
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
            'password'  => $this->password,
            'company' => $this->company,
            'status' => $this->status,
            'cep' => $this->cep,
            'client' => $this->client,
            'call_client' => $this->call_client,
            'nivel' => $this->nivel,
            'companies' => $this->companies,
            'input' => $this->input,
            'algar' => $this->algar,
            'net' => $this->net,
            'claro' => $this->claro,
            'americanet' => $this->americanet,
            'vero' => $this->vero,
            'desktop_get' => $this->desktop_get,
            'desktop_sis' => $this->desktop_sis,
            'desktop_netbarretos' => $this->desktop_netbarretos
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
     * Método responsável por retornar o nome usuário com base no seu ID 
     *
     * @param integer $id
     * @return User
     */
    public static function getUserByIdReturnName(int $id): User
    {
        return self::getUsers(
            'name, email',
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