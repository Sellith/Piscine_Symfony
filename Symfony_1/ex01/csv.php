<?php
$filename   = "./ex01.txt";
$file       = fopen($filename, 'r') or die("Can't read file");
$strings    = explode(',', fread($file, filesize($filename)));
fclose(($file));
foreach($strings as $str) {
    echo $str . "\n";
}
?>
