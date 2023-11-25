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

    public function getPartidasPDF(){
        $modelRespose = $this->model->getPartidasPDF();
        $modelRespose['cantidad de partida'] = count($modelRespose);
        return $modelRespose;
    }

    public function getPartidasAPI(){
        $modelRespose['partidas'] = $this->model->getPartidas(true);
        $modelRespose['cantidad_partidas'] = count($modelRespose['partidas']);

        return $modelRespose;
    }

    public function actualizarPartida($user_id, $puntaje){
        $this->model->actualizarPartida($user_id, $puntaje);

    }

    public function getPartidasUser($id){
        return $this->model->getPartidasUser($id);
    }

    public function getPartidaPuntaje($session){
        $user_id = $session['user']['id'];
        $puntaje = $this->model->getPartidaPuntaje($user_id);

        return $puntaje['puntaje'];
    }

    public function preguntaContestada($id){
        $sql = "UPDATE preguntas SET contestada = contestada + 1 WHERE id = $id";
        $this->model->run($sql);
    }

    public function getNivelUsuario($id){
        $sql = "SELECT puntaje FROM partidas where user_id = '$id'";
        $modelResponse = $this->model->run($sql);

        $cantidadDePartidasJugadas = count($modelResponse);

        $puntajesEnteros = array_map(function($item) {
            return intval($item['puntaje']);
        },$modelResponse);

        $promedio = number_format((array_sum($puntajesEnteros) / $cantidadDePartidasJugadas) / 10, 2);

        return $promedio;
    }
}