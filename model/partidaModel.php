<?php

class partidaModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function getPartidas($id){
        $sql = "SELECT * FROM partidas WHERE user_id = :id";
        $params = array(':id' => $id);

        $resultado = $this->database->select($sql, $params);

        return $resultado;
    }

    public function getPuntajeTotal($id){
        $sql = "SELECT SUM(puntaje) AS puntaje_total FROM partidas WHERE user_id = :id";
        $params = array(':id' => $id);

        $resultado = $this->database->select($sql, $params);

        if (isset($resultado[0]['puntaje_total'])) {
            return $resultado[0]['puntaje_total'];
        } else {
            return 0;
        }
    }

}