<?php

namespace App\Http\Controller\Admin\Adm\Consult;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Client as EntityClient;
use App\Model\Entity\MailingInput as EntityInput;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Client extends Page {

    /**
     * Método responsável por remover a string dos números
     * @param string|null $value
     * @return string|int
     */
    public static function removeStringNumber($value)
    {

        if (!empty($value)){
            $value = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $value);
            return $value;
        }

        return false;
    }

        /**
     * Método responsável por obter e renderização o resultado do CPF/CNPJ
     * @param Request $request
     * @param string $cpf_cnpj
     * @return string
     */
    public static function getCpfContratoSolar(Request $request, string $cpfContrato): string
    {

        //USUÁRIOS
        $itens = '';

        //RESULTADOS CPF/CNPJ
        $results = EntityInput::getMailingInput("*, date_format(status_lista_datetime, '%d/%m/%Y %Hh%i') as status_lista_datetime, date_format(data_instalado, '%d/%m/%Y') as data_instalado", null, "cpf = '$cpfContrato' OR contrato = '$cpfContrato'", '', '', '');

        //RENDERIZA O ITEM
        while($mailing = $results->fetchObject(EntityClient::class)){

            $itens .=  View::render('admin/adm/consult/modules/solar/item', [
                'tipo_mailing' => $mailing->tipo_mailing,
                'num_protocolo' => $mailing->num_protocolo,
                'num_pedido_proposta'  => $mailing->num_pedido_proposta,
                'contrato'  => $mailing->contrato,
                'data_venda' => $mailing->data_venda,
                'nome_cliente'  => $mailing->nome_cliente,
                'cpf'  => $mailing->cpf,
                'rg'  => $mailing->rg,
                'cod_hp' => $mailing->cod_hp,
                'endereco' => $mailing->endereco,
                'rua' => $mailing->rua,
                'cep' => $mailing->cep,
                'historico_hp' => $mailing->historico_hp,
                'num' => $mailing->num,
                'bairro' => $mailing->bairro,
                'cidade' => $mailing->cidade,
                'uf' => $mailing->uf,
                'codigo_cidade' => $mailing->codigo_cidade,
                'motivo_pendencia_venda' => $mailing->motivo_pendencia_venda,
                'status_proposta' => $mailing->status_proposta,
                'canal_venda' => $mailing->canal_venda,
                'fone' => $mailing->fone,
                'fone1' => $mailing->fone1,
                'fone2' => $mailing->fone2,
                'email' => $mailing->email,
                'tipo_pessoa' => $mailing->tipo_pessoa,
                'rg' => $mailing->rg,
                'nome_mae' => $mailing->nome_mae,
                'base_cluster' => $mailing->base_cluster,
                'regiao' => $mailing->regiao,
                'data_atendimento' => $mailing->data_atendimento,
                'motivo_cancelamento' => $mailing->motivo_cancelamento,
                'data_cancelamento' => $mailing->data_cancelamento,
                'data_instalado' => $mailing->data_instalado,
                'status_contrato' => $mailing->status_contrato,
                'data_status' => $mailing->data_status,
                'data_status_venda' => $mailing->data_status_venda,
                'status_lista_datetime' => $mailing->status_lista_datetime,
                'color' => 'primary'
            ]);
        }

        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por obter e renderização o resultado do CPF/CNPJ
     * @param Request $request
     * @param string $cpf_cnpj
     * @return string
     */
    public static function getCpfCnpj(Request $request, string $cpf_cnpj): string
    {

        //USUÁRIOS
        $itens = '';

        //RESULTADOS CPF/CNPJ
        $results = EntityClient::getClient('*', null, "cpf_cnpj = $cpf_cnpj", '', '', '');

        //RENDERIZA O ITEM
        while($obClient = $results->fetchObject(EntityClient::class)){

            $itens .=  View::render('admin/adm/consult/modules/client/item', [
                'id' => $obClient->id,
                'nome_cliente' => $obClient->nome_cliente,
                'cpf_cnpj' => $obClient->cpf_cnpj,
                'tipo_cliente' => $obClient->tipo_cliente,
                'endereco' => $obClient->endereco,
                'numero' => $obClient->numero,
                'complemento' => $obClient->complemento,
                'cep' => $obClient->cep,
                'tipo_edificacao' => $obClient->tipo_edificacao,
                'bairro' => $obClient->bairro,
                'cidade' => $obClient->cidade,
                'uf' => $obClient->uf,
                'cod_hp' => $obClient->cod_hp,
                'fone_cel' => $obClient->fone_cel,
                'fone_fixo' => $obClient->fone_fixo,
                'email' => $obClient->email,
                'origem' => $obClient->origem,
                'operadora_atual' => $obClient->operadora_atual,
                'cod_contrato' => $obClient->cod_contrato,
                'data_higienizacao' => $obClient->data_higienizacao,
                'tec_banda_larga' => $obClient->tec_banda_larga,
                'correlacoes_adic' => $obClient->correlacoes_adic,
                'comentario' => $obClient->comentario,
                'color' => 'primary'
            ]);
        }

        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de cpf e cpnj
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getClient(Request $request, string $errorMessage = null): string
    {

        //POST VARS
        $postVars = $request->getPostVars();

        //VERIFICA SE O INPUT NÃO ESTÁ VAZIO
        if(empty($postVars['cpf_cnpj'])){
            $request->getRouter()->redirect('/consulta/cliente?status=emptyClient');
        }

        //GET CPF/CNPJ E REMOVE STRINGS
        $cpf_cnpj = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $postVars['cpf_cnpj']);

        //REMOVE CPF/CNPJ QUE COMEÇA COM 0 A ESQUERDA
        $cpf_cnpj = ltrim($cpf_cnpj, "0");

        //CONSULTA CPF E CNPJ
        $result_client = self::getCpfCnpj($request, $cpf_cnpj);

        //VERIFICA SE O RESULTADO NÃO ESTÁ VAZIO
        if(empty($result_client)){
            $request->getRouter()->redirect('/consulta/cliente?status=notFoundClient');
        }

        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/consult/client_post', [
        'cpf_cnpj'      => $cpf_cnpj,
        'result_client' => $result_client,
        'status'        => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Consulta',
            'Cliente',
            'Consulta de Client',
            $content
        );

    }


    /**
     * Método responsável por retornar a renderização a view de listagem de cpf e cpnj
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getClientSolar(Request $request, string $errorMessage = null): string
    {

        //POST VARS
        $postVars = $request->getPostVars();

        //VERIFICA SE O INPUT NÃO ESTÁ VAZIO
        if(empty($postVars['contrato']) AND empty($postVars['cpf'])){
            $request->getRouter()->redirect('/consulta/solar?status=emptyClient');
        }

        //VERIFICA SE O CPF OU CONTRATO ESTÁ VAZIO PARA AI SIM FAZER A CONSULTA SE JÁ EXISTE
        if(!empty($postVars['cpf'])){
            //VERFICAR SE EXISTE CPF
            $cpf = self::removeStringNumber($postVars['cpf']);
            $result_client = self::getCpfContratoSolar($request, $cpf);
        }

        //VERIFICA SE O CPF OU CONTRATO ESTÁ VAZIO PARA AI SIM FAZER A CONSULTA SE JÁ EXISTE
        if(!empty($postVars['contrato'])){
            //VERFICAR SE EXISTE CPF/CONTRATO
            $contrato = self::removeStringNumber($postVars['contrato']);
            $result_client = self::getCpfContratoSolar($request, $contrato);
        }

        //VERIFICA SE O RESULTADO NÃO ESTÁ VAZIO
        if(empty($result_client)){
            $request->getRouter()->redirect('/consulta/solar?status=notFoundClient');
        }

        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/consult/solar_post', [
        'tipo_busca'    => $postVars['tipo_busca'],
        'cpf_contrato'  => $cpf ?? $contrato,
        'result_client' => $result_client,
        'status'        => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Consulta',
            'Cliente',
            'Consulta de Client',
            $content
        );

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de usuários
     * @param Request $request
     * @return string
     */
    public static function getClientPage(Request $request): string
    {

        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/consult/client', [
            'cpf_cnpj'      => '',
            'status'        => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Consulta',
            'Cliente',
            'Consulta de Client',
            $content
        );

    }

        /**
     * Método responsável por retornar a renderização a view de listagem de usuários
     * @param Request $request
     * @return string
     */
    public static function getClientPageSolar(Request $request): string
    {

        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/consult/solar', [
            'cpf_cnpj'      => '',
            'status'        => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Consulta',
            'Cliente',
            'Consulta Solar',
            $content
        );

    }

    /**
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus(Request $request): string
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGEM DE STATUS
        switch ($queryParams['status']) {
            case 'notFoundClient':
                return Alert::getError('Erro :(','Cliente não encontrado!');
                break;
            case 'emptyClient':
                return Alert::getError('Erro :(','Campo vazio!');
                break;
            case 'updated':
                return Alert::getSuccess('Sucesso','Usuário atualizado com sucesso.');
                break;
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
        }
    }

}