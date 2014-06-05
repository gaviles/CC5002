<?php

include_once 'app/ini.php';

$viajeId = filter_input(INPUT_GET, 'id');
    
    $aViajes = $db->viaje->getById($viajeId);
    
    $bValid = true;
    
    if( $aViajes == false ){
        $bValid = false;
        $aViaje['origen'] = "";
        $aViaje['destino'] = "";
        $aViaje['fecha_ida'] = "";
        $aViaje['fecha_regreso'] = "";
        $aViaje['espacio_disponible'] = "";
        $aViaje['kilos_disponible'] = "";
        $aViaje['email_viajero'] = "";
        $aViaje['celular_viajero'] = "";
    }else{
        $aViaje = $aViajes[0];
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
					<td>Ciudad Origen: </td><td><b><?php echo $db->ciudad->getById($aViaje['origen']); ?></b></td>
				</tr>
				<tr>
					<td>Ciudad Destino: </td><td> <b><?php echo $db->ciudad->getById($aViaje['destino']); ?></b></td>
				</tr>
				<tr>
					<td>Fecha Ida: </td><td> <b><?php echo $aViaje['fecha_ida']; ?></b> </td>
				</tr>
				<tr>
					<td>Fecha Llegada: </td><td><b><?php echo $aViaje['fecha_regreso']; ?></b> </td>
				</tr>
				<tr>
					<td>Espacio: </td><td> <b><?php echo $db->espacio->getById($aViaje['espacio_disponible']); ?></b> </td>
				</tr>
				<tr>
					<td>Kilos: </td><td> <b><?php echo $db->kilos->getById($aViaje['kilos_disponible']); ?></b></td>
				</tr>
				<tr>
					<td>Email: </td><td> <b><?php echo $aViaje['email_viajero']; ?></b> </td>
				</tr>
				<tr>
					<td>Número de celular: </td><td> <b><?php echo $aViaje['celular_viajero']; ?></b> </td>
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