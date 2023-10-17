<?php
class LobbyController {
    private $userModel;
    private $partidasModel;

    private $render;

    public function __construct($userModel, $partidasModel) {
        $this->userModel = $userModel;
        $this->partidasModel = $partidasModel;
    }

    public function mostrarLobby($id) {
        // Recupera información del usuario
        $userData = $this->userModel->getUserData($id); // Implementa esta función en tu modelo

        // Comprueba si el usuario existe
        if (!$userData) {
            // Manejar el caso en el que el usuario no existe
            die("Usuario no encontrado.");
        }

        // Recupera las partidas del usuario
        $partidas = $this->partidasModel->getPartidas($id); // Implementa esta función en tu modelo

        // Calcula el puntaje total del usuario
        $puntajeTotal = $this->partidasModel->getPuntajeTotal($id); // Implementa esta función en tu modelo

        // Carga una vista y pasa los datos
        include 'vista_lobby.php'; // Asegúrate de que tengas una vista adecuada para mostrar los datos

        // Puedes utilizar $userData, $partidas y $puntajeTotal en tu vista
    }
}

// Uso del controlador
$userModel = new UserModel(); // Reemplaza con tu clase de modelo de usuario
$partidasModel = new PartidasModel(); // Reemplaza con tu clase de modelo de partidas
$lobbyController = new LobbyController($userModel, $partidasModel);

if (isset($_GET['user_id'])) {
    $id = $_GET['user_id']; // Asegúrate de validar y sanear esta entrada
    $lobbyController->mostrarLobby($id);
} else {
    // Manejar el caso en el que no se proporciona un ID de usuario
    die("ID de usuario no proporcionado.");
}