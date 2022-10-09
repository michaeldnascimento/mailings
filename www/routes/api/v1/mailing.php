<?php

use \App\Http\Response;
use \App\Http\Controller\Api\Mailing;

//ROTA DE CADASTRO DE MAILING DESKTOP
$obRouter->post('/api/v1/mailing/desktop/', [
    'middlewares' => [
        'api',
        //'user-basic-auth'
    ],
    function($request){
        return new Response(201, Mailing::setNewMailingDesktop($request), 'application/json');
    }
]);

//ROTA DE ATUALIZAÇÃO DE DEPOIMENTO
$obRouter->put('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::setEditTestimony($request, $id), 'application/json');
    }
]);