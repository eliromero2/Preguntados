<?php
/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'third-party/phpmailer/src/Exception.php';
require_once 'third-party/phpmailer/src/PHPMailer.php';
require_once 'third-party/phpmailer/src/SMTP.php';*/

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