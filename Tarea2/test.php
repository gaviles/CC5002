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


echo exec('whoami');