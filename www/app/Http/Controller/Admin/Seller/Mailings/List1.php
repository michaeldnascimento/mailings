<?php

namespace App\Http\Controller\Admin\Seller\Mailings;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Mailing as EntityMailing;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class List1 extends Page {

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param $request $request
     */
    public static function getList1ItensUser(Request $request): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityMailing::getMailingUser('*', null, null, 'id DESC', '');

        //RENDERIZA O ITEM
        while($obUsers = $results->fetchObject(EntityMailing::class)){
            $items .=  View::render('admin/adm/users/modules/user/item', [
                'id' => $obUsers->id,
                'company' => $obUsers->company,
                'name' => $obUsers->name,
                'email' => $obUsers->email,
                'status_user' => $obUsers->status,
                'nivel' => $obUsers->nivel
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getList1(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/seller/mailings/list1', [
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Mailings',
            'List1',
            'Lista de mailing 1',
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
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
        }
    }

}