<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\User\Users;
use \App\Http\Controller\Admin\Adm\User\Called;

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

//ROTA INPUT LISTA
$obRouter->get('/adm/usuarios/chamados/lista', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request){
        return new Response(200, Called::getCalledList($request));
    }
]);

//ROTA DE EDIÇÃO DE UM USUÁRIO
$obRouter->get('/adm/usuarios/chamados/lista/{id}/view', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Called::getViewCall($request, $id));
    }
]);

//ROTA DE EDIÇÃO DE USUÁRIO (POST)
$obRouter->post('/adm/usuarios/chamados/lista/{id}/view', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Called::setResponseCall($request, $id));
    }
]);


//ROTA DE EXCLUSÃO DE UM NOVO DEPOIMENTO
$obRouter->get('/adm/usuarios/chamados/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Called::getDeleteUser($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE UM NOVO DEPOIMENTO (POST)
$obRouter->post('/adm/usuarios/chamados/lista/{id}/delete', [
    'middlewares' => [
        'required-admin-login',
        'required-nivel-admin',
    ],
    function($request, $id){
        return new Response(200, Called::setDeleteUser($request, $id));
    }
]);