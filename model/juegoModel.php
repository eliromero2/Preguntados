<?php

class juegoModel{

    private $database;
    public function __construct($database){
        $this->database = $database;
    }
    public function registrar($nombre_completo, $ano_nacimiento, $sexo,$mail, $password,$user_name,$lat, $lng, $direccion) {
        $sql = "INSERT INTO `users` ( `nombre_completo`, `ano_nacimiento`, `sexo`,`mail`,`password`,`user_name`,`imagen_path`,`lat`,`lng`,`direccion` ) 
                VALUES ( '$nombre_completo', '$ano_nacimiento', '$sexo','$mail', '$password', '$user_name','$foto_perfil','$lat','$lng','$direccion')";
        Logger::info('Usuario registro: ' . $sql);

        $this->database->query($sql);
    }

    public function buscarUsuario($user_name,$password){
        $sql="SELECT * FROM users WHERE user_name = '$user_name'";
         $this->database->select($sql);

}

    public function validarUsuario($user_name, $password){
        $sql="SELECT * FROM users WHERE user_name = '$user_name'";
        $resultado = $this->database->select($sql);

        if (!$resultado || count($resultado) === 0) {
            Logger::info('NO econtro el usuario: ' . $sql);
            return false;
        }

        $user = $resultado;
        Logger::info(print_r($user,true));

        // Compara la contraseña ingresada con la contraseña almacenada en la base de datos.
        if ($password === $user[0]['password']) {
            Logger::info('La contraseña es correcta');
            $_SESSION["user"] = $user[0];
            return true;

        } else {
           $_SESSION['error']= "Credenciales Incorrectas";
           unset($_SESSION['error']);
            return false;
        }
    }


}