<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Mailings;

//ROTA HOME
$obRouter->get('/vendedor/mailings/lista1', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
    ],
    function($request){
        return new Response(200, Mailings\List1::getList1($request));
    }
]);
