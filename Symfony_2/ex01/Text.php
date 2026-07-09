<?php
class Text {
    private array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }
    public function readData():array {
        $formatedData = [];
        foreach($this->data as $strs) {
            $formatedData[] = "<p>" . $strs . "</p>\n";
        }
        return $formatedData;
    }
    public function append(string $str) {
        $this->data[] = $str;
    }
}
