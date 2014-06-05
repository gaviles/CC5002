<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class EncargoModel{
    
    private $_PAGESIZE = 7,$databaseModel,$dataBase;
        
    public function __construct( $databaseModel ){
        $this->databaseModel = $databaseModel;
        $this->dataBase = $databaseModel->database;
    }
    
    /**
     * Return the encargo list by 7 elements.
     * 
     * @param type page, int of the page
     * @return type array()
     */
    public function read($page = ""){
        if($page !== ""){
            $page = $this->dataBase->toInt($page);
            $start = $page*$this->_PAGESIZE;
        }else{
            $start = "0";
        }
        
        $sql = "SELECT * FROM `encargo` ORDER BY id ASC LIMIT {$start},{$this->_PAGESIZE};";
        return  $this->dataBase->query($sql);
    }
    
    /**
     * Returns the number of pages 
     * @return number
     */
    public function getPages(){
        $sql = "SELECT COUNT(*) as 'encargo' FROM viaje";
        $total = $this->dataBase->query($sql)[0]['total'];
        $rest = $total % $this->_PAGESIZE;
        if( $rest > 0 ){
            return ($total - $rest)/ $this->_PAGESIZE;
        }else{
            return $total/$this->_PAGESIZE-1;
        }
    }
    
    public function get( $page = "" ){
        $aData = $this->read($page);
        $iMax = count($aData);
        $aReturn = [];
        for( $i = 0; $i < $iMax; $i++ ){
            $ciudadOrigen = $this->databaseModel->ciudad->getById($aData[$i]['origen'],true );
            $ciudadDestino = $this->databaseModel->ciudad->getById($aData[$i]['destino'],true);
            $paisOrigen = $this->databaseModel->pais->getById( $ciudadOrigen['pais'] );
            $paisDestino = $this->databaseModel->pais->getById( $ciudadDestino['pais'] );
            $aReturn[] = [
                "ciudad-origen"=>$ciudadOrigen['nombre'],
                "ciudad-destino"=>$ciudadDestino['nombre'],
                "pais-destino"=>$paisDestino,
                "pais-origen"=>$paisOrigen,
                "espacio"=>$this->databaseModel->espacio->getById($aData[$i]['espacio']),
                "kilos"=>$this->databaseModel->kilos->getById($aData[$i]['kilos']),
                "email"=>$aData[$i]['email_encargador'],
                "imagen"=>$aData[$i]['imagen'],
                "descripcion"=>$aData[$i]['descripcion'],
                "id"=>$aData[$i]['id']
                ];
        }
        return $aReturn;
    }
    /**
     * Returns an string parsed javascript object
     * @param type $page
     * @return string parser javascript object
     */
    public function getParsed( $page = "" ){
        
        $data = $this->read($page);
        $sData = "[";
        $iMax = count($data);
        
        for( $i = 0; $i < $iMax; $i++ ){
            $sData .= "[{t:'s',v:'";
            $sData .= $this->databaseModel->ciudad->getById($data[$i]['origen']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->ciudad->getById($data[$i]['destino']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->espacio->getById($data[$i]['espacio']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->kilos->getById($data[$i]['kilos']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $data[$i]['email_encargador'];
            $sData .= "'},{t:'i',v:'";
            $sData .= $data[$i]['imagen'];
            $sData .= "'},{id:";
            $sData .= $data[$i]['id'];
            $sData .= "}";
            
            if( $i < ($iMax-1) ){
                $sData .= "],";
            }else{
                $sData .= "]";
            }
        }
        $sData .= "];";
        return $sData;
    } 
    
    public function getById( $id ){
        
        $id = $this->dataBase->toInt($id);
        $sql = "SELECT * FROM `encargo` WHERE id = {$id} LIMIT 1;";
        return  $this->dataBase->query($sql);
    }
    
    /**
     * Create: an encargo in the database
     * 
     * @param type $descripcion
     * @param type $espacio
     * @param type $kilos
     * @param type $origen
     * @param type $destino
     * @param type $imagen
     * @param type $email
     * @param type $celular
     * @return boolean, dependa if it was successfully created
     */
    public function create( $descripcion, $espacio, $kilos, $origen, $destino, $imagen, $email, $celular ){
        
        // validate data 
        $descripcion = $this->dataBase->toString($descripcion);
        $celular = $this->dataBase->toString($celular);
        $email = $this->dataBase->toString($email);
        $kilos = $this->dataBase->toInt($kilos);
        $espacio = $this->dataBase->toInt($espacio);
        $destino = $this->dataBase->toInt($destino);
        $origen = $this->dataBase->toInt($origen);
        
        // validate externals id's
        if( !$this->databaseModel->kilos->isValid($kilos) ){ return false; }
        if( !$this->databaseModel->espacio->isValid($espacio) ){ return false; }
        if( !$this->databaseModel->ciudad->isValid($origen) ){ return false; }
        if( !$this->databaseModel->ciudad->isValid($destino) ){ return false; }
        if( $origen == $destino ){ return false; }
        
        $sql = "INSERT INTO `encargo` (descripcion, espacio, kilos, origen, destino, imagen, email_encargador, celular_encargador) VALUES ('?',?,?,?,?,'?','?','?');";
        $sqlComplete = $this->dataBase->fillQuery($sql,array($descripcion, $espacio, $kilos, $origen, $destino, $imagen, $email, $celular));
        $this->dataBase->query($sqlComplete);
        return true;
    }
}
