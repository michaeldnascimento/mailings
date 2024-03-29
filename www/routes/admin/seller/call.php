<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Call\Called;

//ROTA LISTA CHAMADOS
$obRouter->get('/vendedor/chamados/lista', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-call',
    ],
    function($request){
        return new Response(200, Called::getCalledList($request));
    }
]);

//ROTA ADICIONAR NOVO CHAMADO
$obRouter->get('/vendedor/chamados/novo', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-call',
    ],
    function($request){
        return new Response(200, Called::getNewCall($request));
    }
]);

//ROTA ADICIONAR NOVO CHAMADO
$obRouter->post('/vendedor/chamados/novo', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-call',
    ],
    function($request){
        return new Response(200, Called::setNewCall($request));
    }
]);

//ROTA DE EDIÇÃO DE UMA EMPRESA
$obRouter->get('/vendedor/chamados/lista/{id}/view', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-call',
    ],
    function($request, $id){
        return new Response(200, Called::getViewCall($request, $id));
    }
]);

//ROTA DE EDIÇÃO DE EMPRESA (POST)
$obRouter->post('/vendedor/chamados/lista/{id}/view', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-call',
    ],
    function($request, $id){
        return new Response(200, Called::setResponseCall($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE EMPRESA (POST)
$obRouter->post('/vendedor/chamados/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-call',
    ],
    function($request, $id){
        return new Response(200, Called::setDeleteCall($request, $id));
    }
]);