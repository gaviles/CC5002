<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class EspacioModel{
    
    private $databaseModel,$dataBase;
        
    public function __construct( $databaseModel ){
        $this->databaseModel = $databaseModel;
        $this->dataBase = $databaseModel->database;
    }
    
    public function read(){
        $sql = "SELECT * FROM espacio_encargo;";
        return $this->dataBase->query($sql);
    }
    
    /**
     * 
     * @param type $id, espacio id
     * @return type string, given espacio value
     */
    public function getById($id){
        
        $id = $this->dataBase->toInt($id);
        $sql = "SELECT * FROM espacio_encargo WHERE id = '{$id}';";
        $return = $this->dataBase->query($sql);
        if( count($return) > 0 ){
            return $return[0]['valor'];
        }
        return $return;
    }
    
    /**
     * Returns a Bollean, depending if the given number is in the table as an id.
     * @param type $id, is an id of the table espacio_encargo
     */
    public function isValid( $id ){
        
        $return = $this->getById($id);
        
        if(count($return) == 0){
            return false;
        }
        return true;
    }
}

