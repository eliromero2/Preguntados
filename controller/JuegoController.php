<?php
class JuegoController{

    private $userModel;
    private $preguntaModel;

    private $render;

    public function __construct($render, $userModel, $preguntaModel) {
        $this->render = $render;
        $this->userModel = $userModel;
        $this->preguntaModel = $preguntaModel;
    }

    public function list() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['modulos'] = $this->preguntaModel->getModules();
        
        $this->render->printView('juego', $data);
    }
}
