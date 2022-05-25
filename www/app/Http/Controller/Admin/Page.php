<?php

namespace App\Http\Controller\Admin;

use \App\Utils\View;
use \App\Db\Pagination;
use \App\Http\Request;
use \App\Session\Admin\Nivel as SessionNivel;
use \App\Http\Controller\Admin\Adm\Folder\Folders;

class Page {


    /**
     * Método responsavel por renderizar o topo da pagina
     * @param string $title
     * @param string $web_title
     * @return string
     */
    private static function getHeader(string $title, string $web_title): string
    {
        return View::render('admin/layouts/header',
            [
                'title' => $title,
                'web_title' => $web_title
            ]);
    }

    /**
     * Método responsavel por renderizar o rodapé da pagina
     * @return string
     */
    private static function getFooter(): string
    {
        return View::render('admin/layouts/footer');
    }

    /**
     * Método responsavel por renderizar o rodapé da pagina
     * @return string
     */
    private static function getSidebar(): string
    {

        //VERIFICA O NIVEL DE ACESSO
        if (SessionNivel::getNivelSession() == 2){
            $valueDisplay = "block";
        }else{
            $valueDisplay = "none";
        }

        //BUSCA EMPRESAS
        $resultsCompanies = Folders::getListCompaniesRouter();

        while($obCompanies = $resultsCompanies->fetchObject(Folders::class)) {

            //ID PASTA
            $folder_id = $obCompanies->id;
            $folder_company = $obCompanies->company;

            $folders .= "<li class='sidebar-item  has-sub'>
                        <a href='#' class='sidebar-link'>
                            <i class='bi bi-person-lines-fill'></i>
                            <span>$folder_company</span>
                        </a>
                        <ul class='submenu'>
                            <li class='submenu-item'>
                                <a href='/pasta/$folder_id'>Arquivos</a>
                            </li>
                        </ul>
                    </li>";

        }

        //CARREGA SIDEBAR
        return View::render('admin/layouts/sidebar',[
            'display' => "style=display:$valueDisplay",
            'folders' => $folders,
        ]);
    }


    /**
     * Método responsável por retornar o conteúdo (view) da estrutura genética da página do painel
     * @param string $title
     * @param string $web_title
     * @param string $desc
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $web_title, string $desc, string $content): string
    {

        return View::render('admin/page', [
            'header'  => self::getHeader($title, $web_title),
            'page-title' => $web_title,
            'page-desc' => $desc,
            'sidebar'  => self::getSidebar(),
            'content' => $content,
            'footer'  => self::getFooter()
        ]);
    }

}