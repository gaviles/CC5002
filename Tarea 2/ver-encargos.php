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

	function verDetalle(){
		window.location.href = "informacion-encargo.php";
	}

	function ini(){
		var aData = <?php echo $db->encargo->getParsed(); ?>;

		fillTable("encargos", aData );
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
			<table >
                            <thead>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Espacio</th>
                                <th>Kilos</th>
                                <th>Email</th>
                                <th>Foto</th>
                            </thead>
                            <tbody id="encargos"></tbody>
			</table>
		</div>
	</div>

</body>
</html>