<?php 
// Fix for special characters
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

// Defining constants 
include_once("apikey.secret.php");

// Input is what we get from the user/form
$input = "Erthainel, eune\nRuzgud, eune\nTSM Bjergsen, na\nShaterane, eune";

// Strip spaces (API ignores them anyway)
$input = str_replace(' ', '', $input);   // remove spaces

// Explode by line-ends (every line = one summoner)
$summoners_array = explode("\n", $input);
// !debug
//var_dump($summoners_array);

// Empty array for sorted summoners
$summoners_sorted_array = array();
// !debug
//var_dump($summoners_sorted_array);

// Cycle that will go through all summoners and sort them into their regions
foreach ($summoners_array as $summoner_and_region) {  // For each summoner
    $explode = explode(",", $summoner_and_region);  // Explode by "," (separate summoner and region)
    
    // Properly name variables for future use
    $summoner = preg_replace('/\s+/', '', $explode[0]); // remove all whitespace characters
    $region = $explode[1];
    
    // If that region does not exist yet, create it
    if(!isset($summoners_sorted_array[$region])) {
        $summoners_sorted_array[$region] = array();
    } 
    
    // Push into region (has to exist due to previous if)
    array_push($summoners_sorted_array[$region], $summoner);
}

// !debug
var_dump($summoners_sorted_array);
print("\n\n\n");

/* ---- END of pure sorter, group debug beginning ---- */
print("Including group.php\n");
include_once("group.php");
print("Creating group object...\n");
$group = new Group($summoners_sorted_array);
print("Done.\n")
?>