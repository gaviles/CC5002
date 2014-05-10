<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class ViajeModel{
    
    private $databaseModel,$dataBase;
        
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
    public function read($page){
        if($page !== ""){
            $page = $this->dataBase->toInt($page).",";
        }else{
            $page = "0,";
        }
        $sql = "SELECT * FROM viaje ORDER BY id ASC LIMIT {$page}7;";
        return  $this->dataBase->query($sql);
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
            $sData .= $this->databaseModel->ciudad->getById($data[$i]['fecha_ida']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->ciudad->getById($data[$i]['fecha_regreso']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->espacio->getById($data[$i]['espacio_disponible']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $this->databaseModel->kilos->getById($data[$i]['kilos_disponible']);
            $sData .= "'},{t:'s',v:'";
            $sData .= $data[$i]['email_viajero'];
            $sData .= "'}";
            
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
        $descripcion = $this->dataBase->toString($descripcion);
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
        
        $sql = "INSERT INTO  viaje (origen, destino, fecha_ida, fecha_regreso, kilos_disponible, espacio_disponible, email_viajero, celular_viajero) VALUES (?,?,?,?,?,?,?,?)";
        $sqlComplete = $this->dataBase->fillQuery($sql,array($origen, $destino, $fecha_ida, $fecha_regreso, $kilos, $espacio, $email, $celular));
        $this->dataBase->query($sqlComplete);
        return true;
    }
}
