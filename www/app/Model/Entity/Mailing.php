<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;
use \App\Model\Entity\Property\Mailing as ClassMailing;

class Mailing extends ClassMailing {


    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'mailing'))->insert([
            'ordens' => $this->ordens,
            'pendencia' => $this->pendencia,
            'nome'  => $this->nome,
            'status_spc'  => $this->status_spc,
            'doc' => $this->doc,
            'rg'  => $this->rg,
            'data_nasc'  => $this->data_nasc,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'email' => $this->email,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'compl'  => $this->compl,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'proposta' => $this->proposta,
            'hp' => $this->hp,
            'tipo' => $this->tipo,
            'criado_por' => $this->criado_por,
            'data_cad' => $this->data_cad,
            'plano' => $this->plano,
            'contrato' => $this->contrato,
            'status' => $this->status,
            'vendedor' => $this->vendedor,
            'mensalidade' => $this->mensalidade,
            'tipo_contrato' => $this->tipo_contrato,
            'n_protocolo' => $this->n_protocolo,
            'status_protocolo' => $this->status_protocolo,
            'data_protocolo' => $this->data_protocolo,
            'obs_protocolo' => $this->obs_protocolo,
            'obs' => $this->obs,
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
        return (new Database('db_mailings', 'mailing'))->update('id = '. $this->id, [
            'nome' => $this->nome,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'compl' => $this->compl,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'proposta' => $this->proposta,
            'email' => $this->email,
            'hp' => $this->hp,
            'tipo' => $this->tipo,
            'obs' => $this->obs,
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
        return (new Database('db_mailings', 'mailing'))->update('id_mailing = '.$id_mailing, [
            'status_lista' => $status_lista,
        ]);
    }

    /**
     * Método responsável por retornar a quantidade de mailing
     *
     * @param string $list
     * @return Mailing
     */
    public static function getMailingQtd(string $list): ?Mailing
    {
        return self::getMailing(
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
     * @return Mailing
     * @param int $id_user
     */
    public static function getMailingQtdUser(string $list, int $id_user): ?Mailing
    {
        return self::getMailing(
            'count(*) as qtd',
            '',
            'lista = '. " '$list' " . ' AND id_user = '. " '$id_user' AND (status_mailing IS NULL OR status_mailing = '')" ,
            '',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por consultar o mailing com base no seu DOC
     *
     * @param string $doc
     * @return false|mixed|object
     */
    public static function getMailingByDoc(string $doc)
    {
        return self::getMailing(
            '*',
            '',
            'doc = '. " '$doc' ",
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
        return self::getMailing(
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
        return self::getMailing(
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
        return self::getMailing(
            '*',
            '',
            'lista = '. " '$list' AND (id_user = '' OR id_user IS NULL AND status_lista = 1)",
            'id DESC',
            '',
            '1'
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar depoimentos
     */
    public static function getMailing(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'mailing'))->select($fields, $join, $where, $order, $group, $limit);
    }

}