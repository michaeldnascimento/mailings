<?php

namespace App\Http\Controller\Admin\Adm\Input;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\User as EntityUser;
use App\Utils\Import\Excel\CSV;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Lists extends Page {

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getLists(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/adm/input/lists', [
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Listas',
            'Input de listas',
            $content
        );
    }


    /**
     * Método responsável por inserir mailing nas listas
     * @param Request $request
     */
    public static function setNewMailingList(Request $request)
    {

        //POST VARS
        $postVars = $request->getPostVars();

        //RESULTADOS DA PÁGINA
        $resultImport = CSV::importCSVMailings($request, $_FILES["inputCSV"], $postVars['inputList']);


        //VERIFICA A VALIDAÇÃO DE SENHA
        if ($resultImport == true){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/adm/input/listas?status=successImport');
        }

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/adm/input/listas?status=errorImport');

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
            case 'successImport':
                return Alert::getSuccess('Sucesso','Mailing importado com sucesso!');
                break;
            case 'errorImport':
                return Alert::getError('Erro :(','Erro ao importar o mailing');
                break;
            case 'erroExtension':
                return Alert::getError('Erro :(','Necessário enviar arquivo .csv');
                break;
            case 'nullCSV':
                return Alert::getWarning('Atenção :|','Anexar CSV.');
                break;
            case 'erroMove':
                return Alert::getError('Erro :(','ao salvar arquivo');
                break;
        }
    }

}