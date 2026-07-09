<?php
class TemplateEngine {
    
    public function createFile(string $filename, Text $text) {
        $newHtml    = "<html><body>\n" 
            . implode($text->readData()) 
            . "</body></html>";
        if (file_put_contents($filename, $newHtml) === false)
            throw new Exception("Error: couldn't put data in $filename");
    }
}
