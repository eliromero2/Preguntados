<?php
require 'third-party/phpqrcode/qrlib.php';

class QRcode {
    private $tamanio;
    private $level;
    private $rutaBase;

    public function __construct($tamanio = 10, $level = 'Q', $rutaBase = 'public/qr/') {
        $this->tamanio = $tamanio;
        $this->level = $level;
        $this->rutaBase = $rutaBase;

        if (!file_exists($rutaBase)) {
            mkdir($rutaBase);
        }
    }

    public function generarQR($datos, $nombreArchivo) {
        $rutaArchivo = $this->rutaBase . $nombreArchivo . '.png';

        QRcode::png($datos, $rutaArchivo, $this->level, $this->tamanio);

        return $rutaArchivo;
    }

}