<?php

namespace App\Session\Login;

use \App\Model\Entity\User;

class Home {

    /**
     * Método responsável por iniciar a sessão
     */
    private static function init()
    {
        //VERIFICA SE A SESSÃO NÃO ESTÁ ATIVA
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Método responsável por criar o login do usuário
     * @param User $obUser
     * @return boolean
     */
    public static function login(User $obUser): bool
    {

        //INICIA A SESSÃO
        self::init();

        //DEFINE A SESSÃO DO USUÁRIO
        $_SESSION['mailings']['admin']['user'] = [
            'id'    => $obUser->id,
            'name'  => $obUser->name,
            'email' => $obUser->email,
            'company' => $obUser->company,
            'nivel' => $obUser->nivel,
            'companies' => $obUser->companies,
            'cep'   => $obUser->cep,
            'client' => $obUser->client,
            'algar' => $obUser->algar,
            'claro' => $obUser->claro,
            'net' => $obUser->net,
            'desktop_get' => $obUser->desktop_get,
            'desktop_sis' => $obUser->desktop_sis,
            'desktop_netbarretos' => $obUser->desktop_netbarretos
        ];

        //SUCESSO
        return true;

    }


    /**
     * Método responsável por verificar se o usuário está logado
     * @return boolean
     */
    public static function isLogged(): bool
    {
        //INICIA A SESSÃO
        self::init();

        //RETORNA A VERIFICAÇÃO
        return isset($_SESSION['mailings']['admin']['user']['id']);

    }

    /**
     * Método responsável por executar o logout do usuário
     * @return boolean
     */
    public static function logout(): bool
    {
        //INICIA A SESSÃO
        self::init();

        //DESLOGA O URUÁRIO
        unset($_SESSION['mailings']['admin']['user']);

        //SUCESSO
        return true;
    }

    /**
     * Método responsável por retornar a session do usuário
     * @return string
     */
    public static function getSession(): string
    {

        //RETORNA A SESSION
        return $_SESSION['mailings']['admin']['user'];

    }
}