<?php

namespace App\Http\Controller\Admin\Seller\Finder;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Finder as EntityFinder;
use App\Utils\View;
use DateTime;

class ListFinder extends Page {

    /**
     * Método responsável por remover a string dos números
     * @param string|null $value
     * @return string|int
     */
    public static function removeStringNumber(?string $value)
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

        //PEGA ID USUÁRIO E ID EQUIPE NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityFinder::getFinderInput("*", null, "lista = '$list' AND id_user = $id_user", 'id DESC', '');

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
                    $color_status_button = "btn-primary";
                    $color_status_lista = "table-primary";
                    break;
                }
            }

            $items .=  View::render('admin/seller/input/finder/modules/item_results', [
                'cpf_cnpj' => $obFinder->cpf_cnpj,
                'nome_razao_social' => $obFinder->nome_razao_social,
                'tipo_pessoa' => $obFinder->tipo_pessoa,
                'nascimento_abertura' => $obFinder->nascimento_abertura,
                'mae_nome_fantasia' => $obFinder->mae_nome_fantasia,
                'email' => $obFinder->email,
                'telefone_1' => $obFinder->telefone_1,
                'telefone_2' => $obFinder->telefone_2,
                'telefone_3' => $obFinder->telefone_3,
                'telefone_4' => $obFinder->telefone_4,
                'telefone_5' => $obFinder->telefone_5,
                'telefone_6' => $obFinder->telefone_6,
                'endereco_1' => $obFinder->endereco_1,
                'endereco_2' => $obFinder->endereco_2,
                'parente_1'  => $obFinder->parente_1,
                'parente_2'  => $obFinder->parente_2,
                'parente_3'  => $obFinder->parente_3,
                'parente_4'  => $obFinder->parente_4,
                'parente_5'  => $obFinder->parente_5,
                'parente_6'  => $obFinder->parente_6,
                'cpf_cnpj_socio_1' => $obFinder->cpf_cnpj_socio_1,
                'cpf_cnpj_socio_2' => $obFinder->cpf_cnpj_socio_2,
                'cpf_cnpj_socio_3' => $obFinder->cpf_cnpj_socio_3,
                'cpf_cnpj_socio_4' => $obFinder->cpf_cnpj_socio_4,
                'cpf_cnpj_socio_5' => $obFinder->cpf_cnpj_socio_5,
                'cpf_cnpj_socio_6' => $obFinder->cpf_cnpj_socio_6,
                'socio_sociedades_1' => $obFinder->socio_sociedades_1,
                'socio_sociedades_2' => $obFinder->socio_sociedades_2,
                'socio_sociedades_3' => $obFinder->socio_sociedades_3,
                'socio_sociedades_4' => $obFinder->socio_sociedades_4,
                'socio_sociedades_5' => $obFinder->socio_sociedades_5,
                'socio_sociedades_6' => $obFinder->socio_sociedades_6,
                'situacao_cadastral_empresa' => $obFinder->situacao_cadastral_empresa,
                'porte_empresa' => $obFinder->porte_empresa,
                'origem' => $obFinder->origem,
                'status' => $obFinder->status,
                'lista' => $list,
                'atualizado' => $obFinder->atualizado,

                'status_lista' => $status_lista,
                'color_status_button' => $color_status_button,
                'color_status_lista' => $color_status_lista
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
        $results = EntityFinder::getFinderInput("*, DATE_FORMAT(atualizado, '%d/%m/%Y') as atualizado", null, "lista = '$list' AND id_user = $id_user AND (status = 1 OR status = 2)", 'id DESC', '');

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
                    $color_status_button = "btn-primary";
                    $color_status_lista = "table-primary";
                    break;
                }
            }


            $items .=  View::render('/admin/seller/input/finder/modules/item', [
                'cpf_cnpj' => $obFinder->cpf_cnpj,
                'nome_razao_social' => $obFinder->nome_razao_social,
                'tipo_pessoa' => $obFinder->tipo_pessoa,
                'nascimento_abertura' => $obFinder->nascimento_abertura,
                'mae_nome_fantasia' => $obFinder->mae_nome_fantasia,
                'email' => $obFinder->email,
                'telefone_1' => $obFinder->telefone_1,
                'telefone_2' => $obFinder->telefone_2,
                'telefone_3' => $obFinder->telefone_3,
                'telefone_4' => $obFinder->telefone_4,
                'telefone_5' => $obFinder->telefone_5,
                'telefone_6' => $obFinder->telefone_6,
                'endereco_1' => $obFinder->endereco_1,
                'endereco_2' => $obFinder->endereco_2,
                'parente_1'  => $obFinder->parente_1,
                'parente_2'  => $obFinder->parente_2,
                'parente_3'  => $obFinder->parente_3,
                'parente_4'  => $obFinder->parente_4,
                'parente_5'  => $obFinder->parente_5,
                'parente_6'  => $obFinder->parente_6,
                'cpf_cnpj_socio_1' => $obFinder->cpf_cnpj_socio_1,
                'cpf_cnpj_socio_2' => $obFinder->cpf_cnpj_socio_2,
                'cpf_cnpj_socio_3' => $obFinder->cpf_cnpj_socio_3,
                'cpf_cnpj_socio_4' => $obFinder->cpf_cnpj_socio_4,
                'cpf_cnpj_socio_5' => $obFinder->cpf_cnpj_socio_5,
                'cpf_cnpj_socio_6' => $obFinder->cpf_cnpj_socio_6,
                'socio_sociedades_1' => $obFinder->socio_sociedades_1,
                'socio_sociedades_2' => $obFinder->socio_sociedades_2,
                'socio_sociedades_3' => $obFinder->socio_sociedades_3,
                'socio_sociedades_4' => $obFinder->socio_sociedades_4,
                'socio_sociedades_5' => $obFinder->socio_sociedades_5,
                'socio_sociedades_6' => $obFinder->socio_sociedades_6,
                'situacao_cadastral_empresa' => $obFinder->situacao_cadastral_empresa,
                'porte_empresa' => $obFinder->porte_empresa,
                'origem' => $obFinder->origem,
                'status' => $obFinder->status,
                'lista' => $list,
                'atualizado' => $obFinder->atualizado,

                'status_lista' => $status_lista,
                'color_status_button' => $color_status_button,
                'color_status_lista' => $color_status_lista
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
    public static function getListFinderResults(Request $request, string $list): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/input/finder/lista_results", [
            'itens_bot'   => self::getListResultInput($list),
            'lista'        => $list
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            "Input",
            "Resultados",
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
    public static function getListInputFinder(Request $request, string $list, string $errorMessage = null): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/input/finder/lista", [
            'itens_user'   => self::getInputListUser($list),
            'lista'        => $list,
            'status'       => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Input',
            "Consulta",
            '',
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
        $content = View::render("admin/seller/input/finder/lista", [
            'itens_user'   => self::getInputListUser($list),
            'lista'        => $list,
            'status'       => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Input',
            "Consulta",
            '',
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
        $id_team = $_SESSION['mailings']['admin']['user']['team'];

        //POST VARS
        $postVars = $request->getPostVars();

        if(empty($postVars['cpf']) AND empty($postVars['cnpj'])){
            $request->getRouter()->redirect("/vendedor/input/$list?status=CPFCnpjExisting");
        }

        //VERIFICA SE O CPF OU CONTRATO ESTÁ VAZIO PARA AI SIM FAZER A CONSULTA SE JÁ EXISTE
        if(!empty($postVars['cpf'])){
            //VERFICAR SE EXISTE CPF
            $cpf_cnpj = self::removeStringNumber($postVars['cpf']);
            $finder = EntityFinder::getFinderByCpfCnpj($cpf_cnpj);
        }

        if(!empty($postVars['cnpj'])){
            $cpf_cnpj = self::removeStringNumber($postVars['cnpj']);
            $finder = EntityFinder::getFinderByCpfCnpj($cpf_cnpj);
        }

        //echo "<pre>";
        //print_r($postVars);
        //print_r($finder);
        //exit();

        if (!empty($finder)){
            //ATUALIZA A STATUS  MAILING
            $id = EntityFinder::setFinderExisting($finder, $list, $id_user, $id_team);
            if (!empty($id)){
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect("/vendedor/input/$list?status=mailingExisting");
            }else{
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect("/vendedor/input/$list?status=mailingError");
            }
        }else{

            //SET MAILING CPF OU CONTRATO
            $id = EntityFinder::setFinderNotExisting($cpf_cnpj, $list, $id_user, $id_team);

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
        $obMailing = EntityFinder::getInputById($id);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityFinder){
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