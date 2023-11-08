<?php

require_once 'app/models/api.model.php';


class VinotecaModel extends Model {

    //se usa para api
    public function getVinos() {
        $query = $this->db->prepare('SELECT ID_VINO, Nombre, Tipo, Azucar, Nombre_cepa, Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega' );
        $query->execute();
        $vinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }

    //se usa para api
    public function getVinosPage($parametro) {
        $cant = 10;
        $offset= $cant * ($parametro-1);
        $query = $this->db->prepare('SELECT ID_VINO, Nombre, Tipo, Azucar, Nombre_cepa, Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega LIMIT '.$cant.' OFFSET '.$offset.' ' );
        $query->execute();
        $vinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }

    /*
    public function getAll($paramsGet) {
        $sql = 'SELECT a.ID_VINO, a.Nombre, a.Tipo, a.Azucar, b.Nombre_cepa, c.Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega';
        $ex = [];

        if (isset($paramsGet['order'])) {
            
            $sql += " ORDER BY " + $paramsGet['order']; 
        } 

        if (isset($paramsGet['bodega'])) {
            
            $sql += " WHERE bodega = :bodega";
            $ex[] =  ['bodega' => $paramsGet['bodega']];
        } 


        $where = ['bodega', 'cepa', 'nombre'];
    }
    */

    //se usa para api
    public function getVino($id) {
        $query= $this->db->prepare('SELECT ID_VINO, Nombre, Tipo, Azucar, Nombre_cepa, Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega  WHERE `ID_vino` = ?');
        $query->execute([$id]);
        $vino= $query->fetch(PDO::FETCH_OBJ);

        return $vino;
    }

    //se usa para api
    public function getVinosPorBodega($bodega) {
        $query = $this->db->prepare('SELECT a.ID_VINO, a.Nombre, a.Tipo, a.Azucar, b.Nombre_cepa, c.Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega WHERE Nombre_bodega = ?' );
        $query->execute([$bodega]);
        $vinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }

    //se usa para api
    public function getVinosPorCepa($cepa) {
        $query = $this->db->prepare('SELECT a.ID_VINO, a.Nombre, a.Tipo, a.Azucar, b.Nombre_cepa, c.Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega WHERE Nombre_cepa = ?' );
        $query->execute([$cepa]);
        $vinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }

    //se usa para api
    public function getVinosPorCriterioOrdenado($parametro) {
        $query = $this->db->prepare('SELECT a.ID_VINO, a.Nombre, a.Tipo, a.Azucar, b.Nombre_cepa, c.Nombre_bodega FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa INNER JOIN `bodega` c ON a.id_bodega = c.id_bodega ORDER BY ' .$parametro['sort']. ' ' .$parametro['order']. '');
        $query->execute();
        $vinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }            
    public function getBodega($id) {
        $query= $this->db->prepare('SELECT * FROM `bodega`  WHERE `id_bodega` = ?');
        $query->execute([$id]);
        $bodega= $query->fetch(PDO::FETCH_OBJ);

        return $bodega;
    }

    public function getBodegas() {
        $query= $this->db->prepare('SELECT id_bodega, Nombre_bodega FROM `bodega`');
        $query->execute();
        $bodegas= $query->fetchAll(PDO::FETCH_OBJ);

        return $bodegas;
    }
    

    public function getCepa($id) {
        $query= $this->db->prepare('SELECT * FROM `cepa`  WHERE `id_cepa` = ?');
        $query->execute([$id]);
        $cepa= $query->fetch(PDO::FETCH_OBJ);

        return $cepa;
    }

    public function getCepas() {
        $query= $this->db->prepare('SELECT id_cepa, Nombre_cepa FROM `cepa`');
        $query->execute();
        $cepas= $query->fetchAll(PDO::FETCH_OBJ);

        return $cepas;
    }

    public function getVinosPorBodegaID($id) {
        $query= $this->db->prepare('SELECT a.*, b.id_cepa, b.Nombre_cepa FROM `vino` a INNER JOIN `cepa` b ON a.id_cepa = b.id_cepa  WHERE a.id_bodega = ?');
        $query->execute([$id]);
        $vinos= $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }

    public function getVinosPorCepaID($id) {
        $query= $this->db->prepare('SELECT a.*, b.id_bodega, b.Nombre_bodega FROM `vino` a INNER JOIN `bodega` b ON a.id_bodega = b.id_bodega  WHERE a.id_cepa = ?');
        $query->execute([$id]);
        $vinos= $query->fetchAll(PDO::FETCH_OBJ);

        return $vinos;
    }

    //se usa para api
    public function updateVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa, $id) {    
        $query = $this->db->prepare('UPDATE `vino` SET Nombre=?, Tipo=?, Azucar=?, id_cepa=?, id_bodega =? WHERE ID_vino = ?');
        $query->execute([$Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa, $id]);
    }

    public function updateBodega($Nombre_bodega, $Ubicación, $Año, $Características, $id) {    
        $query = $this->db->prepare('UPDATE `bodega` SET Nombre_bodega=?, Ubicación=?, Año=?, Características=? WHERE id_bodega = ?');
        $query->execute([$Nombre_bodega, $Ubicación, $Año, $Características, $id]);
    }

    public function updateCepa($Nombre_cepa, $Aroma, $Maridaje, $Textura, $id) {    
        $query = $this->db->prepare('UPDATE `cepa` SET Nombre_cepa=?, Aroma=?, Maridaje=?, Textura=? WHERE id_cepa = ?');
        $query->execute([$Nombre_cepa, $Aroma, $Maridaje, $Textura, $id]);
    }

    //se usa para api
    public function deleteVino($id){
        $query = $this->db->prepare('DELETE FROM `vino` WHERE ID_vino = ?');
        $query->execute([$id]);
    }

    public function deleteBodega($id){
        $query = $this->db->prepare('DELETE FROM `bodega` WHERE id_bodega = ?');
        $query->execute([$id]);
    }

    public function deleteCepa($id){
        $query = $this->db->prepare('DELETE FROM `cepa` WHERE id_cepa = ?');
        $query->execute([$id]);
    }

    // se usa para api
    public function insertVino($Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa){
        $query = $this->db->prepare('INSERT INTO `vino` (Nombre, Tipo, Azucar, id_bodega, id_cepa) VALUES(?,?,?,?,?)');
        $query->execute([$Nombre, $Tipo, $Azucar, $id_bodega, $id_cepa]);

        return $this->db->lastInsertId();
    }

    public function insertBodega($Nombre_bodega, $Ubicación, $Año, $Características){
        $query = $this->db->prepare('INSERT INTO `bodega` (Nombre_bodega, Ubicación, Año, Características) VALUES(?,?,?,?)');
        $query->execute([$Nombre_bodega, $Ubicación, $Año, $Características]);

         return $this->db->lastInsertId();
    }

    public function insertCepa($Nombre_cepa, $Aroma, $Maridaje, $Textura){
        $query = $this->db->prepare('INSERT INTO `cepa` (Nombre_cepa, Aroma, Maridaje, Textura) VALUES(?,?,?,?)');
        $query->execute([$Nombre_cepa, $Aroma, $Maridaje, $Textura]);

        return $this->db->lastInsertId();
    }
}