<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class EncargoModel{
    
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
    public function read($page = ""){
        if($page !== ""){
            $page = $this->dataBase->toInt($page).",";
        }else{
            $page = "0,";
        }
        
        $sql = "SELECT * FROM `encargo` ORDER BY id ASC LIMIT {$page}7;";
        return  $this->dataBase->query($sql);
    }
    
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
        
        echo "lala";
        
        // validate data 
        $descripcion = $this->dataBase->toString($descripcion);
        $celular = $this->dataBase->toString($celular);
        $email = $this->dataBase->toString($email);
        $kilos = $this->dataBase->toInt($kilos);
        $espacio = $this->dataBase->toInt($espacio);
        $destino = $this->dataBase->toInt($destino);
        $origen = $this->dataBase->toInt($origen);
        
        echo "verification";
        
        // validate externals id's
        if( !$this->databaseModel->kilos->isValid($kilos) ){ return false; }
        if( !$this->databaseModel->espacio->isValid($espacio) ){ return false; }
        if( !$this->databaseModel->ciudad->isValid($origen) ){ return false; }
        if( !$this->databaseModel->ciudad->isValid($destino) ){ return false; }
        if( $origen == $destino ){ return false; }
        
        echo "hi mom";
        
        $sql = "INSERT INTO `encargo` (descripcion, espacio, kilos, origen, destino, imagen, email_encargador, celular_encargador) VALUES ('?',?,?,?,?,'?','?','?');";
        $sqlComplete = $this->dataBase->fillQuery($sql,array($descripcion, $espacio, $kilos, $origen, $destino, $imagen, $email, $celular));
        var_dump($sqlComplete);
        $this->dataBase->query($sqlComplete);
        return true;
    }
}
