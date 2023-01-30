<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;

class Call {

    /*
     * ID da CHAMADOS
     */
    public int $id;

    /*
    * Status Chamados
    */
    public string $status;

    /*
    * Assunto Chamado
    */
    public string $assunto;

    /*
    * Data hora Chamado
    */
    public string $datahora;

    /*
    * ID do responsavel por abrir o chamado
    */
    public int $id_abriu_chamado;

    /*
    * ID do responsavel que atendeu o chamado
    */
    public ?int $id_atendimento_chamado = null;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'chamados'))->insert([
             'assunto'  => $this->assunto,
             'status' => $this->status,
             'datahora' => $this->datahora,
             'id_abriu_chamado' => $this->id_abriu_chamado,
             'id_atendimento_chamado' => $this->id_atendimento_chamado
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
        return (new Database('db_mailings', 'chamados'))->update('id = '. $this->id, [
            'assunto'  => $this->assunto,
            'status' => $this->status,
            'datahora' => $this->datahora,
            'id_abriu_chamado' => $this->id_abriu_chamado,
            'id_atendimento_chamado' => $this->id_atendimento_chamado
        ]);
    }

    /**
     * Método responsável por excluir uma empresa do banco de dados
     * @return boolean
     */
    public function excluir(): bool
    {
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('company'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por verifica o nome da empresa
     *
     * @param string $id
     * @return false|mixed|object
     */
    public static function getCall()
    {
        return self::getCalled(
            '*',
            '',
            '',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar uma empresa com base no seu ID
     *
     * @param integer $id
     * @return Call|false|object|\stdClass|null
     */
    public static function getCallById(int $id)
    {
        return self::getCalled(
            '*, DATE_FORMAT(datahora, "%d/%m/%Y %Hh%i") as datahora',
              '',
            'id = '.$id,
             '',
              ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar depoimentos
     */
    public static function getCalled(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'chamados'))->select($fields, $join, $where, $order, $limit);
    }

}