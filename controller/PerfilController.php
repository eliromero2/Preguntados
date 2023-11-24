<?php

require 'third-party/phpqrcode/qrlib.php';

class PerfilController{

    private $userService;
    private $render;


    public function __construct($render ,$userService) {
        $this->render = $render;

        $this->userService = $userService;


    }

    public function list() {

        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = @$_SESSION['error'];

        unset($_SESSION['error']);

        $userId = $_SESSION['user']['id'];

        $userData = $this->userService->getUserById($userId);

        $data['userData'] = $userData;

        $dir='public/qr/';

        if(!file_exists($dir)){
            mkdir($dir);
        }
        $nombreArchivo=$dir.'qrPerfil.png';
        $tamanio=7;
        $level='Q';
        $framesize=3;
        $contenido= 'http://localhost/perfil/list';

        QRcode::png($contenido,$nombreArchivo,$level,$tamanio,$framesize);

        $data['qrPerfil']=$nombreArchivo;

        $this->render->printView('perfil', $data);
    }

    public function show(){
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = @$_SESSION['error'];

        unset($_SESSION['error']);
        $user = $this->userService->getByUserName($_GET['params']);
        $userName = @$user['user_name'];
        $data['userData'] = $user;

        $dir='public/qr/';
        if(!file_exists($dir)){
            mkdir($dir);
        }

        $nombreArchivo= $dir . $userName.'qrPerfilUsuario.png';
        if(!file_exists($nombreArchivo)){
            $tamanio=7;
            $level='Q';
            $framesize=3;
            $contenido= 'http://localhost/perfil/show/'.$userName;

            QRcode::png($contenido,$nombreArchivo,$level,$tamanio,$framesize);

            $data['qrPerfil']=$nombreArchivo;
        }else{
            $data['qrPerfil']=$nombreArchivo;
        }

        $this->render->printView('perfil', $data);
    }


}

