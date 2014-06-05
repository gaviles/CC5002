<?php

/**
 * Ajax port, to comunicate javascript and the database
 */

include_once 'app/ini.php';

header('Content-type: application/json');

$request = filter_input(INPUT_GET, 'request');
$value = filter_input(INPUT_GET, 'value');

switch ( $request ){
    case "ciudades":
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
    break;
    case "page_viaje":
        $iPage = $value;
        $maxPages = $db->viaje->getPages();
        if( $iPage >= $maxPages ){
            $viajes = $db->viaje->getParsed($maxPages);        
            echo json_encode(array("aData"=>$viajes,"iPage"=>$maxPages));
        }else{
            $viajes = $db->viaje->getParsed($iPage);        
            echo json_encode(array("aData"=>$viajes,"iPage"=>$iPage));
        }
    break;
    case "page_encargo":
        $iPage = $value;
        $maxPages = $db->viaje->getPages();
        if( $iPage >= $maxPages ){
            $encargos = $db->encargo->getParsed($maxPages);
            echo json_encode(array("aData"=>$encargos,"iPage"=>$maxPages));
        }else{
            $encargos = $db->encargo->getParsed($iPage);
            echo json_encode(array("aData"=>$encargos,"iPage"=>$iPage));
        }
    break;
    default:
        echo "[]";
}