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

    public function getPregunta($id){
        $modelResponse = $this->model->getPreguntaBy($id);

        $indexedOpciones = array_map(function($item, $index) use ($modelResponse) {
            return [
                'index' => $index + 1, 
                'opcion' => $item,
                'opcion_correcta' => $item === $modelResponse['opcion_correcta'] ?? null
            ];
        }, $modelResponse['opciones'], array_keys($modelResponse['opciones']));

        $modelResponse['opciones'] = $indexedOpciones;

        //Logger::dd($modelResponse);

        return $modelResponse;
    }

    public function updatePregunta($data){
        Logger::dd($data);
        $this->model->update($data);
        return $this->model->all();
    }
}