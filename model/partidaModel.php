<?php

class partidaModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function createPartida($id){
        $sql ="INSERT INTO partidas (user_id, puntaje) VALUES ($id,0)";

        $this->database->query($sql);
    }

    public function getPartidas(){
        $sql = "SELECT user_id, SUM(puntaje) as puntaje FROM partidas group by user_id";

        $resultado = $this->database->select($sql);

        return $resultado;
    }

    public function getPartidasUser($id){
        $sql = "SELECT * FROM partidas WHERE user_id = $id";
        $resultado = $this->database->select($sql);

        return $resultado ?? 0;
    }

    public function getPuntajeUser($id){
        $sql = "SELECT SUM(puntaje) AS puntaje_total FROM partidas WHERE user_id = $id";

        $resultado = $this->database->select($sql);

        if (isset($resultado[0]['puntaje_total'])) {
            return $resultado[0]['puntaje_total'];
        }

        return 0;
    }

}