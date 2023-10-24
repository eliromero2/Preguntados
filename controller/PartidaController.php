<?php
class PartidaController{

    private $userModel;
    private $partidaModel;

    private $render;

    public function __construct($render, $userModel, $partidaModel) {
        $this->render = $render;
        $this->userModel = $userModel;
        $this->partidaModel = $partidaModel;
    }

    public function list() {
        $data = [
            'partidas' => $this->partidaModel->getPartidasUser($_SESSION['user']['id']),
            'userSession' => $this->userModel->getCurrentSession(),
            'error' => $_SESSION['error'],
            'success' => $_SESSION['success'],
        ];

        $this->render->authView($data['userSession'],'partida', $data,'/login');

    }


}