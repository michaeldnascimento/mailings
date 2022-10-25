<?php

namespace App\Http\Middleware;

use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Admin\Nivel as SessionNivel;
use Closure;

class RequireNivelSellerList {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        //SEPARA URI EM ARRAY
        $arrayUri = $request->getArrayUri();

        //SELECIONA O INDICE
        $mailing = $arrayUri[1];

        //RECEBE DA SESSÃO
        $arrayLists = $_SESSION['mailings']['admin']['user']["$mailing"];

        //LISTAS LIBERADAS POR SESSÃO
        $list = explode(", ", $arrayLists);

        if(array_filter($list) == null){
            $request->getRouter()->redirect('/?status=mailingInvalid');
        }

        //RECEBE A ULTIMA PALAVRA URI
        $lastWord = $request->getLastWord();

        //VERIFICA EMPRESA USUÁRIO
        if(!in_array($lastWord, $list)){
            $request->getRouter()->redirect('/?status=listInvalid');
        }
        //CONTINUA A EXECUÇÃO
        return $next($request);

    }

}