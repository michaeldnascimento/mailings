<?php

namespace App\Http\Middleware;

use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Admin\Nivel as SessionNivel;
use Closure;

class RequireNivelSolar {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {


        //RECEBE CEP DA SESSÃO
        $cep = $_SESSION['mailings']['admin']['user']['solar'];

        //VERIFICA EMPRESA USUÁRIO
        if($cep != 1){
            $request->getRouter()->redirect('/?status=solarInvalid');
        }
        //CONTINUA A EXECUÇÃO
        return $next($request);

    }

}