<?php

class opcionModel
{
    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function getOpciones($idPregunta){
        $sql = "SELECT * FROM opciones WHERE pregunta_id = ".$idPregunta;
        return $this->database->select($sql);
    }

    public function delete($idPregunta){
        $sql = "DELETE FROM opciones WHERE pregunta_id = '$idPregunta'";
        return $this->database->query($sql);
    }
    public function updateOpciones($data){
        $result = $this->getOpciones($data->id_pregunta);
        $sqlStatus = true;

        foreach ($result as $key => $row){
            $opcionCorrecta = $key === (intval($data->respuesta_correcta) - 1) ? 'SI' : 'NO';
            $opcionTexto = $data->opciones[$key];
            $sql = "UPDATE opciones SET opcion ='$opcionTexto', opcion_correcta = '$opcionCorrecta' WHERE id = ". $row['id'];
            $sqlStatus = $this->database->query($sql);
        }

        return $sqlStatus;
    }

    public function createOpciones($data){

        $sqlStatus = true;
        foreach ($data->opciones as $key => $row){
            $opcionCorrecta = $key === (intval($data->respuesta_correcta) - 1) ? 'SI' : 'NO';
            $opcionTexto = $data->opciones[$key];
            $sql = "INSERT INTO opciones (opcion, opcion_correcta,pregunta_id) VALUES ('$opcionTexto', '$opcionCorrecta', '$data->id_pregunta')";
            $sqlStatus = $this->database->query($sql);
        }

        return $sqlStatus;
    }
}