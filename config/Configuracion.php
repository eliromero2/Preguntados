<?php
include_once('helper/Database.php');
include_once('helper/Render.php');
include_once('helper/MustacheRender.php');
include_once("helper/Router.php");
include_once("helper/Logger.php");
include_once('helper/Redirect.php');
include_once('helper/Request.php');
include_once('helper/Mailer.php');
include_once('helper/Sesion.php');

include_once('controller/LoginController.php');
include_once('controller/RegistroController.php');
include_once('controller/HomeController.php');
include_once('controller/JuegoController.php');
include_once('controller/PreguntaController.php');
include_once('controller/RankingController.php');
include_once('controller/PartidaController.php');
include_once('controller/AdminController.php');

include_once("model/userModel.php");
include_once("model/preguntaModel.php");
include_once("model/partidaModel.php");

include_once('services/PartidaService.php');
include_once('services/PreguntaService.php');
include_once('services/UsuarioService.php');


include_once('third-party/mustache/src/Mustache/Autoloader.php');
include_once('third-party/phpmailer/src/PHPMailer.php');
include_once('third-party/phpmailer/src/SMTP.php');
include_once('third-party/phpmailer/src/Exception.php');


class Configuracion {

    private $models;
    private $controllers;
    private $services;
    public function __construct() {
        $this->models = [
            'user' => 'userModel',
            'pregunta' => 'preguntaModel',
            'partida' => 'partidaModel',
            'categoria' => 'categoriaModel'
        ];

        $this->services = [
            'UsuarioService' => ['model' => ['user']],
            'PreguntaService' => [ 'model' => ['pregunta']],
            'PartidaService' => [ 'model' => ['partida']],
            'CategoriaService' => [ 'model' => ['categoria']]
        ];

        $this->controllers = [
            'RegistroController' => ['render', 'mailer' ,'service' => ['UsuarioService']],
            'LoginController' => ['render', 'service' => ['UsuarioService']],
            'HomeController' => ['render', 'service' => ['UsuarioService', 'PartidaService']],
            'JuegoController' => ['render', 'service' => ['UsuarioService', 'PreguntaService', 'PartidaService']],
            'PreguntaController' => ['render', 'service' => ['UsuarioService', 'PreguntaService','PartidaService']],
            'RankingController' => ['render', 'service' => ['UsuarioService', 'PartidaService']],
            'PartidaController' => ['render', 'service' => ['UsuarioService', 'PartidaService']],
            'AdminController' => ['render', 'service' => ['UsuarioService', 'PreguntaService']],
            'ApiController' => ['render', 'service' => ['CategoriaService', 'TipoService']],
        ];
    }

    public function getDatabase() {
        $config = parse_ini_file('configuration.ini');
        $database = new Database(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['dbname'],
            $config['port'] ?? 3306
        );
        return $database;
    }

    public function getMailer() {
        $config = parse_ini_file('configuration.ini');
        $mailer = new Mailer(
            $config['mailer_user'],
            $config['mailer_password'],
            $config['mailer_port'],
            $config['mailer_host']
        );
        return $mailer;
    }

    public function getPartidaService(){
        $model = new partidaModel($this->getDatabase());
        return new PartidaService($model);
    }

    public function getRender() {
        return new MustacheRender();
    }

    public function getModel($modelName){
    
        if (array_key_exists($modelName, $this->models)) {
            $className = $this->models[$modelName];
            switch ($modelName) {
                case 'user':
                    return new $className($this->getDatabase(), $this->getPartidaService());
                default:
                    return new $className($this->getDatabase());
            }
        }
    
        Logger::dd("El modelo ($modelName) no esta declarado en el proyecto");
    }


    public function getService($serviceName) {
    
        if (!isset($this->services[$serviceName])) {
            Logger::dd("El servicio ($serviceName) no esta declarado en el proyecto");
        }
    
        $classData = $this->services[$serviceName];
        $models = [];
    
        foreach ($classData['model'] as $modelName) {
            $model = $this->getModel($modelName);
            $models[] = $model;
        }
    
        return new $serviceName(...$models);
    }


    public function getController($controllerName) {
    
        if (!isset($this->controllers[$controllerName])) {
            Logger::dd("El controlador ($controllerName) no esta declarado en el proyecto");
        }
    
        $classData = $this->controllers[$controllerName];
        $services = [];
    
        foreach ($classData['service'] as $serviceName) {
            $service = $this->getService($serviceName);
            $services[] = $service;
        }

        if($controllerName == 'RegistroController'){
            return new $controllerName($this->getRender(),$this->getMailer(),...$services);
        }else{
            return new $controllerName($this->getRender(),...$services);
        }
    }

    public function getRouter() {
       return new Router($this,"HomeController","list");
    }
}
