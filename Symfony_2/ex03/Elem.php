<?php
class Elem {
    private const VOID_ELEM = [
        "meta",
        "link",    
        "img",
        "hr",
        "br"
    ];
    private const TEXT_ELEM = [
        "title",
        "h1",
        "h2",
        "h3",
        "h4",
        "h5",
        "h6",
        "p"
    ];

    private string $HTML;

    private function getMainElement(): string {
        preg_match('/^<(\w+)/', $this->HTML, $element);
        return $element[1];
    }

    private function isVoidElement(?string $element = null): bool {
        return in_array($element ?? $this->getMainElement(), self::VOID_ELEM, true);
    }
    private function isTextElement(?string $element = null): bool {
        return in_array($element ?? $this->getMainElement(), self::TEXT_ELEM, true);
    }


    private function indent(string $html): string {
        $lines      = explode(PHP_EOL, rtrim($html));
        $newHtml    = array_map(fn(string $line): string => "\t" . $line, $lines);
        return implode(PHP_EOL ,$newHtml) . PHP_EOL;
    }

    public function __construct(string $element, string|array|null $content = null) {
        $isVoid         = $this->isVoidElement($element); 
        $this->HTML     = "<" . $element;
        $this->HTML    .= $isVoid ? " " : (">" . PHP_EOL);

        if ($content !== null) {
            $renderedContent = is_array($content) ? implode($content) : $content;
            if ($isVoid) {
                $this->HTML .= $renderedContent;
            } else {
                $this->HTML .= $this->indent($renderedContent) ;
            }
        }
        
        $this->HTML   .= $isVoid ? "" : "</" . $element;
        $this->HTML   .= ">" . PHP_EOL;
    }

    public function pushElement(Elem $element): void {
        
        if ($this->isVoidElement())
            throw new Exception("Error: Void elements can't be parents");
        else if ($this->isTextElement())
            throw new Exception("Error: Text elements can't be parents");

        $lastClosingPos = strrpos($this->HTML, "<");
        
        $buff   = $this->indent($element->HTML);
        $this->HTML = substr_replace($this->HTML, $buff, $lastClosingPos, 0);
    }

    public function getHTML(): string {return $this->HTML;}
}
