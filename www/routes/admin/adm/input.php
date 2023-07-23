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
$obRouter->get('/adm/input/fila-bot', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Input\Bot::getListInput($request, 'mailing'));
    }
]);