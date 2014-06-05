<?php

ini_set('display_errors', 'On');
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_ALL);
error_reporting(-1);

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
                
		function ini(){
			// Insertar el arreglo de paises en el SELECT de paises
			var oPaisOrigenSelect = document.getElementById('pais-origen');
			var oPaisDestinoSelect = document.getElementById('pais-destino');
			for(var i= 0; i < aCountries.length ; i++){
				apendOption( oPaisOrigenSelect, aCountries[i].name, aCountries[i].name );
				apendOption( oPaisDestinoSelect, aCountries[i].name, aCountries[i].name );
			}
		}

		function validarFormulario(){
			console.log("validando formulario");

			// Validar Pais Origen
			if( !testInputValue('pais-origen',"Por favor seleccione un País de origen") ){return false;}

			// Validar Ciudad de Origen
			if( !testInputValue('ciudad-origen',"Por favor seleccione una Ciudad de origen") ){return false;}

			// Validar Pais de Destino
			if( !testInputValue('pais-destino',"Por favor seleccione un País de destino") ){return false;}

			// Validar Ciudad de Destino
			if( !testInputValue('ciudad-destino',"Por favor seleccione una Ciudad de destino") ){return false;}

			// Valida fechas de ida y regreso.
			if( !testInputValue('fecha-ida',"Fecha de ida no es válida, Ej.:2012-08-20") ){return false;}

			var oRegresoDate = testDate( document.getElementById('fecha-regreso').value );
			if(oRegresoDate === false){
				alert("Fecha de regreso no es válida, Ej.:2012-08-20");
				return false;
			}

			if( oIdaDate >= oRegresoDate ){
				alert("La fecha de regreso debe ser mayor que la fecha de ida");
				return false;
			}
			
			// Valida Espacio dsiponible
			if( !testInputValue('espacio-disponible',"Por favor seleccione el espacio disponible.") ){return false;}

			// Valida Espacio dsiponible
			if( !testInputValue('kilos-disponibles',"Por favor seleccione los kilos disponibles.") ){return false;}

			var bEmailValido = testEmail( document.getElementById('email').value );
			if( !bEmailValido ){
				alert("Correo electrónico no válido.");
				return false;
			}
                        
			return true;
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
		<form action="guardar.php?form=viaje" method="POST" onsubmit="return validarFormulario()" >
		<table class="tabla-formulario">
			<tr>
				<td>
					País de Origen:
				</td>
				<td>
					<select id="pais-origen" name="pais-origen" onchange="setPaisOrigen(this)" >
						<option value="" >Seleccione un País</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Ciudad de Origen;
				</td>
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
						<option value="" >Seleccione un País primero</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Fecha ida:
				</td>
				<td>
					<input type="text" id="fecha-ida" name="fecha-ida" value="año-mes-dia"  maxlength="10" />
				</td>
			</tr>
			<tr>
				<td>
					Fecha regreso:
				</td>
				<td>
					<input type="text" id="fecha-regreso" name="fecha-regreso" value="año-mes-dia" maxlength="10"  />
				</td>
			</tr>
			<tr>
				<td>
					Espacio Disponible:
				</td>
				<td>
					<select id="espacio-disponible" name="espacio-disponible">
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
				<td>
					Kilos Disponibles:
				</td>
				<td>				
					<select id="kilos-disponibles" name="kilos-disponibles">
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
				<td>
					Email del Viejero:
				</td>
				<td>
					<input id="email" type="email" name="email" size="30" />
				</td>
			</tr>
			<tr>
				<td>
					Número de Celular:
				</td>
				<td>
					<input type="text" name="celular" size="15" />
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input type="submit" value="Enviar" />
				</td>
			</tr>
		</table>
		</form>
	</div>
</body>
</html>