<?php
// The point of this file is to be ran 1 time to set up all the tables necessary for lolcompare to run.
// This script uses .sql files that have to be UPDATED after every structural change to the database.

include_once("dibi.min.php");
include_once("db.secret.php");
dibi::connect($mysql_credentials);
unset($mysql_credentials);

dibi::loadFile('sql/lolcompare.sql');

print("\n\nDB install is done.");
?>