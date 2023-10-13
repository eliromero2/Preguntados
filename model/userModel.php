<?php

class userModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }
    public function registrar($nombre_completo, $ano_nacimiento, $sexo,$pais, $cuidad,$mail, $password,$user_name,$foto_perfil) {
        $sql = "INSERT INTO `users` ( `nombre_completo`, `ano_nacimiento`, `sexo`,`pais`,`ciudad`,`mail`,`password`,`user_name`,`imagen_path` ) VALUES ( '$nombre_completo', '$ano_nacimiento', '$sexo','$pais', '$cuidad','$mail', '$password', '$user_name','$foto_perfil');";
        Logger::info('Usuario registro: ' . $sql);

        $this->database->query($sql);
    }

    public function buscarUsuario($user_name,$password){
        $sql="SELECT * FROM users WHERE user_name = '$user_name' and password = '$password'";
        Logger::info('Se econtro el usuario: ' . $sql);

        $this->database->query($sql);

}

    public function validarUsuario($user_name,$password){
        $sql="SELECT * FROM users WHERE user_name = '$user_name' and password = '$password'";
        Logger::info('Se econtro el usuario: ' . $sql);

        $resultado = $this->database->query($sql);

        if (!$resultado || mysqli_num_rows($resultado) === 0) {
            Logger::info('NO econtro el usuario: ' . $sql);
            return false;
        }
        $user = mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);

        // Compara la contraseña ingresada con la contraseña almacenada en la base de datos.
        if ($password === $user['password']) {
            Logger::info('La contraseña es correcta');
            return true;

        } else {
            Logger::info('Contraseña incorrecta');
            return false;
        }
    }




}