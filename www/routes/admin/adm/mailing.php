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

//ROTA DE EDIÇÃO DE EMPRESA (POST)
$obRouter->post('/empresa/lista/novo', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Companies::setNewCompany($request));
    }
]);

//ROTA DE EDIÇÃO DE UMA EMPRESA
$obRouter->get('/empresa/lista/{id}/edit', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Companies::getEditCompany($request, $id));
    }
]);

//ROTA DE EDIÇÃO DE EMPRESA (POST)
$obRouter->post('/empresa/lista/{id}/edit', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Companies::setEditCompany($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE EMPRESA (POST)
$obRouter->post('/empresa/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Companies::setDeleteCompany($request, $id));
    }
]);
