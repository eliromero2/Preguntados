<?php
class PreguntaController{

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
        $this->render->printView('pregunta', $data);
    }

    public function modulo() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['preguntasByModule'] = $this->preguntaModel->getAllBy($_GET['name']);

        $this->render->printView('pregunta', $data);
    }
}
