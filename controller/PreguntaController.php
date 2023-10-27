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

        $idPregunta = isset($_GET['params']) ? $_GET['params'] : $this->preguntaModel->getRandomId();

        $data['pregunta'] = $this->preguntaModel->getPreguntaBy($idPregunta,true);

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function validarOpcion(){

        $data['userSession'] = $this->userModel->getCurrentSession();

        $data['pregunta'] = $this->preguntaModel->getPreguntaBy($_POST['id']);


        $opcionSeleccionada = $_POST['opcion'];


       $opcionCorrecta = $data['pregunta'][0]['opcion_correcta'];

        if ($opcionSeleccionada == $opcionCorrecta){
            $data['opcionEsCorrecta']= "La es opcion correcta ";
        }else{
            $data['opcionEsCorrecta']= "fin ";

            Redirect::to('/juego/list');

        }

        $this->render->authView($data['userSession'],'pregunta',$data);

    }
}
