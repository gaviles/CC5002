<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

/**
 * this model follow CRUD standar
 */
class PaisModel{
    
    private $databaseModel,$dataBase;
        
    public function __construct( $databaseModel ){
        $this->databaseModel = $databaseModel;
        $this->dataBase = $databaseModel->database;
    }
    
    /**
     * Return an array of countries
     * @return type array(), of pais
     */
    public function read(){
        $sql = "SELECT * FROM pais;";
        return $this->dataBase->query($sql);
    }
    
    /**
     * Returns the json parsed countries
     */
    public function getJsParsed(){
        $countries = $this->read();
        $sArray = "[";
        
        for($i=0,$max=count($countries); $i< $max ; $i++ ){
            
            $country = $countries[$i];
            $sArray .= "{name:\"".$country['nombre']."\",iso:\"".$country['id']."\",cities:[]";
            
            if( $i < ($max-1)  ){
                $sArray .= "},";
            }else{
                $sArray .= "}";
            }
        }
        
        $sArray .= "]";
        return $sArray;
    }
    
    /**
     * Returns a Bollean, depending if the given number is in the table as an id.
     * @param type $id, is an id of the table ciudad
     */
    public function isValid( $id ){
        
        $id = $this->dataBase->toString($id);
        $sql = "SELECT id FROM pais WHERE id = '{$id}';";
        $return = $this->dataBase->query($sql);
        
        if(count($return) == 0){
            return false;
        }
        return true;
    }
}

