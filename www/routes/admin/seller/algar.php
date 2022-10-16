<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Algar\ListAlgar;

//ROTA LISTA 1 MAILING
$obRouter->get('/vendedor/algar/lista1', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'lista1'));
    }
]);

//ROTA LISTA 1 MAILING
$obRouter->post('/vendedor/algar/lista1/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'lista1'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/algar/lista2', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::getListAlgar($request, 'lista2'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->post('/vendedor/algar/lista2/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request){
        return new Response(200, ListAlgar::setListAlgar($request, 'lista2'));
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