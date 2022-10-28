<?php

namespace App\Model\Entity\Property;


class Desktop2
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
    * RG
    */
    public ?string $rg = null;

    /*
    * DATA Nasc
    */
    public ?string $nascimento = null;

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
    * Email
    */
    public ?string $email = null;

    /*
    * CEP
    */
    public ?string $cep = null;

    /*
    * Endereco
    */
    public ?string $endereco = null;

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
    * plano
    */
    public ?string $contrato = null;

    /*
    * Status
    */
    public ?string $status = null;

    /*
    * subStatus
    */
    public ?string $subStatus = null;

    /*
    * observacao
    */
    public ?string $observacao = null;

    /*
    * produto
    */
    public ?string $produto = null;

    /*
    * ultimaOC
    */
    public ?string $ultimaOC = null;

    /*
    * Data e hora follow mailing
    */
    public ?string $datatime_follow = null;

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