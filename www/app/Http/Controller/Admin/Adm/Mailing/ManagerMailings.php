<?php

namespace App\Http\Controller\Admin\Adm\Mailing;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Mailing as EntityMailing;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class ManagerMailings extends Page {

    /**
     * Método responsável por obter a renderização dos itens da empresa para a página
     * @param $request $request
     */
    public static function getListMailingsItems(Request $request): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityMailing::getMailing('id_mailing, status_lista, lista, COUNT(*) as qtd', '', '', '', 'id_mailing', '');

        //$stringSql = "SELECT id_mailing, status_mailing, lista_sistema, COUNT(*) as qtde FROM clientes WHERE id_mailing <> '' GROUP BY id_mailing";

        //RENDERIZA O ITEM
        while($obMailings = $results->fetchObject(EntityMailing::class)){
            $items .=  View::render('admin/adm/mailing/modules/mailings/item', [
                'id_mailing' => $obMailings->id_mailing,
                'lista' => $obMailings->lista,
                'status_lista' => $obMailings->status_lista,
                'qtd' => $obMailings->qtd,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de empresa
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getManagerMailingsList(Request $request, string $errorMessage = null): string
    {

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA DE EMPRESA
        $content = View::render('admin/adm/mailing/list', [
            'itens'    => self::getListMailingsItems($request),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Mailings',
            'Lista de Mailings',
            $content
        );

    }

    /**
     * Método responsável por retornar o formulário de nova empresa
     * @param Request $request
     * @return string
     */
    public static function getNewCompany(Request $request): string
    {

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('/admin/adm/company/form', [
            'company' => $obCompany->company,
            'options_status_company' => "<option value='1'>ATIVO</option>.
                                      <option value='0'>DESATIVAR</option>",
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Empresa',
            'Nova Empresa',
            $content
        );
    }

    /**
     * Método responsável por nova empresa
     * @param Request $request
     * @return string
     */
    public static function setNewCompany(Request $request): string
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $company  = $postVars['company'] ?? '';
        $status = $postVars['status'] ?? '';

        //VALIDA E-MAIL DO USUÁRIO
        $obCompany = EntityCompany::getCompanyName($company);

        //VERIFICA SE O USUÁRIO JÁ EXISTE
        if ($obCompany != ''){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/empresa/lista?status=duplicated');
        }

        //NOVA INSTANCIA DE USUÁRIO
        $obCompany = new EntityCompany();
        $obCompany->company = $company;
        $obCompany->status = 1; //status aguardando aprovação
        $obCompany->cadastrar();

        //VERIFICA SE O USUÁRIO FOI SALVO
        if ($obCompany->id != '') {
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/empresa/lista?status=created');
        }

        //REDIRECIONA O USUÁRIO ERRO
        $request->getRouter()->redirect('/empresa/lista?status=errorCreated');
    }

    /**
     * Método responsável por retornar o formulário de edição de um empresa
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditCompany(Request $request, int $id): string
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $obCompany = EntityCompany::getCompanyById($id);

        //VALIDA A INSTANCIA
        if(!$obCompany instanceof EntityCompany){
            $request->getRouter()->redirect('/admin/adm/users/list');
        }

        //VERIFICA O STATUS DO EMPRESA E RETORNA NO SELECT
        switch ($obCompany->status) {
            case "0": {
                $disabled = "selected";
                break;
            }
            case "1": {
                $active = "selected";
                break;
            }
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('/admin/adm/company/form', [
            'id' => $obCompany->id,
            'company' => $obCompany->company,
            'options_status_company' => "<option value='1' $active>ATIVO</option>.
                                      <option value='0' $disabled>DESATIVAR</option>",
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Empresa',
            'Editar Empresa',
            $content
        );
    }

    /**
     * Método responsável por grava a ataulização de um empresa
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditCompany(Request $request, int $id): string
    {
        //OBTÉM O EMPRESA DO BANCO DE DADOS
        $obCompany = EntityCompany::getCompanyById($id);

        //VALIDA A INSTANCIA
        if(!$obCompany instanceof EntityCompany){
            $request->getRouter()->redirect('/empresa/lista');
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obCompany->company = $postVars['company'] ?? $obCompany->company;
        $obCompany->status = $postVars['status'] ?? $obCompany->status;
        $obCompany->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/empresa/lista/'.$obCompany->id.'/edit?status=updated');
    }


    /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteCompany(Request $request, int $id): string
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obCompany = EntityCompany::getCompanyById($id);

        //VALIDA A INSTANCIA
        if(!$obCompany instanceof EntityCompany){
            $request->getRouter()->redirect('/empresa/lista/');
        }

        //EXCLUI O DEPOIMENTO
        $obCompany->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/empresa/lista?status=deleted');
    }

    /**
     * Método responsável por obter a renderização dos itens da empresa para a página
     * @param $request $request
     */
    public static function getListCompaniesArray(Request $request): array
    {

        //RESULTADOS DA PÁGINA
        $results = EntityCompany::getCompanies('*', null, null, 'id DESC', '');

        //RETORNA ITEM EMPRESA
        return $results->fetchAll();

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
            case 'created':
                return Alert::getSuccess('Sucesso','Empresa salva com sucesso.');
                break;
            case 'updated':
                return Alert::getSuccess('Sucesso','Empresa atualizado com sucesso.');
                break;
            case 'deleted':
                return Alert::getSuccess('Sucesso','Empresa deletada com sucesso.');
                break;
            case 'disable':
                return Alert::getWarning('Atenção :|','Empresa inativo no momento!');
                break;
            case 'duplicated':
                return Alert::getWarning('Atenção :|','Empresa já cadastrada!');
                break;
        }
    }

}