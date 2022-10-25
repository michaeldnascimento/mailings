<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Seller\Claro\ListClaro;

//ROTA CANCELADOMAILING
$obRouter->get('/vendedor/claro/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::getListClaro($request, 'cancelado'));
    }
]);

//ROTA CANCELADO MAILING
$obRouter->post('/vendedor/claro/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::setListClaro($request, 'cancelado'));
    }
]);

//ROTA MAILING DESABILITADO
$obRouter->get('/vendedor/claro/desabilitado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::getListClaro($request, 'desabilitado'));
    }
]);

//ROTA MAILING DESABILITADO
$obRouter->post('/vendedor/claro/desabilitado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::setListClaro($request, 'desabilitado'));
    }
]);

//ROTA MAILING PROPOSTA
$obRouter->get('/vendedor/claro/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::getListClaro($request, 'proposta'));
    }
]);

//ROTA MAILING PROPOSTA
$obRouter->post('/vendedor/claro/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::setListClaro($request, 'proposta'));
    }
]);

//ROTA MAILING PEDENTE INSTALAÇÃO
$obRouter->get('/vendedor/claro/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::getListClaro($request, 'pendente-instalacao'));
    }
]);

//ROTA MAILING PEDENTE INSTALAÇÃO
$obRouter->post('/vendedor/claro/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListClaro::setListClaro($request, 'pendente-instalacao'));
    }
]);


//TABULAÇÃO MAILING
$obRouter->post('/vendedor/claro/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListClaro::statusMailing($request, $list, $_POST['id']));
    }
]);