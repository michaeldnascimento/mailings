<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;

class CallActivity {

    /*
     * ID atividade
     */

    public int $id;

    /*
     * ID da CHAMADOS
     */
    public int $id_chamado;

    /*
    * Descrição Chamado
    */
    public string $descricao;

    /*
    * Data hora Chamado
    */
    public string $datahora;

    /*
    * Anexo Chamado
    */
    public ?string $anexo = null;

    /*
    * Id usuário chamado
    */
    public int $id_user;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'chamados_atividades'))->insert([
             'id_chamado'  => $this->id_chamado,
             'descricao' => $this->descricao,
             'datahora' => $this->datahora,
             'anexo' => $this->anexo,
             'id_user' => $this->id_user
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
        return (new Database('db_mailings', 'chamados_atividades'))->update('id = '. $this->id, [
            'id_chamado'  => $this->id_chamado,
            'descricao' => $this->descricao,
            'datahora' => $this->datahora,
            'anexo' => $this->anexo,
            'id_user' => $this->id_user
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
     * @return false|mixed|object
     */
    public static function getCall()
    {
        return self::getCalledActivity(
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
     * @return CallActivity
     */
    public static function getCallActivityById(int $id): CallActivity
    {
        return self::getCalledActivity(
            '*',
              '',
            'id_chamado = '.$id,
             '',
              ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar depoimentos
     */
    public static function getCalledActivity(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'chamados_atividades'))->select($fields, $join, $where, $order, $limit);
    }

}