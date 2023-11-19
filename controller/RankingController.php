<?php
class RankingController{

    private $userService;
    private $partidaService;

    private $render;

    public function __construct($render, $userService, $partidaService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->partidaService = $partidaService;
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
            'userSession' => $this->userService->getCurrentSession(),
            'partidas' => $this->partidaService->getPartidas(),
        ];
        
        $this->render->authView($data['userSession'],'ranking', $data,'/login');
    }


}