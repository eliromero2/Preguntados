<?php

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
        $mail = $_POST['mail'];
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
          //  echo json_encode($error);
          //  die();
        }

        $this->userService->registrar($nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$mail,$password,$user_name,$image_path);
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