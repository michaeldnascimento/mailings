<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;
use \App\Model\Entity\Property\Vero as ClassVero;

class MailingVero extends ClassVero {


    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'mailing_vero'))->insert([
            'cliente'  => $this->cliente,
            'id_cliente' => $this->id_cliente,
            'tipo_cliente' => $this->tipo_cliente,
            'cpf_cnpj' => $this->cpf_cnpj,
            'nascimento'  => $this->nascimento,
            'data_cadastro'  => $this->data_cadastro,
            'data_ultima_alteracao'  => $this->data_ultima_alteracao,
            'email' => $this->email,
            'rg'  => $this->rg,
            'mae'  => $this->mae,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'fone3' => $this->fone3,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'status' => $this->status,
            'contrato' => $this->contrato,
            'sublista' => $this->sublista,
            'lista' => $this->lista,
            'status_lista' => $this->status_lista,
            'id_mailing' => $this->id_mailing,
            'nome_mailing' => $this->nome_mailing,
            'status_data_mailing' => $this->status_data_mailing,
            'status_obs_mailing' => $this->status_obs_mailing
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
        return (new Database('db_mailings', 'mailing_vero'))->update('id = '. $this->id, [
            'cliente'  => $this->cliente,
            'id_cliente' => $this->id_cliente,
            'tipo_cliente' => $this->tipo_cliente,
            'cpf_cnpj' => $this->cpf_cnpj,
            'nascimento'  => $this->nascimento,
            'data_cadastro'  => $this->data_cadastro,
            'data_ultima_alteracao'  => $this->data_ultima_alteracao,
            'email' => $this->email,
            'rg'  => $this->rg,
            'mae'  => $this->mae,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'fone3' => $this->fone3,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'status' => $this->status,
            'contrato' => $this->contrato,
            'status_lista' => $this->status_lista,
            'id_mailing' => $this->id_mailing,
            'nome_mailing' => $this->nome_mailing,
            'sublista' => $this->sublista,
            'lista' => $this->lista,
            'id_user' => $this->id_user,
            'status_mailing' => $this->status_mailing,
            'status_obs_mailing' => $this->status_obs_mailing,
            'status_data_mailing' => $this->status_data_mailing,
            'datatime_follow' => $this->datatime_follow
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
     * Método responsável por retornar os status mailing com base no seu ID
     *
     * @param int $id_mailing
     * @param int $status_lista
     * @return bool|false
     */
    public static function setStatusMailingById(int $id_mailing, int $status_lista): bool
    {
        //ATUALIZA O STATUS MAILING NO BANCO DE DADOS
        return (new Database('db_mailings', 'mailing_vero'))->update('id_mailing = '.$id_mailing, [
            'status_lista' => $status_lista,
        ]);
    }

    /**
     * Método responsável por retornar a quantidade de mailing
     *
     * @param string $list
     * @return ClassVero|null
     */
    public static function getMailingQtd(string $list): ?ClassVero
    {
        return self::getMailingVero(
            'count(*) as qtd',
            '',
            'lista = '. " '$list' " . ' AND (id_user = "" OR id_user is null AND status_lista = 1)',
            '',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar a quantidade de mailing por usuário
     *
     * @param string $list
     * @param int $id_user
     * @return ClassVero|null
     */
    public static function getMailingQtdUser(string $list, int $id_user): ?ClassVero
    {
        return self::getMailingVero(
            'count(*) as qtd',
            '',
            'lista = '. " '$list' " . ' AND id_user = '. " '$id_user' AND (status_mailing IS NULL OR status_mailing = '')" ,
            '',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por consultar o mailing com base no seu cpf
     *
     * @param string $cpf
     * @return false|mixed|object
     */
    public static function getMailingByCpf(string $cpf)
    {
        return self::getMailingVero(
            '*',
            '',
            'cpf = '. " '$cpf' ",
            '',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar os mailing do usuário com base no seu ID
     *
     * @param string $list
     * @param int $id_user
     * @return false|mixed|object
     */
    public static function getMailingUserById(string $list, int $id_user)
    {
        return self::getMailingVero(
            '*',
            '',
            'lista = '. " '$list' " . ' AND id_user = '. " '$id_user' " ,
            '',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar os mailing com base no seu ID
     *
     * @param int $id
     * @return false|mixed|object
     */
    public static function getMailingById(int $id)
    {
        return self::getMailingVero(
            '*',
            '',
            'id = '. " '$id' " ,
            '',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar os mailing do usuário com base no seu ID
     *
     * @param string $list
     * @return false|mixed|object
     */
    public static function getNewMailing(string $list)
    {
        return self::getMailingVero(
            '*',
            '',
            'lista = '. " '$list' AND (id_user = '' OR id_user IS NULL AND status_lista = 1)",
            'id DESC',
            '',
            '1'
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar mailing
     */
    public static function getMailingVero(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'mailing_vero'))->select($fields, $join, $where, $order, $group, $limit);
    }

}