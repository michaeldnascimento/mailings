<?php

namespace App\Http\Controller\Api;

use \App\Db\Pagination;
use \App\Http\Request;
use \App\Model\Entity\Client as EntityClient;
use \Exception;

class Client extends Api{

    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    private static function getTestimonyItems(Request $request, &$obPagination): array
    {
        //DEPOIMENTOS
        $items = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $items[] =  [
                'id'       => (int)$obTestimony->id,
                'nome'     => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data'     => $obTestimony->data
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $items;
    }

    /**
     * Método responsável por retornar os depoimentos cadastrados
     * @param Request $request
     * @return array
     */
    public static function getTestimonies(Request $request): array
    {
        return [
            'depoimentos' => self::getTestimonyItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

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
     * Método responsável por cadastrar um novo depoimento
     * @param Request $request
     * @throws Exception
     * @return array
     */
    public static function setNewTestimony(Request $request): array
    {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['nome']) OR !isset($postVars['mensagem'])){
            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios.", 400);
        }

        //NOVO DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        //RETORNA OS DETALHES DO DEPOIMENTO CADASTRADO
        return [
            'id'       => (int)$obTestimony->id,
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data'     => $obTestimony->data
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


    /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @throws Exception
     * @return array
     */
    public static function setDeleteTestimony(Request $request, int $id): array
    {

        //BUSCAR O DEPOIMENTO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityTestimony){
            throw new Exception("O depoimento ".$id." não foi encontrado.", 404);
        }

        //EXCLUI O DEPOIMENTO
        $obTestimony->excluir();

        //RETORNA O SUCESSO DA EXCLUSÃO
        return [
            'sucesso'       => true
        ];
    }
}