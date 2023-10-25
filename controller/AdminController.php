<?php
class AdminController{

    private $userService;
    private $preguntaService;

    private $render;

    public function __construct($render, $userService, $preguntaService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->preguntaService = $preguntaService;
    }

    public function list() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }

    public function preguntas() {
        $data['userSession'] = $this->preguntaService->getCurrentSession();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }

    public function usuarios() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }

    public function categorias() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }
}
