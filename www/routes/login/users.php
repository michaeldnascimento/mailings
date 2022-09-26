<?php

use \App\Http\Response;
use \App\Http\Controller\Login;

//ROTA CADASTRO LOGIN
$obRouter->get('/login/users/auth-register', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\User::getAuthRegister($request));
    }
]);

//ROTA CADASTRO LOGIN (POST)
$obRouter->post('/login/users/auth-register', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\User::setNewUser($request));
    }
]);

//ROTA ESQUECEU A SENHA
$obRouter->get('/login/users/auth-forgot-password', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\User::getAuthForgotPassword($request));
    }
]);

//ROTA DE RECUPERAÇÃO DE SENHA
$obRouter->post('/login/users/auth-forgot-password', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\User::recoverPassword($request));
    }
]);

//ROTA DE RECUPERAÇÃO DE SENHA
$obRouter->get('/login/users/auth-forgot-password/{token}/{email}', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request, $token, $email){
        return new Response(200, Login\User::recoverTokenValidation($request, $token, $email));
    }
]);

//ROTA DE CADASTRO DE UMA NOVA SENHA (POST)
$obRouter->post('/login/users/auth-forgot-password/{token}/{email}', [
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Login\User::setNewPassword($request));
    }
]);