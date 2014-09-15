<?php
// The point of this file is to be ran 1 time to set up all the tables necessary for lolscores to run.
// This script uses .sql files that have to be UPDATED after every structural change to the database.

require('../__init.php');

dibi::loadFile('../sql/lolscores.sql');

print("\n\nDB install is done.");
?>