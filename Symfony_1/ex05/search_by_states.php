<?php
$STATES     = [
    'New Jersey'    => 'NJ',
    'Colorado'      => 'CO',
    'Alabama'       => 'AL',
    'Oregon'        => 'OR'
];
$CAPITALS   = [
    'AL' => 'Montgomery',
    'NJ' => 'Trenton',
    'KS' => 'Topeka',
    'OR' => 'Salem'
];

function search_by_states(string $states) {
    global  $STATES;
    global  $CAPITALS;
    $stateArr   = array_map('trim', str_getcsv($states, ','));
    foreach($stateArr as $state) {
        $abbr       = $STATES[$state] ?? null;
        $capital    = $CAPITALS[$abbr] ?? null;
        if ($capital)
            echo "$capital is the capital of $state\n";
        else if (array_search($state, $CAPITALS, false))
            echo "$state is a capital\n";
        else
            echo "$state  is neither a capital nor a state.\n";
    }
}
?>
