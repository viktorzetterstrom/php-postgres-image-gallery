<?php

$myFile = "../writeable/testFile.txt";

$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = "Lite data att skriva till filen för att se att det fungerar\n";
fwrite($fh, $stringData);
fclose($fh);

$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);

header("Content-Type: text/plain; charset=utf-8"); 
echo $theData;

?>
