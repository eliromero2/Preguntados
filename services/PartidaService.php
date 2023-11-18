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

    public function createPartida($id){
        $this->model->createPartida($id);
    }

    public function getPartidas(){
        $modelRespose = $this->model->getPartidas();
        $modelRespose['cantidad de partida'] = count($modelRespose);
        return $modelRespose;
    }

    public function actualizarPartida($user_id, $puntaje){
        $this->model->actualizarPartida($user_id, $puntaje);

    }

    public function getPartidasUser($id){
        return $this->model->getPartidasUser($id);
    }


}