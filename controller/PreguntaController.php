<?php
class PreguntaController{

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

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function modulo() {
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['preguntasByModule'] = $this->preguntaModel->getAllBy($_GET['name']);

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function show(){
        $data['userSession'] = $this->userModel->getCurrentSession();
        $data['puntaje'] = 0;

        $idPregunta = isset($_GET['params']) ? $_GET['params'] : $this->preguntaModel->getRandomId();

        $data['pregunta'] = $this->preguntaModel->getPreguntaBy($idPregunta,true);

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function validarOpcion(){

        $data['userSession'] = $this->userModel->getCurrentSession();
        Logger::info(print_r($_POST,true));

        $data['pregunta'] = $this->preguntaModel->getPreguntaBy($_POST['id']);


        $opcionSeleccionada = $_POST['opcion'];
        $puntajeActual = $_POST['puntaje'];

       $opcionCorrecta = $data['pregunta'][0]['opcion_correcta'];

        if ($opcionSeleccionada == $opcionCorrecta){
            $data['opcionEsCorrecta']= "La es opcion correcta ";
            $data['puntaje'] =  $puntajeActual + 1;

            $idPregunta = $this->preguntaModel->getRandomId();
            $data['pregunta'] = $this->preguntaModel->getPreguntaBy($idPregunta,true);

        }else{
            $data['opcionEsCorrecta']= "fin ";

            $this->partidaModel->actualizarPartida($data['userSession']['user']['id'], $puntajeActual);

            Redirect::to('/juego/list');

        }

        $this->render->authView($data['userSession'],'pregunta',$data);
    }
}
