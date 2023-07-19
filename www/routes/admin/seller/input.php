<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Seller\Input\ListInput;

//ROTA INPUT MAILING
$obRouter->get('/vendedor/input/mailing', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::getListInput($request, 'mailing'));
    }
]);

//ROTA INPUT MAILING
$obRouter->post('/vendedor/input/mailing/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::setListInput($request, 'mailing'));
    }
]);