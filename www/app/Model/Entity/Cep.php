<?php

namespace App\Model\Entity;

use \App\Db\Database;
use App\Http\Request;
use \PDO;
use PDOStatement;

class Cep {

    /*
     * CEP
     */
    public string $cep;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'files'))->insert([
            'path'  => $this->path,
            'date_created' => $this->date_created,
            'description' => $this->description,
            'id_company' => $this->id_company
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
        return (new Database('db_mailings', 'files'))->update('id = '. $this->id, [
            'path' => $this->path,
            'date_created' => $this->date_created,
            'description' => $this->description,
            'id_company' => $this->id_company
        ]);
    }

    /**
     * Método responsável por excluir uma empresa do banco de dados
     * @return boolean
     */
    public function excluir(): bool
    {
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('files'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por verifica os ceps Vip
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepVip(string $cep)
    {
        return self::getCep(
            'cep_vip',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps OI Sul
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepOISul(string $cep)
    {
        return self::getCep(
            'cep_oi_sul',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps OI
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepOISP(string $cep)
    {
        return self::getCep(
            'cep_oi_sp',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por verifica os ceps OI
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepOI(string $cep)
    {
        return self::getCep(
            'cep_oi',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps Algar
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepAlgar(string $cep)
    {
        return self::getCep(
            'cep_algar',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps Desktop
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepDesktop(string $cep)
    {
        return self::getCep(
            'cep_desktop',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps vivo nacional
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepVivoNacional(string $cep)
    {
        return self::getCep(
            'cep_vivo_nacional',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps vivo SP
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepVivoSP(string $cep)
    {
        return self::getCep(
            'cep_vivo_sp',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps Tim
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepTim(string $cep)
    {
        return self::getCep(
            'cep_tim',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps net nacional
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepNetNacional(string $cep)
    {
        return self::getCep(
            'cep_net_nacional',
            '*',
            '',
            'cep = "'. $cep.'"',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por verifica os ceps net cidades 11
     *
     * @param string $cep
     * @return false|mixed|object
     */
    public static function getCepNetCidades11(string $cep)
    {
        return self::getCep(
            'cep_net_cidades_11',
            '*',
            '',
            '(faixa_1 <= '. $cep.' AND faixa_2 >= '. $cep.')',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar depoimentos
     */
    public static function getCep(string $table, string $fields = null, string $join = null, string $where = null, string $order = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', $table))->select($fields, $join, $where, $order, $limit);
    }

}