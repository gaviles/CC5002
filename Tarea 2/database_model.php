<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

class DatabaseModel {
    
   public $database,$encargo,$viaje,$pais,$ciudad,$espacio,$kilos;
   
   public function __construct() {
       $this->database = new DatabaseController();
       $this->encargo = new EncargoModel($this);
       $this->espacio = new EspacioModel($this); 
   }
}