<?php

namespace App\Utils\Import\Excel;

use App\Http\Request;
use App\Model\Entity\Files as EntityFiles;

class Update
{


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $remote_file
     * @param string $file_string
     * @return string|bool
     */
    public static function ftp_file_put_contents(Request $request, array $remote_file, string $file_string): bool
    {


        // FTP login details
        $ftp_server = '';
        $ftp_user_name = '';
        $ftp_user_pass = '';

        // FTP connection
        $ftp_conn = ftp_connect($ftp_server);

        // FTP login
        @$login_result = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);

        // FTP upload
        ftp_chdir($ftp_conn, 'http://162.241.60.58/home1/gpagam04/public_ftp/');
        if ($login_result) $upload_result = ftp_put($ftp_conn, $remote_file, $file_string, FTP_ASCII);

        // Error handling
        if (!$login_result or !$upload_result) {
            echo('<p>FTP error: The file could not be written to the FTP server.</p>');
        }

        // Close FTP connection
        ftp_close($ftp_conn);

        return true;
    }


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param array $inputCSV
     * @param string $company
     * @param string $description
     * @return string|bool
     */
    public static function importFilesCompany(Request $request, array $inputCSV, string $company, string $description): bool
    {

        //VERIFICA SE EXISTE O ARQUIVO
        if ($inputCSV == '') {
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

        //VERIFICA O TAMANHO DO ARQUIVO
        if ($inputCSV["error"] === UPLOAD_ERR_OK) {
            $request->getRouter()->redirect('/adm/input/empresas?status=uploadError');
        }


        //DEFINE O NOME DO ARQUIVO ENVIADO ex: nome_dia-mes-ano_hora-minuto-segundo.csv
        $dir = $dir . basename($originalFilename, "." . $fileExtension) . "_" . date('d-m-Y_H-i-s') . "." . $fileExtension;

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


    /**
     * Método responsável por importar csv
     * @param Request $request
     * @param string $inputCSV
     * @param string $company
     * @param string $description
     * @return string|bool
     */
    public static function importNameFileCompany(Request $request, string $inputCSV, string $company, string $description): bool
    {

        //VERIFICA SE EXISTE O ARQUIVO
        if ($inputCSV == '') {
            $request->getRouter()->redirect('/adm/input/empresas?status=nullCSV');
        }

        //PASTA DE ARQUIVOS
        $dir = "./resources/docs/excel/companies/";

        //DEFINE O NOME DO ARQUIVO ENVIADO
        $dir .= $inputCSV;

        //move o arquivo para a pasta /csv
        if(!empty($dir)) {

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