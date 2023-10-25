<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
include_once("config/Configuracion.php");

$configuracion = new Configuracion();
$router = $configuracion->getRouter();

$controller = ($_GET['controller'] && $_GET['controller'] != '') ?$_GET['controller'] : "home";
$method = $_GET['method'] ?? 'list';

//Logger::dd($controller, $method, $_GET);


$router->route($controller, $method);