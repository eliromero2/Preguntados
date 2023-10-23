<?php

class preguntaModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }
    
    public function all()
    {
        $sql = "SELECT p.*, GROUP_CONCAT(o.opcion SEPARATOR ';') AS opciones, GROUP_CONCAT(CASE WHEN o.opcion_correcta = 'SI' THEN o.opcion END SEPARATOR ';') AS opciones_correctas FROM preguntas AS p
                                                                                                                                                                                    LEFT JOIN opciones AS o
                                                                                                                                                                                    ON p.id = o.pregunta_id
                                                                                                                                                                                    GROUP BY p.id";

        $resultado = $this->database->select($sql);

        if (empty($resultado)) {
            Logger::info('No se encontraron preguntas con opciones.');
            return false;
        }

        foreach ($resultado as &$row) {
            $row['opciones'] = explode(';', $row['opciones']);
            $row['opciones_correctas'] = explode(';', $row['opciones_correctas']);
        }

        return $resultado;
    }

        /*$sql="SELECT * FROM preguntas";
        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('NO econtro: ' . $sql);
            return false;
        }

        $preguntas = $resultado;
        
        return $preguntas;*/



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
        $sql = "SELECT p.pregunta, GROUP_CONCAT(o.opcion SEPARATOR ';') AS opciones, MAX(CASE WHEN o.opcion_correcta = 'SI' THEN o.opcion END) AS opcion_correcta FROM preguntas AS p
                                                                                                                                                                LEFT JOIN opciones AS o
                                                                                                                                                                ON p.id = o.pregunta_id
                                                                                                                                                                WHERE p.modulo = ".$moduleName."
                                                                                                                                                                GROUP BY  p.id";

        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('No se encontraron resultados para el módulo: ' . $moduleName);
            return false;
        }

        foreach ($resultado as &$row) {
            $row['opciones'] = explode(';', $row['opciones']);
        }

        return $resultado;

    }


    public function getPreguntaBy($id){
        $sql = "SELECT * FROM preguntas WHERE id = $id";
        $preguntaRow = $this->database->select($sql);

        if (empty($preguntaRow)) {
            Logger::info('No se encontró la pregunta con el ID: ' . $id);
            return false;
        }

        $idPregunta = $preguntaRow[0]['id'];
        $sql = "SELECT pregunta_id, GROUP_CONCAT(opcion SEPARATOR ';') AS opciones, MAX(CASE WHEN opcion_correcta = 'SI' THEN opcion END) AS opcion_correcta FROM opciones WHERE pregunta_id = $idPregunta GROUP BY pregunta_id";

        $resultado = $this->database->select($sql);
        $resultado[0]['pregunta'] = $preguntaRow[0]['pregunta'];



        if (empty($resultado[0])) {
            Logger::info('No se encontraron opciones para la pregunta con ID: ' . $id);
            return false;
        }

        $resultado[0]['opciones'] = explode(';', $resultado[0]['opciones']);

        // Procesa las opciones
       // Logger::dd($resultado);


        return $resultado;
    }

    public function getRandomId(){
        $sql = "SELECT COUNT(pregunta) total FROM preguntas";
        $result = $this->database->select($sql);
        $total = intval($result[0]['total']);
        return rand(1,$total);
    }

    /*OTRA OPCION CON UNA SOLA CONSULTA DE SQL (no probe cual funcoina)
     * $sql = "SELECT p.pregunta, GROUP_CONCAT(o.opcion SEPARATOR ';') AS opciones,MAX(CASE WHEN o.opcion_correcta = 'SI' THEN o.opcion END) AS opcion_correcta
            FROM preguntas AS p
            LEFT JOIN opciones AS o
            ON p.id = o.pregunta_id
            WHERE p.id = $id
            GROUP BY p.id";

    $resultado = $this->database->select($sql);

    if (empty($resultado)) {
        Logger::info('No se encontró la pregunta con el ID: ' . $id);
        return false;
    }
    foreach ($resultado as &$row) {
        $row['opciones'] = explode(';', $row['opciones']);
    }
    return $resultado;
}*/



}