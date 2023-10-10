<?php
class LoginController{

    private $userModel;

    private $render;

    public function __construct($render, $userModel) {
        $this->render = $render;
        $this->userModel = $userModel;
    }

    public function list() {
        $this->render->printView('login');
    }
}