<?php

namespace App\Http\Controller\Admin\Seller\Input;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\MailingInput as EntityInput;
use App\Model\Entity\StateCity as EntityStateCity;
use App\Utils\View;
use DateTime;

class ListInput extends Page {

    /**
     * Método responsável por remover a string dos números
     * @param string|null $value
     * @return string|int
     */
    public static function removeStringNumber($value)
    {

        if (!empty($value)){
            $value = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $value);
            return ltrim($value, "0");
        }

        return 0;
    }

        /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getListResultInput(string $list): string
    {

        //MAILING
        $items = '';


        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityInput::getMailingInput("*", null, "lista = '$list' AND id_user = $id_user", 'id DESC', '');

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

            $items .=  View::render('admin/seller/input/modules/item_results', [
                'id' => $obInput->id,
                'num_protocolo' => $obInput->num_protocolo,
                'num_pedido_proposta' => $obInput->num_pedido_proposta,
                'contrato' => $obInput->contrato,
                'nome_cliente' => $obInput->nome_cliente,
                'email' => $obInput->email,
                'cep' => $obInput->cep,
                'rg' => $obInput->rg,
                'fone' => $obInput->fone,
                'fone1' => $obInput->fone1,
                'fone2' => $obInput->fone2,
                'endereco' => $obInput->endereco,
                'num' => $obInput->num,
                'compl' => $obInput->compl,
                'bairro' => $obInput->bairro,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'codigo_cidade' => $obInput->codigo_cidade,
                'tipo_pessoa' => $obInput->tipo_pessoa,
                'data_instalacao' => $obInput->data_instalado,
                'data_cancelamento' => $obInput->data_cancelamento,
                'motivo_cancelamento' => $obInput->motivo_cancelamento,
                'nome_mae' => $obInput->nome_mae,
                'tipo_mailing' => $obInput->tipo_mailing,
                'base_cluster' => $obInput->base_cluster,
                'lista' => $list,
                'status_lista' => $status_lista,
                'color_status_lista' => $color_status_lista,

                'status_mailing' => $obInput->status_mailing,
                'status_data_mailing' => $obInput->status_data_mailing,
                'status_obs_mailing' => $obInput->status_obs_mailing,

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
    public static function getInputListUser(string $list): string
    {

        //MAILING
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];


        //RESULTADOS DA PÁGINA
        $results = EntityInput::getMailingInput("*, DATE_FORMAT(data_instalado, '%d/%m/%Y') as data_instalado", null, "lista = '$list' AND id_user = $id_user AND (status_mailing IS NULL OR status_mailing = '' OR status_mailing LIKE '%OPORTUNIDADE%')", 'id DESC', '');

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
                case "4": {
                    $status_lista = "Processando";
                    $color_status_lista = "table-primary";
                    break;
                }
            }


            $items .=  View::render('/admin/seller/input/modules/item', [
                'id' => $obInput->id,
                'num_protocolo' => $obInput->num_protocolo,
                'num_pedido_proposta' => $obInput->num_pedido_proposta,
                'contrato' => $obInput->contrato,
                'nome_cliente' => $obInput->nome_cliente,
                'email' => $obInput->email,
                'cep' => $obInput->cep,
                'cpf' => $obInput->cpf,
                'rg' => $obInput->rg,
                'fone' => $obInput->fone,
                'fone1' => $obInput->fone1,
                'fone2' => $obInput->fone2,
                'endereco' => $obInput->endereco,
                'num' => $obInput->num,
                'compl' => $obInput->compl,
                'bairro' => $obInput->bairro,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'codigo_cidade' => $obInput->codigo_cidade,
                'tipo_pessoa' => $obInput->tipo_pessoa,
                'data_instalacao' => $obInput->data_instalado,
                'data_cancelamento' => $obInput->data_cancelamento,
                'motivo_cancelamento' => $obInput->motivo_cancelamento,
                'nome_mae' => $obInput->nome_mae,
                'tipo_mailing' => $obInput->tipo_mailing,
                'base_cluster' => $obInput->base_cluster,
                'status_lista' => $status_lista,
                'color_status_lista' => $color_status_lista,
                'status_obs_mailing' => $obInput->status_obs_mailing
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
    public static function getListInputResults(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/input/lista_results", [
            'itens_bot'   => self::getListResultInput($list),
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
    public static function getListInput(Request $request, string $list, string $errorMessage = null): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/input/lista", [
            'itens_user'   => self::getInputListUser($list),
            'lista'        => $list,
            'status'       => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Solar Bot',
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

        //echo "<pre>";
        //print_r($postVars);
        //exit;

        if(empty($postVars['cpf']) AND empty($postVars['contrato'])){
            $request->getRouter()->redirect("/vendedor/input/$list?status=CPFContratoExisting");
        }

        //if((empty($postVars['estado']) OR empty($postVars['cidade'])) AND empty($postVars['codigo_cidade'])){
            //$request->getRouter()->redirect("/vendedor/input/$list?status=CityExisting");
        //}

        //if(!empty($postVars['estado'])){
            //PEGAR ESTADO
            //$estado = EntityStateCity::getState($postVars['estado']);
        //}

        //if(!empty($postVars['cidade'])){
            //PEGAR CIDADE
            //$cidade = EntityStateCity::getCity($postVars['cidade']);
        //}

        //GET CPF/CNPJ E REMOVE STRINGS
        $cpf = self::removeStringNumber($postVars['cpf']);
        $contrato = self::removeStringNumber($postVars['contrato']);

        // Formata o código da cidade com zeros à esquerda
        $codigo_cidade = str_pad($postVars['codigo_cidade'], 3, '0', STR_PAD_LEFT);

        //VERIFICA SE O CPF OU CONTRATO ESTÁ VAZIO PARA AI SIM FAZER A CONSULTA SE JÁ EXISTE
        if(!empty($cpf)){
            //VERFICAR SE EXISTE CPF/CONTRATO
            $mailing = EntityInput::getMailingByCpfContrato($cpf);
        }
        //else{
            //$mailing = EntityInput::getMailingByCpfContrato($contrato);
        //}

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

            //SET MAILING CPF OU CONTRATO
            $id = EntityInput::setMailingNotExisting($cpf, $contrato , $postVars['cidade'], $postVars['estado'], $codigo_cidade, $postVars['regiao'], $postVars['cluster'], $list, $id_user);

            if (!empty($id)){
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect("/vendedor/input/$list?status=newMailingCPF");
            }else{
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect("/vendedor/input/$list?status=mailingError");
            }
            

            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect("/vendedor/input/$list?status=mailingErrorCPFContrato");
        }

    }


    /**
     * Método responsável gerenciar o status do mailing
     * @param Request $request
     * @param string $list
     * @param int $id
     */
    public static function statusMailing(Request $request, string $list, int $id)
    {

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obMailing = EntityInput::getInputById($id);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityInput){
            $request->getRouter()->redirect("/vendedor/input/$obMailing->lista");
        }

        //POST VARS
        $postVars = $request->getPostVars();


        //VERIFICA CONVERTENDO A DATA US
        if ($postVars['data_follow'] != '' AND $postVars['time_follow'] != '') {
            $data_follow = DateTime::createFromFormat('d/m/Y', $postVars['data_follow']);
            $convertDate = $data_follow->format('Y-m-d');
            $postVars['datatime_follow'] = $convertDate . " " . $postVars['time_follow'];
        }else{
            $obMailing->datatime_follow = '2010-01-01 00:00:00';
        }


        //ATUALIZA A INSTANCIA
        $obMailing->status_mailing = $postVars['status_mailing'] ?? $obMailing->status_mailing;
        $obMailing->status_obs_mailing = $postVars['status_obs_mailing'] ?? $obMailing->status_obs_mailing;
        $obMailing->datatime_follow = $postVars['datatime_follow'] ?? $obMailing->datatime_follow;
        $obMailing->status_data_mailing = date('Y-m-d H:m:s');
        $obMailing->atualizar();

        //VERIFICA A LISTA QUE FOI FEITA A TABULAÇÃO
        switch($list) {
            case '':
                $request->getRouter()->redirect("/vendedor/input/$obMailing->lista?status=statusUpdate");
                break;
            case 'follow':
                $request->getRouter()->redirect("/vendedor/resultados/follow?status=statusUpdate");
                break;
        }

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
            case 'mailingError':
                return Alert::getError('Erro :(','Não foi possível salvar o novo input!');
                break;
            case 'mailingErrorCPFContrato':
                return Alert::getError('Erro :(','Não foi possível salvar o novo input por contrato ou CPF!');
                break;
            case 'limitExceeded':
                return Alert::getWarning('Atenção !','Limite de mailing na lista atingido');
                break;
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
            case 'notMailing':
                return Alert::getWarning('Atenção :|','Sem mailing disponivel no momento!');
                break;
            case 'CPFContratoExisting':
                return Alert::getWarning('Atenção :|','Necessário ter CPF ou Contrato para busca!');
                break;
            case 'CityExisting':
                return Alert::getWarning('Atenção :|','Cidade/Estado ou Código cidade necessário para busca!');
                break;
            case 'mailingExisting':
                return Alert::getSuccess('Sucesso :)','Novo input ok.');
                break;
            case 'newMailingCPF':
                return Alert::getSuccess('Sucesso :)','Novo input por CPF, aguarde enquanto completamos as informações.');
                break;
            case 'newMailingContrato':
                return Alert::getSuccess('Sucesso :)','Novo input por Contrato, aguarde enquanto completamos as informações.');
                break;
            case 'statusUpdate':
                return Alert::getSuccess('Sucesso :)','Status mailing atualizado com sucesso.');
                break;
        }
    }

}