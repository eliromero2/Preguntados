<?php
class HomeController{

    private $userService;
    private $partidaService;

    private $render;

    public function __construct($render, $userService, $partidaService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->partidaService = $partidaService;
    }

    public function list() {

        $data['userSession'] = $this->userService->getCurrentSession();
        $data['userSession']['nivel'] = Sesion::parseUserLevel($data['userSession']['nivel']);;
        $data['error'] = @$_SESSION['error'];
        $data['success'] = @$_SESSION['success'];
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        echo '<script>localStorage.removeItem("tiempoRestante");</script>';
        $this->render->printView('home', $data);
    }
}
