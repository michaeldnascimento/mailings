<?php

namespace App\Http\Controller\Admin\Adm\Consult;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Client as EntityClient;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Client extends Page {

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

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

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