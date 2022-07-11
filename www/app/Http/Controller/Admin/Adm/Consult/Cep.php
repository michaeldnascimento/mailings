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
    public static function getCepAlgar(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //CONSULTA ALGAR
        $results = EntityCep::getCepAlgar($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'ALGAR',
            'result' => $msg,
            'color' => $color
        ]);


        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepOI(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //CONSULTA OI
        $resultsOI = EntityCep::getCepOI($cep);

        //CONSULTA OI SP
        $resultsOISP = EntityCep::getCepOISP($cep);

        //CONSULTA OI SUL
        $resultsOISul = EntityCep::getCepOISul($cep);

        //MENSAGEM DE RETORNO
        if (!empty($resultsOI) OR !empty($resultsOISP) OR !empty($resultsOISul)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'OI',
            'result' => $msg,
            'color' => $color
        ]);

        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepVip(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //CONSULTA VIP
        $results = EntityCep::getCepVip($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'VIP',
            'result' => $msg,
            'color' => $color
        ]);


        //RETORNA OS ITENS
        return $itens;

    }


    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepDesktop(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //CONSULTA DESKTOP
        $results = EntityCep::getCepDesktop($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'DESKTOP',
            'result' => $msg,
            'color' => $color
        ]);

        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepVivo(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //CONSULTA VIVO SP
        $resultsVivoSP = EntityCep::getCepVivoSP($cep);

        //CONSULTA VIVO NACIONAL
        $resultsVivoNacional = EntityCep::getCepVivoNacional($cep);

        //MENSAGEM DE RETORNO
        if (!empty($resultsVivoSP OR !empty($resultsVivoNacional))){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'VIVO',
            'result' => $msg,
            'color' => $color
        ]);


        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepTim(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //RESULTADOS CEP TIM
        $results = EntityCep::getCepTim($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'TIM',
            'result' => $msg,
            'color' => $color
        ]);

        //RETORNA OS ITENS
        return $itens;

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string
     */
    public static function getCepNetNacional(string $cep): string
    {

        //USUÁRIOS
        $itens = '';

        //RESULTADOS CEP NET
        $results = EntityCep::getCepNetNacional($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        $itens .=  View::render('admin/adm/consult/modules/operadoras/item', [
            //RETORNA A MENSAGEM
            'operadora' => 'NET',
            'result' => $msg,
            'color' => $color
        ]);

        //RETORNA OS ITENS
        return $itens;

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
            'algar_list'    => self::getCepAlgar($cep),
            'desktop_list'  => self::getCepDesktop($cep),
            'oi_list'       => self::getCepOI($cep),
            'vip_list'      => self::getCepVIP($cep),
            'status'        => self::getStatus($request)
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