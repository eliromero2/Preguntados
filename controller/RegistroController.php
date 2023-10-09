<?php

class RegistroController{

    private $userModel;

    private $render;

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
    }


    public function procesarRegistro(){
        if( empty($_POST['nombre_completo'] ) || empty($_POST['mail'] ) || empty($_POST['password'] ) ){
            $_SESSION["error"] = "Alguno de los campos era erroneo o vacio";
            Redirect::to('/preguntados/registro');
        }

        $nombre_completo = $_POST['nombre_completo'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $this->userModel->registrar($nombre_completo,$mail,$password);
        Redirect::root();
    }

    public function registro(){
        $data = [];

        if(!empty($_SESSION['error'])){
            $data["error"] = $_SESSION['error'];
            unset( $_SESSION['error']);
        }

        $data['action'] = '/preguntados/procesarRegistro';
        $data['submitText'] = 'Registrar';
        $this->render->printView('registro', $data);
    }

}