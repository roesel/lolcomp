<?php
/* takes Name and Region: ?name=Erthainel&region=eune */
include_once("player.php");

function remoteFileExists($url) {
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);
    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
        if ($statusCode == 200) {
            $ret = true;   
        }
    }

    curl_close($curl);
    return $ret;
}

/* -- Defining constants ---------------------------------------------------- */
include_once("apikey.secret.php");

/* ---------------------------------------------------------------------------*/

if (isset($_GET["region"]) && isset($_GET["name"])){
    // get name and region
    $region = strtolower($_GET["region"]);
    $name = $_GET["name"];
}

/* ---------------------------------------------------------------------------*/



try {
    $p = new Player($name, $region);
    
} catch (Exception $e) {
    print("Object creation failed");
    exit();
}


// basic info
$id = $p->id;
$name = $p->name;

print("\nname: ".$name);
print("\nid: ".$id);
print("\n\n");

// general ranked status
$league = $p->league;
$tier = $p->tier;
$rank = $p->rank;
$rank_roman = $p->rank_roman;
$lp = $p->lp;
print("\nleague: ".$league);
print("\ntier: ".$tier);
print("\nrank: ".$rank);
print("\nrank_roman: ".$rank_roman);
print("\nlp: ".$lp);

print("\n\n");

// stats
$stats = $p->stats;

var_dump($stats);
/* -------------------------------------------------------------------------- */
