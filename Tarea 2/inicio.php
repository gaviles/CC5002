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
        function initialize() {
            var mapOptions = {
              zoom: 1,
              center: new google.maps.LatLng(0,0)
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
            geocoder = new google.maps.Geocoder();
            
            for(var i in encargos ){
                var encargo = encargos[i];
                if( i < _Max_NUM_ELEMNETS ) addEncargo(encargo);
            }
            for(var i in viajes ){
                var viaje = viajes[i];
                if( i < _Max_NUM_ELEMNETS ) addViaje(viaje);
            }
        }
        google.maps.event.addDomListener(window, 'load', initialize);
        
        
        
        function addEncargo( oEncargo ){
            var adressOrigen = oEncargo['ciudad-origen'] + ", " + oEncargo['pais-origen'];
            addMarker( adressOrigen, "img/repo/package-in.png");
            var adressDestino = oEncargo['ciudad-destino'] + ", " + oEncargo['pais-destino'];
            addMarker( adressDestino, "img/repo/package-out.png");
        }
        
        function addViaje( oViaje ){
            console.log( oViaje );
            var sAdressOrigen = oViaje['ciudad-origen'] + ", " + oViaje['pais-origen'];
            var sAdressDestino = oViaje['ciudad-destino'] + ", " + oViaje['pais-destino'];
            
            var flight = { origen:null,destino:null};
            
            geocoder.geocode( { 'address':sAdressOrigen }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    flight.origen = results[0].geometry.location;
                    if( flight.destino !== null ){
                        addFlight( oViaje, flight  );
                        console.log( oViaje );
                    }
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
            geocoder.geocode( { 'address':sAdressDestino }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    flight.destino = results[0].geometry.location;
                    if( flight.origen !== null ){
                        addFlight( oViaje, flight  );
                        console.log( oViaje );
                    }
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });   
        }
        
        function addFlight( oViaje, oPath  ){
            console.log( oPath );
            var aPath = [ oPath.origen,oPath.destino ];
            var flightPath = new google.maps.Polyline({
                    path: aPath,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                 });

            flightPath.setMap(map);
        }
            
        
        function addMarker( sAdress, sIcon ){
            geocoder.geocode( { 'address':sAdress }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                  var marker = new google.maps.Marker({
                      map: map,
                      position: results[0].geometry.location,
                      icon: sIcon
                  });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
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