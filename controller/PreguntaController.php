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

        $data['pregunta'] = $this->preguntaService->getPregunta();



        Sesion::setPreguntas($data['pregunta']);

        $data['partidaSesion']= json_encode(Sesion::getPreguntas());



        //$_SESSION['id_pregunta_actual'] = $idPregunta;
        $_SESSION['tiempo_inicio'] = time();
        //$data['pregunta'] = $this->preguntaService->getPregunta($idPregunta, true);
       // Logger::dd($data['pregunta']);

        $this->render->printView('pregunta',$data);
    }

    public function validarOpcion(){

        $data['userSession'] = $this->userService->getCurrentSession();


        $data['pregunta'] = $this->preguntaService->getPregunta();

        // Obtener el ID de la pregunta actual desde la sesión
        $idPreguntaActual = $_SESSION['id_pregunta_actual'];

        // Obtener la pregunta actual basada en el ID almacenado
        $data['pregunta'] = $this->preguntaService->getPregunta($idPreguntaActual, true);



        $opcionSeleccionada = $_POST['opcion'];
        $puntajeActual = $_POST['puntaje'];

        $opcionCorrecta = $data['pregunta']['opcion_correcta'];

        $tiempoInicio = $_SESSION['tiempo_inicio'];

        $tiempoTranscurrido = time() - $tiempoInicio;

        $duracionMaxima = 30;


        if($tiempoTranscurrido > $duracionMaxima){
            $data['opcionEsCorrecta']= "fin ";

            $this->partidaService->actualizarPartida($data['userSession']['user']['id'], $puntajeActual);

            Redirect::to('/juego/perdido');
        }
        if ($opcionSeleccionada == $opcionCorrecta){


            $data['opcionEsCorrecta']= "La opcion era correcta, siguiente pregunta";
            $data['puntaje'] =  $puntajeActual + 1;
            if ( $data['puntaje'] >= 10) {
                Redirect::to('/juego/ganado');
            }
            $this->partidaService->actualizarPartida($data['userSession']['user']['id'], $data['puntaje']);

            $idPregunta = $this->preguntaService->getRandomId();
            $data['pregunta'] = $this->preguntaService->getPregunta($idPregunta,true);



            Redirect::to('/pregunta/show/'.$idPregunta);

        }else{
            $data['opcionEsCorrecta']= "fin ";

            $this->partidaService->actualizarPartida($data['userSession']['user']['id'], $puntajeActual);

            Redirect::to('/juego/perdido');

        }

        $this->render->authView($data['userSession'],'pregunta',$data);
    }
}
