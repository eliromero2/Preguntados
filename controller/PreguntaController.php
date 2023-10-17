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

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function modulo() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['preguntasByModule'] = $this->preguntaModel->getAllBy($_GET['name']);

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function show(){
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['pregunta'] = $this->preguntaModel->getPreguntaBy($_GET['id']);

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function validarOpcion(){

        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['pregunta'] = $this->preguntaModel->getPreguntaBy($_GET['id']);

        $opcionSeleccionada = $_POST['opcion'];

        $opcionCorrecta = $this->preguntaModel->getRespuestaCorrecta($_GET['id']);

        if ($opcionSeleccionada == $opcionCorrecta){
            $data['opcionEsCorrecta']= "La es opcion correcta ";
        }else{
            Redirect::to('/juego/list');
        }

        $this->render->authView($data['userSession'],'pregunta',$data);

    }
}
