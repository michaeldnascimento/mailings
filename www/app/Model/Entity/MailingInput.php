<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;
use \App\Model\Entity\Property\Input as ClassInput;

class MailingInput extends ClassInput {


    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'mailing_input'))->insert([
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
            'status_lista' => 1,
            'id_mailing' => $this->id_mailing,
            'nome_mailing' => $this->nome_mailing,
            'status_data_mailing' => $this->status_data_mailing,
            'status_obs_mailing' => $this->status_obs_mailing
        ]);

        //SUCESSO
        return true;
    }

        /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @param object $mailing
     * @param string $list
     * @param int $id_user
     * @return int|null
     */
    public function setMailingExisting(object $mailing, string $list, int $id_user): int
    {

        //INSERE A INSTANCIA NO BANCO
        $id = (new Database('db_mailings', 'mailing_input'))->insert([
            'tipo_mailing' => $mailing->tipo_mailing,
            'num_protocolo' => $mailing->num_protocolo,
            'num_pedido_proposta'  => $mailing->num_pedido_proposta,
            'contrato'  => $mailing->contrato,
            'data_venda' => $mailing->data_venda,
            'nome_cliente'  => $mailing->nome_cliente,
            'cpf'  => $mailing->cpf,
            'cod_hp' => $mailing->cod_hp,
            'endereco' => $mailing->endereco,
            'rua' => $mailing->rua,
            'cep' => $mailing->cep,
            'historico_hp' => $mailing->historico_hp,
            'num' => $mailing->num,
            'bairro' => $mailing->bairro,
            'cidade' => $mailing->cidade,
            'uf' => $mailing->uf,
            'motivo_pendencia_venda' => $mailing->motivo_pendencia_venda,
            'status_proposta' => $mailing->status_proposta,
            'canal_venda' => $mailing->canal_venda,
            'fone' => $mailing->fone,
            'fone1' => $mailing->fone1,
            'fone2' => $mailing->fone2,
            'email' => $mailing->email,
            'tipo_pessoa' => $mailing->tipo_pessoa,
            'rg' => $mailing->rg,
            'nome_mae' => $mailing->nome_mae,
            'base_cluster' => $mailing->base_cluster,
            'data_atendimento' => $mailing->data_atendimento,
            'motivo_cancelamento' => $mailing->motivo_cancelamento,
            'data_cancelamento' => $mailing->data_cancelamento,
            'data_instalado' => $mailing->data_instalado,
            'status_contrato' => $mailing->status_contrato,
            'data_status' => $mailing->data_status,
            'data_status_venda' => $mailing->data_status_venda,
            'obs' => $mailing->obs,
            'id_user' => $id_user,
            'lista' => $list,
            'status_lista' => 1
        ]);

        //SUCESSO
        return $id;
    }

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @param int|null $cpf
     * @param int|null $contrato
     * @param string $cidade
     * @param string $estado
     * @param string $list
     * @param int $id_user
     * @return int|null
     */
    public function setMailingNotExisting(int $cpf, int $contrato, string $cidade, string $estado, string $list, int $id_user): int
    {

        //INSERE A INSTANCIA NO BANCO
        $id = (new Database('db_mailings', 'mailing_input'))->insert([
            'contrato'  => $contrato,
            'cpf'  => $cpf,
            'cidade' => $cidade,
            'uf' => $estado,
            'id_user' => $id_user,
            'lista' => $list,
            'status_lista' => 2
        ]);

        //SUCESSO
        return $id;
    }

    /**
     * Método responsável por atualizar os dados no banco
     */
    public function atualizar(): bool
    {
        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('db_mailings', 'mailing_input'))->update('id = '. $this->id, [
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
        return (new Database('db_mailings', 'mailing_input'))->update('id_mailing = '.$id_mailing, [
            'status_lista' => $status_lista,
        ]);
    }

    /**
     * Método responsável por retornar a quantidade de mailing
     *
     * @param string $list
     * @return ClassInput|null
     */
    public static function getMailingQtd(string $list): ?ClassInput
    {
        return self::getMailingInput(
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
     * @return ClassInput|null
     */
    public static function getMailingQtdUser(string $list, int $id_user): ?ClassInput
    {
        return self::getMailingInput(
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
     */
    public static function getMailingByCpfContrato(string $cpf_contrato)
    {
        return self::getMailingInput(
            '*',
            '',
            'cpf = '. " '$cpf_contrato' " . 'OR contrato = '. " '$cpf_contrato' ",
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
        return self::getMailingInput(
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
        return self::getMailingInput(
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
        return self::getMailingInput(
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
    public static function getMailingInput(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'mailing_input'))->select($fields, $join, $where, $order, $group, $limit);
    }

}