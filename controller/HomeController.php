<?php
class HomeController{

    private $userModel;
    private $partidaModel;

    private $render;

    public function __construct($render, $userModel, $partidaModel) {
        $this->render = $render;
        $this->userModel = $userModel;
        $this->partidaModel = $partidaModel;
    }

    public function list() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['puntaje'] = $this->partidaModel->getPartidasUser($data['userSession']['id']);
        $this->render->printView('home', $data);
    }
}
