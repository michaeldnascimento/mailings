<?php

namespace App\Http\Controller\Admin\Adm\Input;

use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\MailingInput as EntityInput;
use App\Model\Entity\StateCity as EntityStateCity;
use App\Utils\View;

class Bot extends Page {

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getMailingsListUser(string $list): string
    {

        //MAILING
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityInput::getMailingInput("*, DATE_FORMAT(data_cancelamento, '%d/%m/%Y') as data_cancelamento", null, "lista = '$list' AND status_lista = 2 AND (status_mailing IS NULL OR status_mailing = '' OR status_mailing LIKE '%OPORTUNIDADE%')", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obInput = $results->fetchObject(EntityInput::class)){

            //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
            switch ($obInput->status_lista) {
                case "1": {
                    $status_lista = "Concluído";
                    $color_status_lista = "table-success";
                    break;
                }
                case "2": {
                    $status_lista = "Aguardando";
                    $color_status_lista = "table-warning";
                    break;
                }
                case "3": {
                    $status_lista = "Dados não localizados";
                    $color_status_lista = "table-danger";
                    break;
                }
            }


            $items .=  View::render('admin/adm/input/bot/modules/item', [
                'id' => $obInput->id,
                'contrato' => $obInput->contrato,
                'cpf' => $obInput->cpf,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'status_lista' => $status_lista,
                'color_status_lista' => $color_status_lista,
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
    public static function getListInput(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/adm/input/bot/lista", [
            'itens_user'   => self::getMailingsListUser($list),
            'lista'        => $list
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Mailings',
            "$list",
            'Lista Input',
            $content
        );
    }

    /**
     * Método responsável gerar novo mailing lista1
     * @param Request $request
     * @param string $list
     * @return string
     */
    public static function setListInput(Request $request, string $list): string
    {

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //POST VARS
        $postVars = $request->getPostVars();

        //PEGAR ESTADO E CIDADE
        $estado = EntityStateCity::getState($postVars['estado']);
        $cidade = EntityStateCity::getCity($postVars['cidade']);

        //GET CPF/CNPJ E REMOVE STRINGS
        $cpf_contrato = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $postVars['cpf-contrato']);

        //REMOVE CPF/CNPJ QUE COMEÇA COM 0 A ESQUERDA
        $cpf_contrato = ltrim($cpf_contrato, "0");

        $mailing = EntityInput::getMailingByCpfContrato($cpf_contrato);

        if (!empty($mailing)){
            //ATUALIZA A STATUS  MAILING
            $id = EntityInput::setMailingExisting($mailing, $list, $id_user);
            if (!empty($id)){
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect("/vendedor/input/$list?status=mailingExisting");
            }else{
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect("/vendedor/input/$list?status=mailingError");
            }
        }else{

            if(strlen($cpf_contrato) == 11){
                
                //SET MAILING CPF
                $id = EntityInput::setMailingNotExisting($cpf_contrato, 0 , $cidade->nome, $estado->uf, $list, $id_user);

                if (!empty($id)){
                    //REDIRECIONA O USUÁRIO
                    $request->getRouter()->redirect("/vendedor/input/$list?status=newMailingCPF");
                }else{
                    //REDIRECIONA O USUÁRIO
                    $request->getRouter()->redirect("/vendedor/input/$list?status=mailingError");
                }
            }else{

                //SET MAILING CONTRATO
                $id = EntityInput::setMailingNotExisting(0, $cpf_contrato , $cidade->nome, $estado->uf, $list, $id_user);
                
                if (!empty($id)){
                    //REDIRECIONA O USUÁRIO
                    $request->getRouter()->redirect("/vendedor/input/$list?status=newMailingContrato");
                }else{
                    //REDIRECIONA O USUÁRIO
                    $request->getRouter()->redirect("/vendedor/input/$list?status=mailingError");
                }
            }

            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect("/vendedor/input/$list?status=mailingErrorCPFContrato");
        }

    }


}