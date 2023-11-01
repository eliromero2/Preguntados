<?php
class PreguntaController{

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

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function modulo() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['preguntasByModule'] = $this->preguntaService->getAllBy($_GET['name']);

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function show(){
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['puntaje'] = 0;

        $idPregunta = $_GET['params'] ?? $this->preguntaService->getRandomId();

        $data['pregunta'] = $this->preguntaService->getPregunta($idPregunta,true);

       // Logger::dd($data['pregunta']);
        $this->render->printView('pregunta',$data);
    }

    public function validarOpcion(){

        $data['userSession'] = $this->userService->getCurrentSession();
        Logger::info(print_r($_POST,true));

        $data['pregunta'] = $this->preguntaService->getPreguntaBy($_POST['id']);


        $opcionSeleccionada = $_POST['opcion'];
        $puntajeActual = $_POST['puntaje'];

       $opcionCorrecta = $data['pregunta'][0]['opcion_correcta'];

        if ($opcionSeleccionada == $opcionCorrecta){
            $data['opcionEsCorrecta']= "La es opcion correcta ";
            $data['puntaje'] =  $puntajeActual + 1;

            $idPregunta = $this->preguntaService->getRandomId();
            $data['pregunta'] = $this->preguntaService->getPreguntaBy($idPregunta,true);

        }else{
            $data['opcionEsCorrecta']= "fin ";

            $this->partidaService->actualizarPartida($data['userSession']['user']['id'], $puntajeActual);

            Redirect::to('/juego/list');

        }

        $this->render->authView($data['userSession'],'pregunta',$data);
    }
}
