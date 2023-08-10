<?php

use \App\Http\Response;
use App\Http\Controller\Admin\Seller\Input\ListInput;

//ROTA INPUT MAILING
$obRouter->get('/vendedor/input/solarbot1', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::getListInput($request, 'solarbot1'));
    }
]);

//ROTA INPUT MAILING
$obRouter->post('/vendedor/input/solarbot1/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::setListInput($request, 'solarbot1'));
    }
]);

//ROTA INPUT MAILING
$obRouter->get('/vendedor/input/solarbot2', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::getListInput($request, 'solarbot2'));
    }
]);

//ROTA INPUT MAILING
$obRouter->post('/vendedor/input/solarbot2/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::setListInput($request, 'solarbot2'));
    }
]);

//ROTA INPUT MAILING
$obRouter->get('/vendedor/input/solarbot3', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::getListInput($request, 'solarbot3'));
    }
]);

//ROTA INPUT MAILING
$obRouter->post('/vendedor/input/solarbot3/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        'required-nivel-seller-list'
    ],
    function($request){
        return new Response(200, ListInput::setListInput($request, 'solarbot3'));
    }
]);

//ROTA LISTA HISTORICO INPUT
$obRouter->get('/vendedor/input/{lista}/resultados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $lista){
        return new Response(200, ListInput::getListInputResults($request, $lista));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/input/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        return new Response(200, ListInput::statusMailing($request, $list, $_POST['id']));
    }
]);