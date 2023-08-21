<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);

//DEFINE TIMEZONE SISTEMA
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

//COMPOSER - AUTOLOAD
require __DIR__ . '/../vendor/autoload.php';

use \App\Utils\View;
use \App\Common\Environment;
use \App\Db\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

//CARREGA AS VARIAVEIS DE AMBIENTE DO PROJETO
Environment::load(__DIR__. '/../');

//DEFINE AS CONFIGURAÇÕES DE BANCO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
);

//DEFINE A CONSTANTE DE URL
define('URL', getenv('URL'));

//DEFINE OS DADOS DE ENVIO E-MAIL
define("MAIL", [
    "host" => "smtp.titan.email",
    "port" => "587",
    "username" => "naoresponder@geniosales.net.br",
    "password" => "n56f}Y1h3%O{Wr%",
    "from_name" => "Genio Sales",
    "from_email" => "naoresponder@geniosales.net.br"
]);

//DEFINE O VALOR PADRÃO DAS VARIAVEIS
View::init([
    'URL' => URL
]);

//DEFINE O MAPEAMENTO DE MIDDLEWARE
MiddlewareQueue::setMap([
    'maintenance'            => \App\Http\Middleware\Maintenance::class,
    'required-admin-logout'  => \App\Http\Middleware\RequireAdminLogout::class,
    'required-admin-login'   => \App\Http\Middleware\RequireAdminLogin::class,
    'required-nivel-seller'  => \App\Http\Middleware\RequireNivelSeller::class,
    'required-nivel-company' => \App\Http\Middleware\RequireNivelCompany::class,
    'required-nivel-admin'   => \App\Http\Middleware\RequireNivelAdmin::class,
    'required-nivel-cep'     => \App\Http\Middleware\RequireNivelCep::class,
    'required-nivel-client'  => \App\Http\Middleware\RequireNivelClient::class,
    'required-nivel-solar'   => \App\Http\Middleware\RequireNivelSolar::class,
    'required-nivel-call'    => \App\Http\Middleware\RequireNivelCall::class,
    'api'                    => \App\Http\Middleware\Api::class,
    'required-nivel-seller-list'  => \App\Http\Middleware\RequireNivelSellerList::class,
    //'user-basic-auth'        => \App\Http\Middleware\UserBasicAuth::class,
    //'jwt-auth'               => \App\Http\Middleware\JWTAuth::class,
    //'cache'              => \App\Http\Middleware\Cache::class
]);


//DEFINE O MAPEAMENTO DE MIDDLEWARE PADRÕES (EXECUTADOS EM TODAS AS ROTAS)
MiddlewareQueue::setDefault([
    'maintenance'
]);