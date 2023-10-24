<?php
class JuegoController{

    private $userModel;
    private $preguntaModel;
    private $partidaModel;
    private $render;

    public function __construct($render, $userModel, $preguntaModel, $partidaModel) {
        $this->render = $render;
        $this->userModel = $userModel;
        $this->preguntaModel = $preguntaModel;
        $this->partidaModel = $partidaModel;
    }

    public function list() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['modulos'] = $this->preguntaModel->getModules();
      
        $this->render->authView($data['userSession'],'juego', $data);
    }

    public function crear() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $this->partidaModel->createPartida($data['userSession']['user']['id']);

        $idRandom = $this->preguntaModel->getRandomId();

        Redirect::to("/pregunta/show/$idRandom");
    }
}
