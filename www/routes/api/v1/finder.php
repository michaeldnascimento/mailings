<?php

use \App\Http\Response;
use \App\Http\Controller\Api\Finder;

//ROTA DE CADASTRO DE MAILING DESKTOP
$obRouter->post('/api/v1/finder/', [
    'middlewares' => [
        'api',
        //'user-basic-auth'
    ],
    function($request){
        return new Response(201, Finder::setNewFinder($request), 'application/json');
    }
]);

//ROTA DE ATUALIZAÇÃO DE MAILING
$obRouter->post('/api/v1/finder/{id}', [
    'middlewares' => [
        'api',
        //'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Finder::setEditFinder($request, $id), 'application/json');
    }
]);