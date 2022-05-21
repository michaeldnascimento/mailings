<?php

namespace App\Http\Controller\Login;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\User as EntityUser;
//use \App\Model\Entity\Recover as EntityRecover;
//use \App\Model\Entity\Email as EntityEmail;

class User extends Page {

    /**
     * Método responsável por retornar a renderização da página de cadastro de login
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getAuthRegister(Request $request, string $errorMessage = null): string
    {
        //Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('login/auth-register', [
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Malings', 'Novo Usuário', $content);
    }

    /**
     * Método responsável por retornar a renderização da página de esqueceu a senha
     * @param Request $request
     * @param string|null $errorMessage
     * @return string
     */
    public static function getAuthForgotPassword(Request $request, string $errorMessage = null): string
    {
        //Se o errorMessage não for nulo, ele vai exibir a msg, se não ele não vai exibir nada
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('login/auth-forgot-password', [
            'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Malings', 'Esqueceu a senha', $content);
    }

    /**
     * Método responsável por cadastrar um usuário no banco
     * @param Request $request
     */
    public static function setNewUser(Request $request)
    {

        //POST VARS
        $postVars = $request->getPostVars();
        $name  = $postVars['name'] ?? '';
        $email  = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';
        $confirmPassword = $postVars['confirmPassword'] ?? '';

        //VERIFICA A VALIDAÇÃO DE SENHA
        if ($password != $confirmPassword){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login/users/auth-register?status=errorConfirmationPassword');
        }

        //VALIDA E-MAIL DO USUÁRIO
        $obUser = EntityUser::getUserByEmail($email);
        //VERIFICA SE O USUÁRIO JÁ EXISTE
        if ($obUser instanceof EntityUser){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login/users/auth-register?status=duplicated');
        }


        //NOVA INSTANCIA DE USUÁRIO
        $obUser = new EntityUser();
        $obUser->name = $name;
        $obUser->email = $email;
        $obUser->password =  password_hash($password, PASSWORD_DEFAULT);
        $obUser->status = 0; //status aguardando aprovação
        $obUser->nivel = 0; //nivel de acesso ao sistema
        $obUser->cadastrar();

        //VERIFICA SE O USUÁRIO FOI SALVO
        if ($obUser->id != '') {
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login/users/auth-register?status=created');
        }

        //REDIRECIONA O USUÁRIO ERRO
        $request->getRouter()->redirect('/login/users/auth-register?status=errorCreated');

    }

    /**
     * Método responsável por recuperar a senha do usuário
     * @param Request $request
     * @return string
     */
    public static function recoverPassword($request)
    {

        //POST VARS
        $postVars = $request->getPostVars();
        $email = isset($postVars['resetEmail']) ? $postVars['resetEmail'] : '';

        //VALIDA E-MAIL DO USUÁRIO
        $obRecover = EntityUser::getUserByEmail($email);

        //VERIFICA SE O LOGIN EXISTE
        if ($obRecover == ''){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login?status=notFound');
        }

        //NOVA INSTANCIA DE USUÁRIO
        $obRecover = new EntityRecover();
        $obRecover->login = $email;
        $obRecover->token = sha1(date('Y-m-d H:i:s'));
        $obRecover->cadastrar();

        //VERIFICA O ID RECUPERAÇÃO
        if ($obRecover->id == ''){
            $request->getRouter()->redirect('/login?status=erroRecover');
        }

        //ENVIAR E-MAIL COM O RESET SENHA
        $entityEmail = new EntityEmail();
        $sendEmail = $entityEmail->emailPasswordRecover($obRecover);

        //VERIFICA SE O E-MAIL FOI ENVIADO
        if ($sendEmail == ''){
            $request->getRouter()->redirect('/login?status=errorEmail');
        }

        //RETORNA PARA LOGIN
        $request->getRouter()->redirect('/login?status=send');

    }

    /**
     * Método responsável por validar o token recebido da recuperação de senha
     * @param Request $request
     * @param string $token
     * @param string $email
     * @return string
     */
    public static function recoverTokenValidation($request, $token, $email)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obToken = EntityRecover::tokenValidation($token);

        //VERIFICA SE O TOKEN NÃO SOFREU ALTERAÇÕES
        if ($token != $obToken['token']){
            $request->getRouter()->redirect('/login?status=changedToken');
        }

        //VALIDA E-MAIL DO USUÁRIO
        $obRecover = EntityUser::getUserByEmail($email);

        //VERIFICA SE O LOGIN EXISTE
        if ($obRecover == ''){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login?status=notFound');
        }

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('login/recover', [
            'token'    => $token,
            'email'    => $email,
            //'status'   => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Mailings', 'Nova Senha Usuário', $content);
    }

    /**
     * Método responsável por cadastrar uma nova senha no banco
     * @param Request $request
     * @return string
     */
    public static function setNewPassword($request)
    {

        //POST VARS
        $postVars = $request->getPostVars();
        $token = isset($postVars['token']) ? $postVars['token'] : '';
        $login = isset($postVars['login']) ? $postVars['login'] : '';
        $senha = isset($postVars['senha']) ? $postVars['senha'] : '';
        $confirmaSenha = isset($postVars['confirmaSenha']) ? $postVars['confirmaSenha'] : '';

        //VERIFICA A VALIDAÇÃO DE SENHA
        if ($senha != $confirmaSenha) {
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/login?status=confirmation');
        }

        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obToken = EntityRecover::tokenValidation($token);

        //VERIFICA SE O TOKEN NÃO SOFREU ALTERAÇÕES
        if ($token != $obToken['token']) {
            $request->getRouter()->redirect('/login?status=changedToken');
        }

        //NOVA INSTANCIA DE RECOVER -
        $obRecover = new EntityRecover();
        $obRecover->id = $obToken['id'];
        $obRecover->login = $obToken['login'];
        $obRecover->token = $obToken['token'];
        $obRecover->status = 0;
        $obRecover->atualizar();

        //VERIFICA SE OS VALORES FORAM PASSADOS
        if ($obRecover->date_update == '') {
            $request->getRouter()->redirect('/login?status=erroRecover');
        }

        //VALIDA E-MAIL DO USUÁRIO
        $user = EntityUser::getUserByEmail($login);

        //ATUALIZA A INSTANCIA
        $obUser = new EntityUser();
        $obUser->id = $user['id'];
        $obUser->nome = $user['nome'];
        $obUser->email = $user['email'];
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/login?status=updateSuccess');

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
            case 'created':
                return Alert::getSuccess('Sucesso :)','Usuário criado com sucesso! Por favor aguarde liberação de acesso');
                break;
            case 'errorCreated':
                return Alert::getError('Erro :(','Não foi possivel criar seu usuário, tente novamente mais tarde!');
                break;
            case 'updated':
                return Alert::getSuccess('Sucesso','Usuário atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('','Usuário excluído com sucesso!');
                break;
            case 'invalid':
                return Alert::getError('','E-mail ou senha inválido!');
                break;
            case 'duplicated':
                return Alert::getError('Error!','E-mail já está cadastrado, caso não lembre do acesso clique em esqueceu a senha.');
                break;
            case 'send':
                return Alert::getSuccess('','E-mail de recuperação foi enviado com Sucesso!');
                break;
            case 'updateSuccess':
                return Alert::getSuccess('','Senha atualizada com sucesso!');
                break;
            case 'confirmation':
                return Alert::getError('','Senha e confirmação de senha são diferentes, tente novamente!');
                break;
            case 'errorConfirmationPassword':
                return Alert::getWarning('Atenção :|','Confirmade senha diferente do campo senha!');
                break;
            case 'notFound':
                return Alert::getError('Error :(','O E-mail não foi localizado!');
                break;
            case 'changedToken':
                return Alert::getError('','Este link será desativado! O link enviado parece ter sofrido alguma alteração, por isso não é possível fazer a verificação. Por favor solicite novamente a recuperação da senha.');
                break;
            case 'errorEmail':
                return Alert::getError('','Erro ao enviar o e-mail');
                break;
        }
    }

}