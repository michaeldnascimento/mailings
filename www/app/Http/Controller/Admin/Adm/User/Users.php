<?php

namespace App\Http\Controller\Admin\Adm\User;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\User as EntityUser;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Users extends Page {

    /**
     * Método responsável por obter a renderização dos itens do usuários para a página
     * @param $request $request
     */
    public static function getListUsersItems(Request $request): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers('*', null, null, 'id DESC', '');

        //RENDERIZA O ITEM
        while($obUsers = $results->fetchObject(EntityUser::class)){
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
     * Método responsável por retornar a renderização a view de listagem de usuários
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getUsersList(Request $request, string $errorMessage = null): string
    {

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/users/list', [
            'itens'       => self::getListUsersItems($request),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Usuários',
            'Lista de Usuários',
            $content
        );

    }

    /**
     * Método responsável por retornar o formulário de edição de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUser(Request $request, int $id): string
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/adm/users/list');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('/admin/adm/users/form', [
            'id' => $obUser->id,
            'company' => $obUser->company,
            'name' => $obUser->name,
            'email' => $obUser->email,
            'status_user' => $obUser->status,
            'nivel' => $obUser->nivel,
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Usuários',
            'Editar de Usuários',
            $content
        );
    }

    /**
     * Método responsável por grava a ataulização de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditUser(Request $request, int $id): string
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obUser->name = $postVars['name'] ?? $obUser->name;
        $obUser->email = $postVars['email'] ?? $obUser->email;
        $obUser->company = $postVars['company'] ?? $obUser->company;
        $obUser->status = $postVars['status_user'] ?? $obUser->status;
        $obUser->nivel = $postVars['nivel'] ?? $obUser->nivel;
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/usuarios/lista/'.$obUser->id.'/edit?status=updated');
    }


    /**
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser(Request $request, int $id): string
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityUser::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityUser){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/delete', [
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem
        ]);

        return parent::getPanel('Excluir depoimento > WDEV', $content, 'testimonies');
    }


    /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUser(Request $request, int $id): string
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityTestimony){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //EXCLUI O DEPOIMENTO
        $obTestimony->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
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