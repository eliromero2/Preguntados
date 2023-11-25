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

    public function getPregunta($id, $forUser= false){
        $modelResponse = $this->model->getPreguntaBy($id, $forUser);

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

    public function getPreguntaByNivel($id, $level,$forUser= false){

        $levelString = is_numeric($level) ? (floatval($level) <= 0.33 ? 'Facil' : (floatval($level) <= 0.66 ? 'Medio' : 'Dificil')) : 'No válido';

        $modelResponse = $this->model->getPreguntaByNivel($levelString, $forUser);

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

    public function getRandomIdNotInArray($excludedIds){
        $randomId = $this->getRandomId();
        while (in_array($randomId, $excludedIds)) {
            $randomId = $this->getRandomId();
        }
        return $randomId;
    }

    public function updatePregunta($data){
        $jsonData = json_decode($data);
        return $this->model->update($jsonData);
    }

    public function createPregunta($data){
        return $this->model->create($data);
    }

    public function deletePregunta($id){
        return $this->model->delete($id);
    }


    public function getModules(){
        return $this->model->getModules();
    }

    public function getAllBy($moduleName){
        return $this->model->getAllBy($moduleName);
    }

    public function getAllTypes(){
        return $this->model->getAllTypes();
    }

    public function getAllModules(){
        return $this->model->getAllModules();
    }

    public function getAllLevels(){
        return $this->model->getAllLevels();
    }
}