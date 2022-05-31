<?php

namespace App\Http\Middleware;

use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Admin\Nivel as SessionNivel;
use Closure;

class RequireNivelCompany {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        //VERIFICA SE O USUÁRIO ESTÁ LOGADO
        if(SessionNivel::getNivelSession() == 1){
            $request->getRouter()->redirect('/?status=routeInvalid');
        }

        //RECEBE NUMERO EMPRESA NA SESSÃO
        $companies = $_SESSION['mailings']['admin']['user']['companies'];

        //RECEBER A URI E REMOVER STRING
        $uri_number = (filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT));


        //VERIFICA EMPRESA USUÁRIO
        if(SessionNivel::getNivelSession() == 2 AND $companies != $uri_number){
            $request->getRouter()->redirect('/?status=companyInvalid');
        }

        //CONTINUA A EXECUÇÃO
        return $next($request);

    }

}