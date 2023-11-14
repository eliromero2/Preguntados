<?php
class PreguntaService
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getPuntajeUser($id){
        return $this->model->getPuntajeUser($id);
    }

    public function getPreguntas(){
        return $this->model->all();
    }

    public function getRandomId(){
        return $this->model->getRandomId();
    }

    public function getPregunta(){
        $modelResponse = $this->model->getPreguntasDificultadFaciles();

        $indexedOpciones = array_map(function($item, $index) use ($modelResponse) {
            return [
                'index' => $index + 1, 
                'opcion' => $item,
                'opcion_correcta' => $item === $modelResponse['opcion_correcta'] ?? null
            ];

        }, $modelResponse['opciones'], array_keys($modelResponse['opciones']));

        $modelResponse['opciones'] = $indexedOpciones;

        return $modelResponse;
    }

    public function updatePregunta($data){
        $this->model->update($data);
        return $this->model->all();
    }

    public function getModules(){
        return $this->model->getModules();
    }

    public function getAllBy($moduleName){
        return $this->model->getAllBy($moduleName);
    }

    public function getDificultadPregunta($idPregunta){
        return $this->model->getDificultadPregunta($idPregunta);
    }
}