<?php

namespace App\Model\Entity;

use \App\Utils\Email\TinyMinify;
use \App\Utils\Email\Email as SendEmail;


class Email
{
    /**
     * ID Email
     * @var integer
     */
    public $id;

    /**
     * Valor recover
     * @var array
     */
    public $valeu;

    /**
     * Método responsável por gravar o e-mail no banco de disparo
     * @param array $valeu
     * @return bool
     */
    public function emailPasswordRecover(array $valeu): bool
    {

        $body = "
            <!DOCTYPE html>
            <html lang='pt-br'>
            
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
                <meta name='viewport' content='width=device-width,initial-scale=1'>
                <title>E-mail</title>
            </head>
            
            <body>
                <table style='width:100%;height:100%;margin:0;padding:0;border:0;border-collapse:collapse;background-color:#fafafa;'>
                    <tr>
                        <td>
                            <table align='center' style='width:100%;border-collapse:collapse;max-width:600px !important;'>
                                <tr>
                                    <td valign='top' style='padding:0 9px 0 9px;' width='600'>
                                        <h1 style='text-align:justify;display:block;margin:0;font-size:26px;font-style:normal;font-weight:bold;line-height:125%;letter-spacing:normal;color:#009e9b;font-family:georgia,times,times new roman,serif;'>
                                                Foi solicitado a redefinição de senha para o seu acesso no Gênio Sales
                                        </h1>
                                                
                                        <p style='text-align:justify;margin:8px 0;'>
                                            <span style='color:#696969;font-size:14px;line-height:150%;font-family:georgia,times,times new roman,serif'><br />

                                                <p>
                                                <b>Caso não tenha sido você o responsável em fazer o pedido de recuperação, por favor ignore este e-mail.</b><br/><br/>
                                                </p>           
                                                
                                                <p>Para continuar e fazer a redefinição de senha, 
                                                    <a href='https://geniosales.net.br/login/users/auth-forgot-password/$valeu[token]/$valeu[login]'>Clique Aqui.</a>
                                                </p>
                                                <br />
                                                
                                                <p>ou acesse diretamente no link:</p>
                                                http://localhost:8010/login/users/auth-forgot-password/$valeu[token]/$valeu[login]
                                                <br />
                                                
                                                <p>Enviado em: $valeu[date_recover]</p>
                                                <br />
                                                
                                                <p>
                                                  <p>Caso tenha dúvidas, envie um email para contato@geniosales.net.br</p>
                                                </p>
                                                <p>
                                                    Atenciosamente, <br />
                                                    Gênio Sales
                                                </p>
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
        ";

        //minificar o html
        $bodyMini = TinyMinify::html($body);

        //echo $bodyMini;
        //exit();

        $to      = $valeu['login'];
        $subject = 'Solicitação - nova senha';

        $email = new SendEmail;
        $returnEmail = $email->add($subject, $bodyMini, $to)->send();

        if (empty($returnEmail)){
            return false;
        }

        return true;

    }

}
