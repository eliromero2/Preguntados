<?php
session_start();
include_once ("config/Configuracion.php");

$configuracion = new Configuracion();
$router = $configuracion->getRouter();

$controller = isset($_GET['controller']) ? $_GET['controller'] : "home";
$method = isset($_GET['method']) ? $_GET['method'] : 'registrar';

$router->route($controller, $method);