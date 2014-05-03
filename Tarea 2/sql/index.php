<?php

echo "holi :) 1</br> ";

$handle = fopen ("ciudad-pais.sql", "r");

$stringInsertHeader = "INSERT INTO tarea2.ciudad (pais, nombre) VALUES ";
$stringValues = "";
$maxStringLength = 16384;
$stringLength = 0;
$lines = 0;
$fileNum = 0;

$first  = new DateTime();


if ($handle) {
    while (($line = fgets($handle)) !== false) {
		$lines++;

		$aLine = explode("(",$line);
		$sValues = "(".explode(")",$aLine[2])[0].")";
		$iLength = strlen($sValues);
		
		if( ( $stringLength + strlen($sValues) + 2 ) >= $maxStringLength ){
			// Write file with the current contents
			$fileNum++;		
			
			$file_handle = fopen("cp{$fileNum}.sql", "w");
			$file_contents = $stringInsertHeader.$stringValues.";";
			fwrite($file_handle, $file_contents);
			fclose($file_handle);
			$stringLength = $iLength+1;
			$stringValues = $sValues;
			shell_exec("mysql -u root -phola < cp{$fileNum}.sql");
			echo " cp{$fileNum}.sql ";
		}else{
			if($stringLength >0){
				$stringValues.= ",".$sValues;
				$stringLength+= 1;
			}else{
				$stringValues.= $sValues;
			}

			$stringLength+= $iLength+1;
		}
  	}
} else {
    echo "<br> Error =( </br>";
} 

echo " Lines {$lines} </br>";
$second = new DateTime();
$diff = $first->diff( $second );
echo $diff->format( '%H:%I:%S' );
fclose($handle);
