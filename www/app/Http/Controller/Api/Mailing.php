<?php

namespace App\Http\Controller\Api;

use \App\Db\Pagination;
use \App\Http\Request;
use \App\Model\Entity\Mailing as EntityMailing;
use \App\Model\Entity\Desktop as EntityDesktop;
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
     * Método responsável por cadastrar um novo mailing desktop
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewMailingDesktop(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf']) OR !isset($postParams['fone1'])){
            throw new Exception("Os campos 'doc' e 'fone' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obDesktop = EntityDesktop::getMailingByCpf($postParams['cpf']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obDesktop instanceof EntityDesktop){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING DESKTOP
        $obDesktop = new EntityDesktop();
        $obDesktop->ordens = $postParams['ordens'];
        $obDesktop->pendencia = $postParams['pendencia'];
        $obDesktop->cliente = $postParams['cliente'];
        $obDesktop->status_spc = $postParams['status_spc'];
        $obDesktop->cpf =   $postParams['cpf'];
        $obDesktop->rg =   $postParams['rg'];
        $obDesktop->data_nasc =   $postParams['data_nasc'];
        $obDesktop->email = $postParams['email'];
        $obDesktop->fone1 = $postParams['fone1'];
        $obDesktop->fone2 = $postParams['fone2'];
        $obDesktop->criado_por = $postParams['criado_por'];
        $obDesktop->data_cad = $postParams['data_cad'];
        $obDesktop->logradouro = $postParams['logradouro'];
        $obDesktop->num = $postParams['num'];
        $obDesktop->bairro = $postParams['bairro'];
        $obDesktop->cidade = $postParams['cidade'];
        $obDesktop->estado = $postParams['estado'];
        $obDesktop->cep = $postParams['cep'];
        $obDesktop->compl = $postParams['compl'];
        $obDesktop->plano = $postParams['plano'];
        $obDesktop->contrato = $postParams['contrato'];
        $obDesktop->status = $postParams['status'];
        $obDesktop->vendedor = $postParams['vendedor'];
        $obDesktop->mensalidade = $postParams['mensalidade'];
        $obDesktop->tipo_contrato = $postParams['tipo_contrato'];
        $obDesktop->n_protocolo = $postParams['n_protocolo'];
        $obDesktop->status_protocolo = $postParams['status_protocolo'];
        $obDesktop->data_protocolo = $postParams['data_protocolo'];
        $obDesktop->obs_protocolo = $postParams['obs_protocolo'];
        $obDesktop->lista = $postParams['lista'];
        $obDesktop->id_mailing = $postParams['id_mailing'];
        $obDesktop->nome_mailing = $postParams['nome_mailing'];
        $obDesktop->status_lista = 1;
        $obDesktop->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obDesktop->id,
            'cliente'  => $obDesktop->cliente,
            'cpf'      => $obDesktop->cpf
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