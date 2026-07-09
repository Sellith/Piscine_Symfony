<?php

function array2hash(array $arrays):array {
    $hash = [];
    foreach($arrays as $array) {
        $name  = $array[0];
        $age = $array[1];
        $hash[$age] = $name;
    }
    return $hash;
}
