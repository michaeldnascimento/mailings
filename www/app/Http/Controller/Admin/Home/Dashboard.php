<?php

namespace App\Http\Controller\Admin\Home;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\User as EntityUser;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class  Dashboard extends Page {

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getHome(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/dashboard', [
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Mailings', 'Home', '', $content);
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
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
            case 'routeInvalid':
                return Alert::getError('Erro :(','Não é possivel acessar essa rota!');
                break;
            case 'companyInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar essa rota da empresa!');
                break;
            case 'cepInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar essa rota CEP!');
                break;
            case 'clientInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar essa rota CLIENTE!');
                break;
            case 'solarInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar essa rota SOLAR!');
                break;
            case 'callInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar essa rota de CHAMADOS!');
                break;
            case 'listInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar essa lista mailing');
                break;
            case 'mailingInvalid';
                return Alert::getError('Erro :(','Não é possivel acessar esse mailing');
                break;
        }
    }

}