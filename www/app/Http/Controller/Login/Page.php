<?php

namespace App\Http\Controller\login;

use \App\Utils\View;
use \App\Db\Pagination;
use \App\Http\Request;

class Page {

    /**
     * Método responsavel por renderizar o topo da pagina
     * @param string $title
     * @param string $web_title
     * @return string
     */
    private static function getHeader(string $title, string $web_title): string
    {
        return View::render('login/layouts/auth-header',
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
        return View::render('login/layouts/auth-footer');
    }


    /**
     * Método responsável por retornar o conteúdo (view) da estrutura genética da página do painel
     * @param string $title
     * @param string $web_title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $web_title, string $content): string
    {
        return View::render('login/page', [
            'header'  => self::getHeader($title, $web_title),
            'content' => $content,
            'footer'  => self::getFooter()
        ]);
    }

}