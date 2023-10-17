<?php
class HomeController{

    private $userModel;

    private $render;

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
    }

    public function list() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $this->render->printView('home', $data);
    }
}
