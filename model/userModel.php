<?php

class userModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }
    public function registrar($nombre_completo, $ano_nacimiento, $sexo,$pais, $cuidad,$email, $password,$password_confirm, $nombre_usuario,$foto_perfil) {
        $sql = "INSERT INTO `pokemones` ( `nombre_completo`, `ano_nacimiento`, `sexo`,`pais`,`ciudad`,`mail`,`password`,`user_name`,`imagen_path` ) VALUES ( '$nombre_completo', '$ano_nacimiento', '$sexo','$pais', '$cuidad','$email', '$password','$password_confirm', '$nombre_usuario','$foto_perfil');";
        Logger::info('Usuario registro: ' . $sql);

        $this->database->query($sql);
    }


}