<?php

namespace App\Model\Entity\Property;


class Desktop
{

    /*
    * ID do Mailing
    */
    public int $id;

    /*
    * ordens
    */
    public ?string $ordens = null;

    /*
    * pendencia
    */
    public ?string $pendencia = null;

    /*
    * Nome
    */
    public ?string $cliente = null;

    /*
    * status_spc
    */
    public ?string $status_spc = null;

    /*
    * Doc
    */
    public string $cpf;

    /*
    * RG
    */
    public ?string $rg = null;

    /*
    * DATA Nasc
    */
    public ?string $data_nasc = null;

    /*
    * Fone 1
    */
    public ?string $fone1 = null;

    /*
    * Fone 2
    */
    public ?string $fone2 = null;

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
    public ?string $logradouro = null;

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
    * Estado
    */
    public ?string $estado = null;

    /*
    * HP
    */
    public ?string $hp = null;

    /*
    * Tipo
    */
    public ?string $tipo = null;

    /*
    * qtd mailing salvo
    */
    public ?string $qtd = null;

    /*
    * id user sistema
    */
    public ?int $id_user = null;

    /*
    * Criado por
    */
    public ?string $criado_por = null;

    /*
    * Data cad
    */
    public ?string $data_cad = null;

    /*
    * plano
    */
    public ?string $plano = null;

    /*
    * plano
    */
    public ?string $contrato = null;

    /*
    * Status
    */
    public ?string $status = null;

    /*
    * Vendedor
    */
    public ?string $vendedor = null;

    /*
    * Mensalidade
    */
    public ?string $mensalidade = null;

    /*
    * tipo contrato
    */
    public ?string $tipo_contrato = null;

    /*
    * Numero protocolo
    */
    public ?string $n_protocolo = null;

    /*
    * Status protocolo
    */
    public ?string $status_protocolo = null;

    /*
    * Data Protocolo
    */
    public ?string $data_protocolo = null;

    /*
    * OBS protocolo
    */
    public ?string $obs_protocolo = null;

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