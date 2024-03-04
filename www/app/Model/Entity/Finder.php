<?php

namespace App\Model\Entity;

use \App\Db\Database;
use \PDO;
use PDOStatement;
use DateTime;
use \App\Model\Entity\Property\Finder as ClassFinder;

class Finder extends ClassFinder {

    private function convertToAmericanDateFormat(string $date): string
    {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);
        if ($dateTime !== false) {
            return $dateTime->format('Y-m-d');
        }
        return $date; // Manter o valor original em caso de erro de formatação
    }

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar():bool
    {

        // Convertendo as datas para o formato americano (YYYY-MM-DD)
        $this->nascimento_abertura = $this->convertToAmericanDateFormat($this->nascimento_abertura);


        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('db_mailings', 'finder'))->insert([
            'cpf_cnpj' => $this->cpf_cnpj,
            'nome_razao_social' => $this->nome_razao_social,
            'tipo_pessoa'  => $this->tipo_pessoa,
            'nascimento_abertura'  => $this->nascimento_abertura,
            'mae_nome_fantasia' => $this->mae_nome_fantasia,
            'email'  => $this->email,
            'telefone_1'  => $this->telefone_1,
            'telefone_2' => $this->telefone_2,
            'telefone_3' => $this->telefone_3,
            'telefone_4' => $this->telefone_4,
            'telefone_5' => $this->telefone_5,
            'telefone_6' => $this->telefone_6,
            'endereco_1' => $this->endereco_1,
            'endereco_2' => $this->endereco_2,
            'parente_1' => $this->parente_1,
            'parente_2' => $this->parente_2,
            'parente_3' => $this->parente_3,
            'parente_4' => $this->parente_4,
            'parente_5' => $this->parente_5,
            'parente_6' => $this->parente_6,
            'cpf_cnpj_socio_1' => $this->cpf_cnpj_socio_1,
            'cpf_cnpj_socio_2' => $this->cpf_cnpj_socio_2,
            'cpf_cnpj_socio_3' => $this->cpf_cnpj_socio_3,
            'cpf_cnpj_socio_4' => $this->cpf_cnpj_socio_4,
            'cpf_cnpj_socio_5' => $this->cpf_cnpj_socio_5,
            'cpf_cnpj_socio_6' => $this->cpf_cnpj_socio_6,
            'socio_sociedades_1' => $this->socio_sociedades_1,
            'socio_sociedades_2' => $this->socio_sociedades_2,
            'socio_sociedades_3' => $this->socio_sociedades_3,
            'socio_sociedades_4' => $this->socio_sociedades_4,
            'socio_sociedades_5' => $this->socio_sociedades_5,
            'socio_sociedades_6' => $this->socio_sociedades_6,
            'situacao_cadastral_empresa' => $this->situacao_cadastral_empresa,
            'porte_empresa' => $this->porte_empresa,
            'origem' => $this->origem,
            'status' => $this->status,
            'lista' => $this->lista,
            'id_user' => $this->id_user,
            'id_team' => $this->id_team,
            'atualizado' => $this->atualizado
        ]);

        //SUCESSO
        return true;
    }

        /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @param object $finder
     * @param string $list
     * @param int $id_user
     * @param int $id_team
     * @return int|null
     */
    public static function setFinderExisting(object $finder, string $list, int $id_user, int $id_team): int
    {

        //INSERE A INSTANCIA NO BANCO
        $id = (new Database('db_mailings', 'finder'))->insert([
            'cpf_cnpj' => $finder->cpf_cnpj,
            'nome_razao_social' => $finder->nome_razao_social,
            'tipo_pessoa'  => $finder->tipo_pessoa,
            'nascimento_abertura'  => $finder->nascimento_abertura,
            'mae_nome_fantasia' => $finder->mae_nome_fantasia,
            'email'  => $finder->email,
            'telefone_1'  => $finder->telefone_1,
            'telefone_2' => $finder->telefone_2,
            'telefone_3' => $finder->telefone_3,
            'telefone_4' => $finder->telefone_4,
            'telefone_5' => $finder->telefone_5,
            'telefone_6' => $finder->telefone_6,
            'endereco_1' => $finder->endereco_1,
            'endereco_2' => $finder->endereco_2,
            'parente_1' => $finder->parente_1,
            'parente_2' => $finder->parente_2,
            'parente_3' => $finder->parente_3,
            'parente_4' => $finder->parente_4,
            'parente_5' => $finder->parente_5,
            'parente_6' => $finder->parente_6,
            'cpf_cnpj_socio_1' => $finder->cpf_cnpj_socio_1,
            'cpf_cnpj_socio_2' => $finder->cpf_cnpj_socio_2,
            'cpf_cnpj_socio_3' => $finder->cpf_cnpj_socio_3,
            'cpf_cnpj_socio_4' => $finder->cpf_cnpj_socio_4,
            'cpf_cnpj_socio_5' => $finder->cpf_cnpj_socio_5,
            'cpf_cnpj_socio_6' => $finder->cpf_cnpj_socio_6,
            'socio_sociedades_1' => $finder->socio_sociedades_1,
            'socio_sociedades_2' => $finder->socio_sociedades_2,
            'socio_sociedades_3' => $finder->socio_sociedades_3,
            'socio_sociedades_4' => $finder->socio_sociedades_4,
            'socio_sociedades_5' => $finder->socio_sociedades_5,
            'socio_sociedades_6' => $finder->socio_sociedades_6,
            'situacao_cadastral_empresa' => $finder->situacao_cadastral_empresa,
            'porte_empresa' => $finder->porte_empresa,
            'origem' => $finder->origem,
            'status' => 2,
            'lista' => $list,
            'id_user' => $id_user,
            'id_team' => $id_team,
            'atualizado' => $finder->atualizado
        ]);

        //SUCESSO
        return $id;
    }

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @param string|null $cpf_cnpj
     * @param string $list
     * @param int $id_user
     * @param int $id_team
     * @return int|null
     */
    public static function setFinderNotExisting($cpf_cnpj, string $list, int $id_user, int $id_team): int
    {

        //INSERE A INSTANCIA NO BANCO
        return (new Database('db_mailings', 'finder'))->insert([
            'cpf_cnpj'  => $cpf_cnpj,
            'lista' => $list,
            'id_user' => $id_user,
            'id_team' => $id_team,
            'status' => 2
        ]);

    }

    /**
     * Método responsável por atualizar os dados no banco
     */
    public function atualizar(): bool
    {
        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('db_mailings', 'finder'))->update('id = '. $this->id, [
            'cpf_cnpj' => $this->cpf_cnpj,
            'nome_razao_social' => $this->nome_razao_social,
            'tipo_pessoa'  => $this->tipo_pessoa,
            'nascimento_abertura'  => $this->nascimento_abertura,
            'mae_nome_fantasia' => $this->mae_nome_fantasia,
            'email'  => $this->email,
            'telefone_1'  => $this->telefone_1,
            'telefone_2' => $this->telefone_2,
            'telefone_3' => $this->telefone_3,
            'telefone_4' => $this->telefone_4,
            'telefone_5' => $this->telefone_5,
            'telefone_6' => $this->telefone_6,
            'endereco_1' => $this->endereco_1,
            'endereco_2' => $this->endereco_2,
            'parente_1' => $this->parente_1,
            'parente_2' => $this->parente_2,
            'parente_3' => $this->parente_3,
            'parente_4' => $this->parente_4,
            'parente_5' => $this->parente_5,
            'parente_6' => $this->parente_6,
            'cpf_cnpj_socio_1' => $this->cpf_cnpj_socio_1,
            'cpf_cnpj_socio_2' => $this->cpf_cnpj_socio_2,
            'cpf_cnpj_socio_3' => $this->cpf_cnpj_socio_3,
            'cpf_cnpj_socio_4' => $this->cpf_cnpj_socio_4,
            'cpf_cnpj_socio_5' => $this->cpf_cnpj_socio_5,
            'cpf_cnpj_socio_6' => $this->cpf_cnpj_socio_6,
            'socio_sociedades_1' => $this->socio_sociedades_1,
            'socio_sociedades_2' => $this->socio_sociedades_2,
            'socio_sociedades_3' => $this->socio_sociedades_3,
            'socio_sociedades_4' => $this->socio_sociedades_4,
            'socio_sociedades_5' => $this->socio_sociedades_5,
            'socio_sociedades_6' => $this->socio_sociedades_6,
            'situacao_cadastral_empresa' => $this->situacao_cadastral_empresa,
            'porte_empresa' => $this->porte_empresa,
            'origem' => $this->origem,
            'status' => $this->status,
            'lista' => $this->lista,
            'atualizado' => $this->atualizado
        ]);
    }


    /**
     * Método responsável por retornar os status mailing com base no seu ID
     *
     * @param int $id
     * @param int $status
     * @return bool|false
     */
    public static function setStatusFinderById(int $id, int $status): bool
    {
        //ATUALIZA O STATUS MAILING NO BANCO DE DADOS
        return (new Database('db_mailings', 'finder'))->update('id_mailing = '.$id, [
            'status' => $status,
        ]);
    }

    /**
     * Método responsável por retornar a quantidade de mailing
     *
     * @param string $list
     * @return ClassFinder|null
     */
    public static function getFinderQtd(string $list): ?ClassFinder
    {
        return self::getFinderInput(
            'count(*) as qtd',
            '',
            'lista = '. " '$list' " . ' AND (id_user = "" OR id_user is null AND status = 1)',
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
     * @return ClassFinder|null
     */
    public static function getFinderQtdUser(string $list, int $id_user): ?ClassFinder
    {
        return self::getFinderInput(
            'count(*) as qtd',
            '',
            'lista = '. " '$list' " . ' AND id_user = '. " '$id_user' AND (status = 1 OR status = 2)" ,
            '',
            '',
            ''
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por consultar o mailing com base no seu cpf
     *
     * @param string $cpf_cnpj
     * @return Finder|false|object|\stdClass|null
     */
    public static function getFinderByCpfCnpj(string $cpf_cnpj)
    {
        return self::getFinderInput(
            '*',
            '',
            'cpf_cnpj = '. " '$cpf_cnpj' " . 'OR cpf_cnpj_socio_1 = '. " '$cpf_cnpj' ",
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
        return self::getFinderInput(
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
    public static function getInputById(int $id)
    {
        return self::getFinderInput(
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
    public static function getNewFinder(string $list)
    {
        return self::getFinderInput(
            '*',
            '',
            'lista = '. " '$list' AND (id_user = '' OR id_user IS NULL AND status = 1)",
            'id DESC',
            '',
            '1'
        )->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar mailing
     */
    public static function getFinderInput(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'finder'))->select($fields, $join, $where, $order, $group, $limit);
    }

}