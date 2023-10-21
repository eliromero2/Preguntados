<?php
class LoginController{

    private $userModel;

    private $render;

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
    }

    private function redirectIfMissParams($params){
        if( empty($params['password'] ) || empty($params['user_name'] )  ){
            $_SESSION["error"] = "Alguno de los campos era erroneo o vacio";
            Redirect::to('/login');
        }else{
            Logger::info("redirectIfMissParams: ".print_r($params,true));
        }
    }

    public function list() {
        
        if(!isset($_SESSION['user'])){
            $data = [
                'action' => '/login/procesarLogin',
                'submitText' => 'Ingresar',
            ];
            $this->render->printView('login', $data);
        }else{
            Redirect::to('/home');
        }
    }

    public function login(){
        $data = [];

        if(!empty($_SESSION['error'])){
            $data["error"] = $_SESSION['error'];
            unset( $_SESSION['error']);
        }

        if(!$_SESSION['user']){
            $data['action'] = '/login/procesarLogin';
            $data['submitText'] = 'Ingresar';
            $this->render->printView('login', $data);
        }else{
            Redirect::to('/home');
        }

    }

    public function procesarLogin(){
        $this->redirectIfMissParams($_POST);
       
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        $this->userModel->validarUsuario($user_name,$password);
        Redirect::to('/home/list');
    }

    public function cerrarSesion(){//revisarrrrr
        session_destroy();
        var_dump(session_destroy());
        Logger::info("Se cerro Session");
        Redirect::to('/home/list');
    }

}