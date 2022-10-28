<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;
use \App\Model\Entity\Property\Desktop2 as ClassDesktop2;

class MailingDesktop2 extends ClassDesktop2 {


    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'mailing_desktop2'))->insert([
            'cliente'  => $this->cliente,
            'cpf_cnpj' => $this->cpf_cnpj,
            'rg'  => $this->rg,
            'nascimento'  => $this->nascimento,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'fone3' => $this->fone3,
            'email' => $this->email,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'contrato' => $this->contrato,
            'status' => $this->status,
            'subStatus' => $this->subStatus,
            'observacao' => $this->observacao,
            'produto' => $this->produto,
            'ultimaOC' => $this->ultimaOC,
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
        return (new Database('db_mailings', 'mailing_desktop2'))->update('id = '. $this->id, [
            'cliente'  => $this->cliente,
            'cpf_cnpj' => $this->cpf_cnpj,
            'rg'  => $this->rg,
            'nascimento'  => $this->nascimento,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'fone3' => $this->fone3,
            'email' => $this->email,
            'cep' => $this->cep,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'contrato' => $this->contrato,
            'status' => $this->status,
            'subStatus' => $this->subStatus,
            'observacao' => $this->observacao,
            'produto' => $this->produto,
            'ultimaOC' => $this->ultimaOC,
            'status_lista' => $this->status_lista,
            'id_mailing' => $this->id_mailing,
            'nome_mailing' => $this->nome_mailing,
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
        return (new Database('db_mailings', 'mailing_desktop'))->update('id_mailing = '.$id_mailing, [
            'status_lista' => $status_lista,
        ]);
    }

    /**
     * Método responsável por retornar a quantidade de mailing
     *
     * @param string $list
     * @return ClassDesktop
     */
    public static function getMailingQtd(string $list): ?ClassDesktop2
    {
        return self::getMailingDesktop(
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
     * @return ClassDesktop
     * @param int $id_user
     */
    public static function getMailingQtdUser(string $list, int $id_user): ?ClassDesktop2
    {
        return self::getMailingDesktop(
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
     * @param string $cpf_cnpj
     * @return false|mixed|object
     */
    public static function getMailingByCpf(string $cpf_cnpj)
    {
        return self::getMailingDesktop(
            '*',
            '',
            'cpf_cnpj = '. " '$cpf_cnpj' ",
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
        return self::getMailingDesktop(
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
        return self::getMailingDesktop(
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
        return self::getMailingDesktop(
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
    public static function getMailingDesktop(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'mailing_desktop2'))->select($fields, $join, $where, $order, $group, $limit);
    }

}