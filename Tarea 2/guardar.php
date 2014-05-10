<?php

/**
 * Homework 2 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */

if( isset($_GET['form']) ){
    include_once 'app/ini.php';
    
    $bSuccess = true;
    
    // call to the given save controller
    echo "<pre>";
    if( $_GET['form'] == "encargo" ){
        
        echo "encargo".PHP_EOL;
        var_dump($_POST);
        
        $descripcion = filter_input(INPUT_POST, 'descripcion');
        $espacio = filter_input(INPUT_POST, 'espacio-solicitado');
        $kilos = filter_input(INPUT_POST, 'kilos-solicitados');
        $origen = filter_input(INPUT_POST, 'ciudad-origen');
        $destino = filter_input(INPUT_POST, 'ciudad-destino');
        $imagen = "1.jpg";
        $email = filter_input(INPUT_POST, 'email');
        $celular = filter_input(INPUT_POST, 'celular');
        
        echo "variables definidas".PHP_EOL;
        
        $bSuccess = $db->encargo->create(
                            $descripcion,
                            $espacio,
                            $kilos,
                            $origen,
                            $destino,
                            $imagen,
                            $email,
                            $celular );
        var_dump($bSuccess);
        
    }else if( $_GET['form'] == "viaje" ){
        echo "viaje".PHP_EOL;
        var_dump($_POST);
    }
    echo "</pre>";
}else{
    include_once 'inicio.php';
}