<?php

namespace App\Model\Entity\Property;


class Vero
{

    /*
    * ID do Mailing
    */
    public int $id;

    /*
    * Nome
    */
    public ?string $cliente = null;

    /*
    * Doc
    */
    public string $cpf_cnpj;

    /*
    * DATA Nasc
    */
    public ?string $nascimento = null;

    /*
    * DATA Cadastro
    */
    public ?string $data_cadastro = null;

    /*
    * DATA Ulta Alteração
    */
    public ?string $data_ultima_alteracao = null;

    /*
    * Email
    */
    public ?string $email = null;

    /*
    * RG
    */
    public ?string $rg = null;

    /*
    * RG
    */
    public ?string $mae = null;


    /*
    * Fone 1
    */
    public ?string $fone1 = null;

    /*
    * Fone 2
    */
    public ?string $fone2 = null;

    /*
    * Fone 3
    */
    public ?string $fone3 = null;

    /*
    * CEP
    */
    public ?string $cep = null;

    /*
    * Endereco
    */
    public ?string $endereco = null;

    /*
    * Endereco número
    */
    public ?string $num = null;

    /*
    * Endereço complemento
    */
    public ?string $complemento = null;

    /*
    * Bairro
    */
    public ?string $bairro = null;

    /*
    * Cidade
    */
    public ?string $cidade = null;

    /*
    * Estado
    */
    public ?string $estado = null;

    /*
    * qtd mailing salvo
    */
    public ?string $qtd = null;

    /*
    * id user sistema
    */
    public ?int $id_user = null;

    /*
    * Status
    */
    public ?string $status = null;

    /*
    * plano
    */
    public ?string $contrato = null;

    /*
    * Pacote
    */
    public ?string $pacote = null;

    /*
    * Data e hora follow mailing
    */
    public ?string $datatime_follow = null;

    /*
    * Data e hora follow mailing
    */
    public ?string $sublista = null;

    /*
    * Lista
    */
    public string $lista;

    /**
     * Status lista
     */
    public ?int $status_lista = null;

    /*
    * id do mailing salvo
    */
    public ?int $id_mailing = null;

    /*
    * Nome mailing
    */
    public ?string $nome_mailing = null;

    /*
    * status do mailing
    */
    public ?string $status_mailing = null;

    /*
    * Data Status mailing
    */
    public ?string $status_data_mailing = null;

    /*
    * observação do mailing
    */
    public ?string $status_obs_mailing = null;

}