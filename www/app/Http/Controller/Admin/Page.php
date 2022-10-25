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
        if (SessionNivel::getNivelSession() == 3){
            $valueDisplayAdm     = "block";
            $valueDisplayCompany = "block";
            $valueDisplaySeller  = "block";
        }

        if (SessionNivel::getNivelSession() == 2){
            $valueDisplayAdm     = "none";
            $valueDisplayCompany = "block";
            $valueDisplaySeller  = "none";
        }

        if (SessionNivel::getNivelSession() == 1){
            $valueDisplayAdm     = "none";
            $valueDisplayCompany = "none";
            $valueDisplaySeller  = "block";
        }

        if (SessionNivel::getNivelSession() == 0 OR SessionNivel::getNivelSession() == null){
            $valueDisplayAdm     = "none";
            $valueDisplayCompany = "none";
            $valueDisplaySeller  = "none";
        }

        //RECEBE SESSÃO CEP
        $cep = $_SESSION['mailings']['admin']['user']['cep'];

        //DISPLAY CEP
        if ($cep == 1){
            $valueDisplayCep  = "block";
        }else{
            $valueDisplayCep  = "none";
        }

        //RECEBE SESSÃO CLIENT
        $client = $_SESSION['mailings']['admin']['user']['client'];

        //DISPLAY CEP
        if ($client == 1){
            $valueDisplayClient  = "block";
        }else{
            $valueDisplayClient  = "none";
        }

        //BUSCA EMPRESAS
        $resultsCompanies = Folders::getListCompaniesRouter();

        //RECEBE NUMERO EMPRESA NA SESSÃO
        $companies = $_SESSION['mailings']['admin']['user']['companies'];


        /****************** LIST MAILING ALGAR **********************/
        //RECEBE DA SESSÃO ALGAR
        $algar = $_SESSION['mailings']['admin']['user']['algar'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($algar)){
            //LISTAS LIBERADAS POR SESSÃO
            $listAlgar = explode(", ", $algar);

            $valueDisplayAlgarBase = in_array('base', $listAlgar) ? 'block' : 'none';
            $valueDisplayAlgarCancelado = in_array('cancelado', $listAlgar) ? 'block' : 'none';
            $valueDisplayAlgarProposta = in_array('proposta', $listAlgar) ? 'block' : 'none';
            $valueDisplayAlgarPendenteInstalacao = in_array('pendente-instalacao', $listAlgar) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS ALGAR LIBERADAS
            $valueDisplayAlgar = "none";
        }


        /****************** LIST MAILING CLARO **********************/
        //RECEBE DA SESSÃO CLARO
        $claro = $_SESSION['mailings']['admin']['user']['claro'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($claro)){
            //LISTAS LIBERADAS POR SESSÃO
            $listClaro = explode(", ", $claro);

            $valueDisplayClaroCancelado = in_array('cancelado', $listClaro) ? 'block' : 'none';
            $valueDisplayClaroDesabilitado = in_array('desabilitado', $listClaro) ? 'block' : 'none';
            $valueDisplayClaroProposta = in_array('proposta', $listClaro) ? 'block' : 'none';
            $valueDisplayClaroPendenteInstalacao = in_array('pendente-instalacao', $listClaro) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS CLARO LIBERADAS
            $valueDisplayClaro = "none";
        }

        /****************** LIST MAILING NET **********************/
        //RECEBE DA SESSÃO NET
        $net = $_SESSION['mailings']['admin']['user']['net'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($net)){
            //LISTAS LIBERADAS POR SESSÃO
            $listNet = explode(", ", $net);

            $valueDisplayNetCancelado = in_array('cancelado', $listNet) ? 'block' : 'none';
            $valueDisplayNetDesabilitado = in_array('desabilitado', $listNet) ? 'block' : 'none';
            $valueDisplayNetProposta = in_array('proposta', $listNet) ? 'block' : 'none';
            $valueDisplayNetPendenteInstalacao = in_array('pendente-instalacao', $listNet) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS NET LIBERADAS
            $valueDisplayNet = "none";
        }

        /****************** LIST MAILING DESKTOP **********************/
        //RECEBE DA SESSÃO DESKTOP
        $desktop = $_SESSION['mailings']['admin']['user']['desktop'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($desktop)){
            //LISTAS LIBERADAS POR SESSÃO
            $listDesktop = explode(", ", $desktop);

            $valueDisplayDesktopLista1 = in_array('lista1', $listDesktop) ? 'block' : 'none';
            $valueDisplayDesktopLista2 = in_array('lista2', $listDesktop) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS ALGAR LIBERADAS
            $valueDisplayDesktop = "none";
        }


        while($obCompanies = $resultsCompanies->fetchObject(Folders::class)) {

            //ID PASTA
            $folder_id = $obCompanies->id;
            $folder_company = $obCompanies->company;

            //VERIFICA EMPRESA USUÁRIO
            if((SessionNivel::getNivelSession() == 2 OR SessionNivel::getNivelSession() == 0 OR SessionNivel::getNivelSession() == null) AND ($companies != $folder_id)){
                $valueDisplayCompanyWhile = "none";
            }else{
                $valueDisplayCompanyWhile = "block";
            }

            $folders .= "<li style='display:$valueDisplayCompanyWhile' class='sidebar-item  has-sub'>
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
            'display_adm' => "style=display:$valueDisplayAdm",
            'display_company' => "style=display:$valueDisplayCompany",
            'display_seller' => "style=display:$valueDisplaySeller",

            'display_seller_algar' => "style=display:$valueDisplayAlgar",
            'display_seller_algar_base' => "style=display:$valueDisplayAlgarBase",
            'display_seller_algar_cancelado' => "style=display:$valueDisplayAlgarCancelado",
            'display_seller_algar_proposta' => "style=display:$valueDisplayAlgarProposta",
            'display_seller_algar_pendente_instalacao' => "style=display:$valueDisplayAlgarPendenteInstalacao",

            'display_seller_claro' => "style=display:$valueDisplayClaro",
            'display_seller_claro_cancelado' => "style=display:$valueDisplayClaroCancelado",
            'display_seller_claro_desabilitado' => "style=display:$valueDisplayClaroDesabilitado",
            'display_seller_claro_proposta' => "style=display:$valueDisplayClaroProposta",
            'display_seller_claro_pendente_instalacao' => "style=display:$valueDisplayClaroPendenteInstalacao",

            'display_seller_net' => "style=display:$valueDisplayNet",
            'display_seller_net_cancelado' => "style=display:$valueDisplayNetCancelado",
            'display_seller_net_desabilitado' => "style=display:$valueDisplayNetDesabilitado",
            'display_seller_net_proposta' => "style=display:$valueDisplayNetProposta",
            'display_seller_net_pendente_instalacao' => "style=display:$valueDisplayNetPendenteInstalacao",

            'display_seller_desktop' => "style=display:$valueDisplayDesktop",
            'display_seller_desktop_lista1' => "style=display:$valueDisplayDesktopLista1",
            'display_seller_desktop_lista2' => "style=display:$valueDisplayDesktopLista2",


            'display_cep' => "style=display:$valueDisplayCep",
            'display_client' => "style=display:$valueDisplayClient",
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