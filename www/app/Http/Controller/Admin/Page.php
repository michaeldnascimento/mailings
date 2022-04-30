<?php

namespace App\Http\Controller\Admin;

use \App\Utils\View;
use \App\Db\Pagination;
use \App\Http\Request;
use \App\Session\Admin\Nivel as SessionNivel;

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

        return View::render('admin/layouts/sidebar',[
            'display' => "style=display:$valueDisplay",
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