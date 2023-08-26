<?php

namespace App\Utils\Import\Excel;

use App\Http\Request;
use App\Model\Entity\Mailing as EntityMailing;
use App\Model\Entity\MailingInput as EntityInput;

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
     * @param string $dir
     * @param int $id_mailing
     * @return bool
     */
    public function importCSVSolarBase(Request $request, array $inputCSV, string $nome_mailing, string $lista, string $dir, int $id_mailing): bool
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

        self::importCsvData($arquivo, $nome_mailing, $lista, $id_mailing);

        fclose($arquivo);
        return true;
    }

    private function moveFileToCsvFolder(array $inputCSV, string $dir): bool
    {
        return move_uploaded_file($inputCSV["tmp_name"], $dir);
    }

    private function importCsvData($arquivo, string $nome_mailing, string $lista, int $id_mailing): void
    {
        $first = true;
        while (($linha = fgetcsv($arquivo, 0, ",")) !== false) {
            if ($first) {
                $first = false;
                continue;
            }

            self::processCsvLine($linha, $nome_mailing, $lista, $id_mailing);
        }
    }

    private function processCsvLine(array $linha, string $nome_mailing, string $lista, int $id_mailing): void
    {
        $entityInput = new EntityInput();

        foreach ($linha as $index => $valor) {
            $colunaNome = self::getColumnName($index);
            if ($colunaNome === 'unknown') {
                continue;
            }

            $campoEntidade = self::getEntityField($colunaNome);
            $entityInput->{$campoEntidade} = $valor;
        }

        $entityInput->lista = $lista;
        $entityInput->status_lista = 2;
        $entityInput->nome_mailing = $nome_mailing;
        $entityInput->id_mailing = $id_mailing;
        $entityInput->cadastrar();
    }

    private function getColumnName(int $index): string
    {
        $linhaCabecalho = array_keys(self::COLUMN_MAPPING);
        return isset($linhaCabecalho[$index]) ? $linhaCabecalho[$index] : 'unknown';
    }

    private function getEntityField(string $colunaNome): string
    {
        if (array_key_exists($colunaNome, self::COLUMN_MAPPING)) {
            return self::COLUMN_MAPPING[$colunaNome];
        }
        return 'campo_desconhecido';
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
    public function importCSVMailings(Request $request, array $inputCSV, string $nome_mailing, string $lista): bool
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


        if($lista == 'lista1' OR $lista == 'lista2'){
            self::importCSVMailing($request, $inputCSV, $nome_mailing, $lista, $dir, $id_mailing);
        }

        if($lista == 'solarbase'){
            self::importCSVSolarBase($request, $inputCSV, $nome_mailing, $lista, $dir, $id_mailing);
        }
        
        if($lista == 'solarbot1' OR $lista == 'solarbot2' OR $lista == 'solarbot3'){
            self::importCSVSolarBot($request, $inputCSV, $nome_mailing, $lista, $dir, $id_mailing);
        }


        return true;
    }

}