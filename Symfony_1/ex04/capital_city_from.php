<?php
$STATES     = [
    'New Jersey'    => 'NJ',
    'Colorado'      => 'CO',
    'Alabama'       => 'AL',
    'Oregon'        => 'OR'
];
$CAPITALS   = [
    'AL' => 'Montgomery',
    'NJ' => 'trenton',
    'KS' => 'Topeka',
    'OR' => 'Salem'
];

function capital_city_from(string $state):string {
    global  $STATES;
    global  $CAPITALS;
    $abbr   = $STATES[$state] ?? null;
    return $CAPITALS[$abbr] ?? 'Unknown';
}
