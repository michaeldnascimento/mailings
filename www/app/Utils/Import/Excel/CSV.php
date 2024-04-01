<?php

namespace App\Utils\Import\Excel;

use App\Http\Request;
use App\Model\Entity\Mailing as EntityMailing;
use App\Model\Entity\MailingInput as EntityInput;
use App\Model\Entity\MailingClaro as EntityClaro;
use App\Model\Entity\MailingNet as EntityNet;
use App\Model\Entity\MailingVero as EntityVero;
use App\Model\Entity\MailingAlgar as EntityAlgar;
use App\Model\Entity\MailingAmericanet as EntityAmericanet;

class CSV {


    private const COLUMN_MAPPING = [
        'contrato' => 'contrato',
        'status_contrato' => 'status_contrato',
        'cpf' => 'cpf',
        'data_nascimento' => 'data_nascimento',
        'rg' => 'rg',
        'tipo_pessoa' => 'tipo_pessoa',
        'nome_cliente' => 'nome_cliente',
        'email' => 'email',
        'nome_mae' => 'nome_mae',
        'cep' => 'cep',
        'endereco' => 'endereco',
        'numero' => 'numero',
        'bairro' => 'bairro',
        'codigo_cidade' => 'codigo_cidade',
        'cidade' => 'cidade',
        'uf' => 'uf',
        'fone_1' => 'fone_1',
        'fone_2' => 'fone_2',
        'fone_3' => 'fone_3',
        'tipo_mailing' => 'tipo_mailing',
        'num_protocolo' => 'num_protocolo',
        'num_pedido_proposta' => 'num_pedido_proposta',
        'proposta' => 'proposta',
        'data_venda' => 'data_venda',
        'cod_hp' => 'cod_hp',
        'rua' => 'rua',
        'regiao' => 'regiao',
        'historico_hp' => 'historico_hp',
        'base_cluster' => 'base_cluster',
        'motivo_pendencia_venda' => 'motivo_pendencia_venda',
        'motivo_cancelamento' => 'motivo_cancelamento',
        'data_atendimento' => 'data_atendimento',
        'data_cancelamento' => 'data_cancelamento',
        'data_instalado' => 'data_instalado',
        'status_proposta' => 'status_proposta',
        'canal_venda' => 'canal_venda',
        'obs' => 'obs',
    ];

    /**
     * Método responsável por importar CSV
     *
     * @param Request $request
     * @param array $inputCSV
     * @param string $nome_mailing
     * @param string $lista
     * @param string $listaMaling
     * @param string $dir
     * @param int $id_mailing
     * @return bool
     */
    public function importCSVBase(Request $request, array $inputCSV, string $nome_mailing, string $lista, string $listaMaling, string $dir, int $id_mailing): bool
    {
        if (!self::moveFileToCsvFolder($inputCSV, $dir)) {
            $request->getRouter()->redirect('/adm/input/mailings?status=erroMove');
            return false;
        }

        $arquivo = fopen($dir, "r");
        if (!$arquivo) {
            // Tratamento de erro ao abrir o arquivo
            return false;
        }

        self::importCsvData($arquivo, $nome_mailing, $lista, $listaMaling, $id_mailing);

        fclose($arquivo);
        return true;
    }

    private function moveFileToCsvFolder(array $inputCSV, string $dir): bool
    {
        return move_uploaded_file($inputCSV["tmp_name"], $dir);
    }


    private function getEntityField(string $colunaNome): string
    {
        if (array_key_exists($colunaNome, self::COLUMN_MAPPING)) {
            return self::COLUMN_MAPPING[$colunaNome];
        }
        return 'campo_desconhecido';
    }

    private function importCsvData($arquivo, string $nome_mailing, string $lista, string $listaMaling, int $id_mailing): void
    {
        // Ler o cabeçalho do arquivo
        $cabecalho = fgetcsv($arquivo, 0, ",");
        // Cria um mapeamento de nome da coluna para índice
        $mapeamentoColunas = array_flip($cabecalho);

        switch ($lista) {
            case 'claro':
                $entity = new EntityClaro();
                break;
            case 'net':
                $entity = new EntityNet();
                break;
            case 'algar':
                $entity = new EntityAlgar();
                break;
            case 'americanet':
                $entity = new EntityAmericanet();
                break;
            case 'vero':
                $entity = new EntityVero();
                break;
            default:
                $entity = new EntityInput();
        }

        while (($linha = fgetcsv($arquivo, 0, ",")) !== false) {

            // Mapeia cada valor para a propriedade correspondente
            foreach ($mapeamentoColunas as $nomeColuna => $index) {
                $campoEntidade = self::getEntityField($nomeColuna);
                if ($campoEntidade !== 'campo_desconhecido' && isset($linha[$index])) {
                    $entity->{$campoEntidade} = $linha[$index];
                }
            }

            if (!empty($listaMaling)) {
                $lista = $listaMaling;
                $status =  1;
            }else{
                $status =  2;
            }

            // Define propriedades adicionais
            $entity->lista = $lista;
            $entity->status_lista = $status;
            $entity->nome_mailing = $nome_mailing;
            $entity->id_mailing = $id_mailing;
            $entity->cadastrar();
        }
    }


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $inputCSV
     * @param string $nome_mailing
     * @param string $lista
     * @return string|bool
     */
    public function importCSVSolarBot(Request $request, array $inputCSV, string $nome_mailing, string $lista, $dir, $id_mailing): bool
    {

        //move o arquivo para a pasta /csv
        if(move_uploaded_file($inputCSV["tmp_name"], $dir)) {

            // ABRIR ARQUIVO
            $arquivo = fopen("$dir", "r");

            $fist = true;
            while (($linha = fgetcsv($arquivo, 0, ",")) !== FALSE) {

                /** Para pular a primeira linha(cabeçaçho) do csv, e se true (primeira vez) executa o "continue;" que pula para a proxima linha do CSV */
                if ($fist) {
                    $fist = false;
                    continue;
                }

                $entityInput = new EntityInput();
                $entityInput->contrato = $linha[0];
                $entityInput->cpf = $linha[1];
                $entityInput->codigo_cidade = $linha[2];
                $entityInput->cidade = $linha[3];
                $entityInput->lista = $lista;
                $entityInput->status_lista = 2;
                $entityInput->nome_mailing = $nome_mailing;
                $entityInput->id_mailing = $id_mailing;
                $entityInput->cadastrar();

            }

            fclose($arquivo);

        } else {
            $request->getRouter()->redirect('/adm/input/mailings?status=erroMove');
        }

        return true;

    }


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $inputCSV
     * @param string $nome_mailing
     * @param string $lista
     * @return string|bool
     */
    public function importCSVMailing(Request $request, array $inputCSV, string $nome_mailing, string $lista, $dir, $id_mailing): bool
    {

        //move o arquivo para a pasta /csv
        if(move_uploaded_file($inputCSV["tmp_name"], $dir)) {

            // ABRIR ARQUIVO
            $arquivo = fopen("$dir", "r");

            $fist = true;
            while (($linha = fgetcsv($arquivo, 0, ",")) !== FALSE) {

                /** Para pular a primeira linha(cabeçaçho) do csv, e se true (primeira vez) executa o "continue;" que pula para a proxima linha do CSV */
                if ($fist) {
                    $fist = false;
                    continue;
                }

                $obMailing = new EntityMailing();
                $obMailing->nome = $linha[0];
                $obMailing->fone1 = $linha[1];
                $obMailing->fone2 = $linha[2];
                $obMailing->doc = $linha[3];
                $obMailing->endereco = $linha[4];
                $obMailing->num = $linha[5];
                $obMailing->compl = $linha[6];
                $obMailing->bairro = $linha[7];
                $obMailing->cidade = $linha[8];
                $obMailing->proposta = $linha[9];
                $obMailing->email = $linha[10];
                $obMailing->hp = $linha[11];
                $obMailing->tipo = $linha[12];
                $obMailing->obs = $linha[13];
                $obMailing->lista = $lista;
                $obMailing->status_lista = 1;
                $obMailing->nome_mailing = $nome_mailing;
                $obMailing->id_mailing = $id_mailing;
                $obMailing->cadastrar();

            }

            fclose($arquivo);

        } else {
            $request->getRouter()->redirect('/adm/input/mailings?status=erroMove');
        }

        return true;

    }



    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $inputCSV
     * @param string $nome_mailing
     * @param string $lista
     * @return string|bool
     */
    public function importCSVMailings(Request $request, array $inputCSV, string $nome_mailing, string $list, string $listMailing): bool
    {

        //VERIFICA SE EXISTE O ARQUIVO
        if ($inputCSV == ''){
            $request->getRouter()->redirect('/adm/input/mailings?status=nullCSV');
        }

        //PASTA DE ARQUIVOS
        $dir = "./resources/docs/excel/";

        //NOME ORIGINAL DO ARQUIVO
        $originalFilename = basename($inputCSV["name"]);
        $fileExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);

        //VERIFICA SE A EXTENSÃO É CSV
        if ($fileExtension != 'csv'){
            $request->getRouter()->redirect('/adm/input/mailings?status=erroExtension');
        }

        //DEFINE O NOME DO ARQUIVO ENVIADO ex: nome_dia-mes-ano_hora-minuto-segundo.csv
        $dir = $dir.basename($originalFilename, ".".$fileExtension)."_".date('d-m-Y_H-i-s').".".$fileExtension;
        $id_mailing = crc32(date('d-m-Y_H-i-s'));


        if($list == 'lista1' OR $list == 'lista2'){
            self::importCSVMailing($request, $inputCSV, $nome_mailing, $list, $dir, $id_mailing);
        }

        if($list == 'solarbase'){
            self::importCSVBase($request, $inputCSV, $nome_mailing, $list, $listMailing = '', $dir, $id_mailing);
        }
        
        if($list == 'solarbot1' OR $list == 'solarbot2' OR $list == 'solarbot3'){
            self::importCSVSolarBot($request, $inputCSV, $nome_mailing, $list, $dir, $id_mailing);
        }

        if($list == 'claro'){
            self::importCSVBase($request, $inputCSV, $nome_mailing, $list, $listMailing, $dir, $id_mailing);
        }

        if($list == 'net'){
            self::importCSVBase($request, $inputCSV, $nome_mailing, $list, $listMailing, $dir, $id_mailing);
        }

        if($list == 'algar'){
            self::importCSVBase($request, $inputCSV, $nome_mailing, $list, $listMailing,  $dir, $id_mailing);
        }

        if($list == 'americanet'){
            self::importCSVBase($request, $inputCSV, $nome_mailing, $list, $listMailing, $dir, $id_mailing);
        }

        if($list == 'vero'){
            self::importCSVBase($request, $inputCSV, $nome_mailing, $list, $listMailing, $dir, $id_mailing);
        }


        return true;
    }

}