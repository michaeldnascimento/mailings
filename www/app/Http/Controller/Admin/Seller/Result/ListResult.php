<?php

namespace App\Http\Controller\Admin\Seller\Result;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Mailing as EntityMailing;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class ListResult extends Page {

    /**
     * Método responsável por obter a renderização os status mailing do usuário para a página
     * @param string $status_mailing
     * @return string
     */
    public static function getResultSellerStatusFollow(string $status_mailing): string
    {

        //MAILING
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityMailing::getMailing("*, date_format(status_data_mailing, '%d/%m/%Y %Hh%i') as status_data_mailing ", null, "status_mailing LIKE '%$status_mailing%' AND id_user = $id_user", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obMailings = $results->fetchObject(EntityMailing::class)){

            $items .=  View::render('/admin/seller/result/modules/item-follow', [
                'id' => $obMailings->id,
                'nome' => $obMailings->nome,
                'fone1' => $obMailings->fone1,
                'fone2' => $obMailings->fone2,
                'doc' => $obMailings->doc,
                'bairro' => $obMailings->bairro,
                'cidade' => $obMailings->cidade,
                'status_mailing' => $obMailings->status_mailing,
                'status_data_mailing' => $obMailings->status_data_mailing,
                'status_obs_mailing' => $obMailings->status_obs_mailing
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter a renderização os status mailing do usuário para a página
     * @param string $status_mailing
     * @return string
     */
    public static function getResultSellerStatusMailing(string $status_mailing): string
    {

        //MAILING
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityMailing::getMailing("*, date_format(status_data_mailing, '%d/%m/%Y %Hh%i') as status_data_mailing ", null, "status_mailing LIKE '%$status_mailing%' AND id_user = $id_user", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obMailings = $results->fetchObject(EntityMailing::class)){

            $items .=  View::render('/admin/seller/result/modules/item', [
                'id' => $obMailings->id,
                'nome' => $obMailings->nome,
                'fone1' => $obMailings->fone1,
                'fone2' => $obMailings->fone2,
                'doc' => $obMailings->doc,
                'bairro' => $obMailings->bairro,
                'cidade' => $obMailings->cidade,
                'status_mailing' => $obMailings->status_mailing,
                'status_data_mailing' => $obMailings->status_data_mailing,
                'status_obs_mailing' => $obMailings->status_obs_mailing
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização da página de vendas vendedor
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getSales(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/result/sales", [
            'itens'    => self::getResultSellerStatusMailing('VENDA'),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Resultados',
            "Vendas",
            'Lista de vendas',
            $content
        );
    }

    /**
     * Método responsável por retornar a renderização da página de vendas vendedor
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getSellerResultAll(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/result/geral", [
            'itens'    => self::getResultSellerStatusMailing(''),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Resultados',
            "Geral",
            'Lista geral',
            $content
        );
    }

    /**
     * Método responsável por retornar a renderização da página de vendas vendedor
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getFollow(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/result/follow", [
            'itens-follow' => self::getResultSellerStatusFollow('FOLLOW-UP'),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Resultados',
            "Follow-up",
            'Lista de Follow-up',
            $content
        );
    }

    /**
     * Método responsável gerar novo mailing lista1
     * @param Request $request
     * @param string $list
     * @return string
     */
    public static function setList(Request $request, string $list): string
    {

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        $qtd_mailing_user = EntityMailing::getMailingQtdUser($list, $id_user);

        //VALIDA SE O USUÁRIO JÁ PASSOU DO LIMIT DE MAILING POR USUÁRIO
        if($qtd_mailing_user->qtd >= 5){
            $request->getRouter()->redirect("/vendedor/mailings/$list?status=limitExceeded");
        }

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //PEGAR NOVO MAILING VAZIO
        $obMailing = EntityMailing::getNewMailing($list);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityMailing){
            $request->getRouter()->redirect("/vendedor/mailings/$list?status=notMailing");
        }

        //ATUALIZA A INSTANCIA
        $obMailing->id_user = $id_user;
        $obMailing->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect("/vendedor/mailings/$list?status=newMailing");
    }

    /**
     * Método responsável gerenciar o status do mailing
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function statusMailing(Request $request, int $id): string
    {

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obMailing = EntityMailing::getMailingById($id);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityMailing){
            $request->getRouter()->redirect("/vendedor/mailings/$obMailing->lista");
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obMailing->status_mailing = $postVars['status_mailing'] ?? $obMailing->status_mailing;
        $obMailing->status_obs_mailing = $postVars['status_obs_mailing'] ?? $obMailing->status_obs_mailing;
        $obMailing->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect("/vendedor/mailings/$obMailing->lista?status=statusUpdate");

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
            case 'limitExceeded':
                return Alert::getWarning('Atenção !','Limite de mailing na lista atingido');
                break;
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
            case 'notMailing':
                return Alert::getWarning('Atenção :|','Sem mailing disponivel no momento!');
                break;
            case 'newMailing':
                return Alert::getSuccess('Sucesso :)','Novo mailing gerado com sucesso.');
                break;
            case 'statusUpdate':
                return Alert::getSuccess('Sucesso :)','Status mailing atualizado com sucesso.');
                break;
        }
    }

}