<?php

namespace App\Http\Controller\Admin\Adm\Consult;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Cep as EntityCep;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Cep extends Page {

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepVivo(string $cep): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityCep::getCepVivoSP($cep);

        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
        }

        //RENDERIZA O ITEM
        $items .=  View::render('admin/adm/consult/modules/operadoras/vivo/item', [
            //RETORNA A MENSAGEM
            'result' => $msg
        ]);


        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepTim(string $cep): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityCep::getCepTim1($cep);

        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
        }

        //RENDERIZA O ITEM
        $items .=  View::render('admin/adm/consult/modules/operadoras/tim/item', [
            //RETORNA A MENSAGEM
            'result' => $msg
        ]);


        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepNetNacional(string $cep): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityCep::getCepNetNacional($cep);

        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
        }

        //RENDERIZA O ITEM
        $items .=  View::render('admin/adm/consult/modules/operadoras/net/item', [
            //RETORNA A MENSAGEM
            'result' => $msg
        ]);


        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de usuários
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getCep(Request $request, string $errorMessage = null): string
    {

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //POST VARS
        $postVars = $request->getPostVars();

        //GET CEP
        $cep = $postVars['cep'];

        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/consult/cep_post', [
            'cep'           => $cep,
            'net_list'      => self::getCepNetNacional($cep),
            'vivo_list'     => self::getCepVivo($cep),
            'tim_list'      => self::getCepTim($cep),
            //'algar_list'    => self::getListCepItems($request, $id),
            //'tim_list'      => self::getListCepItems($request, $id),
            //'vivo_list'     => self::getListCepItems($request, $id),
            //'desktop_list'  => self::getListCepItems($request),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Consulta',
            'CEP Operadora',
            'Consulta de CEP',
            $content
        );

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de usuários
     * @param Request $request
     * @return string
     */
    public static function getCepPage(Request $request): string
    {

        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/consult/cep', [
            'cep'           => '',
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Consulta',
            'CEP Operadora',
            'Consulta de CEP',
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
            case 'invalid':
                return Alert::getError('Erro :(','E-mail ou senha inválido!');
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