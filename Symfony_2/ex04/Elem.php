<?php
class Elem {
    private const VALID_ELEM = [
        "html", "head", "meta", "title", "body", "h1",
        "h2", "h3", "h4", "h5", "h6", "p", "img",
        "hr", "br", "span", "div", 
        "table", "tr", "th", "td", "ul",
        "ol", "li" 
    ];
    private const VOID_ELEM = [ "meta", "link", "img", "hr", "br" ];
    private const TEXT_ELEM = [ "title", "span", "h1", "h2", "h3", "h4", "h5", "h6", "p" ];
    private const VALID_CHILDRENS = [
        "table" => ["tr"],
        "tr"    => ["th", "td"],
        "ul"    => ["li"],
        "ol"    => ["li"]
    ];

    private string $HTML;
    private string $element;

    private function isValidElement(string $element): bool {
        return  $element === null
                    ? false 
                    : in_array($element ?? $this->element, self::VALID_ELEM, true);
    }

    private function elementChecker(array $valid, ?string $element = null): bool {
        return in_array($element ?? $this->element, $valid, true);
    }

    private function indent(string $html): string {
        $lines      = explode(PHP_EOL, rtrim($html));
        $newHtml    = array_map(fn(string $line): string => "\t" . $line, $lines);
        return implode(PHP_EOL ,$newHtml) . PHP_EOL;
    }

    private function addAttribute(array $attributes): string {
        $attr = "";
        $array_keys = array_keys($attributes);
        $last_key   = end($array_keys);
        foreach($attributes as $key => $val) {
            $attr  .= " " . $key . "=\"" . $val . "\"";
        }
        return $attr;
    }
    private function addContent(string|array $content, bool $isVoid) {
        $renderedContent = is_array($content) ? implode($content) : $content;
        if ($isVoid || $this->elementChecker(self::TEXT_ELEM)) {
            $this->HTML .= $renderedContent;
        } else {
            $this->HTML .= PHP_EOL . $this->indent($renderedContent);
        }
    }
    private function createOpeningElem(string $element, ?array $attributes, bool $isVoid) {
        $this->HTML     = "<" . $element;

        if ($attributes !== null)
            $this->HTML.= $this->addAttribute($attributes);

        $this->HTML    .= $isVoid ? "" : ">";
    }


    public function __construct(
        string $element, 
        string|array|null $content = null, 
        ?array $attributes = null) {

        if (!$this->isValidElement($element))
            throw new MyException("Error: Non valid element: $element\n");
        
        $this->element  = $element;
        $isVoid         = $this->elementChecker(self::VOID_ELEM, $element);

        $this->createOpeningElem($element, $attributes, $isVoid);

        if ($content !== null)
            $this->addContent($content, $isVoid);

        $this->HTML   .= ($isVoid ? "" : "</" . $element) . ">" . PHP_EOL;
    }


    public function pushElement(self $data): void {
        
        if ($this->elementChecker(self::VOID_ELEM))
            throw new MyException("Error: Void elements can't be parents\n");

        elseif ($this->elementChecker(self::TEXT_ELEM))
            throw new MyException("Error: Text elements can't be parents\n");
        
        $thisMainElem   = $this->element;
        $elemMainElem   = $data->element;

        if (isset(self::VALID_CHILDRENS[$thisMainElem]))
            if (!$this->elementChecker(self::VALID_CHILDRENS[$thisMainElem], $elemMainElem))
                throw new MyException("Error: Invalid $thisMainElem child\n");

        $openingEndPos  = strpos($this->HTML, ">") + 1;
        $lastClosingPos = strrpos($this->HTML, "<");
        $buff   = $openingEndPos === $lastClosingPos ? PHP_EOL : "";

        $buff  .= $this->indent($data->HTML);
        $this->HTML = substr_replace($this->HTML, $buff, $lastClosingPos, 0);
    }



    public function getHTML(): string {return $this->HTML;}


}
