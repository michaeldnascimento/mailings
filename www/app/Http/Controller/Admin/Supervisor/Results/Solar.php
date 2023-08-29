<?php

namespace App\Http\Controller\Admin\Supervisor\Results;

use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\MailingInput as EntityInput;
use App\Model\Entity\User as EntityUser;
use App\Utils\View;

class Solar extends Page {

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @return string
     */
    public static function getListResultBot(): string
    {

        //MAILING
        $items = '';

        //BUSCAR RESULTADO EQUIPE
        $id_team = $_SESSION['mailings']['admin']['user']['team'];

        if ($id_team != 0) {
            $team = "id_team = $id_team";
        }else{
            $team = '';
        } 

        //RESULTADOS DA PÁGINA
        $results = EntityInput::getMailingInput("*", null, "$team", 'id DESC', '');

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

            //echo "<pre>";
            //print_r($obInput);
            //exit();

            $items .=  View::render('admin/supervisor/result/solar/modules/item_results', [
                'id' => $obInput->id,
                'contrato' => $obInput->contrato,
                'cpf' => $obInput->cpf,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'codigo_cidade' => $obInput->codigo_cidade,
                'user' => $obUserName->name ?? 'Livre',
                'status_lista' => $status_lista,
                'status_mailing' => $obInput->status_mailing,
                'lista' => $obInput->lista,
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
    public static function getListInputResults(Request $request): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/supervisor/result/solar/lista_results", [
            'itens_bot'   => self::getListResultBot()
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            "Equipe Solar",
            "Resultados - Equipe",
            "Lista",
            $content
        );
    }

}