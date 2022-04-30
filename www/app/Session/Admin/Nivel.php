<?php

namespace App\Session\Admin;

class Nivel {

    /**
     * Método responsável por retornar a session do nivel do usuario usuário
     * @return string
     */
    public static function getNivelSession(): string
    {

        //RETORNA A SESSION
        return $_SESSION['mailings']['admin']['user']['nivel'];

    }
}