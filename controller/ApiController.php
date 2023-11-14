<?php

class ApiController
{
    private $preguntaService;
    private $tipoService;
    private $categoriaService;

    public function __construct($preguntaService){
        $this->preguntaService = $preguntaService;
    }

    public function pregunta(){
        echo json_encode($this->preguntaService->getPregunta($_GET['params']));
    }

}