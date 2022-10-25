<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Algar\ListAlgar;

//ROTA LISTA BASE
$obRouter->get('/vendedor/algar/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'base'));
    }
]);

//ROTA LISTA BASE
$obRouter->post('/vendedor/algar/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'base'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->get('/vendedor/algar/cancelado', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'cancelado'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->post('/vendedor/algar/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'cancelado'));
    }
]);

//ROTA LISTA PROPOSTA
$obRouter->get('/vendedor/algar/proposta', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'proposta'));
    }
]);

//ROTA LISTA PROPOSTA
$obRouter->post('/vendedor/algar/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'proposta'));
    }
]);

//ROTA LISTA PENDENTE INSTALAÇÃO
$obRouter->get('/vendedor/algar/pendente-instalacao', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'pendente-instalacao'));
    }
]);

//ROTA LISTA PENDENTE INSTALAÇÃO
$obRouter->post('/vendedor/algar/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
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