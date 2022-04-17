<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Mailings\ListMailing;

//ROTA LISTA 1 MAILING
$obRouter->get('/vendedor/mailings/lista1', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, ListMailing::getList($request, 'lista1'));
    }
]);

//ROTA LISTA 1 MAILING
$obRouter->post('/vendedor/mailings/lista1/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, ListMailing::setList($request, 'lista1'));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/mailings/lista2', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, ListMailing::getList2($request));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/mailings/tabula/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){

        print_r($_POST);
        EXIT;
        return new Response(200, ListMailing::setList($request, 'lista1'));
    }
]);