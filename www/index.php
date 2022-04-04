<?php

require __DIR__ . '/config/app.php';

use \App\Http\Router;

//INICIA O ROUTER
$obRouter = new Router(URL);

//INCLUI AS ROTAS DE PAGINAS
include __DIR__ . '/routes/admin.php';

//INCLUI AS ROTAS DE LOGIN
include __DIR__ . '/routes/login.php';

//IMPRIME O RESPONSE DA ROTA
$obRouter->run()
         ->sendResponse();