<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Result\ListResult;

//ROTA LISTA 1 MAILING
$obRouter->get('/vendedor/resultados/vendas', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, ListResult::getSales($request));
    }
]);

//ROTA LISTA 1 MAILING
$obRouter->get('/vendedor/resultados/follow', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, ListResult::getFollow($request));
    }
]);

//ROTA LISTA 2 MAILING
$obRouter->get('/vendedor/resultados/geral', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, ListResult::getSellerResultAll($request));
    }
]);
