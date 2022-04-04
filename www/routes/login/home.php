<?php

use \App\Http\Response;
use \App\Http\Controller\Login;

//ROTA LOGIN
$obRouter->get('/login', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\Home::getLogin($request));
    }
]);

//ROTA LOGIN (POST)
$obRouter->post('/login', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\Home::setLogin($request));
    }
]);

//ROTA LOGOUT
$obRouter->get('/login/logout', [
    'middlewares' => [
        'required-admin-login',
    ],
    function($request){
        return new Response(200, Login\Home::setLogout($request));
    }
]);