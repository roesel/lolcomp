<?php
require('__init.php');

/* -- Testing script for class player ----------------------------------------*/

/* -- If input region, id, name, profile icon id, revision date and level, ---*/
/* -- are set, proceed to save them into array -------------------------------*/
if (isset($_GET["region"]) && 
	isset($_GET["id"]) && 
	isset($_GET["name"]) && 
	isset($_GET["profile_icon_id"]) && 
	isset($_GET["revision_date"]) && 
	isset($_GET["summoner_level"]))
{
/* -- Save input parameters into general array -------------------------------*/
	$general = array(
		"region"=>$_GET["region"], 
		"id"=>$_GET["id"], 
		"name"=>$_GET["name"], 
		"profile_icon_id"=>$_GET["profile_icon_id"], 
		"revision_date"=>$_GET["revision_date"], 
		"summoner_level"=>$_GET["summoner_level"],
		);
}

/* -- Create instance player, with set parameters ----------------------------*/
$p = new Player($general);

/* -- Get all stats for the player (all game modes) and print them -----------*/
$stats = $p->getStats();
dump($stats);

/* -- End --------------------------------------------------------------------*/
?>