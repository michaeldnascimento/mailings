<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Seller\Net\ListNet;

//ROTA CANCELADOMAILING
$obRouter->get('/vendedor/net/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::getListNet($request, 'cancelado'));
    }
]);

//ROTA CANCELADO MAILING
$obRouter->post('/vendedor/net/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::setListNet($request, 'cancelado'));
    }
]);

//ROTA MAILING DESABILITADO
$obRouter->get('/vendedor/net/desabilitado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::getListNet($request, 'desabilitado'));
    }
]);

//ROTA MAILING DESABILITADO
$obRouter->post('/vendedor/net/desabilitado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::setListNet($request, 'desabilitado'));
    }
]);

//ROTA MAILING PROPOSTA
$obRouter->get('/vendedor/net/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::getListNet($request, 'proposta'));
    }
]);

//ROTA MAILING PROPOSTA
$obRouter->post('/vendedor/net/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::setListNet($request, 'proposta'));
    }
]);

//ROTA MAILING PEDENTE INSTALAÇÃO
$obRouter->get('/vendedor/net/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::getListNet($request, 'pendente-instalacao'));
    }
]);

//ROTA MAILING PEDENTE INSTALAÇÃO
$obRouter->post('/vendedor/net/pendente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListNet::setListNet($request, 'pendente-instalacao'));
    }
]);


//TABULAÇÃO MAILING
$obRouter->post('/vendedor/net/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListNet::statusMailing($request, $list, $_POST['id']));
    }
]);