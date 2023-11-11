<?php

require_once 'app/models/api.model.php';


class VinotecaModel extends Model {

    public function getAll($paramsGet) {
        $sql = 'SELECT ID_vino, Nombre, Tipo, Azucar, Nombre_cepa, Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega';
        $ex=[];
        if (isset($paramsGet['Nombre_bodega'])) {
            $sql .= ' WHERE Nombre_bodega = ?';
            $ex[] = $paramsGet['Nombre_bodega'];
            if (isset($paramsGet['Nombre_cepa'])) {
                $sql .= ' AND Nombre_cepa = ?';
                $ex[] = $paramsGet['Nombre_cepa'];
            }
            }else if (isset($paramsGet['Nombre_cepa'])) {
            
            $sql .= ' WHERE Nombre_cepa = ?';
            $ex[] = $paramsGet['Nombre_cepa'];
            }
        if (isset($paramsGet['sort'])) {
            $sql .= ' ORDER BY '  .$paramsGet['sort']; 

            if (isset($paramsGet['order'])) {
                $sql .= " ".$paramsGet['order'];
            }
        }
        if (isset($paramsGet['page'])){
            $cant = 10;
            $offset= $cant * ($paramsGet['page']-1);
            $sql .= ' LIMIT '.$cant .' OFFSET '.$offset;
        }
        $query = $this->db->prepare($sql);
        if (count($ex)==2){
                $query->execute([$ex[0], $ex[1]]);
            }else if (count($ex)==1) {
                $query->execute([$ex[0]]); 
            }else if(count($ex)==0){
               $query->execute();
            }
        $vinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }
    
    public function getVino($id) {
        $query= $this->db->prepare('SELECT ID_vino, Nombre, Tipo, Azucar, Nombre_cepa, Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega  WHERE `ID_vino` = ?');
        $query->execute([$id]);
        $vino= $query->fetch(PDO::FETCH_OBJ);

        return $vino;
    }
    
    public function getBodega($bodega) {
        $query= $this->db->prepare('SELECT * FROM `bodega`  WHERE `Nombre_bodega` = ?');
        $query->execute([$bodega]);
        $bodega= $query->fetch(PDO::FETCH_OBJ);

        return $bodega;
    }
    
    public function getCepa($cepa) {
        $query= $this->db->prepare('SELECT * FROM `cepa`  WHERE `Nombre_cepa` = ?');
        $query->execute([$cepa]);
        $cepa= $query->fetch(PDO::FETCH_OBJ);

        return $cepa;
    }

    public function getColumnName() {
        $query= $this->db->prepare('SELECT column_name from information_schema.columns where TABLE_SCHEMA = ?');
        $query->execute(["db_vinoteca"]);
        $columnas= $query->fetchAll(PDO::FETCH_OBJ);

        return $columnas;
    }

    public function updateVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa, $id) {    
        $query = $this->db->prepare('UPDATE `vino` SET Nombre=?, Tipo=?, Azucar=?, id_cepa=?, id_bodega =? WHERE ID_vino = ?');
        $query->execute([$Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa, $id]);
    }

    public function deleteVino($id){
        $query = $this->db->prepare('DELETE FROM `vino` WHERE ID_vino = ?');
        $query->execute([$id]);
    }

    public function insertVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa){
        $query = $this->db->prepare('INSERT INTO `vino` (Nombre, Tipo, Azucar, id_bodega, id_cepa) VALUES(?,?,?,?,?)');
        $query->execute([$Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa]);

        return $this->db->lastInsertId();
    }

}