<?php

namespace App\Http\Middleware;

use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Login\Home as SessionLogin;
use Closure;

class RequireAdminLogin {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        //VERIFICA SE O USUÁRIO ESTÁ LOGADO
        if(!SessionLogin::isLogged()){
            $request->getRouter()->redirect('/login');
        }

        //CONTINUA A EXECUÇÃO
        return $next($request);

    }

}