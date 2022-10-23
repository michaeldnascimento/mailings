<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Algar\ListAlgar;

//ROTA LISTA 1 MAILING
$obRouter->get('/vendedor/algar/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'base'));
    }
]);

//ROTA LISTA 1 MAILING
$obRouter->post('/vendedor/algar/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'base'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/algar/cancelado', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'cancelado'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->post('/vendedor/algar/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'cancelado'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/algar/proposta', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'proposta'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->post('/vendedor/algar/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'proposta'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/algar/pendente-instalacao', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'pendente-instalacao'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->post('/vendedor/algar/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'pendente-instalacao'));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/algar/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListAlgar::statusMailing($request, $list, $_POST['id']));
    }
]);