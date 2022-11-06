<?php

namespace App\Http\Controller\Admin\Adm\User;

use App\Http\Controller\Admin\Alert;
use App\Http\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\User as EntityUser;
use App\Http\Controller\Admin\Adm\Company\Companies;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Users extends Page {

    /**
     * Método responsável por obter a renderização dos itens do usuários para a página
     * @param $request $request
     */
    public static function getListUsersItems(Request $request): string
    {

        //USUÁRIOS
        $items = '';

        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers('*', null, null, 'id DESC', '');

        //RENDERIZA O ITEM
        while($obUsers = $results->fetchObject(EntityUser::class)){
            $items .=  View::render('admin/adm/users/modules/user/item', [
                'id' => $obUsers->id,
                'company' => $obUsers->company,
                'name' => $obUsers->name,
                'email' => $obUsers->email,
                'status_user' => $obUsers->status,
                'nivel' => $obUsers->nivel,
                'companies' => $obUsers->companies
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $items;

    }

    /**
     * Método responsável por retornar a renderização a view de listagem de usuários
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getUsersList(Request $request, string $errorMessage = null): string
    {

        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';


        //CONTEÚDO DA PÁGINA DE USUÁRIOS
        $content = View::render('admin/adm/users/list', [
            'itens'       => self::getListUsersItems($request),
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Usuários',
            'Lista de Usuários',
            $content
        );

    }

    /**
     * Método responsável por retornar o formulário de edição de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUser(Request $request, int $id): string
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/adm/users/list');
        }

        //VERIFICA O STATUS DO USUÁRIO E RETORNA NO SELECT
        switch ($obUser->status) {
            case "0": {
                $disabled = "selected";
                break;
            }
            case "1": {
                $active = "selected";
                break;
            }
        }

        //VERIFICA O STATUS DO CEP USUÁRIO E RETORNA NO SELECT
        switch ($obUser->cep) {
            case "0": {
                $disabledCep = "selected";
                break;
            }
            case "1": {
                $activeCep = "selected";
                break;
            }
        }

        //VERIFICA O STATUS DO CLIENTE USUÁRIO E RETORNA NO SELECT
        switch ($obUser->client) {
            case "0": {
                $disabledClient = "selected";
                break;
            }
            case "1": {
                $activeClient = "selected";
                break;
            }
        }

        //VERIFICA O NIVEL DO USUÁRIO E RETORNA NO SELECT
        switch ($obUser->nivel) {
            case "1": {
                $seller = "selected";
                break;
            }
            case "2": {
                $company = "selected";
                break;
            }
            case "3": {
                $adm = "selected";
                break;
            }
        }

        //LIST ALGAR
        $listAlgar = explode(", ", $obUser->algar);

        //LIST CLARO
        $listClaro = explode(", ", $obUser->claro);

        //LIST DESKTOP
        $listDesktopGet = explode(", ", $obUser->desktop_get);
        $listDesktopSis = explode(", ", $obUser->desktop_sis);
        $listDesktopNetBarretos = explode(", ", $obUser->desktop_netbarretos);

        //LIST NET
        $listNet = explode(", ", $obUser->net);

        //RETORNA EMPRESA
        $companies = Companies::getListCompaniesArray($request);

        //CRIA O CAMPO SELECT EMPRESA
        $select_company = "";
        $companies_disabled= "";
        foreach ($companies as $key => $col):
            $obj = (Object)$col;

            //VERIFICA O ID PARA SELECIONAR O OPTION
            if ($obj->id == $obUser->companies){
                $check = "selected";
            }else{
                $check = '';
            }

            if ($obUser->nivel != 2){
                $companies_disabled = "disabled";
            }else{
                $companies_disabled = '';
            }

            $select_company .= "<option value='$obj->id' $check>$obj->company</option>";
        endforeach;

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('/admin/adm/users/form', [
            'id' => $obUser->id,
            'company' => 1,
            'name' => $obUser->name,
            'email' => $obUser->email,
            'options_status_user' => "<option value='1' $active>ATIVO</option>.
                                      <option value='0' $disabled>DESATIVAR</option>",
            'options_cep_user'    => "<option value='1' $activeCep>SIM</option>.
                                      <option value='0' $disabledCep>NÃO</option>",
            'options_client_user' => "<option value='1' $activeClient>SIM</option>.
                                      <option value='0' $disabledClient>NÃO</option>",
            'options_nivel_user' =>  "<option value='1' $seller>VENDEDOR</option>.
                                      <option value='2' $company>EMPRESA</option>.
                                      <option value='3' $adm>ADMINISTRADOR</option>",
            'companies' => $select_company,
            'companies_disabled' => $companies_disabled,
            'status_algar_base' => in_array('base', $listAlgar) ? 'checked' : '',
            'status_algar_cancelado' => in_array('cancelado', $listAlgar) ? 'checked' : '',
            'status_algar_proposta' => in_array('proposta', $listAlgar) ? 'checked' : '',
            'status_algar_pendente_instalacao' => in_array('pendente-instalacao', $listAlgar) ? 'checked' : '',

            'status_claro_desabilitado' => in_array('desabilitado', $listClaro) ? 'checked' : '',
            'status_claro_cancelado' => in_array('cancelado', $listClaro) ? 'checked' : '',
            'status_claro_proposta' => in_array('proposta', $listClaro) ? 'checked' : '',
            'status_claro_pendente_instalacao' => in_array('pendente-instalacao', $listClaro) ? 'checked' : '',

            'status_desktop_get_base' => in_array('base', $listDesktopGet) ? 'checked' : '',
            'status_desktop_get_cancelados' => in_array('cancelados', $listDesktopGet) ? 'checked' : '',
            'status_desktop_get_pedidos' => in_array('pedidos', $listDesktopGet) ? 'checked' : '',
            'status_desktop_sis_base' => in_array('base', $listDesktopSis) ? 'checked' : '',
            'status_desktop_sis_cancelados' => in_array('cancelados', $listDesktopSis) ? 'checked' : '',
            'status_desktop_sis_pedidos' => in_array('pedidos', $listDesktopSis) ? 'checked' : '',
            'status_desktop_netbarretos_base' => in_array('base', $listDesktopNetBarretos) ? 'checked' : '',
            'status_desktop_netbarretos_cancelados' => in_array('cancelados', $listDesktopNetBarretos) ? 'checked' : '',
            'status_desktop_netbarretos_pedidos' => in_array('pedidos', $listDesktopNetBarretos) ? 'checked' : '',

            'status_net_desabilitado' => in_array('desabilitado', $listNet) ? 'checked' : '',
            'status_net_cancelado' => in_array('cancelado', $listNet) ? 'checked' : '',
            'status_net_proposta' => in_array('proposta', $listNet) ? 'checked' : '',
            'status_net_pendente_instalacao' => in_array('pendente-instalacao', $listNet) ? 'checked' : '',

            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage(
            'Administrativo',
            'Usuários',
            'Editar de Usuários',
            $content
        );
    }

    /**
     * Método responsável por grava a ataulização de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditUser(Request $request, int $id): string
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/adm/usuarios/lista/');
        }

        //POST VARS
        $postVars = $request->getPostVars();

        if ($postVars['nivel'] == 0 OR $postVars['nivel'] == 1 OR $postVars['nivel'] == 3){
            $postVars['companies'] = null;
            $obUser->companies = null;
        }

        //ATUALIZA A INSTANCIA
        $obUser->name = $postVars['name'] ?? $obUser->name;
        $obUser->email = $postVars['email'] ?? $obUser->email;
        $obUser->company = 1;
        $obUser->status = $postVars['status_user'] ?? $obUser->status;
        $obUser->cep = $postVars['cep'] ?? $obUser->cep;
        $obUser->client = $postVars['client'] ?? $obUser->client;
        $obUser->nivel = $postVars['nivel'] ?? $obUser->nivel;
        $obUser->companies = $postVars['companies'] ?? $obUser->companies;
        $obUser->algar = implode(", ", array_keys($postVars['listAlgar'])) ?? null;
        $obUser->net = implode(", ", array_keys($postVars['listNet'])) ?? null;
        $obUser->claro = implode(", ", array_keys($postVars['listClaro'])) ?? null;
        $obUser->desktop_get = implode(", ", array_keys($postVars['listDesktop']['get'])) ?? null;
        $obUser->desktop_sis = implode(", ", array_keys($postVars['listDesktop']['sis'])) ?? null;
        $obUser->desktop_netbarretos = implode(", ", array_keys($postVars['listDesktop']['netbarretos'])) ?? null;
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/adm/usuarios/lista/'.$obUser->id.'/edit?status=updated');
    }


    /**
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser(Request $request, int $id): string
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityUser::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityUser){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/delete', [
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem
        ]);

        return parent::getPanel('Excluir depoimento > WDEV', $content, 'testimonies');
    }


    /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUser(Request $request, int $id): string
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityTestimony){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //EXCLUI O DEPOIMENTO
        $obTestimony->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
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
            case 'updated':
                return Alert::getSuccess('Sucesso','Usuário atualizado com sucesso.');
                break;
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
        }
    }

}