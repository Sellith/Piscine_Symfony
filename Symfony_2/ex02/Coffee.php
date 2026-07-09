<?php
class Coffee extends HotBeverage {

    private string $description = "An tastefull beverage made from roasting coffee beans";
    private string $comment = "Bah ! It's bitter !! I need Sugar and milk !!";

    public function __construct() {
        parent::__construct("Coffee", 4.2, 54.98);
    }

    public function getDescription(): string {return $this->description;}
    public function getComment(): string {return $this->comment;}
}
