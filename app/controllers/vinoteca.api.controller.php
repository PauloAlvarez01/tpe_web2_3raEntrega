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
                $parametro=[];
                if (isset ($_GET ['bodega'])){
                    $parametro=$_GET ['bodega'];
                    $vinos = $this->model->getVinosPorBodega($parametro);
                }else if (isset ($_GET ['cepa'])){
                    $parametro=$_GET ['cepa'];
                    $vinos = $this->model->getVinosPorCepa($parametro);
                }else if (isset ($_GET ['sort']) && isset ($_GET ['order'])){
                    $parametro['sort']=$_GET ['sort'];
                    $parametro['order']=$_GET ['order'];
                    $vinos = $this->model->getVinosPorCriterioOrdenado($parametro);
                }else if (isset ($_GET ['page']) && is_numeric($_GET ['page'])) {
                    $parametro=$_GET ['page'];
                    $vinos = $this->model->getVinosPage($parametro);
                
                }else{
                    $vinos = $this->model->getVinos();
                }
                $this->view->response($vinos, 200);
            } else {
                $vino = $this->model->getVino($params[':ID']);
                if(!empty($vino) && empty($params[':subrecurso'])) {
                    $this->view->response($vino, 200);
                }else if(!empty($vino)){
                    $subrecurso = $params[':subrecurso'];
                    if (isset($vino->$subrecurso)) {
                        $this->view->response($vino->$subrecurso, 200);
                    } else {
                        $this->view->response("Subrecurso no existe", 404);
                    }
                } else {    
                    $this->view->response('El vino con el id='.$params[':ID'].' no existe.', 404);
                }
            }
        }

        function get2($params = []) {
            if (empty($params)){
                $paramsGet=[];
                if (isset($_GET['Nombre_bodega'])){
                    $bodega=$this->model->getBodega($_GET['Nombre_bodega']);
                    if($bodega){
                        $paramsGet['Nombre_bodega'] = $_GET['Nombre_bodega'];
                    }else{
                        $this->view->response("La bodega ingresada no existe", 404);
                        return;
                    }
                }
                if (isset($_GET['Nombre_cepa'])){
                    $cepa=$this->model->getCepa($_GET['Nombre_cepa']);
                    if($cepa){
                        $paramsGet['Nombre_cepa'] = $_GET['Nombre_cepa'];
                    }else{
                        $this->view->response("La cepa ingresada no existe", 404);
                        return;
                    }
                }
                //if (isset ($_GET ['sort'])) && ($_GET ['sort']) == 


                
                    
                
                
                
                $vinos = $this->model->getAll($paramsGet);
                $this->view->response($vinos, 200);
            } else {
                $vino = $this->model->getVino($params[':ID']);
                if(!empty($vino) && empty($params[':subrecurso'])) {
                    $this->view->response($vino, 200);
                }else if(!empty($vino)){
                    $subrecurso = $params[':subrecurso'];
                    if (isset($vino->$subrecurso)) {
                        $this->view->response($vino->$subrecurso, 200);
                    } else {
                        $this->view->response("Subrecurso no existe", 404);
                    }
                } else {    
                    $this->view->response('El vino con el id='.$params[':ID'].' no existe.', 404);
                }
            }
        }

        function delete($params = []) {
            $id = $params[':ID'];
            $vino = $this->model->getVino($id);

            if($vino) {
                $this->model->deleteVino($id);
                $this->view->response('El vino con id='.$id.' ha sido borrado.', 200);
            } else {
                $this->view->response('El vino con id='.$id.' no existe.', 404);
            }
        }

        function create($params = []) {
            $body = $this->getData();

            $Nombre = $body->Nombre;
            $Tipo = $body->Tipo;
            $Azucar = $body->Azucar;
            $id_bodega = $body->id_bodega;
            $id_cepa = $body->id_cepa;

            $id = $this->model->insertVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa);

            $this->view->response('El vino fue insertado con el id='.$id, 201);
        }

        function update($params = []) {
            $id = $params[':ID'];
            $vino = $this->model->getVino($id);

            if($vino) {
                $body = $this->getData();

                $Nombre = $body->Nombre;
                $Tipo = $body->Tipo;
                $Azucar = $body->Azucar;
                $id_bodega = $body->id_bodega;
                $id_cepa = $body->id_cepa;
                $this->model->updateVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa, $id);

                $this->view->response('El vino con id='.$id.' ha sido modificado.', 200);
            } else {
                $this->view->response('El vino con id='.$id.' no existe.', 404);
            }
        }
    }


