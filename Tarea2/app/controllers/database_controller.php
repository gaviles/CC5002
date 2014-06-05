<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

class DatabaseController{
	
        // Base de datos de la app
	private static $db_name = "tarea2";
        // Usuario MySQL
	private static $db_user = "root";
        // Password
	private static $db_pass = "hola";
        // Servidor donde esta alojado, puede ser 'localhost' o una IP (externa o interna).
	private static $db_host = "localhost";
        // Mysqlli object connection
        private static $mysqli;
        
        public function __construct() {
            self::connect();
        }
        
	public static function connect(){
            self::$mysqli = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
            self::$mysqli->set_charset("utf8");
        }
        
        public function query( $string ){
            
            $result = self::$mysqli->query($string);
            $res = array();
            if( gettype($result) !== "boolean" ){
                while($row = mysqli_fetch_array($result)) {
                  $res[] = $row;
                }
                return $res;
            }else{
                return $result;
            }
        }
        
        public function toString($string){
            settype($string, "string");
            // Prevent sql injection
            return $this->injectionKiller($string);
	}
        
        public function injectionKiller( $string ){
            
            // prevent sql injection 
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
            $string =  str_replace($search, $replace, $string);
            // prevent html and javascript injection
            $string = htmlspecialchars( $string, ENT_COMPAT | ENT_HTML401,"UTF-8",true);
            
            return $string;
        }
	
	public function toInt($int){
            settype($int,"integer");
            return $int;
	}
	
	public function toDouble($double){
            settype($double, "float");
            return $double;
	}
	
	public function toDate($date){
            
            $aDate = explode("-", $date);
            
            if( checkdate($aDate[1],$aDate[2],$aDate[0]) ){
                return $aDate[0]."-".$aDate[1]."-".$aDate[2];
            }
            return null;
	}
	
        /**
         * Fill the given query, yust need to add "?" characted in the place, 
         * fills the query in the exact order that it receives the array
         * @param type $query Insert values () into (?,?,'?',?,'?')
         * @param type $array
         * @return string
         */
	public function fillQuery($query, $array){
            $aQuery = explode("?",$query);
            $sQuery = "";
            
            for( $i=0; count($aQuery) > $i ; $i++ ){
                $sQuery.=$aQuery[$i];
                if(count($array) > $i ){
                    $sQuery.=$array[$i];
                }
            }
            return $sQuery;
	}
}