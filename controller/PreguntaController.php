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
        $data['puntaje'] = $this->partidaService->getPartidaPuntaje($data['userSession']);

        $idPregunta = $_GET['params'] ?? $this->preguntaService->getRandomId();
        $_SESSION['tiempo_inicio'] = time();
        $data['pregunta'] = $this->preguntaService->getPreguntaByNivel($data['userSession']['nivel'] ,true);
        $data['dificultad'] = $this->preguntaService->getNivelPreguntaById($idPregunta ,true);

        Sesion::setPreguntas($data['pregunta']);

        $this->render->printView('pregunta',$data);
    }

    public function validarOpcion(){
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['pregunta'] = $this->preguntaService->getPregunta($_POST['id']);

        $idPreguntaActual = $_POST['id'];

        
        $data['pregunta'] = $this->preguntaService->getPregunta($idPreguntaActual, true);

        $opcionSeleccionada = $_POST['opcion'];

        $opcionCorrecta = $data['pregunta']['opcion_correcta'];

        $tiempoInicio = $_SESSION['tiempo_inicio'];

        $tiempoTranscurrido = time() - $tiempoInicio;

        $duracionMaxima = 30;
        //logger::info(print_r([ 'opcioncorrecta' => $opcionCorrecta, 'opcionseleccionada' => $opcionSeleccionada,'data' => $data ],true));
        if($tiempoTranscurrido > $duracionMaxima){
            $data['opcionEsCorrecta']= "fin ";
            $_SESSION['error'] = 'Expiro el tiempo';

            $this->partidaService->actualizarPartida($data['userSession']['user']['id'],$_POST['puntaje']);

            Redirect::to('/juego/perdido');
        }
        if ($opcionSeleccionada == $opcionCorrecta){
            $data['opcionEsCorrecta']= "La es opcion correcta ";
            $this->partidaService->preguntaContestada($_POST['id']);
            $data['puntaje'] =  intval($_POST['puntaje']) + 1;

            $this->partidaService->actualizarPartida($data['userSession']['user']['id'],  $data['puntaje']);
            if ( $data['puntaje'] >= 10) {
                Redirect::to('/juego/ganado');
            }

            $preguntas = Sesion::getPreguntas();
            $preguntasIds = array_column($preguntas, 'id');
            $siguientePreguntaId = $this->preguntaService->getRandomIdNotInArray($preguntasIds);

            Redirect::to("/pregunta/show/$siguientePreguntaId");

        }else{
            $data['opcionEsCorrecta']= "fin ";
            $this->partidaService->actualizarPartida($data['userSession']['user']['id'],$_POST['puntaje']);

            Redirect::to('/juego/perdido');
        }

        $this->render->authView($data['userSession'],'pregunta',$data);
    }

    public function sugerir(){
        $data['modulos'] = $this->preguntaService->getAllModules();
        $data['tipos'] = $this->preguntaService->getAllTypes();

        $this->render->printView('sugerirPregunta', $data);
    }
}
