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
    public ?string $nome = null;

    /*
     * Fone 1
     */
    public ?string $fone1 = null;

    /*
     * Fone 2
     */
    public ?string $fone2 = null;

    /*
    * Doc
    */
    public ?string $doc = null;

    /*
    * Endereco
    */
    public ?string $endereco = null;

    /*
    * Num
    */
    public ?string $num = null;

    /*
    * Compl
    */
    public ?string $compl = null;

    /*
    * Bairro
    */
    public ?string $bairro = null;

    /*
    * Cidade
    */
    public ?string $cidade = null;

    /*
    * Tipo
    */
    public ?string $tipo = null;

    /*
    * Obs
    */
    public ?string $obs = null;

    /*
    * Lista
    */
    public string $lista;

    /*
    * id do mailing salvo
    */
    public ?string $id_mailing = null;

    /*
    * qtd mailing salvo
    */
    public ?string $qtd = null;

    /*
    * id user sistema
    */
    public ?int $id_user = null;


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
        return (new Database('db_mailings', 'mailing'))->update('id = '. $this->id, [
            'nome' => $this->nome,
            'fone1' => $this->fone1,
            'fone2' => $this->fone2,
            'doc' => $this->doc,
            'endereco' => $this->endereco,
            'num' => $this->num,
            'compl' => $this->compl,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'tipo' => $this->tipo,
            'obs' => $this->obs,
            'lista' => $this->lista,
            'id_user' => $this->id_user
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
            'lista = '. " '$list' " . ' AND (id_user = "" OR id_user is null) ',
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
            'lista = '. " '$list' " . ' AND id_user = '. " '$id_user' " ,
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
            'lista = '. " '$list' AND (id_user = '' OR id_user IS NULL)",
            'id DESC',
            '1'
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar depoimentos
     */
    public static function getMailing(string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'mailing'))->select($fields, $join, $where, $order, $limit);
    }

}