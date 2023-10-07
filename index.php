<?php
session_start();
include_once ("config/Configuracion.php");

$configuracion = new Configuracion();
$router = $configuracion->getRouter();

$controller = $_GET['controller'] ?? "home";/*CAMBIARRRRR*/
$method = $_GET['method'] ?? 'listar';/*CAMBIARRRRR*/

$router->route($controller, $method);