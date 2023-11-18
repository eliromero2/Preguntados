<?php

class ApiController
{
    private $preguntaService;
    private $opcionService;

    public function __construct($preguntaService, $opcionService){
        $this->preguntaService = $preguntaService;
        $this->opcionService = $opcionService;
    }

    public function pregunta(){
        echo json_encode($this->preguntaService->getPregunta($_GET['params']));
    }

    public function editarPregunta(){
       $resultPregunta = $this->preguntaService->updatePregunta(file_get_contents('php://input'));
       $resultRespuestas = $this->opcionService->updateOpciones(file_get_contents('php://input'));

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

}