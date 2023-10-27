<?php
require 'third-party/phpmailer/src/Exception.php';
require 'third-party/phpmailer/src/PHPMailer.php';
require 'third-party/phpmailer/src/SMTP.php';

class RegistroController{

    private $userModel;
    private $render;
    private $need = ['nombre_completo','mail','password'];

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
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
        $this->userModel->registrar($nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$email,$password,$user_name,$image_path);


        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'elianaromero002@gmail.com';
            $mail->Password   = 'inop ujof mggb ejzl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //ssl
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('elianaromero002@gmail.com', 'Administrador');
            $mail->addAddress($_POST['mail'], 'usuario');

            //$mail->addAttachment('/var/tmp/file.tar.gz');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Verificacion de cuenta';
            $mail->Body    = 'Verifique su correo electronico para iniciar sesion <b>ahora!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Se envio el mail';
        } catch (Exception $e) {
            echo "No se puedo enviar el email. Mailer Error: {$mail->ErrorInfo}";
        }

        Redirect::to('/home/list');
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