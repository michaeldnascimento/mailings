<?php

namespace App\Utils\Import\Excel;

use App\Http\Request;
use App\Model\Entity\Mailing as EntityMailing;

class CSV {


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $inputCSV
     * @param string $lista
     * @return string|bool
     */
    public function importCSVMailings(Request $request, array $inputCSV, string $lista): bool
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
        $id  = basename($originalFilename)."_".date('d-m-Y_H-i-s');

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
                $obMailing->id_mailing = $id;
                $obMailing->cadastrar();

            }

            fclose($arquivo);

        } else {
            $request->getRouter()->redirect('/adm/input/mailings?status=erroMove');
        }

        return true;
    }

}