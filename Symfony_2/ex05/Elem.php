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
        "html"  => ["head", "body"],
        "head"  => ["title", "meta"],
        "table" => ["tr"],
        "tr"    => ["th", "td"],
        "ul"    => ["li"],
        "ol"    => ["li"]
    ];

    private string  $HTML;
    private string  $element;
    private array   $children = [];

    private function isValidElement(string $element): bool {
        return  $element === null
                    ? false 
                    : in_array($element ?? $this->element, self::VALID_ELEM, true);
    }

    private function elementChecker(array $valid, ?string $element = null): bool {
        return in_array($element ?? $this->element, $valid, true);
    }

    private function elementsChecker(array $valid, ?string $element = null): bool {
        foreach($valid as $array) {
            if (in_array($element ?? $this->element, $array, true))
                return true;
        }
        return false;
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

    private function pageChecker(self $elem): bool {
        if (count($elem->children) === 0)
            return true;
        if ($this->elementsChecker([self::TEXT_ELEM, self::VOID_ELEM], $elem->element))
            return false;

        foreach($elem->children as $child) {
            if (!$this->pageChecker($child))
                return false;
        }

        foreach($elem->children as $child) {
        if (isset(self::VALID_CHILDRENS[$elem->element]))
            if (!$elem->elementChecker(self::VALID_CHILDRENS[$elem->element], $child->element))
                return false;
        }

        return true;
    }

    private function getAttributes(string $HTML): array {
        $start = strpos($HTML, " ") + 1;
        $end   = strpos($HTML, ">");
        $attr  = substr($HTML, $start, $end - $start);
        preg_match_all('/(\w+)="([^"]*)"/', $attr, $matches, PREG_SET_ORDER);

        $result = [];
        foreach($matches as $match) {
            $result[$match[1]] = $match[2];
        }
        return $result;
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

    /* 
        @brief for this exercise's sake, all verifications will be commented
     */
    public function pushElement(self $data): void {
        
        // if ($this->elementChecker(self::VOID_ELEM))
        //     throw new MyException("Error: Void elements can't be parents\n");

        // elseif ($this->elementChecker(self::TEXT_ELEM))
        //     throw new MyException("Error: Text elements can't be parents\n");
        
        // $thisMainElem   = $this->element;
        // $elemMainElem   = $data->element;

        // if (isset(self::VALID_CHILDRENS[$thisMainElem]))
        //     if (!$this->elementChecker(self::VALID_CHILDRENS[$thisMainElem], $elemMainElem))
        //         throw new MyException("Error: Invalid $thisMainElem child\n");

        if ($this === $data) return ;
        $this->children[]   = $data;
        $openingEndPos      = strpos($this->HTML, ">") + 1;
        $lastClosingPos     = strrpos($this->HTML, "<");
        $buff   = $openingEndPos === $lastClosingPos ? PHP_EOL : "";

        $buff  .= $this->indent($data->HTML);
        $this->HTML = substr_replace($this->HTML, $buff, $lastClosingPos, 0);
    }

    public function validPage(): bool {

        if ($this->element !== "html")                  return false;
        if (count($this->children) !== 2)               return false;
        if ($this->children[0]->element !== 'head' 
            || $this->children[1]->element !== 'body')  return false;
        $head           = $this->children[0];
        $metaCharset    = 0;
        $title          = 0;
        foreach($head->children as $child) {
            if ($child->element === "title")
                $title++;
            elseif ($child->element === "meta") {
                $attr   = $this->getAttributes($child->HTML);
                if (key_exists("charset", $attr))
                    $metaCharset++;
            }
        }
        if ($metaCharset !== 1 || $title !== 1)         return false;
        if (!$this->pageChecker($this))                 return false;
        return true;
    }

    public function getHTML(): string {return $this->HTML;}


}
