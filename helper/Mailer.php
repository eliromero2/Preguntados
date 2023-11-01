<?php

class Mailer
{

    private $conn;

    public function __construct($Username, $Password, $Port,$Host) {

    }

    public function enviarCorreoConfirmacion($correoDestinatario) {
        $token = $this->generarToken();
        $mail = new PHPMailer();
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'elianaromero002@gmail.com';
        $mail->Password = 'inop ujof mggb ejzl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //ssl
        $mail->Port = 465;

        //Recipients
        $mail->setFrom($Username, 'Administrador');
        $mail->addAddress($_POST['mail'], 'usuario');

        //$mail->addAttachment('/var/tmp/file.tar.gz');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Verificacion de cuenta';
        $mail->Body = 'Verifique su correo electronico para iniciar sesion <b>SU CODIGO ES!:  </b>'.$token;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



        if ($mail->Send()) {
            return true; // Éxito al enviar el correo
        } else {
            return false; // Error al enviar el correo
        }
    }

    public function __destruct() {
        mysqli_close($this->conn);
    }






}