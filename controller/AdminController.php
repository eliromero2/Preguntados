<?php
require('third-party/fpdf/fpdf.php');
class AdminController{

    private $userService;
    private $preguntaService;
    private $opcionService;

    private $partidaService;

    private $render;
    private $data;


    public function __construct($render, $userService, $preguntaService,$opcionService,$partidaService) {
        $this->render = $render;
        $this->userService = $userService;
        $this->preguntaService = $preguntaService;
        $this->opcionService = $opcionService;
        $this->partidaService=$partidaService;
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
        $this->data['reportId'] = $_GET['reportId'];

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
        $data['error'] = @$_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);

        $data['usuarios']=$this->userService->getUsuarios();
        
        $this->render->adminView($userRow,'admin/usuarios', $data);
    }

    public function categorias() {
        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = @$_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);

        $data['categorias']=$this->preguntaService->getModules();
        
        $this->render->adminView($userRow,'admin/categorias', $data);
    }

    public function sugerencias(){
        $data['userSession'] = $this->userService->getCurrentSession();
        $userRow = $data['userSession']['user'];

        $data['sugerencias'] = $this->preguntaService->getSugerencias();

        $data['reportes'] = $this->preguntaService->getReportes();

        $data['success'] = @$_SESSION['success'];
        $data['error'] = @$_SESSION['error'];

        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->render->adminView($userRow,'admin/sugerencias', $data);
    }

    public function reporte(){

        $data['userSession'] = $this->userService->getCurrentSession();
        $data['error'] = @$_SESSION['error'];
        $userRow = $data['userSession']['user'];
        unset($_SESSION['error']);


        $this->render->adminView($userRow,'admin/chart', $data);
    }

    public function createPDF(){

        $ranking=$this->partidaService->getPartidasPDF();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        //Header
        $pdf->Cell(60);
        $pdf->Cell(70,10,'Registro del ranking',0,0,'C');
        $pdf->Ln(20);
        $pdf->Cell(70,10,'Identidicador del usuario',1,0,'C',0);
        $pdf->Cell(70,10,'Usuario',1,0,'C',0);
        $pdf->Cell(45,10,'Puntaje',1,1,'C',0);

        //Contenido

        foreach ($ranking as $row) {

            $pdf->Cell(70, 10, $row['user_id'], 1, 0, 'C', 0);
            $pdf->Cell(70, 10, $row['name'], 1, 0, 'C', 0);
            $pdf->Cell(45, 10, $row['puntaje'], 1, 1, 'C', 0);

        }

        ob_end_clean();
        $pdf->Output();

    }
}
