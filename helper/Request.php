<?php

class Request {

    public static function validate($data, $need = []) {

        $valid = true;

        foreach($need as $attr){
            $valid = !empty($data[$attr]);
        }

        if(!$valid){
            $_SESSION["error"] = "Alguno de los campos era erroneo o vacio";
            Redirect::to('/registro');
        }
    }
}