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
                if (isset ($_GET ['sort'])){
                    $columnas = $this->model->getColumnName();
                    $tituloValido=false;
                    foreach ($columnas as $columna){
                        if ($_GET ['sort'] == $columna->column_name){
                            $paramsGet['sort'] = $_GET['sort'];
                            $tituloValido=true;
                        }
                    }
                    if ($tituloValido==false){
                        $this->view->response("El título ingresado no existe", 404);
                        return;
                    }
                }
                if (isset ($_GET ['order'])){
                    if ($_GET ['order']=="asc"||$_GET ['order']=="desc"){
                        $paramsGet['order'] = $_GET['order'];
                    }else{
                        $this->view->response("Criterio de ordenamiento no válido (utilice: asc ó desc)", 404);
                        return;
                    }
                }
                if (isset ($_GET ['page'])){
                    if (is_numeric($_GET ['page']) && $_GET ['page'] >=1){
                        $paramsGet['page'] = $_GET['page'];
                    }else{
                        $this->view->response("Ingrese un número de página válido", 404);
                        return;
                    }
                }
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

            $bodega=$this->model->getBodegaById($id_bodega);
            if(!$bodega){
                $this->view->response('El id_bodega ' .$id_bodega. ' no existe', 404);
                return;
            }
            $cepa=$this->model->getCepaById($id_cepa);
            if(!$cepa){
                $this->view->response('El id_cepa ' .$id_cepa. ' no existe', 404);
                return;
            }

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

                $bodega=$this->model->getBodegaById($id_bodega);
                if(!$bodega){
                    $this->view->response('El id_bodega ' .$id_bodega. ' no existe', 404);
                    return;
                }
                $cepa=$this->model->getCepaById($id_cepa);
                if(!$cepa){
                    $this->view->response('El id_cepa ' .$id_cepa. ' no existe', 404);
                    return;
                }

                $this->model->updateVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa, $id);

                $this->view->response('El vino con id='.$id.' ha sido modificado.', 200);
            } else {
                $this->view->response('El vino con id='.$id.' no existe.', 404);
            }
        }
    }


