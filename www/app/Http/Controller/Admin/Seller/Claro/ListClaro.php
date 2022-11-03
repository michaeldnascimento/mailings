<?php

namespace App\Http\Controller\Admin\Seller\Claro;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\MailingClaro as EntityClaro;
use App\Utils\View;
use DateTime;

class ListClaro extends Page {

    /**
     * Método responsável por obter a renderização da quantidade de mailings
     * @param Request $request $request
     * @param string $list
     * @return string
     */
    public static function getMailingsListQtd(Request $request, string $list): string
    {

        //QUANTIDADE
        $qtd_mailing = '';

        //RESULTADOS QUANTIDADE MAILING
        $qtd_mailing = EntityClaro::getMailingQtd($list);

        //POST VARS
        $postVars = $request->getPostVars();

        //RECEBE QUANTIDADE
        $qtd_mailing->qtd = $postVars['qtd'] ?? $qtd_mailing->qtd;

        //RETORNA OS USUÁRIOS
        return $qtd_mailing->qtd;

    }

    /**
     * Método responsável por obter a renderização os mailings do usuário para a página
     * @param string $list
     * @return string
     */
    public static function getMailingsListUser(string $list): string
    {

        //MAILING
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityClaro::getMailingClaro("*, DATE_FORMAT(data_cancelamento, '%d/%m/%Y') as data_cancelamento", null, "lista = '$list' AND id_user = $id_user AND (status_mailing IS NULL OR status_mailing = '' OR status_mailing LIKE '%OPORTUNIDADE%')", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obClaro = $results->fetchObject(EntityClaro::class)){
            $items .=  View::render('/admin/seller/claro/modules/item', [
                'id' => $obClaro->id,
                'num_protocolo' => $obClaro->num_protocolo,
                'num_pedido_proposta' => $obClaro->num_pedido_proposta,
                'contrato' => $obClaro->contrato,
                'nome_cliente' => $obClaro->nome_cliente,
                'email' => $obClaro->email,
                'cep' => $obClaro->cep,
                'cpf' => $obClaro->cpf,
                'fone' => $obClaro->fone,
                'fone1' => $obClaro->fone1,
                'fone2' => $obClaro->fone2,
                'endereco' => $obClaro->endereco,
                'num' => $obClaro->num,
                'compl' => $obClaro->compl,
                'bairro' => $obClaro->bairro,
                'cidade' => $obClaro->cidade,
                'uf' => $obClaro->uf,
                'tipo_pessoa' => $obClaro->tipo_pessoa,
                'data_cancelamento' => $obClaro->data_cancelamento,
                'motivo_cancelamento' => $obClaro->motivo_cancelamento,
                'status_mailing' => $obClaro->status_mailing,
                'status_obs_mailing' => $obClaro->status_obs_mailing
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getList(Request $request, string $list, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/claro/$list", [
            'itens_qtd'    => self::getMailingsListQtd($request, $list),
            'itens_user'    => self::getMailingsListUser($list),
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
     * Método responsável por retornar a renderização da página cancelado
     * @param Request $request
     * @param string $list
     * @param string|null $errorMessage
     * @return string
     */
    public static function getListClaro(Request $request, string $list, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/claro/lista", [
            'itens_qtd'    => self::getMailingsListQtd($request, $list),
            'itens_user'   => self::getMailingsListUser($list),
            'lista'        => $list,
            'status'       => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Mailings',
            "$list",
            'Lista Claro',
            $content
        );
    }

    /**
     * Método responsável gerar novo mailing lista1
     * @param Request $request
     * @param string $list
     * @return string
     */
    public static function setListClaro(Request $request, string $list): string
    {

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        $qtd_mailing_user = EntityClaro::getMailingQtdUser($list, $id_user);

        //VALIDA SE O USUÁRIO JÁ PASSOU DO LIMIT DE MAILING POR USUÁRIO
        if($qtd_mailing_user->qtd >= 5){
            $request->getRouter()->redirect("/vendedor/claro/$list?status=limitExceeded");
        }

        //PEGAR NOVO MAILING VAZIO
        $obMailing = EntityClaro::getNewMailing($list);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityClaro){
            $request->getRouter()->redirect("/vendedor/claro/$list?status=notMailing");
        }

        //ATUALIZA A INSTANCIA
        $obMailing->id_user = $id_user;
        $obMailing->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect("/vendedor/claro/$list?status=newMailing");
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
        $obMailing = EntityClaro::getMailingById($id);

        //VALIDA A INSTANCIA
        if(!$obMailing instanceof EntityClaro){
            $request->getRouter()->redirect("/vendedor/claro/$obMailing->lista");
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
                $request->getRouter()->redirect("/vendedor/claro/$obMailing->lista?status=statusUpdate");
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