<?php

namespace App\Http\Controller\Api;

use \App\Db\Pagination;
use \App\Http\Request;
use \App\Model\Entity\Mailing as EntityMailing;
use \App\Model\Entity\MailingDesktop as EntityDesktop;
use \App\Model\Entity\MailingDesktop2 as EntityDesktop2;
use \App\Model\Entity\MailingAlgar as EntityAlgar;
use \App\Model\Entity\MailingClaro as EntityClaro;
use \App\Model\Entity\MailingNet as EntityNet;
use \App\Model\Entity\MailingVero as EntityVero;
use \App\Model\Entity\MailingAmericanet as EntityAmericanet;
use \Exception;

class Mailing extends Api{

    /**
     * Método responsável por retornar os detalhes de um depoimento
     * @param Request $request
     * @param string $cpf_cnpj
     * @return array
     * @throws Exception
     */
    public static function getCpfCnpj(Request $request, string $cpf_cnpj): array
    {

        //CLIENTE
        $items = [];

        //GET CPF/CNPJ E REMOVE STRINGS
        $cpf_cnpj = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $cpf_cnpj);

        //REMOVE CPF/CNPJ QUE COMEÇA COM 0 A ESQUERDA
        $cpf_cnpj = ltrim($cpf_cnpj, "0");

        //RESULTADOS CPF/CNPJ
        $results = EntityClient::getClient('*', null, "cpf_cnpj = $cpf_cnpj", '', '', '');

        //RENDERIZA O ITEM
        while($obClient = $results->fetchObject(EntityClient::class)){
            $items[] =  [
                'id'       => (int)$obClient->id,
                'fone1'    => $obClient->fone_cel,
                'fone2'    => $obClient->fone_fixo
            ];
        }

        return $items;
    }

    /**
     * Método responsável por cadastrar um novo mailing americanet
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingAmericanet(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf_cnpj']) OR !isset($postParams['fone1'])){
            throw new Exception("Os campos 'cpf_cnpj' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obAmericanet = EntityAmericanet::getMailingByCpf($postParams['cpf_cnpj']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obAmericanet instanceof EntityAmericanet){
            throw new Exception("Esse mailing já existe", 400);
        }

        $nascimento = str_replace("/", "-", $postParams['nascimento']);
        $data_cadastro = str_replace("/", "-", $postParams['data_cadastro']);
        $data_ultima_alteracao = str_replace("/", "-", $postParams['data_ultima_alteracao']);

        //NOVO MAILING DESKTOP
        $obAmericanet = new EntityAmericanet();
        $obAmericanet->cliente = $postParams['cliente'];
        $obAmericanet->id_cliente = $postParams['id_cliente'];
        $obAmericanet->tipo_cliente = $postParams['tipo_cliente'];
        $obAmericanet->cpf_cnpj =  $postParams['cpf_cnpj'];
        $obAmericanet->nascimento = date('Y-m-d', strtotime($nascimento));
        $obAmericanet->data_cadastro = date('Y-m-d H:i:s', strtotime($data_cadastro));
        $obAmericanet->data_ultima_alteracao = date('Y-m-d H:i:s', strtotime($data_ultima_alteracao));
        $obAmericanet->email = $postParams['email'];
        $obAmericanet->rg = $postParams['rg'];
        $obAmericanet->mae = $postParams['mae'];
        $obAmericanet->fone1 = $postParams['fone1'];
        $obAmericanet->fone2 = $postParams['fone2'];
        $obAmericanet->fone3 = $postParams['fone3'];
        $obAmericanet->cep = $postParams['cep'];
        $obAmericanet->endereco = $postParams['endereco'];
        $obAmericanet->num = $postParams['num'];
        $obAmericanet->complemento = $postParams['complemento'];
        $obAmericanet->bairro = $postParams['bairro'];
        $obAmericanet->cidade = $postParams['cidade'];
        $obAmericanet->estado = $postParams['estado'];
        $obAmericanet->status = $postParams['status'];
        $obAmericanet->contrato = $postParams['contrato'];
        $obAmericanet->produto = $postParams['produto'];
        $obAmericanet->sublista = $postParams['sublista'];
        $obAmericanet->lista = $postParams['lista'];
        $obAmericanet->id_mailing = $postParams['id_mailing'];
        $obAmericanet->nome_mailing = $postParams['nome_mailing'];
        $obAmericanet->status_lista = 1;
        $obAmericanet->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obAmericanet->id,
            'cliente'  => $obAmericanet->cliente,
            'cpf_cnpj' => $obAmericanet->cpf_cnpj
        ];
    }

    /**
     * Método responsável por cadastrar um novo mailing vero
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingVero(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf_cnpj']) OR !isset($postParams['fone1'])){
            throw new Exception("Os campos 'cpf_cnpj' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obVero = EntityVero::getMailingByCpf($postParams['cpf_cnpj']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obVero instanceof EntityVero){
            throw new Exception("Esse mailing já existe", 400);
        }

        $nascimento = str_replace("/", "-", $postParams['nascimento']);
        $data_cadastro = str_replace("/", "-", $postParams['data_cadastro']);
        $data_ultima_alteracao = str_replace("/", "-", $postParams['data_ultima_alteracao']);

        //NOVO MAILING DESKTOP
        $obVero = new EntityVero();
        $obVero->cliente = $postParams['cliente'];
        $obVero->id_cliente = $postParams['id_cliente'];
        $obVero->tipo_cliente = $postParams['tipo_cliente'];
        $obVero->cpf_cnpj =  $postParams['cpf_cnpj'];
        $obVero->nascimento = date('Y-m-d', strtotime($nascimento));
        $obVero->data_cadastro = date('Y-m-d H:i:s', strtotime($data_cadastro));
        $obVero->data_ultima_alteracao = date('Y-m-d H:i:s', strtotime($data_ultima_alteracao));
        $obVero->email = $postParams['email'];
        $obVero->rg = $postParams['rg'];
        $obVero->mae = $postParams['mae'];
        $obVero->fone1 = $postParams['fone1'];
        $obVero->fone2 = $postParams['fone2'];
        $obVero->fone3 = $postParams['fone3'];
        $obVero->cep = $postParams['cep'];
        $obVero->endereco = $postParams['endereco'];
        $obVero->num = $postParams['num'];
        $obVero->complemento = $postParams['complemento'];
        $obVero->bairro = $postParams['bairro'];
        $obVero->cidade = $postParams['cidade'];
        $obVero->estado = $postParams['estado'];
        $obVero->status = $postParams['status'];
        $obVero->contrato = $postParams['contrato'];
        $obVero->produto = $postParams['produto'];
        $obVero->sublista = $postParams['sublista'];
        $obVero->lista = $postParams['lista'];
        $obVero->id_mailing = $postParams['id_mailing'];
        $obVero->nome_mailing = $postParams['nome_mailing'];
        $obVero->status_lista = 1;
        $obVero->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obVero->id,
            'cliente'  => $obVero->cliente,
            'cpf_cnpj' => $obVero->cpf_cnpj
        ];
    }

    /**
     * Método responsável por cadastrar um novo mailing desktop
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingDesktop2(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf_cnpj']) OR !isset($postParams['fone1'])){
            throw new Exception("Os campos 'cpf_cnpj' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obDesktop = EntityDesktop2::getMailingByCpf($postParams['cpf_cnpj']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obDesktop instanceof EntityDesktop2){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING DESKTOP
        $obDesktop = new EntityDesktop2();
        $obDesktop->cliente = $postParams['cliente'];
        $obDesktop->cpf_cnpj =  $postParams['cpf_cnpj'];
        $obDesktop->rg =   $postParams['rg'];
        $obDesktop->nascimento = implode('-', array_reverse(explode('/', $postParams['nascimento'])));
        $obDesktop->email = $postParams['email'];
        $obDesktop->fone1 = $postParams['fone1'];
        $obDesktop->fone2 = $postParams['fone2'];
        $obDesktop->fone3 = $postParams['fone3'];
        $obDesktop->endereco = $postParams['endereco'];
        $obDesktop->bairro = $postParams['bairro'];
        $obDesktop->cidade = $postParams['cidade'];
        $obDesktop->estado = $postParams['estado'];
        $obDesktop->cep = $postParams['cep'];
        $obDesktop->contrato = $postParams['contrato'];
        $obDesktop->status = $postParams['status'];
        $obDesktop->subStatus = $postParams['subStatus'];
        $obDesktop->observacao = $postParams['observacao'];
        $obDesktop->produto = $postParams['produto'];
        $obDesktop->ultimaOC = $postParams['ultimaOC'];
        $obDesktop->sublista = $postParams['sublista'];
        $obDesktop->lista = $postParams['lista'];
        $obDesktop->id_mailing = $postParams['id_mailing'];
        $obDesktop->nome_mailing = $postParams['nome_mailing'];
        $obDesktop->status_lista = 1;
        $obDesktop->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obDesktop->id,
            'cliente'  => $obDesktop->cliente,
            'cpf_cnpj' => $obDesktop->cpf_cnpj
        ];
    }

    /**
     * Método responsável por cadastrar um novo mailing desktop
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingDesktop(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf']) OR !isset($postParams['fone1'])){
            throw new Exception("Os campos 'doc' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obDesktop = EntityDesktop::getMailingByCpf($postParams['cpf']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obDesktop instanceof EntityDesktop){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING DESKTOP
        $obDesktop = new EntityDesktop();
        $obDesktop->ordens = $postParams['ordens'];
        $obDesktop->pendencia = $postParams['pendencia'];
        $obDesktop->cliente = $postParams['cliente'];
        $obDesktop->status_spc = $postParams['status_spc'];
        $obDesktop->cpf =  $postParams['cpf'];
        $obDesktop->rg =   $postParams['rg'];
        $obDesktop->data_nasc = implode('-', array_reverse(explode('/', $postParams['data_nasc'])));
        $obDesktop->email = $postParams['email'];
        $obDesktop->fone1 = $postParams['fone1'];
        $obDesktop->fone2 = $postParams['fone2'];
        $obDesktop->criado_por = $postParams['criado_por'];
        $obDesktop->data_cad = implode('-', array_reverse(explode('/', $postParams['data_cad'])));
        $obDesktop->logradouro = $postParams['logradouro'];
        $obDesktop->num = $postParams['num'];
        $obDesktop->bairro = $postParams['bairro'];
        $obDesktop->cidade = $postParams['cidade'];
        $obDesktop->estado = $postParams['estado'];
        $obDesktop->cep = $postParams['cep'];
        $obDesktop->compl = $postParams['compl'];
        $obDesktop->plano = $postParams['plano'];
        $obDesktop->contrato = $postParams['contrato'];
        $obDesktop->status = $postParams['status'];
        $obDesktop->vendedor = $postParams['vendedor'];
        $obDesktop->mensalidade = $postParams['mensalidade'];
        $obDesktop->tipo_contrato = $postParams['tipo_contrato'];
        $obDesktop->n_protocolo = $postParams['n_protocolo'];
        $obDesktop->status_protocolo = $postParams['status_protocolo'];
        $obDesktop->data_protocolo = implode('-', array_reverse(explode('/', $postParams['data_protocolo'])));
        $obDesktop->obs_protocolo = $postParams['obs_protocolo'];
        $obDesktop->lista = $postParams['lista'];
        $obDesktop->id_mailing = $postParams['id_mailing'];
        $obDesktop->nome_mailing = $postParams['nome_mailing'];
        $obDesktop->status_lista = 1;
        $obDesktop->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obDesktop->id,
            'cliente'  => $obDesktop->cliente,
            'cpf'      => $obDesktop->cpf
        ];
    }

    /**
     * Método responsável por cadastrar um novo mailing claro
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingClaro(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();


        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf']) OR !isset($postParams['fone'])){
            throw new Exception("Os campos 'doc' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obClaro = EntityClaro::getMailingByCpf($postParams['cpf']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obClaro instanceof EntityClaro){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING CLARO
        $obClaro = new EntityClaro();
        $obClaro->tipo_mailing = $postParams['tipo_mailing'];
        $obClaro->num_protocolo = $postParams['num_protocolo'];
        $obClaro->num_pedido_proposta = $postParams['num_pedido_proposta'];
        $obClaro->contrato = $postParams['contrato'];
        $obClaro->data_venda = implode('-', array_reverse(explode('/', $postParams['data_venda'])));
        $obClaro->nome_cliente = $postParams['nome_cliente'];
        $obClaro->cpf = $postParams['cpf'];
        $obClaro->cod_hp = $postParams['cod_hp'];
        $obClaro->endereco = $postParams['endereco'];
        $obClaro->rua = $postParams['rua'];
        $obClaro->cep = $postParams['cep'];
        $obClaro->historico_hp = $postParams['historico_hp'];
        $obClaro->num = $postParams['num'];
        $obClaro->bairro = $postParams['bairro'];
        $obClaro->cidade = $postParams['cidade'];
        $obClaro->uf = $postParams['uf'];
        $obClaro->motivo_pendencia_venda = $postParams['motivo_pendencia_venda'];
        $obClaro->status_proposta = $postParams['status_proposta'];
        $obClaro->canal_venda = $postParams['canal_venda'];
        $obClaro->fone = $postParams['fone'];
        $obClaro->fone1 = $postParams['fone1'];
        $obClaro->fone2 = $postParams['fone2'];
        $obClaro->email = $postParams['email'];
        $obClaro->tipo_pessoa = $postParams['tipo_pessoa'];
        $obClaro->rg = $postParams['rg'];
        $obClaro->nome_mae = $postParams['nome_mae'];
        $obClaro->base_cluster = $postParams['base_cluster'];
        $obClaro->data_atendimento = implode('-', array_reverse(explode('/', $postParams['data_atendimento'])));
        $obClaro->motivo_cancelamento = $postParams['motivo_cancelamento'];
        $obClaro->data_cancelamento = implode('-', array_reverse(explode('/', $postParams['data_cancelamento'])));
        $obClaro->data_instalado = implode('-', array_reverse(explode('/', $postParams['data_instalado'])));
        $obClaro->status_contrato = $postParams['status_contrato'];
        $obClaro->data_status = implode('-', array_reverse(explode('/', $postParams['data_status'])));
        $obClaro->data_status_venda = implode('-', array_reverse(explode('/', $postParams['data_status_venda'])));
        $obClaro->obs = $postParams['obs'];
        $obClaro->lista = $postParams['lista'];
        $obClaro->id_mailing = $postParams['id_mailing'];
        $obClaro->nome_mailing = $postParams['nome_mailing'];
        $obClaro->status_lista = 1;
        $obClaro->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obClaro->id,
            'nome_cliente'  => $obClaro->nome_cliente,
            'cpf'      => $obClaro->cpf
        ];
    }

    /**
     * Método responsável por cadastrar um novo mailing Net
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingNet(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();


        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf']) OR !isset($postParams['fone'])){
            throw new Exception("Os campos 'doc' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obNet = EntityNet::getMailingByCpf($postParams['cpf']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obNet instanceof EntityNet){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING NET
        $obNet = new EntityNet();
        $obNet->tipo_mailing = $postParams['tipo_mailing'];
        $obNet->num_protocolo = $postParams['num_protocolo'];
        $obNet->num_pedido_proposta = $postParams['num_pedido_proposta'];
        $obNet->contrato = $postParams['contrato'];
        $obNet->data_venda = implode('-', array_reverse(explode('/', $postParams['data_venda'])));
        $obNet->nome_cliente = $postParams['nome_cliente'];
        $obNet->cpf = $postParams['cpf'];
        $obNet->cod_hp = $postParams['cod_hp'];
        $obNet->endereco = $postParams['endereco'];
        $obNet->rua = $postParams['rua'];
        $obNet->cep = $postParams['cep'];
        $obNet->historico_hp = $postParams['historico_hp'];
        $obNet->num = $postParams['num'];
        $obNet->bairro = $postParams['bairro'];
        $obNet->cidade = $postParams['cidade'];
        $obNet->uf = $postParams['uf'];
        $obNet->motivo_pendencia_venda = $postParams['motivo_pendencia_venda'];
        $obNet->status_proposta = $postParams['status_proposta'];
        $obNet->canal_venda = $postParams['canal_venda'];
        $obNet->fone = $postParams['fone'];
        $obNet->fone1 = $postParams['fone1'];
        $obNet->fone2 = $postParams['fone2'];
        $obNet->email = $postParams['email'];
        $obNet->tipo_pessoa = $postParams['tipo_pessoa'];
        $obNet->rg = $postParams['rg'];
        $obNet->nome_mae = $postParams['nome_mae'];
        $obNet->base_cluster = $postParams['base_cluster'];
        $obNet->data_atendimento = implode('-', array_reverse(explode('/', $postParams['data_atendimento'])));
        $obNet->motivo_cancelamento = $postParams['motivo_cancelamento'];
        $obNet->data_cancelamento = implode('-', array_reverse(explode('/', $postParams['data_cancelamento'])));
        $obNet->data_instalado = implode('-', array_reverse(explode('/', $postParams['data_instalado'])));
        $obNet->status_contrato = $postParams['status_contrato'];
        $obNet->data_status = implode('-', array_reverse(explode('/', $postParams['data_status'])));
        $obNet->data_status_venda = implode('-', array_reverse(explode('/', $postParams['data_status_venda'])));
        $obNet->obs = $postParams['obs'];
        $obNet->lista = $postParams['lista'];
        $obNet->id_mailing = $postParams['id_mailing'];
        $obNet->nome_mailing = $postParams['nome_mailing'];
        $obNet->status_lista = 1;
        $obNet->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obNet->id,
            'nome_cliente'  => $obNet->nome_cliente,
            'cpf'      => $obNet->cpf
        ];
    }

    /**
     * Método responsável por cadastrar um novo mailing Algar
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingAlgar(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();


        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf']) OR !isset($postParams['fone'])){
            throw new Exception("Os campos 'doc' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obAlgar = EntityAlgar::getMailingByCpf($postParams['cpf']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obAlgar instanceof EntityAlgar){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING ALGAR
        $obAlgar = new EntityAlgar();
        $obAlgar->tipo_mailing = $postParams['tipo_mailing'];
        $obAlgar->num_protocolo = $postParams['num_protocolo'];
        $obAlgar->num_pedido_proposta = $postParams['num_pedido_proposta'];
        $obAlgar->contrato = $postParams['contrato'];
        $obAlgar->data_venda = implode('-', array_reverse(explode('/', $postParams['data_venda'])));
        $obAlgar->nome_cliente = $postParams['nome_cliente'];
        $obAlgar->cpf = $postParams['cpf'];
        $obAlgar->cod_hp = $postParams['cod_hp'];
        $obAlgar->endereco = $postParams['endereco'];
        $obAlgar->rua = $postParams['rua'];
        $obAlgar->cep = $postParams['cep'];
        $obAlgar->historico_hp = $postParams['historico_hp'];
        $obAlgar->num = $postParams['num'];
        $obAlgar->bairro = $postParams['bairro'];
        $obAlgar->cidade = $postParams['cidade'];
        $obAlgar->uf = $postParams['uf'];
        $obAlgar->motivo_pendencia_venda = $postParams['motivo_pendencia_venda'];
        $obAlgar->status_proposta = $postParams['status_proposta'];
        $obAlgar->canal_venda = $postParams['canal_venda'];
        $obAlgar->fone = $postParams['fone'];
        $obAlgar->fone1 = $postParams['fone1'];
        $obAlgar->fone2 = $postParams['fone2'];
        $obAlgar->email = $postParams['email'];
        $obAlgar->tipo_pessoa = $postParams['tipo_pessoa'];
        $obAlgar->rg = $postParams['rg'];
        $obAlgar->nome_mae = $postParams['nome_mae'];
        $obAlgar->base_cluster = $postParams['base_cluster'];
        $obAlgar->data_atendimento = implode('-', array_reverse(explode('/', $postParams['data_atendimento'])));
        $obAlgar->motivo_cancelamento = $postParams['motivo_cancelamento'];
        $obAlgar->status_contrato = $postParams['status_contrato'];
        $obAlgar->data_status_venda = implode('-', array_reverse(explode('/', $postParams['data_status_venda'])));
        $obAlgar->obs = $postParams['obs'];
        $obAlgar->lista = $postParams['lista'];
        $obAlgar->id_mailing = $postParams['id_mailing'];
        $obAlgar->nome_mailing = $postParams['nome_mailing'];
        $obAlgar->status_lista = 1;
        $obAlgar->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obAlgar->id,
            'nome_cliente'  => $obAlgar->nome_cliente,
            'cpf'      => $obAlgar->cpf
        ];
    }



}