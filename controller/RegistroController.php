<?php

class RegistroController{

    private $userService;
    private $render;
    private $mailer;
    private $need = ['nombre_completo','mail','password'];

    public function __construct($render,$mailer, $userService) {
        $this->render = $render;
        $this->mailer = $mailer;
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
        $passwordConfirmacion=$_POST['password_confirm'];
        $ano_nacimiento =$_POST['ano_nacimiento'];
        $sexo=$_POST['sexo'];
        $pais=$_POST['pais'];
        $ciudad=$_POST['ciudad'];
        $user_name=$_POST['user_name'];
        $image_path=null;
        $extension_image = ".jpg";

        $folderSave = __DIR__."/../public/avatar/".$user_name.$extension_image ;

        if($password != $passwordConfirmacion){
            $_SESSION['error'] ='Las contraseñas no coinciden';
            $data['error']=$_SESSION['error'];
            $data['action'] = '/registro/procesarRegistro';
            $data['submitText'] = 'Registrar';

            $data['formulario']=[
            'nombre_completo' => $_POST['nombre_completo'],
            'mail' => $_POST['mail'],
            'password' => $_POST['password'],
            'password_confirm'=>$_POST['password_confirm'],
            'ano_nacimiento' =>$_POST['ano_nacimiento'],
            'sexo'=>$_POST['sexo'],
            'pais'=>$_POST['pais'],
            'ciudad'=>$_POST['ciudad'],
            'user_name'=>$_POST['user_name']];

            unset( $_SESSION['error']);
            $this->render->printView('registro',$data);
        }

        if($error = move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $folderSave))
        {
             $image_path= $user_name;
        }else{
        }
    try{
    $this->userService->registrar($nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$email,$password,$user_name,$image_path);
    }catch (\Exception $e){
        $_SESSION['error'] = $e->getMessage();
        $data['error']=$_SESSION['error'];
        $data['action'] = '/registro/procesarRegistro';
        $data['submitText'] = 'Registrar';
        unset( $_SESSION['error']);

        $this->render->printView('registro',$data);
    }


        $this->mailer->enviarCorreoConfirmacion($email);

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