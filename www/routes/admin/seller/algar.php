<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Desktop\ListDesktop;

//ROTA LISTA 1 MAILING
$obRouter->get('/vendedor/desktop/lista1', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListDesktop::getList($request, 'lista1'));
    }
]);

//ROTA LISTA 1 MAILING
$obRouter->post('/vendedor/desktop/lista1/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListDesktop::setList($request, 'lista1'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/desktop/lista2', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListDesktop::getList($request, 'lista2'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->post('/vendedor/desktop/lista2/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListDesktop::setList($request, 'lista2'));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/desktop/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListDesktop::statusMailing($request, $list, $_POST['id']));
    }
]);