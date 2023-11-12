<?php

class ApiController
{
    private $preguntaService;
    private $tipoService;
    private $categoriaService;

    public function __construct(PreguntaService $preguntaService){
        $this->preguntaService = $preguntaService;
    }

    public function pregunta(){
        echo json_encode($this->preguntaService->getPregunta($_GET['params']));
    }

}