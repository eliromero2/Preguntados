<?php
class Sesion{

    static $preguntas = [];

    public static function setPreguntas(array $pregunta): void
    {
        array_push(self::$preguntas, $pregunta);
    }

    public static function getPreguntas(): array
    {
        return self::$preguntas;
    }


}
