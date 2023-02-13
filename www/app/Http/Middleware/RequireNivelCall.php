<?php

namespace App\Http\Middleware;

use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Admin\Nivel as SessionNivel;
use Closure;

class RequireNivelCall {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {


        //RECEBE CEP DA SESSÃO
        $id = $_SESSION['mailings']['admin']['user']['call'];

        //VERIFICA EMPRESA USUÁRIO
        if($id != 1){
            $request->getRouter()->redirect('/?status=callInvalid');
        }
        //CONTINUA A EXECUÇÃO
        return $next($request);

    }

}