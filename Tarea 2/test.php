<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'app/ini.php';

echo "<pre>";
var_dump($_REQUEST);
var_dump($_POST);
var_dump($_FILES);

//var_dump($db->encargo->get());

echo json_encode($db->encargo->get());

echo "</pre>";
?>

<script>
    a = <?php echo json_encode($db->encargo->get());?>;
    console.log(a);
    
</script>

primeros   50   caracteres   de   la  
descripción,   país   y   ciudad   origen,   país   y   ciudad   destino,   espacio   y   kilos.  

<table>
    <tr>
        <td>
            Origen:
            <ul>
                <li>País:</li>
                <li>Ciudad:</li>
            </ul>
            Destino:
            <ul>
                <li>País:</li>
                <li>Ciudad:</li>
            </ul>
        </td>
        <td>
            Requerimientos:
            <ul>
                <li>Espacio:</li>
                <li>Kilos:</li>
            </ul>
            Descripción:
            <ul>
                <li></li>
            </ul>
        </td>
    </tr>
</table>

<style>
    .info-window td{
    vertical-align: top;
    padding-right: 5px;
}

.info-window tr:first-child td:first-child{
    border-right-style: solid;
    border-right-width: 1px;
}
</style>
    

<table class="info-window"><tr><td>Origen:<ul><li>País:</li><li>Ciudad:</li></ul>Destino:<ul><li>País:</li><li>Ciudad:</li></ul></td><td>Ida:<ul><li>Fecha:</li></ul>Retorno:<ul><li>Fecha:</li></ul>Disponibilidad:<ul><li>Espacio:</li><li>Kilos:</li></ul></td></tr>
</table>