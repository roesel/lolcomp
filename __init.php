<?php
/* Init script for lolcompare - setting you up with everything you need.      */

/* -- Setting safety variable ----------------------------------------------- */
// todo - safety variable - if not set, exit.

/* -- Setting safety variable ----------------------------------------------- */
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

/* -- Including classes ----------------------------------------------------- */
include_once("class/player.class.php");
include_once("class/group.class.php");
include_once("class/printer.class.php");
include_once("class/info.class.php");

/* -- Enabling Tracy Debugger ----------------------------------------------- */
require('lib/tracy/tracy.php');
use Tracy\Debugger;
Debugger::enable();

/* -- Loading in secrets -----------------------------------------------------*/
include_once('secrets/db.secret.php');      // Database credentials
include_once('secrets/apikey.secret.php');  // API key

/* -- Setting up database connection -----------------------------------------*/
require('lib/dibi.min.php');
dibi::connect($mysql_credentials);
unset($mysql_credentials);

/* -- Defining constants -----------------------------------------------------*/
const MAIN_CACHE_TIME = 30;  // time in seconds, 30 for debug, 6*60*60 for live?

/* -- Start session ----------------------------------------------------------*/
session_start();

/* ---------------------------------------------------------------------------*/
?>