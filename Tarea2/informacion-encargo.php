<?php

    include_once 'app/ini.php';
    
    $encargoId = filter_input(INPUT_GET, 'id');
    
    $aEncargos = $db->encargo->getById($encargoId);
    
    $bValid = true;
    
    if( count($aEncargos) == 0 ){
        $bValid = false;
        $aEncargo['origen'] = '';
        $aEncargo['destino'] = '';
        $aEncargo['celular_encargador'] = '';
        $aEncargo['email_encargador'] = '';
        $aEncargo['kilos'] = '';
        $aEncargo['espacio'] = '';
    }else{
        $aEncargo = $aEncargos[0];
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>DCC Express</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <script type="text/javascript">
        function togleModal(){
            var oModal = document.getElementById('modal');
            var sDisplay =	oModal.style.display;

            if( sDisplay === "" || sDisplay === "none" ){
                    oModal.style.display = "block";
            }else
            {
                    oModal.style.display = "none";
            }
        }
    </script>
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
		<div class="tabla" style="display:<?php if( !$bValid ) echo "none"; ?>">
			<div class="imagen-envio-mediana" onclick="togleModal()" >
				<img alt="imagen encargo mediana" src="img/medium/<?php echo $aEncargo['imagen']; ?>" />
			</div>
			<table class="tabla-detalles">
                            <tr>
                                <td>Descripción: </td><td><b><?php echo $aEncargo['descripcion']; ?></b></td>
                            </tr>                            
                            <tr>
                                <td>País Origen: </td><td><b><?php echo $aEncargo['pais-origen']; ?></b></td>
                            </tr>
                            <tr>
				<td>Ciudad Origen: </td><td><b><?php echo $aEncargo['ciudad-origen']; ?></b></td>
                            </tr>
                            <tr>
                                <td>País Destino: </td><td><b><?php echo $aEncargo['pais-destino']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Ciudad Destino: </td><td><b><?php echo $aEncargo['ciudad-destino']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Espacio: </td><td><b><?php echo $aEncargo['espacio']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Kilos: </td><td><b><?php echo $aEncargo['kilos']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Email: </td><td><b><?php echo $aEncargo['email']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Número de celular: </td><td><b><?php echo $aEncargo['celular_encargador']; ?></b></td>
                            </tr>
			</table>
		</div>
                <span style="display:<?php if( !$bValid ){ echo "block"; }else{ echo "none"; } ?>">
                    Error, encargo no encontrado.         
                </span>
	</div>

	<div class="dumbBoxWrap" id="modal" onclick="togleModal()" >
		<div class="dumbBoxOverlay"></div>
		<div class="vertical-offset">
			<div class="dumbBox">
				<img alt="imagen producto grande" src="img/big/<?php echo $aEncargo['imagen']; ?>" />
			</div>
		</div>
	</div>

</body>
</html>