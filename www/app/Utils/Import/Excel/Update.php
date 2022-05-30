<?php

namespace App\Utils\Import\Excel;

use App\Http\Request;
use App\Model\Entity\Files as EntityFiles;

class Update {


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $inputCSV
     * @param string $company
     * @param string $description
     * @return string|bool
     */
    public function importFilesCompany(Request $request, array $inputCSV, string $company, string $description): bool
    {

        //VERIFICA SE EXISTE O ARQUIVO
        if ($inputCSV == ''){
            $request->getRouter()->redirect('/adm/input/empresas?status=nullCSV');
        }

        //PASTA DE ARQUIVOS
        $dir = "./resources/docs/excel/";

        //NOME ORIGINAL DO ARQUIVO
        $originalFilename = basename($inputCSV["name"]);
        $fileExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);

        //VERIFICA SE A EXTENSÃO É CSV
        if ($fileExtension != 'csv'){
            $request->getRouter()->redirect('/adm/input/empresas?status=erroExtension');
        }


        //DEFINE O NOME DO ARQUIVO ENVIADO ex: nome_dia-mes-ano_hora-minuto-segundo.csv
        $dir = $dir.basename($originalFilename, ".".$fileExtension)."_".date('d-m-Y_H-i-s').".".$fileExtension;

        //move o arquivo para a pasta /csv
        if(move_uploaded_file($inputCSV["tmp_name"], $dir)) {


            $obFiles = new EntityFiles();
            $obFiles->path = $dir;
            $obFiles->date_created = date('Y-m-d H:m:s');
            $obFiles->description = $description;
            $obFiles->id_company = $company;
            $obFiles->cadastrar();


        } else {
            $request->getRouter()->redirect('/adm/input/empresas?status=erroMove');
        }

        return true;
    }

}