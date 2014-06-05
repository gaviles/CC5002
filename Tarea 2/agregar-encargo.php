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
                
                aCountries = <?php echo $db->pais->getJsParsed(); ?>;
                
		function validarFormulario(){

			console.log("validar");
			// validamos que la descripción no se encuentre vacía
			if(!testInputValue("descripcion","Por favor escriba una descripcion del encargo.")){ return false; }

			// Validar Pais Origen
			if( !testInputValue('pais-origen',"Por favor seleccione un País de origen") ){return false;}

			// Validar Ciudad de Origen
			if( !testInputValue('ciudad-origen',"Por favor seleccione una Ciudad de origen") ){return false;}

			// Validar Pais de Destino
			if( !testInputValue('pais-destino',"Por favor seleccione un País de destino") ){return false;}

			// Validar Ciudad de Destino
			if( !testInputValue('ciudad-destino',"Por favor seleccione una Ciudad de destino") ){return false;}

			// Validar Existencia de fotografía
			if( !testInputValue('foto-encargo',"Por favor seleccione una foto del encargo.") ){return false;}

			// Valida que el archivo a subir tenga extensión de imágen (jpg, jpeg, png)
			var sFilePath = document.getElementById("foto-encargo").value;
			var aFilePath = sFilePath.split(".");
			var sExtension = aFilePath[aFilePath.length-1].toLowerCase();
			var aValidExtensions = ["jpg","jpeg","png"];
			if( aValidExtensions.indexOf(sExtension) < 0 ){
				alert("La extensión del archivo ingresado no es válida.");
				return false;
			}

			// validar email
			var bEmailValido = testEmail( document.getElementById('email').value );
			if( !bEmailValido ){
				alert("Correo electrónico no válido.");
				return false;
			}
			return true;
		}

		function ini(){
			// Insertar el arreglo de paises en el SELECT de paises
			var oPaisOrigenSelect = document.getElementById('pais-origen');
			var oPaisDestinoSelect = document.getElementById('pais-destino');
			for(var i= 0; i < aCountries.length ; i++){
				apendOption( oPaisOrigenSelect, aCountries[i].name, aCountries[i].name );
				apendOption( oPaisDestinoSelect, aCountries[i].name, aCountries[i].name );
			}
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
		<p id="msg">
                    <?php if(isset( $sMessage )){ echo $sMessage;} ?>
                </p>
		<form action="guardar.php?form=encargo" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()" >
			<table class="tabla-formulario">
				<tr>
					<td>Descripción Encargo: </td>
					<td> <input type="text" id="descripcion" name="descripcion" maxlength="100" > </td>
				</tr>
				<tr>
					<td>Espacio: </td>
					<td>
						<select id="espacio-solicitado" name="espacio-solicitado">
                                                    <?php
							$espacios = $db->espacio->read();
                                                        foreach( $espacios as $espacio ){
                                                            echo "<option value=\"".$espacio['id']."\" >".$espacio['valor']."</option>";
                                                        }
                                                    ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Kilos: </td>
					<td>
						<select id="kilos-solicitados" name="kilos-solicitados">
                                                    <?php
							$pesos = $db->kilos->read();
                                                        foreach( $pesos as $peso ){
                                                            echo "<option value=\"".$peso['id']."\" >".$peso['valor']."</option>";
                                                        }
                                                    ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>País Origen: </td>
					<td>
						<select id="pais-origen" name="pais-origen" onchange="setPaisOrigen(this)" >
							<option value="" >Seleccione un País</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Ciudad Origen: </td>
					<td>
						<select id="ciudad-origen" name="ciudad-origen">
							<option value="buenos_aires" >Seleccione un País primero</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						País de Destino:
					</td>
					<td>
						<select id="pais-destino" name="pais-destino" onchange="setPaisDestino(this)">
							<option value="" >Seleccione un País</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Ciudad de Destino:
					</td>
					<td>
						<select id="ciudad-destino" name="ciudad-destino">
							<option value="buenos_aires" >Seleccione un País primero</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Foto Encargo (jpg, jpeg, png) : </td>
					<td><input type="file" name="foto-encargo" id="foto-encargo" /></td>
				</tr>
				<tr>
					<td>Email Encargador: </td>
					<td><input type="email" id="email" name="email" size="30" /></td></tr>
				<tr>
					<td>Número Celular Encargador: </td>
					<td><input type="text" name="celular" size="15"></td>
				</tr>
				<tr>
					<td></td><td><input type="submit" name="submit" value="Enviar" /></td>
				</tr>
			</table>

		</form>
	</div>

</body>
</html>