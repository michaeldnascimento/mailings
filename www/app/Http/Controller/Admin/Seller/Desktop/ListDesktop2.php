<?php

namespace App\Http\Controller\Admin\Seller\Desktop;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\MailingDesktop2 as EntityDesktop;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;
use DateTime;

class ListDesktop2 extends Page {

    /**
     * Método responsável por obter a renderização da quantidade de mailings
     * @param Request $request $request
     * @param string $sublista
     * @param string $list
     * @return string
     */
    public static function getMailingsListQtd(Request $request, string $sublista, string $list): string
    {

        //QUANTIDADE
        $qtd_mailing = '';

        //RESULTADOS QUANTIDADE MAILING
        $qtd_mailing = EntityDesktop::getMailingQtd($sublista, $list);

        //POST VARS
        $postVars = $request->getPostVars();

        //RECEBE QUANTIDADE
        $qtd_mailing->qtd = $postVars['qtd'] ?? $qtd_mailing->qtd;

        //RETORNA OS USUÁRIOS
        return $qtd_mailing->qtd;

    }

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $sublista
     * @param string $list
     * @return string
     */
    public static function getMailingsListUser(string $sublista, string $list): string
    {

        //MAILING
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityDesktop::getMailingDesktop('*', null, "sublista = '$sublista' AND lista = '$list' AND id_user = $id_user AND (status_mailing IS NULL OR status_mailing = '' OR status_mailing LIKE '%OPORTUNIDADE%')", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obDesktop = $results->fetchObject(EntityDesktop::class)){
            $items .=  View::render('/admin/seller/desktop/modules/item', [
                'id' => $obDesktop->id,
                'cliente' => $obDesktop->cliente,
                'cpf_cnpj' => $obDesktop->cpf_cnpj,
                'rg' => $obDesktop->rg,
                'nascimento' => $obDesktop->nascimento,
                'email' => $obDesktop->email,
                'cep' => $obDesktop->cep,
                'fone1' => $obDesktop->fone1,
                'fone2' => $obDesktop->fone2,
                'fone3' => $obDesktop->fone3,
                'endereco' => $obDesktop->endereco,
                'bairro' => $obDesktop->bairro,
                'cidade' => $obDesktop->cidade,
                'estado' => $obDesktop->estado,
                'contrato' => $obDesktop->contrato,
                'status' => $obDesktop->status,
                'subStatus' => $obDesktop->subStatus,
                'observacao' => $obDesktop->observacao,
                'produto' => $obDesktop->produto,
                'ultimaOC' => $obDesktop->ultimaOC,
                'sublista' => $obDesktop->sublista,
                'lista' => $obDesktop->lista,
                'status_lista' => $obDesktop->status_lista,
                'status_mailing' => $obDesktop->status_mailing,
                'status_obs_mailing' => $obDesktop->status_obs_mailing
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string $submenu
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getList(Request $request, string $sublista, string $list, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/desktop/lista", [
            'itens_qtd'    => self::getMailingsListQtd($request, $sublista, $list),
            'itens_user'    => self::getMailingsListUser($sublista, $list),
            'sublista'      => $sublista,
            'lista'         => $list,
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Mailings',
            "$list",
            'Lista de mailing',
            $content
        );
    }

    /**
     * Método responsável gerar novo mailing lista1
     * @param Request $request
     * @param string $sublista
     * @param string $list
     * @return string
     */
    public static function setList(Request $request, string $sublista, string $list): string
    {

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        $qtd_mailing_user = EntityDesktop::getMailingQtdUser($sublista, $list, $id_user);

        //VALIDA SE O USUÁRIO JÁ PASSOU DO LIMIT DE MAILING POR USUÁRIO
        if($qtd_mailing_user->qtd >= 5){
            $request->getRouter()->redirect("/vendedor/desktop/$sublista/$list?status=limitExceeded");
        }

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //PEGAR NOVO MAILING VAZIO
        $obMailing = EntityDesktop::getNewMailing($list);

        echo "<pre>";
        print_r($obMailing);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityDesktop){
            $request->getRouter()->redirect("/vendedor/desktop/$sublista/$list?status=notMailing");
        }

        //ATUALIZA A INSTANCIA
        $obMailing->id_user = $id_user;
        $obMailing->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect("/vendedor/desktop/$sublista/$list?status=newMailing");
    }

    /**
     * Método responsável gerenciar o status do mailing
     * @param Request $request
     * @param string $list
     * @param int $id
     * @return string
     */
    public static function statusMailing(Request $request, string $list, int $id): string
    {

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obMailing = EntityDesktop::getMailingById($id);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityDesktop){
            $request->getRouter()->redirect("/vendedor/desktop/$obMailing->sublista/$obMailing->lista");
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
                $request->getRouter()->redirect("/vendedor/desktop/$obMailing->sublista/$obMailing->lista?status=statusUpdate");
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
            case 'invalid':
                return Alert::getError('Erro :(','E-mail ou senha inválido!');
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
            case 'newMailing':
                return Alert::getSuccess('Sucesso :)','Novo mailing gerado com sucesso.');
                break;
            case 'statusUpdate':
                return Alert::getSuccess('Sucesso :)','Status mailing atualizado com sucesso.');
                break;
        }
    }

}