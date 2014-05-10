<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

// Show errors
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_ALL);
error_reporting(-1);

include_once 'controllers/save_controller.php';
include_once 'controllers/database_controller.php';
include_once 'models/espacioModel.php';
include_once 'models/kilosModel.php';
include_once 'models/ciudadModel.php';
include_once 'models/encargoModel.php';
include_once 'models/paisModel.php';
include_once 'models/viajeModel.php';

class DatabaseModel {
    
   public $database,$encargo,$viaje,$pais,$ciudad,$espacio,$kilos;
   
   public function __construct() {
       $this->database = new DatabaseController();
       $this->encargo = new EncargoModel($this);
       $this->espacio = new EspacioModel($this);
       $this->kilos = new KilosModel($this);
       $this->ciudad = new CiudadModel($this);
       $this->pais = new PaisModel($this);
       $this->viaje = new ViajeModel($this);
   }
}

$db = new DatabaseModel();

//echo "<pre>";

/*
var_dump( $db->espacio->isValid(1) );
var_dump( $db->espacio->isValid(8) );

var_dump( $db->encargo->create("hasdas",1,1,775344,775345,"hola.jpg","h@x.c","+56232 234234 ") );
var_dump( $db->pais->isValid('cl') );
var_dump( $db->pais->isValid('ar') );
var_dump( $db->pais->isValid('XX') );

var_dump( $db->kilos->isValid(1) );

var_dump( $db->kilos->isValid(10) );
*/

//var_dump( $db->viaje->getParsed() );
//
//echo json_encode( $db->encargo->read() );
//echo "</pre>";