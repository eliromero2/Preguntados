<?php

class preguntaModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function run($sql){
       return $this->database->query($sql);
    }
    
    public function all()
    {
        $sql = "SELECT 
                    p.*, 
                    GROUP_CONCAT(o.opcion SEPARATOR ';') AS opciones, 
                    GROUP_CONCAT(CASE WHEN 
                        o.opcion_correcta = 'SI' 
                        THEN o.opcion 
                        END SEPARATOR ';') AS opciones_correctas 
                FROM preguntas AS p
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

    public function getPreguntaByNivel($level, $forUser=false){


        $sql = "SELECT
                    p.*,
                    AVG(p.contestada * 1.0 / p.entregadas) AS promedio,
                    CASE
                        WHEN AVG(p.contestada * 1.0 / p.entregadas) <= 0.33 THEN 'Dificil'
                        WHEN AVG(p.contestada * 1.0 / p.entregadas) <= 0.66 THEN 'Medio'
                        ELSE 'Facil'
                    END AS nivel
                FROM
                    preguntas p
                group by p.id";

        $preguntasPorNivel = $this->database->select($sql);

        if (empty($preguntasPorNivel)) {
            Logger::info('$preguntasPorNivel: ' . print_r($preguntasPorNivel,true));
            return false;
        }

        $levelFilter = array_filter($preguntasPorNivel, function ($pregunta) use ($level){
           return $pregunta['nivel'] === $level;
        });

        $countPreguntas = count($levelFilter);
        $preguntaIndex = array_rand($levelFilter);

        //Logger::json(array_keys($levelFilter),$preguntaIndex);

        $idPregunta = $levelFilter[$preguntaIndex]['id'];
        //Logger::json($levelFilter[$preguntaIndex],$idPregunta);
        $sql = "SELECT pregunta_id, GROUP_CONCAT(opcion SEPARATOR ';') AS opciones, MAX(CASE WHEN opcion_correcta = 'SI' THEN opcion END) AS opcion_correcta FROM opciones WHERE pregunta_id = $idPregunta GROUP BY pregunta_id";

        $resultado = $this->database->select($sql);
        $resultado[0]['pregunta'] = $levelFilter[$preguntaIndex]['pregunta'];


        if (empty($resultado[0])) {
            Logger::info('No se encontraron opciones para la pregunta con ID: ' . $idPregunta);
            return false;
        }

        if($forUser){
            $this->database->query("UPDATE preguntas SET entregadas = entregadas + 1 WHERE id = $idPregunta");
        }

        $resultado[0]['opciones'] = explode(';', $resultado[0]['opciones']);
        $resultado[0]['preguntaRow'] = $levelFilter[$preguntaIndex];

        return $resultado[0];
    }

    public function getNivelPreguntaById($id, $forUser = false) {
        $sql = "SELECT
                AVG(p.contestada * 1.0 / p.entregadas) AS promedio,
                CASE
                    WHEN AVG(p.contestada * 1.0 / p.entregadas) <= 0.33 THEN 'Dificil'
                    WHEN AVG(p.contestada * 1.0 / p.entregadas) <= 0.66 THEN 'Medio'
                    ELSE 'Facil'
                END AS nivel
            FROM
                preguntas p
            WHERE
                p.id = '$id'";


        $preguntaPorId = $this->database->select($sql);

        if (empty($preguntaPorId)) {
            Logger::info('No se encontró pregunta con ID: ' . $id);
            return false;
        }

        $nivel = $preguntaPorId[0]['nivel'];

        if ($forUser) {
            $this->database->query("UPDATE preguntas SET entregadas = entregadas + 1 WHERE id = $id");
        }

        return $nivel;
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
                id_tipo = '$data->id_tipo'
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

    public function sugerir($data){
        try {
            $sql = "INSERT INTO 
                        preguntas_sugeridas (pregunta, modulo, id_tipo)
                    VALUES ('$data->pregunta','$data->modulo','$data->id_tipo')";

            $result = $this->database->query($sql);

            return $result;

        } catch (PDOException $e) {
            // Manejar errores de base de datos
            // Puedes personalizar este bloque según tus necesidades
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function reportar($data){

        try {
            $sql = "INSERT INTO 
                        reporte_pregunta (user_id,pregunta_id, caso, mensaje)
                    VALUES ('$data->user_id','$data->pregunta_id','$data->caso','$data->comentario')";

            $result = $this->database->query($sql);

            return $result;

        } catch (PDOException $e) {
            // Manejar errores de base de datos
            // Puedes personalizar este bloque según tus necesidades
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function preguntasSugeridas($sql)
    {
        $resultado = $this->database->select($sql);
        if (empty($resultado)) {
            Logger::info('No se encontraron preguntas sugeridas con opciones.');
            return false;
        }

        foreach ($resultado as &$row) {
            if($row['opciones']){
                $row['opciones'] = explode(';', $row['opciones']);
                $row['opciones_correctas'] = explode(';', $row['opciones_correctas']);
            }
        }

        $row['opciones'] = array_values(array_filter($row['opciones']));

        return $resultado;
    }

    public function preguntasReportadas($sql)
    {
        return $this->database->select($sql);
    }

    public function delete($id){
        $sql = "DELETE FROM preguntas WHERE id = '$id'";
        return $this->database->query($sql);
    }

    public function deleteReport($sql){
        return $this->database->query($sql);
    }

    public function resolveInProgressReport($sql){
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