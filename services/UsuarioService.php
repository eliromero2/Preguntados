<?php
class UsuarioService
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getPuntajeUser($id){
        return $this->model->getPuntajeUser($id);
    }

    public function getCurrentSession(){
        $modelResponse = $this->model->getCurrentSession();
        $modelResponse["isAdmin"] = @$modelResponse["user"]["rol"] === "ADMIN";
        return $modelResponse;
    }

    public function validarUsuario($user_name,$password){
        $modelResponse = $this->model->validarUsuario($user_name,$password);
        $modelResponse["isAdmin"] = $modelResponse["user"]["rol"] === "ADMIN"; 
        
        return $modelResponse;
    }

    public function registrar($nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$mail,$password,$user_name,$image_path,$lat,$lng,$direccion){
        $data = [$nombre_completo,$ano_nacimiento,$sexo,$pais,$ciudad,$mail,$password,$user_name,$image_path,$lat,$lng,$direccion];

        $modelResponse = $this->model->registrar(...$data);

        return $modelResponse;
    }

    public function getUserById($id){
        $modelResponse=$this->model->getUserById($id);
        return $modelResponse;
    }

}