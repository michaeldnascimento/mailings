<?php

namespace App\Http\Controller\Admin\Adm\Input;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Utils\Import\Excel\Update;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;
use App\Http\Controller\Admin\Adm\Company\Companies;

class Files extends Page {

    /**
     * Método responsável por retornar a renderização da página de arquivos empresa
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getFilesCompanies(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //RETORNA EMPRESA
        $companies = Companies::getListCompaniesArray($request);

        //CRIA O CAMPO SELECT EMPRESA
        $select_company = "";
        foreach ($companies as $key => $col):
            $obj = (Object)$col;
            $select_company .= "<option value='$obj->id'>$obj->company</option>";
        endforeach;

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/adm/input/files', [
            'companies'   => $select_company,
            'status'      => self::getStatus($request),
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Input',
            'Input de Arquivos Empresa',
            $content
        );
    }

    /**
     * Método responsável por inserir novo arquivo
     * @param Request $request
     * @return bool
     */
    public static function setNewFiles(Request $request): bool
    {

        //POST VARS
        $postVars = $request->getPostVars();

        $resultImport = Update::importFiles($request, $postVars["inputCSV"]); //ENVIANDO APENAS NOME ARQUIVO


        //VERIFICA A VALIDAÇÃO DE SENHA
        if ($resultImport){
            return true;
        }

        return false;

    }


    /**
     * Método responsável por inserir novo arquivo nas empresas
     * @param Request $request
     */
    public static function setNewFilesCompanies(Request $request)
    {

        //POST VARS
        $postVars = $request->getPostVars();

        //INPUT ARQUIVO
        //$resultImport = Update::importFilesCompany($request, $_FILES["inputCSV"], $postVars['inputCompany'], $postVars['description']); //INPUT ARQUIVO CSV
        //$resultImport = Update::ftp_file_put_contents($_FILES["inputCSV"], $postVars['inputCompany']); //INPUT ARQUIVO CSV VIA FTP
        $resultImport = Update::importNameFileCompany($request, $postVars["inputCSV"], $postVars['inputCompany'], $postVars['description']); //ENVIANDO APENAS NOME ARQUIVO


        //VERIFICA A VALIDAÇÃO DE SENHA
        if ($resultImport){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/adm/input/empresas?status=successImport');
        }

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/adm/input/empresas?status=errorImport');

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
                return Alert::getSuccess('Sucesso','Arquivo importado com sucesso!');
                break;
            case 'errorImport':
                return Alert::getError('Erro :(','Erro ao importar o arquivo');
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