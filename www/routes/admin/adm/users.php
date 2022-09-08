<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\User\Users;

//ROTA INPUT LISTA
$obRouter->get('/adm/usuarios/lista', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Users::getUsersList($request));
    }
]);

//ROTA DE EDIÇÃO DE UM USUÁRIO
$obRouter->get('/adm/usuarios/lista/{id}/edit', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Users::getEditUser($request, $id));
    }
]);

//ROTA DE EDIÇÃO DE USUÁRIO (POST)
$obRouter->post('/adm/usuarios/lista/{id}/edit', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Users::setEditUser($request, $id));
    }
]);


//ROTA DE EXCLUSÃO DE UM NOVO DEPOIMENTO
$obRouter->get('/adm/usuarios/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Users::getDeleteUser($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE UM NOVO DEPOIMENTO (POST)
$obRouter->post('/adm/usuarios/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Users::setDeleteUser($request, $id));
    }
]);
