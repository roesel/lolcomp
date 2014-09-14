<?php
require('__init.php');

/* ---------------------------------------------------------------------------*/

if (isset($_GET["region"]) && 
	isset($_GET["id"]) && 
	isset($_GET["name"]) && 
	isset($_GET["profile_icon_id"]) && 
	isset($_GET["revision_date"]) && 
	isset($_GET["summoner_level"]))
{
    // get input parametres
	$general = array(
		"region"=>$_GET["region"], 
		"id"=>$_GET["id"], 
		"name"=>$_GET["name"], 
		"profile_icon_id"=>$_GET["profile_icon_id"], 
		"revision_date"=>$_GET["revision_date"], 
		"summoner_level"=>$_GET["summoner_level"],
		);
}

/* ---------------------------------------------------------------------------*/

$p = new Player($general);


// stats
$stats = $p->getStats();

dump($stats);
/* -------------------------------------------------------------------------- */
