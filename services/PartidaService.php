<?php
class PartidaService
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getPuntajeUser($id){
        return $this->model->getPuntajeUser($id);
    }

    public function getPartidas(){
        $modelRespose = $this->model->getPartidas();
        $modelRespose['cantidad de partida'] = count($modelRespose);
        return $modelRespose;
    }


}