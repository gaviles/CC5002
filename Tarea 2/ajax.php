<?php

/**
 * Ajax port, to comunicate javascript and the database
 */

include_once 'app/ini.php';

header('Content-type: application/json');

$request = filter_input(INPUT_GET, 'request');
$value = filter_input(INPUT_GET, 'value');

if( $request == "ciudades" ){
    $ciudades = $db->ciudad->getByPais( $value );
    $json = "[";
    $numCiudades = count($ciudades);
    $search = array('"');
    $replace = array('\"');
    for($i=0; $i<$numCiudades ; $i++ ){
        $json .= "{\"id\":".$ciudades[$i]['id'].",\"name\":\"".str_replace($search, $replace, $ciudades[$i]['nombre'])."\"";
        if( $i < ( $numCiudades -1 ) ){
            $json .= "},";
        }else{
            $json .= "}";
        }
    }
    $json .= "]";
    echo $json;
}else{
    echo "[]";
}
