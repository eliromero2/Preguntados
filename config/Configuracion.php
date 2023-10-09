<?php
include_once('helper/Database.php');
include_once('helper/Render.php');
include_once('helper/MustacheRender.php');
include_once("helper/Router.php");
include_once("helper/Logger.php");
include_once('helper/Redirect.php');

include_once('controller/loginController.php');
include_once('controller/RegistroController.php');
include_once("model/userModel.php");

include_once('third-party/mustache/src/Mustache/Autoloader.php');

class Configuracion {
    public function __construct() {
    }

    public function getDatabase() {
        $config = parse_ini_file('configuration.ini');
        $database = new Database(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['dbname']
        );
        return $database;
    }

    public function getRender() {
        return new MustacheRender();
    }


    public function getRegistroController() {
        $model = new userModel($this->getDatabase());
        return new RegistroController($this->getRender(), $model);
    }

    public function getRouter() {
       return new Router($this,"getRegistroController","registro");
    }
}
