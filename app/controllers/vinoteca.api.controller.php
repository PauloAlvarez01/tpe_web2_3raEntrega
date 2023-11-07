<?php
    require_once 'app/controllers/api.controller.php';

    require_once 'app/models/vinoteca.api.model.php';

    class VinotecaApiController extends ApiController {
        private $model;

        function __construct() {
            parent::__construct();
            $this->model = new VinotecaModel();
        }

        function get($params = []) {
            if (empty($params)){
                
                $vinos = $this->model->getVinos();
                $this->view->response($vinos, 200);
            } else {
                $vino = $this->model->getVino($params[':ID']);
                if(!empty($vino)) {
                    if($params[':subrecurso']) {
                        switch ($params[':subrecurso']) {
                            case 'nombre':
                                $this->view->response($vino->Nombre, 200);
                                break;
                            case 'cepa':
                                $this->view->response($vino->Nombre_cepa, 200);
                                break;
                            case 'bodega':
                                $this->view->response($vino->Nombre_bodega, 200);
                                break;
                                
                            default:
                            $this->view->response(
                                'El vino no contiene '.$params[':subrecurso'].'.'
                                , 404);
                                break;
                        }
                    } else
                        $this->view->response($vino, 200);
                } else {
                    $this->view->response(
                        'El vino con el id='.$params[':ID'].' no existe.'
                        , 404);
                }
            }
        }

        function delete($params = []) {
            $id = $params[':ID'];
            $tarea = $this->model->getTask($id);

            if($tarea) {
                $this->model->deleteTask($id);
                $this->view->response('La tarea con id='.$id.' ha sido borrada.', 200);
            } else {
                $this->view->response('La tarea con id='.$id.' no existe.', 404);
            }
        }

        function create($params = []) {
            $body = $this->getData();

            $titulo = $body->titulo;
            $descripcion = $body->descripcion;
            $prioridad = $body->prioridad;

            $id = $this->model->insertTask($titulo, $descripcion, $prioridad);

            $this->view->response('La tarea fue insertada con el id='.$id, 201);
        }

        function update($params = []) {
            $id = $params[':ID'];
            $tarea = $this->model->getTask($id);

            if($tarea) {
                $body = $this->getData();
                $titulo = $body->titulo;
                $descripcion = $body->descripcion;
                $prioridad = $body->prioridad;
                $this->model->updateTaskData($id, $titulo, $descripcion, $prioridad);

                $this->view->response('La tarea con id='.$id.' ha sido modificada.', 200);
            } else {
                $this->view->response('La tarea con id='.$id.' no existe.', 404);
            }
        }
    }


