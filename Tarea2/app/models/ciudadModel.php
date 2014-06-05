<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class CiudadModel{
    
    private $databaseModel,$dataBase;
        
    public function __construct( $databaseModel ){
        $this->databaseModel = $databaseModel;
        $this->dataBase = $databaseModel->database;
    }
    /**
     * Returns all the citys of the given pais_id
     * @param type $pais, pais id.
     * @return type Array()
     */
    public function getByPais( $pais ){
        $pais = $this->dataBase->toString($pais);
        $sql = "SELECT * FROM ciudad WHERE pais = '{$pais}' ;";
        return $this->dataBase->query($sql);
    }
    
    /**
     * Returns the city name of the given id, if not exist retruns
     * an empty array.
     * @param type $id, id of an existing insertion in ciudad table
     */
    public function getById( $id, $bFullReturn = false ){
        
        $id = $this->dataBase->toInt($id);
        
        $sql = "SELECT * FROM ciudad WHERE id = '{$id}';";
        $return = $this->dataBase->query($sql);
        if( count($return) > 0 ){
            if($bFullReturn){
                return $return[0];
            }else{
                return $return[0]['nombre'];
            }
        }
        return $return;
    }
    
    
    /**
     * Returns a Bollean, depending if the given number is in the table as an id.
     * @param type $id, is an id of the table ciudad
     */
    public function isValid( $id ){
        
        $return = $this->getById($id);
        
        if(count($return) == 0){
            return false;
        }
        return true;
    }
}
