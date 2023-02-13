<?php

namespace App\Http\Controller\Admin\Adm\User;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Call as EntityCall;
use App\Model\Entity\CallActivity as EntityCallActivity;
use App\Model\Entity\User as EntityUser;
use App\Utils\Import\Excel\Update;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;
use DateTime;

class Called extends Page {

    /**
     * Método responsável por obter a renderização dos itens do chamados para a página
     * @param $request $request
     */
    public static function getListCallItems(Request $request): string
    {
        //USUÁRIOS
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //RESULTADOS DA PÁGINA
        $results = EntityCall::getCalled('*', null, "", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obCall = $results->fetchObject(EntityCall::class)){

            //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
            switch ($obCall->status) {
                case "1": {
                    $status_chamado = "Novo";
                    break;
                }
                case "2": {
                    $status_chamado = "Em atendimento";
                    break;
                }
                case "3": {
                    $status_chamado = "Concluído";
                    break;
                }
                case "4": {
                    $status_chamado = "Cancelado";
                    break;
                }
            }

            $items .=  View::render('admin/adm/users/modules/called/item', [
                'id' => $obCall->id,
                'assunto' => $obCall->assunto,
                'status'  => $status_chamado,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por obter a renderização dos itens do chamados para a página
     * @param $request $request
     */
    public static function getListCallHistory(Request $request, $id_call, $id_open_call): string
    {
        //USUÁRIOS
        $items = '';

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];


        //RESULTADOS DA PÁGINA
        $results = EntityCallActivity::getCalledActivity("*, DATE_FORMAT(datahora, '%d/%m/%Y %Hh%i') as datahora", null, "id_chamado = $id_call", 'id DESC', '');

        //RENDERIZA O ITEM
        while($obCallActivity = $results->fetchObject(EntityCall::class)){

            //OBTÉM O USUÁRIO DO BANCO DE DADOS
            if ($obCallActivity->id_atendimento_chamado != ''){
                $obAtendimento = EntityUser::getUserById($obCallActivity->id_atendimento_chamado);
            }
            if ($obCallActivity->id_user != '') {
                $obUser = EntityUser::getUserById($obCallActivity->id_user);
                if ($obCallActivity->id_user == $id_user){
                    $text_aligin = 'style="text-align: unset;"';
                }else{
                    $text_aligin = 'style="text-align: right;"';
                }
            }


            $items .=  View::render('admin/adm/users/modules/called/historia', [
                'id' => $obCallActivity->id,
                'datahora' => $obCallActivity->datahora,
                'descricao'  => $obCallActivity->descricao,
                'id_atendimento_chamado'  => $obAtendimento->name ?? null,
                'id_user'  => $obUser->name ?? null,
                'aligin'  => $text_aligin ?? null,
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de chamados
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getCalledList(Request $request, string $errorMessage = null): string
    {

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA
        $content = View::render('admin/adm/users/list_called', [
            'itens'       => self::getListCallItems($request),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Vendedor',
            'Chamados',
            'Lista de Chamados',
            $content
        );

    }

    /**
     * Método responsável por retornar o formulário de edição de um empresa
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getViewCall(Request $request, int $id): string
    {


        //OBTÉM O CHAMADO DO BANCO DE DADOS
        $obCall = EntityCall::getCallById($id);

        //OBTÉM O CHAMADO DO BANCO DE DADOS
        $obCallActivity = EntityCallActivity::getCallActivityById($id);

        //VALIDA A INSTANCIA
        if(!$obCall instanceof EntityCall){
            $request->getRouter()->redirect('/vendedor/chamados/lista');
        }

        //VALIDA A INSTANCIA
        if(!$obCallActivity instanceof EntityCallActivity){
            $request->getRouter()->redirect('/vendedor/chamados/lista');
        }

        //VERIFICA O STATUS DO CHAMADO E RETORNA NO SELECT
        switch ($obCall->status) {
            case "1": {
                $seller1 = "selected";
                break;
            }
            case "2": {
                $seller2 = "selected";
                break;
            }
            case "3": {
                $seller3 = "selected";
                break;
            }
            case "4": {
                $seller4 = "selected";
                break;
            }
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/adm/users/form_called', [
            'id' => $obCall->id,
            'assunto' => $obCall->assunto,
            'status_chamado' =>  "<option value='1' $seller1>Novo</option>.
                                  <option value='2' $seller2>Em atendimento</option>
                                  <option value='3' $seller3>Concluído</option>
                                  <option value='4' $seller4>Cancelado</option>
                                  ",
            'datahora_abriu' => $obCall->datahora,
            'historia_chamados'  => self::getListCallHistory($request, $obCall->id, $obCall->id_abriu_chamado),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Vendedor',
            'Chamados',
            'Histórico Chamado',
            $content
        );
    }

    /**
     * Método responsável por grava a ataulização de um empresa
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setResponseCall(Request $request, int $id): string
    {


        //POST VARS
        $postVars = $request->getPostVars();

        //PEGA ID USUÁRIO NA SESSION
        $id_user = $_SESSION['mailings']['admin']['user']['id'];

        //PEGAR NOVO MAILING VAZIO
        $obCall = EntityCall::getCallById($id);

        //VALIDA A INSTANCIA
        if(!$obCall instanceof EntityCall){
            $request->getRouter()->redirect("/adm/usuarios/chamados/lista/'.$id.'/view?status=notCall");
        }

        //NOVA INSTANCIA DE CHAMADO ATIVIDADE
        $obCallActivity = new EntityCallActivity();
        $obCallActivity->id_chamado = $id;
        $obCallActivity->descricao = $postVars['descricao'];
        $obCallActivity->datahora = date('Y-m-d H:m:s');
        $obCallActivity->id_user = $id_user;
        $obCallActivity->cadastrar();

        if ($obCallActivity->id != ''){

            //NOVA INSTANCIA DE CHAMADO
            $obCall->assunto = $postVars['assunto'] ?? $obCall->assunto;
            $obCall->datahora = date('Y-m-d H:m:s');
            $obCall->id_abriu_chamado = $postVars['id_abriu_chamado'] ?? $obCall->id_abriu_chamado;
            $obCall->status = $postVars['status'] ?? $obCall->status;
            $obCall->atualizar();

            if (!empty($_FILES['file-upload']['name'])) {
                $resultImport = Update::importFiles($request, $postVars['anexo']); //ENVIANDO APENAS NOME ARQUIVO
            }

            if ($obCall->id != '') {
                //REDIRECIONA O USUÁRIO
                $request->getRouter()->redirect('/adm/usuarios/chamados/lista/'.$id.'/view?status=updated');
            }else{
                //REDIRECIONA O USUÁRIO ERRO
                $request->getRouter()->redirect('/adm/usuarios/chamados/lista?status=errorCreated');
            }
        }

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/adm/usuarios/chamados/lista/'.$id.'/view?status=updated');
    }


    /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteCall(Request $request, int $id): string
    {
        //OBTÉM O CHAMADO DO BANCO DE DADOS
        $obCall = EntityCall::getCallById($id);

        //VALIDA A INSTANCIA
        if(!$obCall instanceof EntityCall){
            $request->getRouter()->redirect('/vendedor/chamados/lista?status=invalid');
        }

        if ($obCall = 1){
            //EXCLUI O CHAMADO
            $obCall->excluir();
        }

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/vendedor/chamados/lista?status=deleted');
    }

    /**
     * Método responsável por obter a renderização dos itens da empresa para a página
     * @param $request $request
     */
    public static function getListCompaniesArray(Request $request): array
    {

        //RESULTADOS DA PÁGINA
        $results = EntityCall::getCompanies('*', null, null, 'id DESC', '');

        //RETORNA ITEM EMPRESA
        return $results->fetchAll();

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
            case 'errorCreated':
                return Alert::getError('Erro :(','Erro ao criar o chamado!');
                break;
            case 'userInvalid':
                return Alert::getError('Erro :(','Usúario diferente do chamado!');
                break;
            case 'notCall':
                return Alert::getError('Erro :(','Chamado não encontrado!');
                break;
            case 'created':
                return Alert::getSuccess('Sucesso','Chamado salva com sucesso.');
                break;
            case 'updated':
                return Alert::getSuccess('Sucesso','Chamado atualizado com sucesso.');
                break;
        }
    }

}