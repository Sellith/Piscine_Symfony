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
        "span",
        "h1",
        "h2",
        "h3",
        "h4",
        "h5",
        "h6",
        "p",
        "b"
    ];

    private const SPECIAL_CASE = [
        "span",
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
    private function isSpecialCase(?string $element = null): bool {
        return in_array($element ?? $this->getMainElement(), self::SPECIAL_CASE, true);
    }


    private function indent(string $html): string {
        $lines      = explode(PHP_EOL, rtrim($html));
        $newHtml    = array_map(fn(string $line): string => "\t" . $line, $lines);
        return implode(PHP_EOL ,$newHtml) . PHP_EOL;
    }

    public function __construct(string $element, string|array|null $content = null) {
        $renderedContent = is_array($content) ? implode($content) : $content;
        if ($element === '') {
            $this->HTML = $renderedContent;
            return ;
        }

        $isVoid         = $this->isVoidElement($element);
        $this->HTML     = "<" . $element;
        $this->HTML    .= $isVoid ? ($content === null ? "" : " ") : ">";

        if ($content !== null) {
            if ($isVoid || $this->isTextElement()) {
                $this->HTML .= $renderedContent;
            } else {
                $this->HTML .= PHP_EOL . $this->indent($renderedContent);
            }
        }
        elseif (!$isVoid && !$this->isTextElement())
            $this->HTML .= PHP_EOL;

        $this->HTML   .= $isVoid ? "" : "</" . $element;
        $this->HTML   .= ">" . PHP_EOL;
    }

    public function pushElement(Elem $element): void {
        
        if ($this->isVoidElement())
            throw new Exception("Error: Void elements can't be parents");
        elseif ($this->isTextElement() && !$this->isSpecialCase())
            throw new Exception("Error: Text elements can't be parents");

        $lastClosingPos = strrpos($this->HTML, "<");
        
        if (!$this->isSpecialCase())
            $buff   = $this->indent($element->HTML);
        else
            $buff   = explode(PHP_EOL, rtrim($element->HTML));
        $this->HTML = substr_replace($this->HTML, $buff, $lastClosingPos, 0);
    }

    public function getHTML(): string {return $this->HTML;}
}
