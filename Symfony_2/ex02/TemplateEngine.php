<?php
class TemplateEngine {
    
    private function getParameters(HotBeverage $drink): array {
        $reflect    = new ReflectionClass($drink);
        $params     = [];

        foreach ($reflect->getProperties() as $property) {
            $propertyName           = $property->getName();
            $getter                 = "get" . ucfirst($propertyName);
            $params[$propertyName]  = $drink->$getter();
        };

        $params["description"]  ??= "A random Beverage, smells good... Hopefully it's not poisoned";
        $params["comment"]      ??= "It's to die for !";
        return $params;
    }

    public function createFile(HotBeverage $text) {
        $templateName  = "./template.html";
        if (!is_readable($templateName))
            throw new Exception("Error: $templateName is not readable");

        $newHtml    = file_get_contents($templateName);
        if (!$newHtml)
            throw new Exception("Error: Couldn't open $templateName");

        $parameters = $this->getParameters($text);
        $filename   = $parameters["name"] . ".html";
        foreach($parameters as $key => $value) {
            $newHtml = str_replace([ "{" . $key . "}" ], $value, $newHtml);
        }
        if (!file_put_contents($filename, $newHtml))
            throw new Exception("Error: couldn't put data in $filename");
    }
}
