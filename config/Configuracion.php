<?php
include_once('helper/Database.php');
include_once('helper/Render.php');
include_once('helper/MustacheRender.php');
include_once("helper/Router.php");
include_once("helper/Logger.php");
include_once('helper/Redirect.php');
include_once('helper/Request.php');

include_once('controller/LoginController.php');
include_once('controller/RegistroController.php');
include_once('controller/HomeController.php');
include_once('controller/JuegoController.php');
include_once('controller/PreguntaController.php');
include_once('controller/RankingController.php');
include_once('controller/PartidaController.php');

include_once("model/userModel.php");
include_once("model/preguntaModel.php");
include_once("model/partidaModel.php");

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
            $config['dbname'],
            $config['port']
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

    public function getLoginController() {
        $model = new userModel($this->getDatabase());
        return new LoginController($this->getRender(), $model);
    }
    public function getHomeController() {
        $model = new userModel($this->getDatabase());
        $partida = new partidaModel($this->getDatabase());
        return new HomeController($this->getRender(), $model, $partida);
    }

    public function getJuegoController() {
        $user = new userModel($this->getDatabase());
        $pregunta = new preguntaModel($this->getDatabase());
        $partida = new partidaModel($this->getDatabase());

        return new JuegoController($this->getRender(), $user, $pregunta,$partida);
    }

    public function getPreguntaController() {
        $user = new userModel($this->getDatabase());
        $pregunta = new preguntaModel($this->getDatabase());

        return new PreguntaController($this->getRender(), $user, $pregunta);
    }

    public function getRankingController() {
        $user = new userModel($this->getDatabase());
        $partida = new partidaModel($this->getDatabase());

        return new RankingController($this->getRender(), $user, $partida);
    }

    public function getPartidaController() {
        $user = new userModel($this->getDatabase());
        $partida = new partidaModel($this->getDatabase());

        return new PartidaController($this->getRender(), $user, $partida);
    }




    public function getRouter() {
       return new Router($this,"getHomeController","list");
    }
}
