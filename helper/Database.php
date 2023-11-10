<?php

class Database {
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->conn = mysqli_connect($servername, $username, $password, $dbname, $port);

        if(!$this->conn) {
            Logger::error("Error al ingresar a la base de datos con: $servername, $username, $password, $dbname");
            exit();
        }

        // Configura la codificación de caracteres
        mysqli_set_charset($this->conn, "utf8");

    }

    public function __destruct() {
        mysqli_close($this->conn);
    }


    public function query($sql) {
        $result = mysqli_query($this->conn, $sql);
        
        if ($result === false) {
            $_SESSION['error'] = 'El sql fallo: $sql';
            return false;
        }
        return $result;
    }
    

    public function select($sql) {
        $result = mysqli_query($this->conn, $sql);

        if ($result === false) {
            // Handle error, return false, or throw an exception
            $_SESSION['error'] = 'El sql fallo: $sql';
            return false;
        }

        $rows = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
       
    }

}
