<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class ViajeModel{
    
    private $_PAGESIZE = 7,$databaseModel,$dataBase;
        
    public function __construct( $databaseModel ){
        $this->databaseModel = $databaseModel;
        $this->dataBase = $databaseModel->database;
    }
    
    /**
     * Return the encargo list by 7 elements.
     * 
     * @param type $page, int of the page
     * @return type array()
     */
    public function read($page, $bAsc = true ){
        if($page !== ""){
            $page = $this->dataBase->toInt($page)."";
            $start = $page*$this->_PAGESIZE;
        }else{
            $start = "0";
        }
        $sOrder = "ASC";
        if(!$bAsc){
            $sOrder = "DESC";
        }
        
        $sql = "SELECT * FROM viaje ORDER BY id {$sOrder} LIMIT {$start},{$this->_PAGESIZE};";
        return  $this->dataBase->query($sql);
    }
    
    /**
     * Returns a simple array with the viaje of the given id
     * @param type $id
     * @return array( array( viaje model ) )
     */
    public function getById( $id ){
        $id = $this->dataBase->toString($id);
        $sql = "SELECT * FROM viaje WHERE id = {$id} LIMIT 1;";
        return  $this->dataBase->query($sql);
    }
    
    /**
     * Returns the number of pages 
     * @return number
     */
    public function getPages(){
        $sql = "SELECT COUNT(*) as 'total' FROM viaje";
        $total = $this->dataBase->query($sql)[0]['total'];
        $rest = $total % $this->_PAGESIZE;
        if( $rest > 0 ){
            return ($total - $rest)/ $this->_PAGESIZE;
        }else{
            return $total/$this->_PAGESIZE-1;
        }
    }
    
    // 2611718
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
                "espacio"=>$this->databaseModel->espacio->getById($aData[$i]['espacio_disponible']),
                "kilos"=>$this->databaseModel->kilos->getById($aData[$i]['kilos_disponible']),
                "email"=>$aData[$i]['email_viajero'],
                "fecha-ida"=>$aData[$i]['fecha_ida'],
                "fecha-regreso"=>$aData[$i]['fecha_regreso'],
                "id"=>$aData[$i]['id']
                ];
        }
        return $aReturn;
    } 
    
    public function getParsed($page = ""){
        
        $data = $this->read($page);
        $sData = "[";
        $iMax = count($data);
        
        for( $i = 0; $i < $iMax; $i++ ){
            $sData .= "[{t:'s',v:'";
            $sData .= $this->databaseModel->ciudad->getById($data[$i]['origen']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->ciudad->getById($data[$i]['destino']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $data[$i]['fecha_ida'];
            $sData .= "'},{t:'s',v:'";
            $sData .= $data[$i]['fecha_regreso'];
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->espacio->getById($data[$i]['espacio_disponible']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->kilos->getById($data[$i]['kilos_disponible']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $data[$i]['email_viajero'];
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
    
    public function create( $origen, $destino, $fecha_ida, $fecha_regreso, $kilos, $espacio, $email, $celular ){

        // validate data 
        $celular = $this->dataBase->toString($celular);
        $email = $this->dataBase->toString($email);
        $kilos = $this->dataBase->toInt($kilos);
        $espacio = $this->dataBase->toInt($espacio);
        $fecha_ida = $this->dataBase->toString($fecha_ida);
        $fecha_regreso = $this->dataBase->toString($fecha_regreso);
        $destino = $this->dataBase->toInt($destino);
        $origen = $this->dataBase->toInt($origen);
        
        
        // validate externals id's
        if( !$this->databaseModel->kilos->isValid($kilos) ){ return false; }
        if( !$this->databaseModel->espacio->isValid($espacio) ){ return false; }
        if( !$this->databaseModel->ciudad->isValid($origen) ){ return false; }
        if( !$this->databaseModel->ciudad->isValid($destino) ){ return false; }
        if( $origen == $destino ){ return false; }
        if( $this->dataBase->toDate( $fecha_ida ) == null ){ return false; }
        if( $this->dataBase->toDate( $fecha_regreso ) == null ){ return false; }
        
        $sql = "INSERT INTO  viaje (origen, destino, fecha_ida, fecha_regreso, kilos_disponible, espacio_disponible, email_viajero, celular_viajero) VALUES (?,?,'?','?',?,?,'?','?');";
        $sqlComplete = $this->dataBase->fillQuery($sql,array($origen, $destino, $fecha_ida, $fecha_regreso, $kilos, $espacio, $email, $celular));
        return $this->dataBase->query($sqlComplete);
    }
}
