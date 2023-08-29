<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Supervisor\Results;

//ROTA LISTA HISTORICO BOT
$obRouter->get('/supervisor/resultados/solar/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-supervisor',
    ],
    function($request){
        return new Response(200, Results\Solar::getListInputResults($request));
    }
]);