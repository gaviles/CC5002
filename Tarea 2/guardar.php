<?php

/**
 * Homework 3 CC5002
 * @author Gustavo Aviles <gustavo@gaviles.com>
 */


if( isset($_GET['form']) ){
    include_once 'app/ini.php';
    
    $bSuccess = true;
    
    // call to the given save controller
    if( $_GET['form'] == "encargo" ){
        
        $descripcion = filter_input(INPUT_POST, 'descripcion');
        $espacio = filter_input(INPUT_POST, 'espacio-solicitado');
        $kilos = filter_input(INPUT_POST, 'kilos-solicitados');
        $origen = filter_input(INPUT_POST, 'ciudad-origen');
        $destino = filter_input(INPUT_POST, 'ciudad-destino');
        $email = filter_input(INPUT_POST, 'email');
        $celular = filter_input(INPUT_POST, 'celular');
        
        if( isset($_FILES['foto-encargo']) ){
            
            if( strpos( $_FILES['foto-encargo']['type'], 'image' ) !== false ){
                
                // hash image name mix the current time stam, plus a random function
                $imgName = rand(1,1000)."-".time().".jpg";
                
                if( $_FILES['foto-encargo']['type'] == 'image/jpg' ){
                    $image = imagecreatefromjpeg($_FILES['foto-encargo']['tmp_name']);
                }
                if( $_FILES['foto-encargo']['type'] == 'image/jpeg'){
                    $image = imagecreatefromjpeg($_FILES['foto-encargo']['tmp_name']);
                }
                if( $_FILES['foto-encargo']['type'] == 'image/gif'){
                    $image = imagecreatefromgif($_FILES['foto-encargo']['tmp_name']);
                }
                if( $_FILES['foto-encargo']['type'] == 'image/png'){
                    $image = imagecreatefrompng($_FILES['foto-encargo']['tmp_name']);
                }
                
                $exif = exif_read_data( $_FILES['foto-encargo']['tmp_name'] );

                switch($exif['Orientation']) {
                    case 8:
                        $image = imagerotate($image,90,0);
                        break;
                    case 3:
                        $image = imagerotate($image,180,0);
                        break;
                    case 6:
                        $image = imagerotate($image,-90,0);
                        break;
                }
                $pathBase = "img\\";
                
                // Save image big
                $imageBig = imagescale($image, 800,600);
                // Save image medium
                $imageMedium = imagescale($image,320,240);
                // Save image small
                $imageSmall = imagescale($image,80,80);
                
                imagejpeg($imageBig, $pathBase."big\\{$imgName}", 100);
                imagejpeg($imageMedium, $pathBase."medium\\{$imgName}", 100);
                imagejpeg($imageSmall, $pathBase."small\\{$imgName}", 100);
                
                imagedestroy($image);
                imagedestroy($imageBig);
                imagedestroy($imageMedium);
                imagedestroy($imageSmall);
                
                $bSuccess = $db->encargo->create(
                            $descripcion,
                            $espacio,
                            $kilos,
                            $origen,
                            $destino,
                            $imgName,
                            $email,
                            $celular );
                
            }else{
                $bSuccess = false;
            }   
        }
        if( $bSuccess ){
            $sMessage = " Encargo Añadido Satisfactoriamente. ";
            include_once 'ver-encargos.php';
        }else{
            $sMessage = " Error, por favor ingrese un formulario válido. ";
            include_once 'agregar-encargo.php';
        }
    }else if( $_GET['form'] == "viaje" ){
                
        $origen = filter_input(INPUT_POST, 'ciudad-origen');
        $destino = filter_input(INPUT_POST, 'ciudad-destino');
        $fecha_ida = filter_input(INPUT_POST, 'fecha-ida');
        $fecha_regreso = filter_input(INPUT_POST, 'fecha-regreso');
        $kilos = filter_input(INPUT_POST, 'kilos-disponibles');
        $espacio = filter_input(INPUT_POST, 'espacio-disponible');
        $email = filter_input(INPUT_POST, 'email');
        $celular = filter_input(INPUT_POST, 'celular');
        
        $bSuccess = $db->viaje->create(
                        $origen,
                        $destino,
                        $fecha_ida,
                        $fecha_regreso,
                        $kilos,
                        $espacio,
                        $email,
                        $celular);
        if( $bSuccess ){
            $sMessage = " Viaje Añadido Satisfactoriamente. ";
            include_once 'ver-viajes.php';
        }else{
            $sMessage = " Error, por favor ingrese un formulario válido. ";
            include_once 'agregar-viaje.php';
        }
    }
}else{
    include_once 'inicio.php';
}

function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];
     
    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}