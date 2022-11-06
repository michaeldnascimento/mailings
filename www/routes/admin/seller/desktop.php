<?php

use \App\Http\Response;
use \App\Http\Controller\Admin\Seller\Desktop\ListDesktop2;

//ROTA LISTA GET BASE
$obRouter->get('/vendedor/desktop/get/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA GET BASE
$obRouter->post('/vendedor/desktop/get/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA GET CANCELADOS
$obRouter->get('/vendedor/desktop/get/cancelados', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA GET CANCELADOS
$obRouter->post('/vendedor/desktop/get/cancelados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA GET PEDIDOS
$obRouter->get('/vendedor/desktop/get/pedidos', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA GET PEDIDOS
$obRouter->post('/vendedor/desktop/get/pedidos/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA SIS BASE
$obRouter->get('/vendedor/desktop/sis/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA SIS BASE
$obRouter->post('/vendedor/desktop/sis/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA SIS CANCELADOS
$obRouter->get('/vendedor/desktop/sis/cancelados', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA GET CANCELADOS
$obRouter->post('/vendedor/desktop/sis/cancelados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA SIS PEDIDOS
$obRouter->get('/vendedor/desktop/sis/pedidos', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA SIS PEDIDOS
$obRouter->post('/vendedor/desktop/sis/pedidos/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA NETBARRETOS BASE
$obRouter->get('/vendedor/desktop/netbarretos/base', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA NETBARRETOS BASE
$obRouter->post('/vendedor/desktop/netbarretos/base/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA NETBARRETOS CANCELADOS
$obRouter->get('/vendedor/desktop/netbarretos/cancelados', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA NETBARRETOS CANCELADOS
$obRouter->post('/vendedor/desktop/netbarretos/cancelados/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA NETBARRETOS PEDIDOS
$obRouter->get('/vendedor/desktop/netbarretos/pedidos', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::getList($request, $uri[2], $uri[3]));
    }
]);

//ROTA LISTA NETBARRETOS PEDIDOS
$obRouter->post('/vendedor/desktop/netbarretos/pedidos/', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
        //'required-nivel-seller-list'
    ],
    function($request){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::setList($request, $uri[2], $uri[3]));
    }
]);

//TABULAÇÃO MAILING
$obRouter->post('/vendedor/desktop/tabula/?{list}', [
    'middlewares' => [
        //'cache'
        'required-admin-login',
        'required-nivel-seller',
    ],
    function($request, $list){
        $uri = $request->getArrayUri(); //SEPARA URI EM ARRAY
        return new Response(200, ListDesktop2::statusMailing($request, $list, $_POST['id']));
    }
]);