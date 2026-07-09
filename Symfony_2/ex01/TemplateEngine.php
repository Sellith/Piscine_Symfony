<?php
class TemplateEngine {
    
    public function createFile(string $filename, object $text) {
        $newHtml    = "<html><body>\n" 
            . implode($text->readData()) 
            . "</body></html>";
        if (!file_put_contents($filename, $newHtml))
            throw new Exception("Error: couldn't put data in $filename");
    }
}
