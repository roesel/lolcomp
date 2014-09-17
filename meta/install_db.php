<?php
// The point of this file is to be ran 1 time to set up all the tables necessary for lolscores to run.
// This script uses .sql files that have to be UPDATED after every structural change to the database.
define('WEBSECURITY', 'ok');
require('../__init.php');
if (isset($_GET["hash"]) && defined('SAFETY_HASH') && ($_GET["hash"]==SAFETY_HASH)) {
	dibi::loadFile('../sql/lolscores.sql');
	print("DB install is done.");
} else {
	print("Stop hacking pls.");
}
?>