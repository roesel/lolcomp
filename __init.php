<?php
/* -- Init script for lolscores - setting you up with everything you need. --*/

/* -- Setting safety variable ------------------------------------------------*/
if(!defined('WEBSECURITY')) exit;

/* -- Setting safety variable ------------------------------------------------*/
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

/* -- Including classes ------------------------------------------------------*/
include_once("class/player.class.php");
include_once("class/group.class.php");
include_once("class/printer.class.php");
include_once("class/info.class.php");

/* -- Enabling Tracy Debugger ------------------------------------------------*/
require('lib/tracy/tracy.php');
use Tracy\Debugger;
Debugger::enable();

/* -- Loading in secrets -----------------------------------------------------*/
include_once('secrets/db.secret.php');      // Database credentials
include_once('secrets/apikey.secret.php');  // API key

/* -- Setting up database connection -----------------------------------------*/
require('lib/dibi.min.php');
dibi::connect($mysql_credentials);			// connect to mysql database
unset($mysql_credentials);					// security unset of credentials 

/* -- Start session ----------------------------------------------------------*/
session_start();

/* -- End---------------------------------------------------------------------*/
?>