<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Adm\Consult\Cep;

//ROTA INPUT LISTA
$obRouter->get('/consulta/cep/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
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
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Cep::getCep($request));
    }
]);