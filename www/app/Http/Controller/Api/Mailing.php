<?php

namespace App\Http\Controller\Api;

use \App\Db\Pagination;
use \App\Http\Request;
use \App\Model\Entity\Mailing as EntityMailing;
use \Exception;

class Mailing extends Api{

    /**
     * Método responsável por retornar os detalhes de um depoimento
     * @param Request $request
     * @param string $cpf_cnpj
     * @return array
     * @throws Exception
     */
    public static function getCpfCnpj(Request $request, string $cpf_cnpj): array
    {

        //CLIENTE
        $items = [];

        //GET CPF/CNPJ E REMOVE STRINGS
        $cpf_cnpj = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $cpf_cnpj);

        //REMOVE CPF/CNPJ QUE COMEÇA COM 0 A ESQUERDA
        $cpf_cnpj = ltrim($cpf_cnpj, "0");

        //RESULTADOS CPF/CNPJ
        $results = EntityClient::getClient('*', null, "cpf_cnpj = $cpf_cnpj", '', '', '');

        //RENDERIZA O ITEM
        while($obClient = $results->fetchObject(EntityClient::class)){
            $items[] =  [
                'id'       => (int)$obClient->id,
                'fone1'    => $obClient->fone_cel,
                'fone2'    => $obClient->fone_fixo
            ];
        }

        return $items;
    }


    /**
     * Método responsável por cadastrar um novo mailing
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailing(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['doc']) OR !isset($postParams['fone1'])){
            throw new Exception("Os campos 'doc' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obMailing = EntityMailing::getMailingByDoc($postParams['doc']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obMailing instanceof EntityMailing){
            throw new Exception("Esse mailing já existe", 400);
        }


        //NOVO MAILING
        $obMailing = new EntityMailing();
        $obMailing->ordens = $postParams['ordens'];
        $obMailing->pendencia = $postParams['pendencia'];
        $obMailing->nome = $postParams['nome'];
        $obMailing->status_spc = $postParams['status_spc'];
        $obMailing->doc =   $postParams['doc'];
        $obMailing->rg =   $postParams['rg'];
        $obMailing->data_nasc =   $postParams['data_nasc'];
        $obMailing->email = $postParams['email'];
        $obMailing->fone1 = $postParams['fone1'];
        $obMailing->fone2 = $postParams['fone2'];
        $obMailing->criado_por = $postParams['criado_por'];
        $obMailing->data_cad = $postParams['data_cad'];
        $obMailing->endereco = $postParams['endereco'];
        $obMailing->num = $postParams['num'];
        $obMailing->bairro = $postParams['bairro'];
        $obMailing->cidade = $postParams['cidade'];
        $obMailing->estado = $postParams['estado'];
        $obMailing->cep = $postParams['cep'];
        $obMailing->compl = $postParams['compl'];
        $obMailing->plano = $postParams['plano'];
        $obMailing->contrato = $postParams['contrato'];
        $obMailing->status = $postParams['status'];
        $obMailing->vendedor = $postParams['vendedor'];
        $obMailing->mensalidade = $postParams['mensalidade'];
        $obMailing->tipo_contrato = $postParams['tipo_contrato'];
        $obMailing->n_protocolo = $postParams['n_protocolo'];
        $obMailing->status_protocolo = $postParams['status_protocolo'];
        $obMailing->data_protocolo = $postParams['data_protocolo'];
        $obMailing->obs_protocolo = $postParams['obs_protocolo'];
        $obMailing->lista = $postParams['lista'];
        $obMailing->id_mailing = $postParams['id_mailing'];
        $obMailing->nome_mailing = $postParams['nome_mailing'];
        $obMailing->status_lista = 1;
        $obMailing->cadastrar();

        //RETORNA OS DETALHES DO DEPOIMENTO CADASTRADO
        return [
            'id'       => (int)$obMailing->id,
            'nome'     => $obMailing->nome,
            'doc'      => $obMailing->doc
        ];
    }


    /**
     * Método responsável por atualizar um depoimento
     * @param Request $request
     * @param integer $id
     * @throws Exception
     * @return array
     */
    public static function setEditTestimony(Request $request, int $id): array
    {

        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['nome']) OR !isset($postVars['mensagem'])){
            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios.", 400);
        }

        //BUSCAR O DEPOIMENTO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityTestimony){
            throw new Exception("O depoimento ".$id." não foi encontrado.", 404);
        }


        //ATUALIZA O DEPOIMENTO
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->atualizar();

        //RETORNA OS DETALHES DO DEPOIMENTO ATUALIZADO
        return [
            'id'       => (int)$obTestimony->id,
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data'     => $obTestimony->data
        ];
    }


}