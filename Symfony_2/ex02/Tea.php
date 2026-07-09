<?php
class Tea extends HotBeverage {

    private string $description = "An tastefull beverage made from brewing tea leaves, can be made of green, black or white tea leaves";
    private string $comment = "Really Tastefull ! With a bit of honney or sugar, it's delicious";

    public function __construct() {
        parent::__construct("Tea", 1.34, 13.99);
    }

    public function getDescription(): string {return $this->description;}
    public function getComment(): string {return $this->comment;}
}
