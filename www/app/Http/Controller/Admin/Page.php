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

        //RECEBE SESSÃO SOLAR
        $solar = $_SESSION['mailings']['admin']['user']['solar'];

        //DISPLAY SOLAR
        if ($solar == 1){
            $valueDisplaySolar  = "block";
        }else{
            $valueDisplaySolar  = "none";
        }

        //RECEBE SESSÃO CHAMADO
        $call = $_SESSION['mailings']['admin']['user']['call'];

        //DISPLAY CALL
        if ($call == 1){
            $valueDisplayCalled  = "block";
        }else{
            $valueDisplayCalled  = "none";
        }

        //BUSCA EMPRESAS
        $resultsCompanies = Folders::getListCompaniesRouter();

        //RECEBE NUMERO EMPRESA NA SESSÃO
        $companies = $_SESSION['mailings']['admin']['user']['companies'];

        /****************** LIST MAILING INPUT **********************/
        //RECEBE DA SESSÃO INPUT
        $input = $_SESSION['mailings']['admin']['user']['input'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($input)){
            //LISTAS LIBERADAS POR SESSÃO
            $listInput = explode(", ", $input);

            $valueDisplayInputSolarbot1 = in_array('solarbot1', $listInput) ? 'block' : 'none';
            $valueDisplayInputSolarbot2 = in_array('solarbot2', $listInput) ? 'block' : 'none';
            $valueDisplayInputSolarbot3 = in_array('solarbot3', $listInput) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS INPUT LIBERADAS
            $valueDisplayInput = "none";
        }


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

        /****************** LIST MAILING AMERICANET **********************/
        //RECEBE DA SESSÃO NET
        $americanet = $_SESSION['mailings']['admin']['user']['americanet'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($americanet)){
            //LISTAS LIBERADAS POR SESSÃO
            $listAmericanet = explode(", ", $americanet);

            $valueDisplayAmericanetBase = in_array('base', $listAmericanet) ? 'block' : 'none';
            $valueDisplayAmericanetCancelados = in_array('cancelados', $listAmericanet) ? 'block' : 'none';
            $valueDisplayAmericanetPedidos = in_array('pedidos', $listAmericanet) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS AMERICANET LIBERADAS
            $valueDisplayAmericanet = "none";
        }

        /****************** LIST MAILING VERO **********************/
        //RECEBE DA SESSÃO NET
        $vero = $_SESSION['mailings']['admin']['user']['vero'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($vero)){
            //LISTAS LIBERADAS POR SESSÃO
            $listVero = explode(", ", $vero);

            $valueDisplayVeroBase = in_array('base', $listVero) ? 'block' : 'none';
            $valueDisplayVeroCancelados = in_array('cancelados', $listVero) ? 'block' : 'none';
            $valueDisplayVeroPedidos = in_array('pedidos', $listVero) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS VERO LIBERADAS
            $valueDisplayVero = "none";
        }


        /****************** LIST MAILING DESKTOP GET **********************/
        //RECEBE DA SESSÃO DESKTOP
        $desktopGet = $_SESSION['mailings']['admin']['user']['desktop_get'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($desktopGet)){
            //LISTAS LIBERADAS POR SESSÃO
            $listDesktopGet = explode(", ", $desktopGet);

            $valueDisplayDesktopGetBase = in_array('base', $listDesktopGet) ? 'block' : 'none';
            $valueDisplayDesktopGetCancelados = in_array('cancelados', $listDesktopGet) ? 'block' : 'none';
            $valueDisplayDesktopGetPedidos = in_array('pedidos', $listDesktopGet) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS ALGAR LIBERADAS
            $valueDisplayDesktopGet = "none";
        }

        /****************** LIST MAILING DESKTOP SIS **********************/
        //RECEBE DA SESSÃO DESKTOP
        $desktopSis = $_SESSION['mailings']['admin']['user']['desktop_sis'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($desktopSis)){
            //LISTAS LIBERADAS POR SESSÃO
            $listDesktopSis = explode(", ", $desktopSis);

            $valueDisplayDesktopSisBase = in_array('base', $listDesktopSis) ? 'block' : 'none';
            $valueDisplayDesktopSisCancelados = in_array('cancelados', $listDesktopSis) ? 'block' : 'none';
            $valueDisplayDesktopSisPedidos = in_array('pedidos', $listDesktopSis) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS ALGAR LIBERADAS
            $valueDisplayDesktopSis = "none";
        }

        /****************** LIST MAILING DESKTOP NETBARRETOS **********************/
        //RECEBE DA SESSÃO DESKTOP
        $desktopNetbarretos = $_SESSION['mailings']['admin']['user']['desktop_netbarretos'];

        //SE FOR DIFERENTE DE VAZIO
        if (!empty($desktopNetbarretos)){
            //LISTAS LIBERADAS POR SESSÃO
            $listDesktopNetbarretos = explode(", ", $desktopNetbarretos);

            $valueDisplayDesktopNetbarretosBase = in_array('base', $listDesktopNetbarretos) ? 'block' : 'none';
            $valueDisplayDesktopNetbarretosCancelados = in_array('cancelados', $listDesktopNetbarretos) ? 'block' : 'none';
            $valueDisplayDesktopNetbarretosPedidos = in_array('pedidos', $listDesktopNetbarretos) ? 'block' : 'none';
        }else{

            //SE NÃO ESTIVER LISTAS ALGAR LIBERADAS
            $valueDisplayDesktopNetbarretos = "none";
        }

        //VERIFICA SE TODAS AS LISTAS DESKTOP ESTÃO VAZIAS
        if (empty($desktopGet) AND empty($desktopSis) AND empty($desktopNetbarretos)){
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

            'display_seller_input' => "style=display:$valueDisplayInput",
            'display_seller_input_solarbot1' => "style=display:$valueDisplayInputSolarbot1",
            'display_seller_input_solarbot2' => "style=display:$valueDisplayInputSolarbot2",
            'display_seller_input_solarbot3' => "style=display:$valueDisplayInputSolarbot3",

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

            'display_seller_americanet' => "style=display:$valueDisplayAmericanet",
            'display_seller_americanet_base' => "style=display:$valueDisplayAmericanetBase",
            'display_seller_americanet_cancelados' => "style=display:$valueDisplayAmericanetCancelados",
            'display_seller_americanet_pedidos' => "style=display:$valueDisplayAmericanetPedidos",

            'display_seller_vero' => "style=display:$valueDisplayVero",
            'display_seller_vero_base' => "style=display:$valueDisplayVeroBase",
            'display_seller_vero_cancelados' => "style=display:$valueDisplayVeroCancelados",
            'display_seller_vero_pedidos' => "style=display:$valueDisplayVeroPedidos",

            'display_seller_desktop' => "style=display:$valueDisplayDesktop",
            'display_seller_desktop_get' => "style=display:$valueDisplayDesktopGet",
            'display_seller_desktop_get_base' => "style=display:$valueDisplayDesktopGetBase",
            'display_seller_desktop_get_cancelados' => "style=display:$valueDisplayDesktopGetCancelados",
            'display_seller_desktop_get_pedidos' => "style=display:$valueDisplayDesktopGetPedidos",

            'display_seller_desktop_sis' => "style=display:$valueDisplayDesktopSis",
            'display_seller_desktop_sis_base' => "style=display:$valueDisplayDesktopSisBase",
            'display_seller_desktop_sis_cancelados' => "style=display:$valueDisplayDesktopSisCancelados",
            'display_seller_desktop_sis_pedidos' => "style=display:$valueDisplayDesktopSisPedidos",

            'display_seller_desktop_netbarretos' => "style=display:$valueDisplayDesktopNetbarretos",
            'display_seller_desktop_netbarretos_base' => "style=display:$valueDisplayDesktopNetbarretosBase",
            'display_seller_desktop_netbarretos_cancelados' => "style=display:$valueDisplayDesktopNetbarretosCancelados",
            'display_seller_desktop_netbarretos_pedidos' => "style=display:$valueDisplayDesktopNetbarretosPedidos",


            'display_cep' => "style=display:$valueDisplayCep",
            'display_client' => "style=display:$valueDisplayClient",
            'display_solar' => "style=display:$valueDisplaySolar",
            'display_called' => "style=display:$valueDisplayCalled",
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