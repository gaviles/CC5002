<?php 
    include_once 'app/ini.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>DCC Express</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
     <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
        var map;
        var geocoder;
        var encargos = <?php echo json_encode($db->encargo->get()); ?>;
        var viajes = <?php echo json_encode($db->viaje->get()); ?>;
        var _Max_NUM_ELEMNETS = 2;
        var _FLIGH_ICON = "img/repo/flight.png";
        var _BOX_ICON = "img/repo/box.png";
        var _VIAJE_COLOR = '#2526d5';
        var _ENCARGO_COLOR = '#FF0000';
        var EncargoQueue = [];
        var ViajeQueue = [];
        function initialize() {
            var mapOptions = {
              zoom: 1,
              center: new google.maps.LatLng(0,0)
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
            geocoder = new google.maps.Geocoder();
            
            for(var i in encargos ){
                var encargo = encargos[i];
                if( i < _Max_NUM_ELEMNETS ) EncargoQueue.push(encargo);
            }
            for(var i in viajes ){
                var viaje = viajes[i];
                if( i < _Max_NUM_ELEMNETS ) ViajeQueue.push(viaje);
            }
            runQueue();
        }
        google.maps.event.addDomListener(window, 'load', initialize);
        
        function runQueue(){
            if( EncargoQueue.length > 0 ){
                var encargo = EncargoQueue.pop();
                var sTitle = encargo['descripcion'];
                addViaje( encargo, 
                        _ENCARGO_COLOR,
                        _BOX_ICON,
                        sTitle,
                        getInfoEncargo(encargo));
                        
            }else if( ViajeQueue.length > 0 ){
                
                var viaje = ViajeQueue.pop();
                var sTitle = "Ida:"+viaje['fecha-ida'].substring(0,10)
                        +" Regreso:"+viaje['fecha-regreso'].substring(0,10);
                
                addViaje( viaje,
                        _VIAJE_COLOR,
                        _FLIGH_ICON,
                        sTitle,
                        getInfoViaje(viaje));
            }
        }
        
        function getInfoViaje( oViaje ){
            
            var sHtml = "<table class=\"info-window\" ><tr><td>Origen:<ul><li>País:"+oViaje['pais-origen']
                    +"</li><li>Ciudad: "+oViaje['ciudad-origen']
                    +"</li></ul>Destino: <ul><li>País:"+oViaje['pais-destino']
                    +"</li><li>Ciudad: "+oViaje['ciudad-destino']
                    +"</li></ul><a href=\"informacion-viaje.php?id="+oViaje['id']
                    +"\" >Detalles</a> </td><td>Ida:<ul><li>Fecha: "+oViaje['fecha-ida'].substring(0,10)
                    +"</li></ul>Retorno:<ul><li>Fecha: "+oViaje['fecha-regreso'].substring(0,10)
                    +"</li></ul>Disponibilidad:<ul><li>Espacio: "+oViaje['espacio']
                    +"</li><li>Kilos: "+oViaje['kilos']
                    +"</li></ul></td></tr></table>";
            return new google.maps.InfoWindow({
                            content: sHtml
                        });
        }
        
        function getInfoEncargo( oEncargo ){
            
            var sDescripcion = "";
            if( oEncargo['descripcion'].length > 50 ){
                sDescripcion = oEncargo['descripcion'].substring(0,50)+" ...";
            }else{
                sDescripcion = oEncargo['descripcion'];
            }
            
            var sHtml = "<table class=\"info-window\" ><tr><td>Origen:<ul><li>País: "+oEncargo['pais-origen']
                    +"</li><li>Ciudad: "+oEncargo['ciudad-origen']
                    +"</li></ul>Destino:<ul><li>País: "+oEncargo['pais-destino']
                    +"</li><li>Ciudad: "+oEncargo['ciudad-destino']
                    +"</li></ul></td><td>Requerimientos:<ul><li>Espacio: "+oEncargo['espacio']
                    +"</li><li>Kilos: "+oEncargo['kilos']
                    +"</li></ul>Descripción<ul><li>"+sDescripcion
                    +"</li></ul><a href=\"informacion-encargo.php?id="+oEncargo['id']
                    +"\">Detalles</a></td></tr></table>";
            return new google.maps.InfoWindow({
                            content: sHtml
                        });
        }
        
        function addViaje( oViaje, sColor, sIcon, sTitle, infowindow ){
            
            var sAdressOrigen = oViaje['ciudad-origen'] + ", " + oViaje['pais-origen'];
            var sAdressDestino = oViaje['ciudad-destino'] + ", " + oViaje['pais-destino'];
            
            var flight = { origen:null,destino:null};
            
            geocoder.geocode( { 'address':sAdressOrigen }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    flight.origen = results[0].geometry.location;
                    if( flight.destino !== null ){
                        addFlight( flight, sColor, sIcon, sTitle, infowindow );
                    }
                } else {
                    console.log( oViaje );
                    console.log('Geocode was not successful for the following reason: ' + status);
                    var dDelay = Math.random(1,10)*100;
                    setTimeout( function(){ runQueue(); },dDelay);
                }
            });
            geocoder.geocode( { 'address':sAdressDestino }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    flight.destino = results[0].geometry.location;
                    if( flight.origen !== null ){
                        addFlight( flight, sColor, sIcon, sTitle, infowindow );
                    }
                } else {
                    console.log( oViaje );
                    console.log('Geocode was not successful for the following reason: ' + status);
                    var dDelay = Math.random(1,10)*100;
                    setTimeout( function(){ runQueue(); },dDelay);
                }
            });   
        }
        
        function addFlight( oPath, sColor, sIcon, sTitle, infowindow ){
            
            addMarker( oPath.origen, sIcon, sTitle, infowindow );
            addMarker( oPath.destino, sIcon, sTitle, infowindow );
            
            var aPath = [ oPath.origen,oPath.destino ];
            var flightPath = new google.maps.Polyline({
                    path: aPath,
                    geodesic: true,
                    strokeColor: sColor, //'#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                 });

            flightPath.setMap(map);
            
            // Run queue to add another element
            var dDelay = Math.random(1,10)*100;
            setTimeout( function(){ runQueue(); },dDelay);
        }
            
        
        function addMarker( position, sIcon, title, infowindow ){
            var marker = new google.maps.Marker({
                map: map,
                position: position,
                icon: sIcon,
                title: title
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });
        }
    </script>
</head>
<body>
    <div class="principal" >
        <h1>DCC Express</h1>
        <br>
        <div class="botones">
            <a class="boton" href="agregar-viaje.php" >Agregar Viaje</a>
            <a class="boton" href="agregar-encargo.php" >Agregar Encargo</a>
            <a class="boton" href="ver-viajes.php" >Ver Viajes</a>
            <a class="boton" href="ver-encargos.php" >Ver Encargos</a>
        </div>
        <br>
        <div id="map-canvas"></div>
    </div>
</body>
</html>