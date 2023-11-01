<?php
class AdminController{

    private $userService;
    private $preguntaService;

    private $render;
    private $data;

    public function __construct($render, $userService, $preguntaService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->preguntaService = $preguntaService;
        $this->data = [
            "userSession" => $this->userService->getCurrentSession(),
            "error" => $_SESSION['error'] ?? null
        ];
    }

    public function list() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = $_SESSION['error'];
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

        //Logger::dd($data['preguntas'][0]);
        
        $this->render->adminView($userRow,'admin/preguntas', $data);
    }

    public function pregunta() {
        $this->data['pregunta'] = $this->preguntaService->getPregunta($_GET["params"]);
        $this->data['action'] = '/admin/editarPregunta/'.$this->data["pregunta"]["pregunta_id"];

        $this->data['submitText'] = 'Editar pregunta';

        $userRow = $this->data['userSession']['user'];
        unset($_SESSION['error']);

        //Logger::dd($this->data['pregunta']['opciones']);
        $this->render->adminView($userRow,'admin/pregunta', $this->data);
    }

    public function editarPregunta() {
        $data['userSession'] = $this->userService->getCurrentSession();
         $this->preguntaService->updatePregunta($_POST);
        $data['error'] = $_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);

        //Logger::dd($data['pregunta']);
        
        $this->render->adminView($userRow,'admin/editarPregunta', $data);
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