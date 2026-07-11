<?php
class TemplateEngine {
    
    
    public function __construct(
        private Elem $HTML
    ) {}

    public function createFile(string $filename) {
        
        if (file_put_contents($filename, $this->HTML->getHTML()) === false)
            throw new Exception("Error: couldn't put data in $filename");
    }
}
