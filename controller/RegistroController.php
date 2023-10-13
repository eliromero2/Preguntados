<?php

class RegistroController{

    private $userModel;

    private $render;

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
    }

    public function list() {
        $this->render->printView('registro');
    }


    public function procesarRegistro(){

        if( empty($_POST['nombre_completo'] ) || empty($_POST['mail'] ) || empty($_POST['password'] ) ){
            $_SESSION["error"] = "Alguno de los campos era erroneo o vacio";
            Redirect::to('/registro');
        }

        $nombre_completo = $_POST['nombre_completo'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $ano_nacimiento =$_POST['ano_nacimiento'];
        $sexo=$_POST['sexo'];
        $pais=$_POST['pais'];
        $ciudad=$_POST['ciudad'];
        $user_name=$_POST['user_name'];
        $image_path= $_POST['image_path'];

        $this->userModel->registrar($nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$mail,$password,$user_name,$image_path);
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