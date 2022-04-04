<?php

namespace App\Http\Controller\Admin;

use App\Utils\View;

class Alert {

    /**
     * Método responsável por retornar uma mensagem de sucesso
     *
     * @param string $message
     * @param string $status_mensagem
     * @return string
     */
    public static function getSuccess(string $status_mensagem, string $message): string
    {
        return View::render('login/alert/status', [
            'tipo' => 'success',
            'status_mensagem' => $status_mensagem,
            'mensagem' => $message
        ]);
    }

    /**
     * Método responsável por retornar uma mensagem de erro
     *
     * @param string $message
     * @param string $status_mensagem
     * @return string
     */
    public static function getError(string $status_mensagem, string $message): string
    {
        return View::render('login/alert/status', [
            'tipo' => 'danger',
            'status_mensagem' => $status_mensagem,
            'mensagem' => $message
        ]);
    }

    /**
     * Método responsável por retornar uma mensagem de atenção
     *
     * @param string $message
     * @param string $status_mensagem
     * @return string
     */
    public static function getWarning(string $status_mensagem, string $message): string
    {
        return View::render('login/alert/status', [
            'tipo' => 'warning',
            'status_mensagem' => $status_mensagem,
            'mensagem' => $message
        ]);
    }

    /**
     * Método responsável por retornar uma mensagem de info
     *
     * @param string $message
     * @param string $status_mensagem
     * @return string
     */
    public static function getInfo(string $status_mensagem, string $message): string
    {
        return View::render('login/alert/status', [
            'tipo' => 'info',
            'status_mensagem' => $status_mensagem,
            'mensagem' => $message
        ]);
    }
}