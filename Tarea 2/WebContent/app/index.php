<?php
/**
 * Index file inizialize the php components to use
 */

echo getcwd();

include_once '/core/databaseController.php';

$GLOBALS['db'] = new DatabaseController('localhost','root','hola','tarea2');

