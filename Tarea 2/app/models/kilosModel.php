<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class KilosModel{
    
    private $databaseModel,$dataBase;
        
    public function __construct( $databaseModel ){
        $this->databaseModel = $databaseModel;
        $this->dataBase = $databaseModel->database;
    }
    
    public function read(){
        $sql = "SELECT * FROM kilos_encargo;";
        return $this->dataBase->query($sql);
    }
    
    /**
     * Returns the value of the given id, epty array if it doesn't exist.
     * @param type $id, kilos id
     * @return type string, kilos value of the given id
     */
    public function getByID($id){
        $id = $this->dataBase->toInt($id);
        $sql = "SELECT * FROM kilos_encargo WHERE id = '{$id}';";
        $return = $this->dataBase->query($sql);
        if( count($return) > 0 ){
            return $return[0]['valor'];
        }
        return $return;
    }
    
    /**
     * Returns a Bollean, depending if the given number is in the table as an id.
     * @param type $id, is an id of the table kilos_encargo
     */
    public function isValid( $id ){
        
        $return = $this->getByID($id);
        
        if(count($return) == 0){
            return false;
        }
        return true;
    }
}