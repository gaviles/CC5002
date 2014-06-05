<?php

include_once 'app/ini.php';

$viajeId = filter_input(INPUT_GET, 'id');
    
    $aViajes = $db->viaje->getById($viajeId);
    
    $bValid = true;
    
    $oViaje = [];
    
    if( count($aViajes) == 0 ){
        $bValid = false;
        $oViaje['origen'] = "";
        $oViaje['destino'] = "";
        $oViaje['fecha_ida'] = "";
        $oViaje['fecha_regreso'] = "";
        $oViaje['espacio_disponible'] = "";
        $oViaje['kilos_disponible'] = "";
        $oViaje['email_viajero'] = "";
        $oViaje['celular_viajero'] = "";
    }else{
        $oViaje = $aViajes[0];
    }
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>DCC Express</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

	<div class="principal" >
		<h1>DCC Express!!!</h1>
		<br/>
		<div class="botones">
			<a class="boton" href="agregar-viaje.php" >Agregar Viaje</a>
			<a class="boton" href="agregar-encargo.php" >Agregar Encargo</a>
			<a class="boton" href="ver-viajes.php" >Ver Viajes</a>
			<a class="boton" href="ver-encargos.php" >Ver Encargos</a>
		</div>
		<br/>

                <div class="tabla" style="display:<?php if( !$bValid ){ echo "none";} ?>" >
			<table>
                            <tr>
                                <td>País Origen: </td><td><b><?php echo $oViaje['pais-origen']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Ciudad Origen: </td><td><b><?php echo $oViaje['ciudad-origen']; ?></b></td>
                            </tr>
                            <tr>
                                <td>País Destino: </td><td> <b><?php echo $oViaje['pais-destino']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Ciudad Destino: </td><td> <b><?php echo $oViaje['ciudad-destino']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Fecha Ida: </td><td> <b><?php echo $oViaje['fecha-ida']; ?></b> </td>
                            </tr>
                            <tr>
                                <td>Fecha Llegada: </td><td><b><?php echo $oViaje['fecha-regreso']; ?></b> </td>
                            </tr>
                            <tr>
                                <td>Espacio: </td><td> <b><?php echo $oViaje['espacio']; ?></b> </td>
                            </tr>
                            <tr>
                                <td>Kilos: </td><td> <b><?php echo $oViaje['kilos']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Email: </td><td> <b><?php echo $oViaje['email']; ?></b> </td>
                            </tr>
                            <tr>
                                <td>Número de celular: </td><td> <b><?php echo $oViaje['celular_viajero']; ?></b> </td>
                            </tr>
			</table>
		</div>
                <span style="display:<?php if( $bValid ){ echo "none"; }else{ echo "block"; } ?>">
                    Error, viaje no encontrado.
                </span>
	</div>

	</div>

</body>
</html>