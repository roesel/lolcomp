<?php 
require('__init.php');

/* -- Testing script for class group -----------------------------------------*/

/* -- END of pure sorter, group debug beginning ------------------------------*/
print("Including group.php\n");
include_once("group.php");
print("Including player.php\n");
include_once("player.php");
print("Creating group object...\n");

/* -- Hardcoded input from user ----------------------------------------------*/
$input = "Erthainel, eune\nShaterane, eune\nRuuzgud, eune\nTSMBjergsen, na\nRaazhud, na";

/* -- Create instance group, with input and print done -----------------------*/
$group = new Group($input);
print("Done.\n")

/* -- End -------------------------------------------------------------------- */
?>