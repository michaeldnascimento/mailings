<?php

namespace App\Utils\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use stdClass;


class Email
{

    /** @var PHPMailer  */
    private PHPMailer $mail;

    /** @var stdClass  */
    private stdClass $date;

    /** @var Exception */
    private $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->date = new stdClass();

        //Server settings
        $this->mail->CharSet = 'utf-8';
        //$this->mail->SMTPDebug = "1";
        $this->mail->isSMTP();
        $this->mail->Host = MAIL["host"];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = MAIL["username"];
        $this->mail->Password = MAIL["password"];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = MAIL["port"];
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient_email
     * @return $this
     */
    public function add(string $subject, string $body, string $recipient_email) : Email
    {

        $this->date->subject = $subject;
        $this->date->body = $body;
        $this->date->recipient_email = $recipient_email;
        return $this;
    }

    /**
     * Método responsavel por receber anexo
     * @param string $filePath
     * @param string $fileName
     * @return Email
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->date->attach[$filePath] = $fileName;
    }

    /**
     * Método responsavel por disparar o e-mail
     * @param string $from_name
     * @param string $from_email
     * @return bool
     */
    public function send(string $from_name = MAIL["from_name"], string $from_email = MAIL["from_email"]): bool
    {

        try{

            $this->mail->setFrom($from_email, $from_name);
            $this->mail->addAddress($this->date->recipient_email, 'Contato');

            if (!empty($this->date->attach)){
                foreach ($this->date->attach as $path => $name){
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->isHTML(true);
            $this->mail->Subject = $this->date->subject;
            $this->mail->Body = $this->date->body;

            $this->mail->send();
            return true;

        }catch (Exception $exception){
            $this->error = $exception;
            return false;
        }
    }

    /**
     * Retorno error
     * @return Exception|null
     */
    public function error(): ?Exception
    {
        return $this->error();
    }


}