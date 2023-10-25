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
        return $this->model->getCurrentSession();
    }

}