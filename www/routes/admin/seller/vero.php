<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Vero\ListVero;

//ROTA LISTA BASE
$obRouter->get('/vendedor/vero/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::getListVero($request, 'base'));
    }
]);

//ROTA LISTA BASE
$obRouter->post('/vendedor/vero/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'base'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->get('/vendedor/vero/cancelados', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::getListVero($request, 'cancelados'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->post('/vendedor/vero/cancelados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'cancelados'));
    }
]);

//ROTA LISTA PEDIDOS
$obRouter->get('/vendedor/vero/pedidos', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::getListVero($request, 'pedidos'));
    }
]);

//ROTA LISTA PEDIDOS
$obRouter->post('/vendedor/vero/pedidos/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'pedidos'));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/vero/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListVero::statusMailing($request, $list, $_POST['id']));
    }
]);