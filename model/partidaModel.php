<?php

class  partidaModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function createPartida($id){
        $sql ="INSERT INTO partidas (user_id, puntaje) VALUES ($id,0)";

        $this->database->query($sql);
    }
    
    public function actualizarPartida($user_id, $puntaje){
        
        $sql = "SELECT id FROM partidas WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";
        $resultado = $this->database->select($sql);
        
        if (isset($resultado[0]['id'])) {
            $id = $resultado[0]['id'];
        }

        $sqlUpdate ="UPDATE partidas SET puntaje = $puntaje WHERE id = $id";

         $this->database->query($sqlUpdate);

    }

    public function getPartidaPuntaje($user_id){

        $sql = "SELECT id, puntaje FROM partidas WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";
        $resultado = $this->database->select($sql);

        if (isset($resultado[0]['id'])) {
           return $resultado[0];
        }

        return false;
    }

    public function getPartidas($sort = false){
        if($sort){
            $sql = "SELECT users.id as user_id ,users.user_name as name, SUM(partidas.puntaje) as puntaje
                        FROM partidas
                        JOIN users ON partidas.user_id = users.id
                        GROUP BY users.id
                        ORDER BY puntaje DESC";
        }else{
            $sql = "SELECT user_id, SUM(puntaje) as puntaje FROM partidas group by user_id";
        }

        $resultado = $this->database->select($sql);

        return $resultado;
    }
    public function getPartidasPDF(){

            $sql = "SELECT users.id as user_id ,users.user_name as name, SUM(partidas.puntaje) as puntaje
                        FROM partidas
                        JOIN users ON partidas.user_id = users.id
                        GROUP BY users.id
                        ORDER BY puntaje DESC";

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

    public function getPartida($id){
        $sql = "SELECT * FROM partidas WHERE user_id = $id";

        $resultado = $this->database->select($sql);

        if (isset($resultado[0])) {
            return $resultado[0];
        }else{
           return null;
        }
    }

}