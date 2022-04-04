<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Adm\Input;

//ROTA INPUT LISTA
$obRouter->get('/adm/input/listas', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, Input\Lists::getLists($request));
    }
]);


//ROTA INPUT LISTA POST
$obRouter->post('/adm/input/listas', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, Input\Lists::setNewMailingList($request));
    }
]);
