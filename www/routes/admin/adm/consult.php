<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Adm\Consult\Cep;
use App\Http\Controller\Admin\Adm\Consult\Client;

//ROTA PAGE CEP
$obRouter->get('/consulta/cep/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-cep',
    ],
    function($request){
        return new Response(200, Cep::getCepPage($request));
    }
]);

//ROTA CONSULT CEP OPERADORA
$obRouter->post('/consulta/cep/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-cep',
    ],
    function($request){
        return new Response(200, Cep::getCep($request));
    }
]);

$obRouter->get('/consulta/cep/{cep}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-cep',
    ],
    function($request, $cep){
        return new Response(200, Cep::getCepMailing($request, $cep));
    }
]);

//ROTA INPUT LISTA CLIENT
$obRouter->get('/consulta/cliente/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-client',
    ],
    function($request){
        return new Response(200, Client::getClientPage($request));
    }
]);

//ROTA CONSULT CEP OPERADORA
$obRouter->post('/consulta/cliente/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-client',
    ],
    function($request){
        return new Response(200, Client::getClient($request));
    }
]);

//ROTA CONSULTA SOLAR
$obRouter->get('/consulta/solar/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-solar',
    ],
    function($request){
        return new Response(200, Client::getClientPageSolar($request));
    }
]);

//ROTA CONSULT SOLAR
$obRouter->post('/consulta/solar/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-solar',
    ],
    function($request){
        return new Response(200, Client::getClientSolar($request));
    }
]);