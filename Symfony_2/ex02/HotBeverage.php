<?php
class HotBeverage {
    
    public function __construct(
        protected readonly string   $name,
        protected readonly float    $resistance,
        protected float             $price
    ) {}

    public function getName():string {return $this->name;}
    public function getprice():float {return $this->price;}
    public function getResistance():float {return $this->resistance;}
}
