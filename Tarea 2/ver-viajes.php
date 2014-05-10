<?php

include_once 'app/ini.php';

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>DCC Express</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<script type="text/javascript" src="validadores.js"></script>
	<script type="text/javascript">
		var aData = <?php echo $db->viaje->getParsed(); ?>;

		function verDetalle( oRow ){
			window.location.href = "informacion-viaje.php";
		}

		function ini(){

			fillTable("viajes", aData );	
		}
	</script>
</head>
<body onload="ini()">

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
		<div class="tabla">
			<table>
                            <theader>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha Ida</th>
                                <th>Fecha Llegada</th>
                                <th>Espacio</th>
                                <th>Kilos</th>
                                <th>Email</th>
                            </theader>
                            <tbody id="viajes"></tbody>
			</table>
		</div>
	</div>
</body>
</html>