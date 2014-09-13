<?php
/* -- Including objects for esting ------------------------------------------ */
include_once("player.php");

require('tracy/tracy.php');
use Tracy\Debugger;
Debugger::enable();

/* -- Defining constants ---------------------------------------------------- */
include_once("apikey.secret.php");

/* ---------------------------------------------------------------------------*/

// set input parametres
$general = array(
    "region"=>"eune", 
    "id"=>21631229, 
    "name"=>"Shaterane", 
    "profile_icon_id"=>"660", 
    "revision_date"=>"1410395280000", 
    "summoner_level"=>"30",
    );


/* ---------------------------------------------------------------------------*/

$p = new Player($general);


// stats
$stats = $p->stats;

//var_dump($stats);
/* -------------------------------------------------------------------------- */

include_once("dibi.min.php");
include_once("db.secret.php");
dibi::connect($mysql_credentials);
unset($mysql_credentials);

$id = $stats["general"]["id"];
$region = $stats["general"]["region"];
$stat_section = "unranked"; //"unranked"
$table = $stat_section;

$row = $stats[$stat_section];
$row["id"]=$id;
$row["region"]=$region;

/* ---------------------------------------------------------------------------*/
// select
$res = dibi::select('*')
    ->from($table)
    ->orderBy('id')
    ->execute();
$result = $res->fetchAll();

$returned_rows = sizeof($result);
if ($returned_rows>0) {
    for ($i=0; $i<$returned_rows; $i++) {
        foreach($result[$i] as $stat) {
            print($stat."\t");
        }
        print("\n");
        
    }
} else {
    print("No entries found!\n\n");
}


/* ---------------------------------------------------------------------------*/
//update

// bud if 1) exists 2) new enough -> leave be
// else if exists -> update
// else insert
dibi::insert($stat_section, $row)
    ->on('DUPLICATE KEY UPDATE %a ', $row)    
    //->where('id = %i and region = %s', $id, $region)
    ->execute();

print("\n\n");


/* ---------------------------------------------------------------------------
//insert
dibi::insert($stat_section, $row)->execute();

print("\n\n");
 ---------------------------------------------------------------------------*/

 // select
$res = dibi::select('*')
    ->from($table)
    ->orderBy('id')
    ->execute();
$result = $res->fetchAll();

$returned_rows = sizeof($result);
if ($returned_rows>0) {
    for ($i=0; $i<$returned_rows; $i++) {
        foreach($result[$i] as $stat) {
            print($stat."\t");
        }
        print("\n");
        
    }
} else {
    print("No entries found!\n\n");
}

/* ---------------------------------------------------------------------------*/
dump($general);
?>