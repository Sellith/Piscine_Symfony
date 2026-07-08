<?php
class TemplateEngine {
    
    public function createFile(
            string $filename, 
            string $templateName, 
            array $parameters) {

        if (!is_readable($templateName))
            throw new Exception("Error: $templateName is not readable");

        $newHtml    = file_get_contents($templateName);
        if (!$newHtml)
            throw new Exception("Error: Couldn't open $templateName");

        foreach($parameters as $key => $value) {
            $newHtml = str_replace([ "{" . $key . "}" ], $value, $newHtml);
        }
        if (!file_put_contents($filename, $newHtml))
            throw new Exception("Error: couldn't put data in $filename");
    }
}

?>
