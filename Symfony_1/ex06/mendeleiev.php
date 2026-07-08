<?php
define("NAME", 0);
define("POS", 1);
define("NUM", 2);
define("SMALL", 3);
define("MOLAR", 4);
define("ELECTRON", 5);

try {
    $fileName   = "./ex06.txt";
    $newFileName= "./mendeleiev.html";

    if (!is_readable($fileName))
        throw new Exception("Error: Can't read $fileName");

    $fileArr    = file($fileName);

    
    if (file_exists($newFileName) && !is_writable($newFileName))
        throw new Exception("Error: Can't write in $newFileName");

    $newFilePtr = fopen($newFileName, 'w');
    if (!$newFilePtr)
        throw new Exception("Error: Couldn't open $newFileName");

    $finaleHtml = "<html><body><table>\n<tr>\n";
    $lastPos    = 0;
    
    function parseLine(string $line):array {
        [$name, $buff]  = explode('=', $line, 2);
        $ret            = [NAME => trim($name)];
        $i              = 1;
        foreach(explode(',', $buff) as $part)
            $ret[$i++]  = trim(explode(':', $part)[1]);
        return $ret;
    }
    
    foreach($fileArr as $line) {
        $rowArr     = parseLine($line);
        if ($rowArr[POS] < $lastPos)
            $finaleHtml .= "</tr>\n<tr>";
        else if ($rowArr[POS] > $lastPos + 1) {
            $gap         = $rowArr[POS] - $lastPos - 1;
            $finaleHtml .= "<td colspan=\"$gap\"></td>\n";
        }
        $finaleHtml.= "<td>\n<h4>{$rowArr[NAME]}</h4>\n";
        $finaleHtml.= "<ul>\n";
        $finaleHtml.= "<li>{$rowArr[NUM]}</li>\n";
        $finaleHtml.= "<li>{$rowArr[SMALL]}</li>\n";
        $finaleHtml.= "<li>{$rowArr[MOLAR]}</li>\n";
        $finaleHtml.= "<li>{$rowArr[ELECTRON]}</li>\n";
        $finaleHtml.= "</ul>\n</td>\n";
        $lastPos    = $rowArr[POS];
    }
    $finaleHtml     = substr($finaleHtml, 0, strlen($finaleHtml));
    $finaleHtml    .= "</tr>\n</table></body></html>";
    if (!fwrite($newFilePtr, $finaleHtml)) 
        throw new Exception("Error: Couldn't write in $newFileName");
    if (!fclose($newFilePtr))
        throw new Exception("Error: Couldn't close $newFileName");
    
} catch (Exception $e) {
    die($e->getMessage());
}
?>
