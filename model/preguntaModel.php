<?php

class preguntaModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }
    
    public function all(){
        $sql="SELECT * FROM preguntas";
        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('NO econtro: ' . $sql);
            return false;
        }

        $preguntas = $resultado;
        
        return $preguntas;
    }


    public function getModules(){
        $sql="SELECT DISTINCT modulo FROM preguntas";
        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('NO econtro: ' . $sql);
            return false;
        }
        
        return $resultado;
    }

    public function getAllBy($moduleName){
        $sql = "SELECT pregunta, GROUP_CONCAT(opcion SEPARATOR ';') AS opciones, MAX(CASE WHEN opcion_correcta = 'SI' THEN opcion END) AS opcion_correcta FROM preguntas WHERE modulo = ".$moduleName." GROUP BY pregunta";

        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('NO econtro: ' . $sql);
            return false;
        }

        foreach ($resultado as &$row) {
            $row['opciones'] = explode(';', $row['opciones']);
        }
        
        return $resultado;
    }


    public function getPreguntaBy($id){

        $sql2= "SELECT pregunta from preguntas where id = $id";

        $preguntaRow = $this->database->select($sql2);

        $pregunta = $preguntaRow[0]['pregunta'];

        $sql = "SELECT pregunta,id, GROUP_CONCAT(opcion SEPARATOR ';') AS opciones, MAX(CASE WHEN opcion_correcta = 'SI' THEN opcion END) AS opcion_correcta FROM preguntas WHERE pregunta = '$pregunta' GROUP BY pregunta";

        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('NO econtro: ' . $sql);
            return false;
        }

        foreach ($resultado as &$row) {
            $row['opciones'] = explode(';', $row['opciones']);
        }
        
        return $resultado;
    }

    public function getRespuestaCorrecta($id){

        $sql1 = "SELECT pregunta FROM preguntas WHERE id = $id";
        $preguntaRow = $this->database->select($sql1);

        if (!$preguntaRow || count($preguntaRow) === 0) {
            Logger::info('No se encontró la pregunta con ID: ' . $id);
            return false;
        }

        $pregunta = $preguntaRow[0]['pregunta'];
        //
        $sql2 = "SELECT opcion FROM preguntas WHERE pregunta = '$pregunta' AND opcion_correcta = 'SI'";
        $resultado = $this->database->select($sql2);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('No se encontró una respuesta correcta para la pregunta: ' . $pregunta);
            return false;
        }

        return $resultado[0]['opcion_correcta'];
    }

}