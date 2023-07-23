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
        $results = EntityInput::getMailingInput("*, DATE_FORMAT(data_cancelamento, '%d/%m/%Y') as data_cancelamento", null, "lista = '$list' AND id_user = $id_user AND (status_mailing IS NULL OR status_mailing = '' OR status_mailing LIKE '%OPORTUNIDADE%')", 'id DESC', '');

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


            $items .=  View::render('/admin/seller/input/modules/item', [
                'id' => $obInput->id,
                'num_protocolo' => $obInput->num_protocolo,
                'num_pedido_proposta' => $obInput->num_pedido_proposta,
                'contrato' => $obInput->contrato,
                'nome_cliente' => $obInput->nome_cliente,
                'email' => $obInput->email,
                'cep' => $obInput->cep,
                'cpf' => $obInput->cpf,
                'fone' => $obInput->fone,
                'fone1' => $obInput->fone1,
                'fone2' => $obInput->fone2,
                'endereco' => $obInput->endereco,
                'num' => $obInput->num,
                'compl' => $obInput->compl,
                'bairro' => $obInput->bairro,
                'cidade' => $obInput->cidade,
                'uf' => $obInput->uf,
                'tipo_pessoa' => $obInput->tipo_pessoa,
                'data_cancelamento' => $obInput->data_cancelamento,
                'motivo_cancelamento' => $obInput->motivo_cancelamento,
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
    public static function getListInput(Request $request, string $list, string $errorMessage = null): string
    {

        //CONTEÚDO DA PÁGINA DE MAILINGS
        $content = View::render("admin/seller/input/lista", [
            'itens_user'   => self::getMailingsListUser($list),
            'lista'        => $list,
            'status'       => self::getStatus($request)
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


    /**
     * Método responsável gerenciar o status do mailing
     * @param Request $request
     * @param string $list
     * @param int $id
     */
    public static function statusMailing(Request $request, string $list, int $id)
    {

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obMailing = EntityInput::getMailingById($id);

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