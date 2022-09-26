<?php

namespace App\Model\Entity;

use \App\Db\Database;
use App\Http\Request;
use \PDO;
use PDOStatement;

class Client {

    /*
     * ID
     */
    public int $id;

    /*
    * Nome Cliente
    */
    public ?string $nome_cliente = null;

    /*
     * CPF/CNPJ
     */
    public string $cpf_cnpj;

    /*
    * Tipo cliente
    */
    public ?string $tipo_cliente = null;

    /*
    * Endereco
    */
    public ?string $endereco = null;

    /*
    * numero
    */
    public ?string $numero = null;

    /*
    * Complemento
    */
    public ?string $complemento = null;

    /*
    * CEP
    */
    public ?string $cep = null;

    /*
    * Tipo Edificação
    */
    public ?string $tipo_edificacao = null;

    /*
    * Bairro
    */
    public ?string $bairro = null;

    /*
    * Cidade
    */
    public ?string $cidade = null;

    /*
    * UF
    */
    public ?string $uf = null;

    /*
    * Codigo HP NET
    */
    public ?string $cod_hp = null;

    /*
    * Fone Fixo
    */
    public ?string $fone_fixo = null;

    /*
    * Fone celular
    */
    public ?string $fone_cel = null;

    /*
    * E-mail
    */
    public ?string $email = null;

    /*
    * ORIGEM
    */
    public ?string $origem = null;

    /*
    * Operadora Atual
    */
    public ?string $operadora_atual = null;

    /*
    * Codigo Contrato
    */
    public ?string $cod_contrato = null;

    /*
    * Data Higienização
    */
    public ?string $data_higienizacao = null;

    /*
    * tecnologia banda larga
    */
    public ?string $tec_banda_larga = null;

    /*
    * Correlacões adicionais
    */
    public ?string $correlacoes_adic = null;

    /*
    * Comentario
    */
    public ?string $comentario = null;


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
     * Método responsável por verifica os CPF e CNPJ
     *
     * @param string $cpf_cnpj
     * @return false|mixed|object
     */
    public static function getCpfCnpj(string $cpf_cnpj)
    {

        return self::getClient(
            '*',
            '',
            'cpf_cnpj = "'. $cpf_cnpj.'"',
            '',
            '',
            ''
        )->fetchObject(self::class);
    }


    /**
     * Método responsável por retornar clientes
     */
    public static function getClient(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
    {
        return (new Database('db_mailings', 'base_genio'))->select($fields, $join, $where, $order, $group, $limit);
    }

}