<?php 
require('__init.php');
/* --------------------------------------------------- */

/* ---- END of pure sorter, group debug beginning ---- */
print("Including group.php\n");
include_once("group.php");
print("Including player.php\n");
include_once("player.php");
print("Creating group object...\n");

// Input is what we get from the user/form
$input = "Erthainel, eune\nRuuzgud, eune\nTSMBjergsen, na\nRaazhud, na";

$group = new Group($input);
print("Done.\n")
?>