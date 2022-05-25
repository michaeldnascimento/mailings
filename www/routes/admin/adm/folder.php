<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\Folder\Folders;

//BUSCA EMPRESAS
$resultsCompanies = Folders::getListCompaniesRouter();

while($obCompanies = $resultsCompanies->fetchObject(Folders::class)){

    //ID PASTA
    $folder_id = $obCompanies->id;

    //ROTA GET PASTA
    $obRouter->get("/pasta/$folder_id", [
        'middlewares' => [
            //'cache'
            'required-admin-login',
            'required-nivel-admin',
        ],
        function($request, $folder_id){
            return new Response(200, Folders::getFoldersList($request, $folder_id));
        }
    ]);

    $obRouter->post("/pasta/$folder_id", [
        'middlewares' => [
            //'cache'
            'required-admin-login',
            'required-nivel-admin',
        ],
        function($request, $folder_id){
            return new Response(200, Folders::setFoldersDownloads($request, $folder_id));
        }
    ]);

}
