<?php

class Mailer
{
    private $mail;

    public function __construct($username, $password, $port,$host) {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer();
        $this->mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host = $host;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS; //ssl
        $this->mail->Port = $port;

        //Recipients
        $this->mail->setFrom($username, 'Administrador');
    }

    public function enviarCorreoConfirmacion($correoDestinatario,$nombreUsuario,$passwordUsuario) {

        $this->mail->addAddress($correoDestinatario, 'usuario');
        //$mail->addAttachment('/var/tmp/file.tar.gz');
        //Content
        $subject = 'Verificacion de cuenta';
        $body = 'Su Correo ha sido verificado con Exito, Bienvenido '.$nombreUsuario.' !</br> <b>Datos de la Cuenta: </b></br><b>Usuario: '.$nombreUsuario.'</br>Contraseña: '.$passwordUsuario.'</b>';

        $this->prepareMail($subject, $body);
    }


    public function prepareMail($subject, $body){
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->sendMail();
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMail(){
        try {
            $mailSend = $this->mail->Send();
            $_SESSION['success'] = 'SE MANDO CARAJO';
            Logger::info($mailSend);
            Redirect::to('/home/list');
        }catch(Exception $exception){
            Logger::error($exception);
            $_SESSION['error'] = 'Error al enviar el correo de confirmación.';
            Redirect::to('/registro/registro');
        }
    }

}