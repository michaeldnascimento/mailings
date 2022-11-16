<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Vero\ListVero;

//ROTA LISTA BASE
$obRouter->get('/vendedor/vero/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
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
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'base'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->get('/vendedor/vero/cancelado', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::getListVero($request, 'cancelado'));
    }
]);

//ROTA LISTA CANCELADO
$obRouter->post('/vendedor/vero/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'cancelado'));
    }
]);

//ROTA LISTA PROPOSTA
$obRouter->get('/vendedor/vero/proposta', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::getListVero($request, 'proposta'));
    }
]);

//ROTA LISTA PROPOSTA
$obRouter->post('/vendedor/vero/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'proposta'));
    }
]);

//ROTA LISTA PENDENTE INSTALAÇÃO
$obRouter->get('/vendedor/vero/pendente-instalacao', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::getListVero($request, 'pendente-instalacao'));
    }
]);

//ROTA LISTA PENDENTE INSTALAÇÃO
$obRouter->post('/vendedor/vero/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListVero::setListVero($request, 'pendente-instalacao'));
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