<?php

namespace App\Http\Controller\Login;

use App\Http\Controller\Login\Alert;
use App\Http\Request;
use App\Model\Entity\User as EntityUser;
use App\Utils\View;
use App\Session\Login\Home as SessionLogin;

class Home extends Page {

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getLogin(Request $request, string $errorMessage = null): string
    {
        //STATUS > Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('login/auth-login', [
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Mailings', 'Login', $content);
    }


    /**
     * Método responsável por definir o login usuário
     * @param Request $request
     */
    public static function setLogin(Request $request)
    {

        //POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        //VALIDA E-MAIL DO USUÁRIO
        $obUser = EntityUser::getUserByEmail($email);
        //VERIFICA SE O USUÁRIO JÁ EXISTE
        if (!$obUser instanceof EntityUser){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login?status=invalid');
        }

        //VERIFICA A SENHA DO USUÁRIO > verifica a senha passada, e a senha do banco
        if (!password_verify($password, $obUser->password)){
            $request->getRouter()->redirect('/login?status=invalid');
        }

        //VERIFICA SE O USUÁRIO ESTÁ ATIVO
        if ($obUser->status == 0){
            $request->getRouter()->redirect('/login?status=disable');
        }

        //CRIA A SESSÃO DE LOGIN
        SessionLogin::login($obUser);


//        echo "<pre>";
//        print_r($postVars);
//        echo "<pre>";
//        print_r($obUser);
//        echo "<pre>";
//        print_r($_SESSION);
//        exit;

        //REDIRECIONA O USUÁRIO PARA A HOME
        $request->getRouter()->redirect('/');

    }

    /**
     * Método responsável por deslogar o usuário
     * @param Request $request
     */
    public static function setLogout(Request $request)
    {

        //DESTROI A SESSÃO DE LOGIN
        SessionLogin::logout();

        //REDIRECIONA O USUÁRIO PARA A TELA DE LOGIN
        $request->getRouter()->redirect('/login');
    }

    /**
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus(Request $request): string
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGEM DE STATUS
        switch ($queryParams['status']) {
            case 'invalid':
                return Alert::getError('Erro :(','E-mail ou senha inválido!');
                break;
            case 'disable':
                return Alert::getWarning('Atenção :|','Usuário inativo no momento!');
                break;
        }
    }

}