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
        $data['error'] = $_SESSION['error'];
        unset($_SESSION['error']);
        
        $this->render->printView('home', $data);
    }
}
