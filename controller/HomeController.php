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
        $data['error'] = $_SESSION['error'];
        unset($_SESSION['error']);
        
        $this->render->printView('home', $data);
    }
}
