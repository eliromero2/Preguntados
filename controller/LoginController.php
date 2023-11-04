<?php
class LoginController{

    private $userService;

    private $render;

    public function __construct($render, $userService) {
        $this->render = $render;
        $this->userService = $userService;
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
                'error' => $_SESSION['error'] 
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

        if(!@$_SESSION['user']){
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

        $this->userService->validarUsuario($user_name,$password);
        Redirect::to("/home");
    }

    public function cerrarSesion(){//revisarrrrr
        session_destroy();
        Redirect::to('/home/list');
    }

}