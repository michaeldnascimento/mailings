<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\Input;

//ROTA INPUT LISTA
$obRouter->get('/adm/input/mailings', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Lists::getLists($request));
    }
]);


//ROTA INPUT LISTA POST
$obRouter->post('/adm/input/mailings', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Lists::setNewMailingList($request));
    }
]);

//ROTA PAGE EXCEL EMPRESA
$obRouter->get('/adm/input/empresas', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Files::getFilesCompanies($request));
    }
]);


//ROTA INPUT EXCEL EMPRESA
$obRouter->post('/adm/input/empresas', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Files::setNewFilesCompanies($request));
    }
]);


//ROTA INPUT LISTA BOT
$obRouter->get('/adm/input/solarbot1', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Bot::getListInput($request, 'solarbot1'));
    }
]);

//ROTA INPUT LISTA BOT
$obRouter->get('/adm/input/solarbot2', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Bot::getListInput($request, 'solarbot2'));
    }
]);

//ROTA INPUT LISTA BOT
$obRouter->get('/adm/input/solarbot3', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Bot::getListInput($request, 'solarbot3'));
    }
]);

//ROTA LISTA HISTORICO BOT
$obRouter->get('/adm/input/{lista}/resultados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $lista){
        return new Response(200, Input\Bot::getListInputResults($request, $lista));
    }
]);

//ROTA DE EDIÇÃO DE UMA EMPRESA
$obRouter->get('/adm/input/{lista}/{id}/edit', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $lista, $id){
        return new Response(200, Input\Bot::editStatusInput($request, $lista, $id));
    }
]);