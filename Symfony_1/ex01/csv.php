<?php
$filename   = "./ex01.txt";
$file       = fopen($filename, 'r') or die("Can't read file");
$strings    = fgetcsv($file);
fclose(($file));
foreach($strings as $str) {
    echo $str . "\n";
}
?>
