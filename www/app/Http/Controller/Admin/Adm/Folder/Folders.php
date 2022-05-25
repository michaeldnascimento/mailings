<?php

namespace App\Http\Controller\Admin\Adm\Folder;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Company as EntityCompany;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Folders extends Page
{

    /**
     * Método responsável por obter a renderização dos itens da empresa para a página
     */
    public static function getListCompaniesRouter(): \PDOStatement
    {

        //RETORNA AS EMPRESAS
        return EntityCompany::getCompanies('*', null, 'status = 1', 'id DESC', '');

    }

    /**
     * Método responsável por obter a renderização dos itens da empresa para a página
     * @param $request $request
     */
    public static function getListFolderItems(Request $request, string $id): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityCompany::getCompanies('*', null, null, 'id DESC', '');

        //RENDERIZA O ITEM
        while($obCompanies = $results->fetchObject(EntityCompany::class)){
            $items .=  View::render('admin/adm/folder/modules/folders/item', [
                'id' => $obCompanies->id,
                'company' => $obCompanies->company,
                'status' => $obCompanies->status,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de empresa
     * @param Request $request
     * @param string $id
     * @param string|null $errorMessage
     * @return string
     */
    public static function getFoldersList(Request $request, string $id, string $errorMessage = null): string
    {

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA DE EMPRESA
        $content = View::render('admin/adm/folder/list', [
            'itens'       => self::getListFolderItems($request, $id),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Empresa',
            'Lista de Empresa',
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