<?php

class ApiController
{
    private $preguntaService;
    private $opcionService;
    private $partidaService;
    private $userService;
    private $session;

    public function __construct($preguntaService, $opcionService, $partidaService,$userService){
        $this->preguntaService = $preguntaService;
        $this->opcionService = $opcionService;
        $this->partidaService = $partidaService;
        $this->userService = $userService;

    }

    public function pregunta(){
        echo json_encode($this->preguntaService->getPregunta($_GET['params']));
    }

    public function editarPregunta(){
        $data = file_get_contents('php://input');
       $resultPregunta = $this->preguntaService->updatePregunta($data);
       $resultRespuestas = $this->opcionService->updateOpciones($data);

       $this->preguntaService->resolveInProgressReportPregunta(json_decode($data)->report_id);

       $response = [
           'resultPregunta' => $resultPregunta,
           "resultRespuestas" => $resultRespuestas,
       ];

       echo json_encode($response);
    }

    public function crearPregunta(){
        $data = json_decode(file_get_contents('php://input'));
        $resultPregunta = $this->preguntaService->createPregunta($data);
        $data->pregunta_id = $resultPregunta;
        $resultRespuestas = $this->opcionService->createOpciones($data);

        $response = [
            'resultPregunta' => $resultPregunta,
            "resultRespuestas" => $resultRespuestas,
        ];

        echo json_encode($response);
    }


    public function sugerirPregunta(){
        $data = json_decode(file_get_contents('php://input'));
        $resultPregunta = $this->preguntaService->createSugerirPregunta($data);
        $data->pregunta_id = $resultPregunta;
        $resultRespuestas = $this->opcionService->createOpciones($data, true);

        $response = [
            'resultPregunta' => $resultPregunta,
            "resultRespuestas" => $resultRespuestas,
        ];

        $_SESSION['success'] = "Se creo la sugerencia de pregunta";

        echo json_encode($response);
    }

    public function reportPregunta(){
        $data = json_decode(file_get_contents('php://input'));
        $data->pregunta_id = $_GET['params'];
        $data->user_id = $this->userService->getCurrentSession()['user']['id'];
        $resultPregunta = $this->preguntaService->createReportPregunta($data);
        $data->pregunta_id = $resultPregunta;

        $response = [
            'resultPregunta' => $resultPregunta,
        ];

        $_SESSION['success'] = "Se creo la sugerencia de pregunta";

        echo json_encode($response);
    }

    public function descartarReporte(){
        $data = json_decode(file_get_contents('php://input'));
        $result = $this->preguntaService->descartarReportPregunta($data->id);

        if($result){
            $_SESSION['success'] = "Se descarto el reporte";
        }else{
            $_SESSION['error'] = "No se pudo descartar el reporte";
        }

        echo json_encode($result);
    }

    public function resolverReporte(){
        $data = json_decode(file_get_contents('php://input'));
        $result = $this->preguntaService->resolveReportPregunta($data->id);

        if($result){
            $_SESSION['success'] = "Se empezo a resolver el reporte";
        }else{
            $_SESSION['error'] = "No se pudo empezar a resolver el reporte";
        }

        echo json_encode($result);
    }

    public function partidasJugadas(){
        $data['partidas'] = $this->partidaService->getPartidasAPI();
        echo json_encode($data['partidas']);
    }

    public function getEdadUsuarios(){
        $data['edad'] = $this->userService->getEdadUsuarios();
        echo json_encode($data['edad']);
    }

}