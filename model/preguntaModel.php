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


    public function getModules(){
        $sql="SELECT DISTINCT id_modulo FROM preguntas";
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


    public function getPreguntaBy($id, $forUser = false){

        $sql = "SELECT * FROM preguntas WHERE id ='$id'";

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
        
        if($forUser){
            $this->database->query("UPDATE preguntas SET entregadas = entregadas + 1 WHERE id = $id");
        }

        $resultado[0]['opciones'] = explode(';', $resultado[0]['opciones']);
        $resultado[0]['preguntaRow'] = $preguntaRow[0];

        return $resultado[0];
    }


    public function getRandomId(){
        $sql = "SELECT COUNT(pregunta) total FROM preguntas";
        $result = $this->database->select($sql);
        $total = intval($result[0]['total']);
        return rand(1,$total);
    }

    public function update($data){
        try {
            $accesible = $data->accesible ?? null;
            $sql = "UPDATE preguntas SET 
                pregunta = '$data->pregunta',
                estado = '$data->estado',
                accesible = '$accesible',
                id_modulo = '$data->id_modulo',
                id_tipo = '$data->id_tipo',
                dificultad_id = '$data->dificultad_id'
            WHERE id = '$data->pregunta_id'";

            $result = $this->database->query($sql);

            return $result;

        } catch (PDOException $e) {
            // Manejar errores de base de datos
            // Puedes personalizar este bloque según tus necesidades
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function create($data){
        try {
            $accesible = $data->accesible ?? null;
            $sql = "INSERT INTO preguntas (pregunta, estado, accesible, id_modulo, id_tipo, dificultad_id)  VALUES ('$data->pregunta', '$data->estado','$accesible','$data->id_modulo','$data->id_tipo','$data->dificultad_id')";

            $result = $this->database->query($sql);

            return $result;

        } catch (PDOException $e) {
            // Manejar errores de base de datos
            // Puedes personalizar este bloque según tus necesidades
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id){
        $sql = "DELETE FROM preguntas WHERE id = '$id'";
        return $this->database->query($sql);
    }

    public function getPreguntasByDificultad($dificultad) {
        $sql = "SELECT p.pregunta, GROUP_CONCAT(o.opcion SEPARATOR ';') AS opciones, MAX(CASE WHEN o.opcion_correcta = 'SI' THEN o.opcion END) AS opcion_correcta 
            FROM preguntas AS p
            LEFT JOIN opciones AS o ON p.id = o.pregunta_id
            WHERE p.dificultad_id = (
                SELECT id FROM dificultad_preguntas WHERE dificultad = $dificultad
            )
            GROUP BY p.id";


        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('No se encontraron resultados para la dificultad: ' . $dificultad);
            return false;
        }

        foreach ($resultado as &$row) {
            $row['opciones'] = explode(';', $row['opciones']);
        }

        return $resultado;
    }

    public function getAllTypes(){
        $sql = "SELECT id, name FROM tipos";
        $types = $this->database->select($sql);

        return $types;
    }

    public function getAllModules(){
        $sql = "SELECT id, name FROM modulos";
        $modules = $this->database->select($sql);

        return $modules;
    }

    public function getAllLevels(){
        $sql = "SELECT id, dificultad FROM dificultad_preguntas";
        $levels = $this->database->select($sql);

        return $levels;
    }

}