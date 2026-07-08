<?php
$filename   = "./ex0.txt";
$file       = @fopen($filename, 'r') or die("Can't read file\n");
$strings    = fgetcsv($file);
fclose(($file));
foreach($strings as $str) {
    echo $str . "\n";
}
?>
