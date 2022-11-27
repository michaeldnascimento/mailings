<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Americanet\ListAmericanet;

//ROTA LISTA BASE
$obRouter->get('/vendedor/americanet/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAmericanet::getListAmericanet($request, 'base'));
    }
]);

//ROTA LISTA BASE
$obRouter->post('/vendedor/americanet/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAmericanet::setListAmericanet($request, 'base'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->get('/vendedor/americanet/cancelados', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAmericanet::getListAmericanet($request, 'cancelados'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->post('/vendedor/americanet/cancelados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAmericanet::setListAmericanet($request, 'cancelados'));
    }
]);

//ROTA LISTA PEDIDOS
$obRouter->get('/vendedor/americanet/pedidos', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAmericanet::getListAmericanet($request, 'pedidos'));
    }
]);

//ROTA LISTA PEDIDOS
$obRouter->post('/vendedor/americanet/pedidos/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListAmericanet::setListAmericanet($request, 'pedidos'));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/americanet/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListAmericanet::statusMailing($request, $list, $_POST['id']));
    }
]);