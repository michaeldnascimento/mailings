<?php

namespace App\Model\Entity\Property;

class Input
{

    /*
    * ID do Mailing
    */
    public int $id;

    /*
    * tipo mailing
    */
    public ?string $tipo_mailing = null;

    /*
    * numero protocolo
    */
    public ?string $num_protocolo = null;

    /*
    * numero pedido proposta
    */
    public ?string $num_pedido_proposta = null;

    /*
    * contrato
    */
    public ?string $contrato = null;

    /*
    * data venda
    */
    public ?string $data_venda = null;

    /*
    * nome cliente
    */
    public ?string $nome_cliente = null;

    /*
    * CPF
    */
    public string $cpf;

    /*
    * cod hp
    */
    public ?string $cod_hp = null;

    /*
    * Endereco
    */
    public ?string $endereco = null;

    /*
    * Rua
    */
    public ?string $rua = null;

    /*
    * CEP
    */
    public ?string $cep = null;

    /*
    * Histórico HP
    */
    public ?string $historico_hp = null;

    /*
    * Num
    */
    public ?string $num = null;

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
    public ?string $uf = null;

    /*
    * Cod Cidade
    */
    public ?string $codigo_cidade = null;

    /*
    * motivo pendencia venda
    */
    public ?string $motivo_pendencia_venda = null;

    /*
    * Status proposta
    */
    public ?string $status_proposta = null;

    /*
    * canal venda
    */
    public ?string $canal_venda = null;

    /*
    * fone
    */
    public ?int $fone = null;

    /*
    * fone1
    */
    public ?string $fone1 = null;

    /*
    * fone2
    */
    public ?string $fone2 = null;

    /*
    * email
    */
    public ?string $email = null;

    /*
    * tipo pessoa
    */
    public ?string $tipo_pessoa = null;

    /*
    * rg
    */
    public ?string $rg = null;

    /*
    * nome mãe
    */
    public ?string $nome_mae = null;

    /*
    * base cluster
    */
    public ?string $base_cluster = null;

    /*
    * base cluster
    */
    public ?string $regiao = null;

    /*
    * data atendimento
    */
    public ?string $data_atendimento = null;

    /*
    * motivo cancelamento
    */
    public ?string $motivo_cancelamento = null;

    /*
    * data cancelamento
    */
    public ?string $data_cancelamento = null;

    /*
    * data instalado
    */
    public ?string $data_instalado = null;

    /*
    * data Nascimento
    */
    public ?string $data_nascimento = null;

    /*
    * status contrato
    */
    public ?string $status_contrato = null;

    /*
    * data status
    */
    public ?string $data_status = null;

    /*
    * data status venda
    */
    public ?string $data_status_venda = null;

    /*
    * obs
    */
    public ?string $obs = null;

    /*
    * Data e hora follow mailing
    */
    public ?string $datatime_follow = null;

    /**
     * id user
     */
    public ?int $id_user = null;

    /*
    * Lista
    */
    public string $lista;

    /**
     * Status lista
     */
    public ?int $status_lista = null;

    /**
     * Status list date
     */
    public ?string $status_lista_datetime = null;

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