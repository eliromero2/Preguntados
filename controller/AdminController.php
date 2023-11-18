<?php
class AdminController{

    private $userService;
    private $preguntaService;
    private $opcionService;

    private $render;
    private $data;

    public function __construct($render, $userService, $preguntaService,$opcionService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->preguntaService = $preguntaService;
        $this->opcionService = $opcionService;
        $this->data = [
            "userSession" => $this->userService->getCurrentSession(),
            "error" => $_SESSION['error'] ?? null,
            "success" => $_SESSION['success'] ?? null
        ];
    }

    public function list() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = @$_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }

    public function preguntas() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['preguntas'] = $this->preguntaService->getPreguntas();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];

        unset($_SESSION['error']);
        unset($_SESSION['success']);
        
        $this->render->adminView($userRow,'admin/preguntas', $data);
    }

    public function pregunta() {
        $this->data['pregunta'] = $this->preguntaService->getPregunta($_GET["params"]);
        $this->data['modulos'] = $this->preguntaService->getAllModules();
        $this->data['tipos'] = $this->preguntaService->getAllTypes();
        $this->data['dificultades'] = $this->preguntaService->getAllLevels();

        $this->data['action'] = '/admin/editarPregunta/'.$this->data["pregunta"]["pregunta_id"];
        $this->data['submitText'] = 'Editar pregunta';

        $userRow = $this->data['userSession']['user'];
        unset($_SESSION['error']);

        $this->render->adminView($userRow,'admin/pregunta', $this->data);
    }

    public function crearPregunta() {
        $this->data['action'] = '/admin/crearPregunta';
        $this->data['submitText'] = 'Crear pregunta';
        $this->data['modulos'] = $this->preguntaService->getAllModules();
        $this->data['tipos'] = $this->preguntaService->getAllTypes();
        $this->data['dificultades'] = $this->preguntaService->getAllLevels();

        $userRow = $this->data['userSession']['user'];

        $this->render->adminView($userRow,'admin/pregunta', $this->data);
    }

    public function eliminarPregunta() {
        $opciones = $this->opcionService->deleteOpciones($_GET['params']);
        $pregunta = $this->preguntaService->deletePregunta($_GET['params']);

        $userRow = $this->data['userSession']['user'];

        $this->render->adminView($userRow,'admin', $this->data);
    }

    public function usuarios() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }

    public function categorias() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);
        
        $this->render->adminView($userRow,'admin/index', $data);
    }

    public function test(){
        $modelRespose = $this->preguntaService->getPregunta("1");
        echo json_encode(['userSession' => $modelRespose]);
    }
}
