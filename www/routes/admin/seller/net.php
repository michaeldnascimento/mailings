<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Seller\Net\ListNet;

//ROTA CANCELADOMAILING
$obRouter->get('/vendedor/net/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::getListCancelado($request, 'cancelado'));
    }
]);

//ROTA CANCELADO MAILING
$obRouter->post('/vendedor/net/cancelado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::setListCancelado($request, 'cancelado'));
    }
]);

//ROTA MAILING DESABILITADO
$obRouter->get('/vendedor/net/desabilitado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::getListDesabilitado($request, 'desabilitado'));
    }
]);

//ROTA MAILING DESABILITADO
$obRouter->post('/vendedor/net/desabilitado/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::setListDesabilitado($request, 'desabilitado'));
    }
]);

//ROTA MAILING PROPOSTA
$obRouter->get('/vendedor/net/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::getListProposta($request, 'proposta'));
    }
]);

//ROTA MAILING PROPOSTA
$obRouter->post('/vendedor/net/proposta/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::setListProposta($request, 'proposta'));
    }
]);

//ROTA MAILING PEDENTE INSTALAÇÃO
$obRouter->get('/vendedor/net/pedente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::getListPedenteInstalacao($request, 'lista2'));
    }
]);

//ROTA MAILING PEDENTE INSTALAÇÃO
$obRouter->post('/vendedor/net/pedente-instalacao/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListNet::setListPedenteInstalacao($request, 'lista2'));
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