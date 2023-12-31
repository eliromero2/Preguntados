<?php

class userModel{


    private $database;
    private $partidaService;
    public $attributes = ['nombre_completo', 'ano_nacimiento','sexo','mail', 'password', 'user_name', 'lat', 'lng', 'direccion'];

    public function __construct($database, $partidaService){
        $this->database = $database;
        $this->partidaService = $partidaService;
    }
    public function registrar($nombre_completo, $ano_nacimiento, $sexo,$email, $password,$user_name,$foto_perfil,$lat,$lng,$direccion) {
        $sql = "INSERT INTO `users` ( `nombre_completo`, `ano_nacimiento`, `sexo`,`mail`,`password`,`user_name`,`imagen_path`,`lat`,`lng`,`direccion` ) VALUES ( '$nombre_completo', '$ano_nacimiento', '$sexo','$email', '$password', '$user_name','$foto_perfil','$lat','$lng','$direccion');";
        Logger::info('Usuario registro: ' . $sql);

        $this->database->query($sql);
    }
    public function userExists($user_name) {
        $sql = "SELECT COUNT(*) as count FROM users WHERE user_name = '$user_name'";
        $result = $this->database->query($sql);

        if ($result && $result->numRows() > 0) {
            $row = $result->fetchAssoc();
            return $row['count'] > 0;
        }

        return false;
    }

    public function buscarUsuario($user_name,$password){
        $sql="SELECT * FROM users WHERE user_name = '$user_name'";
    $this->database->query($sql);

}

    public function validarUsuario($user_name, $password){
        $sql="SELECT * FROM users WHERE user_name = '$user_name'";
        $resultado = $this->database->select($sql);

        $response = [];

        if (!$resultado || count($resultado) === 0) {
            $response["error"] = "Credenciales invalidas";
            return $response;
        }

        $user = $resultado;
     
        $_SESSION["user"] = $user[0];
        $response['user'] = $user[0];
        return $response;
    }

    public function getCurrentSession(){
        $data['user'] = $_SESSION['user'] ?? null;

        if(isset($data['user']['id'])){
            $data['puntaje'] = $this->partidaService->getPuntajeUser($data['user']['id']);
        }

        $data['nivel'] = $this->partidaService->getNivelUsuario($data['user']['id']);

        return $data;
    }

    public function getUserById($id){
        $sql = "SELECT * FROM users WHERE id = $id";
        $resultado = $this->database->select($sql);
        return $resultado;
    }

    public function getByUserName($sql){
        $resultado = $this->database->select($sql);
        return $resultado;
    }

    public function getUsuarios(){
        $sql = "SELECT * FROM users";
        $resultado = $this->database->select($sql);
        return $resultado;
    }

    public function getEdadUsuarios(){
        $sql="SELECT 
                    nombre_completo,
                    YEAR(CURDATE()) - ano_nacimiento AS edad
                  FROM users";
        $resultado = $this->database->select($sql);

        return $resultado;

    }


}