<?php

namespace App\Http\Middleware;

use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Admin\Nivel as SessionNivel;
use Closure;

class RequireNivelAdmin {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        //VERIFICA SE O USUÁRIO ESTÁ LOGADO
        if(SessionNivel::getNivelSession() != 2){
            $request->getRouter()->redirect('/?status=routeInvalid');
        }

        //CONTINUA A EXECUÇÃO
        return $next($request);

    }

}