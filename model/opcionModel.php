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
    public function updateOpciones($data, $isSugerir = false){
        $result = $this->getOpciones($data->id_pregunta);
        $sqlStatus = true;
        $table = $isSugerir ? "opciones_sugeridas" : "opciones";

        foreach ($result as $key => $row){
            $opcionCorrecta = $key === (intval($data->respuesta_correcta) - 1) ? 'SI' : 'NO';
            $opcionTexto = $data->opciones[$key];
            $sql = "UPDATE ".$table." SET opcion ='$opcionTexto', opcion_correcta = '$opcionCorrecta' WHERE id = ". $row['id'];
            $sqlStatus = $this->database->query($sql);
        }

        return $sqlStatus;
    }

    public function createOpciones($data, $isSugerir){

        $sqlStatus = true;
        $table = $isSugerir ? 'opciones_sugeridas' : 'opciones';

        foreach ($data->opciones as $key => $row){
            $opcionCorrecta = $key === (intval($data->respuesta_correcta) - 1) ? 'SI' : 'NO';
            $opcionTexto = $data->opciones[$key];
            $sql = "INSERT INTO ".$table." (opcion, opcion_correcta,pregunta_id) VALUES ('$opcionTexto', '$opcionCorrecta', '$data->id_pregunta')";
            $sqlStatus = $this->database->query($sql);
        }

        return $sqlStatus;
    }
}