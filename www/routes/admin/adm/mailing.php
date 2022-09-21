<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\Mailing\ManagerMailings;

//ROTA INPUT LISTA
$obRouter->get('/adm/mailings/lista', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, ManagerMailings::getManagerMailingsList($request));
    }
]);

//ROTA DE PARA ALTERAR STATUS MAILING
$obRouter->get('/adm/mailings/lista/{id_mailing}/status', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id_mailing){
        return new Response(200, ManagerMailings::setManagerStatus($request, $id_mailing));
    }
]);