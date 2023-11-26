<?php
class JuegoController{

    private $userService;
    private $preguntaService;
    private $partidaService;
    private $render;

    public function __construct($render, $userService, $preguntaService, $partidaService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->preguntaService = $preguntaService;
        $this->partidaService = $partidaService;
    }

    public function list() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['modulos'] = $this->preguntaService->getModules();
        $this->render->authView($data['userSession'],'juego', $data);
    }

    public function ganado() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $this->render->authView($data['userSession'],'juegoGanado', $data);
    }

    public function perdido() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = @$_SESSION['error'];
        unset($_SESSION['error']);
        $this->render->authView($data['userSession'],'juegoPerdido', $data);
    }

    public function crear() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $this->partidaService->createPartida($data['userSession']['user']['id']);

        $idRandom = $this->preguntaService->getRandomId();

        Redirect::to("/pregunta/show/$idRandom");
    }
}
