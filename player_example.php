<?php
/* takes stats: ?region=eune&id=21631229&name=Shaterane&profile_icon_id=660&revision_date=1410395280000&summoner_level=30 */
include_once("player.php");

/* -- Defining constants ---------------------------------------------------- */
include_once("apikey.secret.php");

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
$stats = $p->stats;

var_dump($stats);
/* -------------------------------------------------------------------------- */
