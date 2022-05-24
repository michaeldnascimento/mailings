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
}