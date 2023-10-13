<?php
class LoginController{

    private $userModel;

    private $render;

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
    }

    public function list() {
        $this->render->printView('login');
    }

    public function login(){
        $data = [];

        if(!empty($_SESSION['error'])){
            $data["error"] = $_SESSION['error'];
            unset( $_SESSION['error']);
        }

        $data['action'] = '/login/procesarLogin';
        $data['submitText'] = 'Ingresar';
        $this->render->printView('login', $data);


    }

    public function procesarLogin(){
        if( empty($_POST['password'] ) || empty($_POST['user_name'] )  ){
            $_SESSION["error"] = "Alguno de los campos era erroneo o vacio";
            Redirect::to('/login');
        }
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        $this->userModel->validarUsuario($user_name,$password);
        Redirect::to('/home/list');
    }

    public function cerrarSesion(){//revisarrrrr
        session_destroy();
        echo('Se cerro la sesion');
        Redirect::to('/home/list');
    }

}