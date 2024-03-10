<?php

namespace App\Http\Controller\Admin\Adm\Input;

use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\MailingInput as EntityInput;
use App\Model\Entity\User as EntityUser;
use App\Model\Entity\Finder as EntityFinder;
use App\Utils\View;

class Bot extends Page {

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getListFinderResultBot(string $list): string
    {

        //MAILING
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityFinder::getFinderInput("*, date_format(atualizado, '%d/%m/%Y %Hh%i') as atualizado", null, "lista = '$list'", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obFinder = $results->fetchObject(EntityFinder::class)){

            //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
            switch ($obFinder->status) {
                case "1": {
                    $status_lista = "Concluído";
                    $color_status_button = "btn-success disabled";
                    $color_status_lista = "table-success";
                    break;
                }
                case "2": {
                    $status_lista = "Aguardando";
                    $color_status_button = "btn-warning disabled";
                    $color_status_lista = "table-warning";
                    break;
                }
                case "3": {
                    $status_lista = "Dados não localizados";
                    $color_status_button = "btn-danger disabled";
                    $color_status_lista = "table-danger";
                    break;
                }
                case "4": {
                    $status_lista = "Processando";
                    $color_status_button = "btn-primary disabled";
                    $color_status_lista = "table-primary";
                    break;
                }
            }

            if(!empty($obFinder->id_user)){
                //OBTÉM O USUÁRIO DO BANCO DE DADOS
                $obUserName = EntityUser::getUserByIdReturnName($obFinder->id_user);
            }

            $items .=  View::render('admin/adm/input/bot/modules/item_finder_results', [
                'id' => $obFinder->id,
                'nome_razao_social' => $obFinder->nome_razao_social,
                'cpf_cnpj' => $obFinder->cpf_cnpj,
                'origem' => $obFinder->origem,
                'tipo_pessoa' => $obFinder->tipo_pessoa,
                'atualizado' => $obFinder->atualizado,
                'user' => $obUserName->name ?? 'Livre',
                'status_lista' => $status_lista,
                'lista' => $list,
                'color_status_lista' => $color_status_lista,
                'color_status_button' => $color_status_button,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getListResultBot(string $list): string
    {

        //MAILING
        $items = '';

        //BUSCAR RESULTADO EQUIPE
        $id_team = $_SESSION['mailings']['admin']['user']['team'];

        if ($id_team != 0) {
            $team = "AND id_team = $id_team";
        }else{
            $team = '';
        } 

        //RESULTADOS DA PÁGINA
        $results = EntityInput::getMailingInput("*", null, "lista = '$list'", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obInput = $results->fetchObject(EntityInput::class)){

            //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
            switch ($obInput->status_lista) {
                case "1": {
                    $status_lista = "Concluído";
                    $color_status_button = "btn-success disabled";
                    $color_status_lista = "table-success";
                    break;
                }
                case "2": {
                    $status_lista = "Aguardando";
                    $color_status_button = "btn-warning disabled";
                    $color_status_lista = "table-warning";
                    break;
                }
                case "3": {
                    $status_lista = "Dados não localizados";
                    $color_status_button = "btn-danger disabled";
                    $color_status_lista = "table-danger";
                    break;
                }
                case "4": {
                    $status_lista = "Processando";
                    $color_status_button = "btn-primary disabled";
                    $color_status_lista = "table-primary";
                    break;
                }
            }

            if(!empty($obInput->id_user)){
                //OBTÉM O USUÁRIO DO BANCO DE DADOS
                $obUserName = EntityUser::getUserByIdReturnName($obInput->id_user);
            }

            $items .=  View::render('admin/adm/input/bot/modules/item_results', [
                'id' => $obInput->id,
                'contrato' => $obInput->contrato,
                'cpf' => $obInput->cpf,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'codigo_cidade' => $obInput->codigo_cidade,
                'user' => $obUserName->name ?? 'Livre',
                'status_lista' => $status_lista,
                'lista' => $list,
                'color_status_lista' => $color_status_lista,
                'color_status_button' => $color_status_button,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getListBotFinder(string $list): string
    {

        //MAILING
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityFinder::getFinderInput("*", null, "(lista = '$list') AND (status = 2 OR status = 4)", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obFinder = $results->fetchObject(EntityFinder::class)){

            //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
            switch ($obFinder->status) {
                case "1": {
                    $status_lista = "Concluído";
                    $color_status_button = "btn-success";
                    $color_status_lista = "table-success";
                    break;
                }
                case "2": {
                    $status_lista = "Aguardando";
                    $color_status_button = "btn-warning";
                    $color_status_lista = "table-warning";
                    break;
                }
                case "3": {
                    $status_lista = "Dados não localizados";
                    $color_status_button = "btn-danger";
                    $color_status_lista = "table-danger";
                    break;
                }
                case "4": {
                    $status_lista = "Processando";
                    $color_status_button = "btn-primary disabled";
                    $color_status_lista = "table-primary";
                    break;
                }
            }

            if(!empty($obFinder->id_user)){
                //OBTÉM O USUÁRIO DO BANCO DE DADOS
                $obUserName = EntityUser::getUserByIdReturnName($obFinder->id_user);
            }

            $items .=  View::render('admin/adm/input/bot/modules/item_finder', [
                'id' => $obFinder->id,
                'cpf_cnpj' => $obFinder->cpf_cnpj,
                'user' => $obUserName->name ?? 'Livre',
                'status_lista' => $status_lista,
                'lista' => $list,
                'color_status_lista' => $color_status_lista,
                'color_status_button' => $color_status_button,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getListBot(string $list): string
    {

        //MAILING
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityInput::getMailingInput("*", null, "(lista = '$list') AND (status_lista = 2 OR status_lista = 4) AND (status_mailing IS NULL OR status_mailing = '' OR status_mailing LIKE '%OPORTUNIDADE%')", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obInput = $results->fetchObject(EntityInput::class)){

            //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
            switch ($obInput->status_lista) {
                case "1": {
                    $status_lista = "Concluído";
                    $color_status_button = "btn-success";
                    $color_status_lista = "table-success";
                    break;
                }
                case "2": {
                    $status_lista = "Aguardando";
                    $color_status_button = "btn-warning";
                    $color_status_lista = "table-warning";
                    break;
                }
                case "3": {
                    $status_lista = "Dados não localizados";
                    $color_status_button = "btn-danger";
                    $color_status_lista = "table-danger";
                    break;
                }
                case "4": {
                    $status_lista = "Processando";
                    $color_status_button = "btn-primary disabled";
                    $color_status_lista = "table-primary";
                    break;
                }
            }

            if(!empty($obInput->id_user)){
                //OBTÉM O USUÁRIO DO BANCO DE DADOS
                $obUserName = EntityUser::getUserByIdReturnName($obInput->id_user);
            }

            $items .=  View::render('admin/adm/input/bot/modules/item', [
                'id' => $obInput->id,
                'contrato' => $obInput->contrato,
                'cpf' => $obInput->cpf,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'codigo_cidade' => $obInput->codigo_cidade,
                'user' => $obUserName->name ?? 'Livre',
                'status_lista' => $status_lista,
                'lista' => $list,
                'color_status_lista' => $color_status_lista,
                'color_status_button' => $color_status_button,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização da página
     * @param Request $request
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getListInputFinderResults(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/adm/input/bot/list_finder_results", [
            'itens_bot'   => self::getListFinderResultBot($list),
            'lista'        => $list
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            "Fila Bot Solar",
            "Resultados - $list",
            "Lista",
            $content
        );
    }

        /**
     * Método responsável por retornar a renderização da página
     * @param Request $request
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getListInputResults(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/adm/input/bot/lista_results", [
            'itens_bot'   => self::getListResultBot($list),
            'lista'        => $list
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            "Fila Bot Solar",
            "Resultados - $list",
            "Lista",
            $content
        );
    }

    /**
     * Método responsável por retornar a renderização da página
     * @param Request $request
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getListFinder(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/adm/input/bot/list_finder", [
            'itens_bot'   => self::getListBotFinder($list),
            'lista'        => $list
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Fila Bot Solar',
            "$list",
            'Lista Input',
            $content
        );
    }

    /**
     * Método responsável por retornar a renderização da página
     * @param Request $request
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getListInput(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/adm/input/bot/lista", [
            'itens_bot'   => self::getListBot($list),
            'lista'        => $list
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Fila Bot Solar',
            "$list",
            'Lista Input',
            $content
        );
    }

    /**
     * Método responsável gerenciar o status do mailing
     * @param Request $request
     * @param string $list
     * @param int $id
     */
    public static function editStatusFinder(Request $request, string $list, int $id)
    {

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obFinder = EntityFinder::getInputById($id);

        //VALIDA A INSTANCIA
        if(!$obFinder instanceof EntityFinder){
            $request->getRouter()->redirect("/adm/input/$obFinder->lista/");
        }

        //ATUALIZA A INSTANCIA
        $obFinder->id = $id;
        $obFinder->status = 4;
        $obFinder->atualizado = date('Y-m-d H:m:s');
        $obFinder->atualizar();

        //VERIFICA A LISTA QUE FOI FEITA A TABULAÇÃO
        $request->getRouter()->redirect("/adm/input/$list");
    }


    /**
     * Método responsável gerenciar o status do mailing
     * @param Request $request
     * @param string $list
     * @param int $id
     */
    public static function editStatusInput(Request $request, string $list, int $id)
    {

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obInput = EntityInput::getInputById($id);

        //VALIDA A INSTANCIA
        if(!$obInput instanceof EntityInput){
            $request->getRouter()->redirect("/adm/input/$obInput->lista/");
        }

        //ATUALIZA A INSTANCIA
        $obInput->id = $id;
        $obInput->status_lista = 4;
        $obInput->status_lista_datetime = date('Y-m-d H:m:s');
        $obInput->atualizar();

        //VERIFICA A LISTA QUE FOI FEITA A TABULAÇÃO
        $request->getRouter()->redirect("/adm/input/$list");
    }

}