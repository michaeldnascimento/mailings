<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\Company\Companies;

//ROTA INPUT LISTA
$obRouter->get('/adm/empresa/lista', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Companies::getCompaniesList($request));
    }
]);

//ROTA DE EDIÇÃO DE UMA EMPRESA
$obRouter->get('/adm/empresa/lista/novo', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Companies::getNewCompany($request));
    }
]);

//ROTA DE EDIÇÃO DE EMPRESA (POST)
$obRouter->post('/adm/empresa/lista/novo', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Companies::setNewCompany($request));
    }
]);

//ROTA DE EDIÇÃO DE UMA EMPRESA
$obRouter->get('/adm/empresa/lista/{id}/edit', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Companies::getEditCompany($request, $id));
    }
]);

//ROTA DE EDIÇÃO DE EMPRESA (POST)
$obRouter->post('/adm/empresa/lista/{id}/edit', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Companies::setEditCompany($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE EMPRESA (POST)
$obRouter->post('/adm/empresa/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Companies::setDeleteCompany($request, $id));
    }
]);
