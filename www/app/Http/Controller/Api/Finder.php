<?php

namespace App\Http\Controller\Api;

use \App\Http\Request;
use \App\Model\Entity\Finder as EntityFinder;
use \Exception;

class Finder extends Api{

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
    public static function setNewFinder(Request $request): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postParams['cpf_cnpj'])){
            throw new Exception("Os campos 'cpf_cnpj' são obrigatórios.", 400);
        }

        //OBTÉM O MAILING DO BANCO DE DADOS
        $obFinder = EntityFinder::getFinderByCpfCnpj($postParams['cpf_cnpj']);

        //VALIDA A INSTANCIA SE O MAILING EXISTIR
        if($obFinder instanceof EntityFinder){
            throw new Exception("Esse mailing já existe", 400);
        }

        //NOVO MAILING DESKTOP
        $obFinder = new EntityFinder();
        $obFinder->cpf_cnpj = $postParams['cpf_cnpj'];
        $obFinder->nome_razao_social = $postParams['nome_razao_social'];
        $obFinder->tipo_pessoa = $postParams['tipo_pessoa'];
        $obFinder->nascimento_abertura = implode('-', array_reverse(explode('/', $postParams['nascimento_abertura'])));
        $obFinder->mae_nome_fantasia = $postParams['mae_nome_fantasia'];
        $obFinder->email =  $postParams['email'];
        $obFinder->telefone_1 =   $postParams['telefone_1'];
        $obFinder->telefone_2 = $postParams['telefone_2'];
        $obFinder->telefone_3 = $postParams['telefone_3'];
        $obFinder->telefone_4 = $postParams['telefone_4'];
        $obFinder->telefone_5 = $postParams['telefone_5'];
        $obFinder->telefone_6 = $postParams['telefone_6'];
        $obFinder->endereco_1 = $postParams['endereco_1'];
        $obFinder->endereco_2 = $postParams['endereco_2'];
        $obFinder->parente_1 = $postParams['parente_1'];
        $obFinder->parente_2 = $postParams['parente_2'];
        $obFinder->parente_3 = $postParams['parente_3'];
        $obFinder->parente_4 = $postParams['parente_4'];
        $obFinder->parente_5 = $postParams['parente_5'];
        $obFinder->parente_6 = $postParams['parente_6'];
        $obFinder->cpf_cnpj_socio_1 = $postParams['cpf_cnpj_socio_1'];
        $obFinder->cpf_cnpj_socio_2 = $postParams['cpf_cnpj_socio_2'];
        $obFinder->cpf_cnpj_socio_3 = $postParams['cpf_cnpj_socio_3'];
        $obFinder->cpf_cnpj_socio_4 = $postParams['cpf_cnpj_socio_4'];
        $obFinder->cpf_cnpj_socio_5 = $postParams['cpf_cnpj_socio_5'];
        $obFinder->cpf_cnpj_socio_6 = $postParams['cpf_cnpj_socio_6'];
        $obFinder->socio_sociedades_1 = $postParams['socio_sociedades_1'];
        $obFinder->socio_sociedades_2 = $postParams['socio_sociedades_2'];
        $obFinder->socio_sociedades_3 = $postParams['socio_sociedades_3'];
        $obFinder->socio_sociedades_4 = $postParams['socio_sociedades_4'];
        $obFinder->socio_sociedades_5 = $postParams['socio_sociedades_5'];
        $obFinder->socio_sociedades_6 = $postParams['socio_sociedades_6'];
        $obFinder->situacao_cadastral_empresa = $postParams['situacao_cadastral_empresa'];
        $obFinder->porte_empresa = $postParams['porte_empresa'];
        $obFinder->origem = $postParams['origem'];
        $obFinder->lista = $postParams['lista'];
        $obFinder->status = 1;
        $obFinder->cadastrar();

        //RETORNA OS DETALHES DO MAILING CADASTRADO
        return [
            'id'       => (int)$obFinder->id,
            'nome_razao_social'  => $obFinder->nome_razao_social,
            'cpf_cnpj'      => $obFinder->cpf_cnpj
        ];
    }


        /**
     * Método responsável por atualizar um depoimento
     * @param Request $request
     * @param integer $id
     * @throws Exception
     * @return array
     */
    public static function setEditFinder(Request $request, int $id): array
    {

        //POST PARAMS
        $postParams = $request->getQueryParams();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($id)){
            throw new Exception("ID do mailing é obrigatório.", 400);
        }

        if(empty($postParams['lista'])) {
            throw new Exception("O campo 'lista' é obrigatórios.", 400);
        }

        if(empty($postParams['status'])) {
            throw new Exception("O campo 'status' é obrigatórios.", 400);
        }

        //BUSCAR O DEPOIMENTO NO BANCO
        $obFinder = EntityFinder::getInputById($id);

        //VALIDA A INSTANCIA
        if(!$obFinder instanceof EntityFinder){
            throw new Exception("O Mailing ".$id." não foi encontrado.", 404);
        }

        if($obFinder->cpf_cnpj != null){
            //GET CPF/CNPJ E REMOVE STRINGS
            $cpf_cnpj = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $postParams['cpf_cnpj']);
            
            //REMOVE CPF/CNPJ QUE COMEÇA COM 0 A ESQUERDA
            $cpf_cnpj = ltrim($cpf_cnpj, "0");
        }

        $obFinder->cpf_cnpj = $cpf_cnpj ?? $obFinder->cpf_cnpj;
        $obFinder->nome_razao_social = $postParams['nome_razao_social'];
        $obFinder->tipo_pessoa = $postParams['tipo_pessoa'];
        $obFinder->nascimento_abertura = implode('-', array_reverse(explode('/', $postParams['nascimento_abertura'])));
        $obFinder->mae_nome_fantasia = $postParams['mae_nome_fantasia'];
        $obFinder->email =  $postParams['email'];
        $obFinder->telefone_1  = preg_replace('/[^0-9]/', '', $postParams['telefone_1']);
        $obFinder->telefone_2 = preg_replace('/[^0-9]/', '', $postParams['telefone_2']);
        $obFinder->telefone_3 = preg_replace('/[^0-9]/', '', $postParams['telefone_3']);
        $obFinder->telefone_4  = preg_replace('/[^0-9]/', '', $postParams['telefone_4']);
        $obFinder->telefone_5 = preg_replace('/[^0-9]/', '', $postParams['telefone_5']);
        $obFinder->telefone_6 = preg_replace('/[^0-9]/', '', $postParams['telefone_6']);
        $obFinder->endereco_1 = $postParams['endereco_1'];
        $obFinder->endereco_2 = $postParams['endereco_2'];
        $obFinder->parente_1 = $postParams['parente_1'];
        $obFinder->parente_2 = $postParams['parente_2'];
        $obFinder->parente_3 = $postParams['parente_3'];
        $obFinder->parente_4 = $postParams['parente_4'];
        $obFinder->parente_5 = $postParams['parente_5'];
        $obFinder->parente_6 = $postParams['parente_6'];
        $obFinder->cpf_cnpj_socio_1 = $postParams['cpf_cnpj_socio_1'];
        $obFinder->cpf_cnpj_socio_2 = $postParams['cpf_cnpj_socio_2'];
        $obFinder->cpf_cnpj_socio_3 = $postParams['cpf_cnpj_socio_3'];
        $obFinder->cpf_cnpj_socio_4 = $postParams['cpf_cnpj_socio_4'];
        $obFinder->cpf_cnpj_socio_5 = $postParams['cpf_cnpj_socio_5'];
        $obFinder->cpf_cnpj_socio_6 = $postParams['cpf_cnpj_socio_6'];
        $obFinder->socio_sociedades_1 = $postParams['socio_sociedades_1'];
        $obFinder->socio_sociedades_2 = $postParams['socio_sociedades_2'];
        $obFinder->socio_sociedades_3 = $postParams['socio_sociedades_3'];
        $obFinder->socio_sociedades_4 = $postParams['socio_sociedades_4'];
        $obFinder->socio_sociedades_5 = $postParams['socio_sociedades_5'];
        $obFinder->socio_sociedades_6 = $postParams['socio_sociedades_6'];
        $obFinder->situacao_cadastral_empresa = $postParams['situacao_cadastral_empresa'];
        $obFinder->porte_empresa = $postParams['porte_empresa'];
        $obFinder->origem = $postParams['origem'];
        $obFinder->lista = $postParams['lista'];
        $obFinder->status = $postParams['status'];
        $obFinder->atualizar();

        //RETORNA OS DETALHES DO MAILING ATUALIZADO
        return [
            'ID'                    => (int)$obFinder->id,
            'Nome ou razao social'  => $obFinder->nome_razao_social,
            'CPF OU CNPJ'           => $obFinder->cpf_cnpj,
            'Tipo Pessoa'           => $obFinder->tipo_pessoa,
            'Origem'                => $obFinder->origem,
            'lista'                 => $obFinder->lista,
            'status'                => $obFinder->status
        ];
    }


}