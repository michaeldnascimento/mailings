<?php

namespace App\Model\Entity;

use \App\Db\Database;
use App\Model\Entity\Property\Net as ClassNet;
use \PDO;
use PDOStatement;

class MailingNet extends ClassNet {


    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'mailing_net'))->insert([
            'tipo_mailing' => $this->tipo_mailing,
            'num_protocolo' => $this->num_protocolo,
            'num_pedido_proposta'  => $this->num_pedido_proposta,
            'contrato'  => $this->contrato,
            'data_venda' => $this->data_venda,
            'nome_cliente'  => $this->nome_cliente,
            'cpf'  => $this->cpf,
            'cod_hp' => $this->cod_hp,
            'endereco' => $this->endereco,
            'rua' => $this->rua,
            'cep' => $this->cep,
            'historico_hp' => $this->historico_hp,
            'num' => $this->num,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
            'motivo_pendencia_venda' => $this->motivo_pendencia_venda,
            'status_proposta' => $this->status_proposta,
            'canal_venda' => $this->canal_venda,
            'fone' => $this->fone,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'email' => $this->email,
            'tipo_pessoa' => $this->tipo_pessoa,
            'rg' => $this->rg,
            'nome_mae' => $this->nome_mae,
            'base_cluster' => $this->base_cluster,
            'data_atendimento' => $this->data_atendimento,
            'motivo_cancelamento' => $this->motivo_cancelamento,
            'data_cancelamento' => $this->data_cancelamento,
            'data_instalado' => $this->data_instalado,
            'status_contrato' => $this->status_contrato,
            'data_status' => $this->data_status,
            'data_status_venda' => $this->data_status_venda,
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
        return (new Database('db_mailings', 'mailing_net'))->update('id = '. $this->id, [
            'nome_cliente' => $this->nome_cliente,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'email' => $this->email,
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
        return (new Database('db_mailings', 'mailing_net'))->update('id_mailing = '.$id_mailing, [
            'status_lista' => $status_lista,
        ]);
    }

    /**
     * Método responsável por retornar a quantidade de mailing
     *
     * @param string $list
     * @return ClassNet
     */
    public static function getMailingQtd(string $list): ?ClassNet
    {
        return self::getMailingNet(
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
     * @return ClassNet
     * @param int $id_user
     */
    public static function getMailingQtdUser(string $list, int $id_user): ?ClassNet
    {
        return self::getMailingNet(
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
        return self::getMailingNet(
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
        return self::getMailingNet(
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
        return self::getMailingNet(
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
        return self::getMailingNet(
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
    public static function getMailingNet(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'mailing_net'))->select($fields, $join, $where, $order, $group, $limit);
    }

}