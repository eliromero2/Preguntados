<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'third-party/phpmailer/src/Exception.php';
require 'third-party/phpmailer/src/PHPMailer.php';
require 'third-party/phpmailer/src/SMTP.php';

class RegistroController{

    private $userService;
    private $render;
    private $need = ['nombre_completo','mail','password'];

    public function __construct($render, $userService) {
        $this->render = $render;
        $this->userService = $userService;
    }

    public function list() {
        $this->render->printView('registro');
    }


    public function procesarRegistro(){

        Request::validate($_POST, $this->need);

        $nombre_completo = $_POST['nombre_completo'];
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $ano_nacimiento =$_POST['ano_nacimiento'];
        $sexo=$_POST['sexo'];
        $pais=$_POST['pais'];
        $ciudad=$_POST['ciudad'];
        $user_name=$_POST['user_name'];
        $image_path=null;
        $extension_image = ".jpg";

        $folderSave = __DIR__."/../public/avatar/".$user_name.$extension_image ;

        if($error = move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $folderSave))
        {
             $image_path= $user_name;
        }else{
        }

        $this->userService->registrar($nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$mail,$password,$user_name,$image_path);

       
        $correoEnviado = $this->enviarCorreoConfirmacion($email);

        if ($correoEnviado) {
            // El correo de confirmación se envió con éxito
            Redirect::to('/home/list');

        } else {
            // Error al enviar el correo de confirmación, puedes manejar esto según tus necesidades
            $_SESSION['error'] = 'Error al enviar el correo de confirmación.';
            Redirect::to('/registro/registro');
        }




    
    }


    function generarToken($longitud = 5) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < $longitud; $i++) {
            $token .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $token;
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
        $mail->setFrom('elianaromero002@gmail.com', 'Administrador');
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

    public function registro(){
        $data = [];

        if(!empty($_SESSION['error'])){
            $data["error"] = $_SESSION['error'];
            unset( $_SESSION['error']);
        }

        $data['action'] = '/registro/procesarRegistro';
        $data['submitText'] = 'Registrar';
        $this->render->printView('registro', $data);
    }

}