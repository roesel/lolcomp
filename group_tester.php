<?php
/* -- Including objects for esting ------------------------------------------ */
require('tracy/tracy.php');
use Tracy\Debugger;
Debugger::enable();

/* ---------------------------------------------------------------------------*/


function saveIdsToDatabase($players_array) {
    include_once("dibi.min.php");
    include_once("db.secret.php");
    dibi::connect($mysql_credentials);
    unset($mysql_credentials);
    
    foreach ($players_array as $player) {
        dibi::insert('group', $player)
            ->on('DUPLICATE KEY UPDATE %a ', $player)    
            ->execute();
    }
}

$players_array = array(
                        array(
                            "name" => "Shaterane",
                            "id" => 63486453,
                            "region" => "eune",
                        ),
                        array(
                            "name" => "Erthainel",
                            "id" => 22286453,
                            "region" => "eune",
                        ),
                       );
saveIdsToDatabase($players_array);
                       
?>