<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Home;

//ROTA HOME
$obRouter->get('/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, Home\Dashboard::getHome($request));
    }
]);
