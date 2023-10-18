<?php
class RankingController{

    private $userModel;
    private $partidaModel;

    private $render;

    public function __construct($render, $userModel, $partidaModel) {
        $this->render = $render;
        $this->userModel = $userModel;
        $this->partidaModel = $partidaModel;
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


        $data = [
            'partidas' => $this->partidaModel->getPartidas(),
        ];


        $this->render->authView($_SESSION['user'],'ranking', $data,'/login');

    }


}