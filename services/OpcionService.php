<?php

class OpcionService
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function deleteOpciones($idPregunta){
        return $this->model->delete($idPregunta);
    }

    public function getOpciones($idPregunta){
        return $this->model->getOpciones($idPregunta);
    }

    public function updateOpciones($data){
        $jsonData = json_decode($data);

        $dataToModel = new stdClass();
        $dataToModel->opciones = $jsonData->respuestas;
        $dataToModel->respuesta_correcta = $jsonData->repuesta_correcta;
        $dataToModel->id_pregunta = $jsonData->pregunta_id;

        $updateOptions = $this->model->updateOpciones($dataToModel);
        //Logger::info("updateOptions: ". print_r($updateOptions,true));

        if(boolval($updateOptions)){
            $_SESSION['success'] = 'Opciones actualizadas!';
        }else{
            $_SESSION['error'] = 'Opciones no actualizadas!';
        }

       return $updateOptions;
    }
    public function createOpciones($data, $isSugerir = false){
        $dataToModel = new stdClass();
        $dataToModel->opciones = $data->respuestas;
        $dataToModel->respuesta_correcta = $data->repuesta_correcta;
        $dataToModel->id_pregunta = $data->pregunta_id;
        $createOptions = $this->model->createOpciones($dataToModel, $isSugerir);

        if(boolval($createOptions)){
            $_SESSION['success'] = 'Pregunta y Opciones creadas!';
        }else{
            $_SESSION['error'] = 'Pregunta y Opciones no creadas!';
        }

        return $createOptions;
    }
}