<?php 
/*-- Including init (required files) -----------------------------------------*/
require('__init.php'); 

// If POST data exist, save them into SESSION data
if (isset($_POST["players"]) && isset($_POST["table"])) 
{
	$_SESSION["players"] = $_POST["players"];
	$_SESSION["table"] = $_POST["table"];
}

if (isset($_GET["orderby"]) && isset($_GET["way"])) 
{
	$_SESSION["orderby"] = $_GET["orderby"];
	$_SESSION["way"] = $_GET["way"];
}

?>
<html>
<head>
	<title>LoLScores - Compare your scores with friends!</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background:url(img/background.jpg);color:white;">
	<div id="wrapper" style="width:1700px;text-align:left;margin-left:auto;margin-right:auto;">

	<div id="form" style="float:left;width:300px;margin-left:150px;">
		<form action="./<?php Printer::printGetParameters(); ?>" method="post">
		<h1>LoLScores (alpha)</h1>
		<p><?php Printer::printVersion(); ?></p>
		<textarea name="players" rows="20" cols="30"><?php Printer::printPlayers(); ?></textarea>
		<br/>
		Table:
		<select name="table">
			<?php
				// create list of tables to choose from
				Printer::printAvailableTables(
					Info::getAvailableTables()
				);
			?>
		</select>
		<br/><input type="submit">
		</form>
	</div>
	<?php
	/*-- Create table of players, according to chosen type of game ---------------*/
		if (isset($_SESSION["players"]) && isset($_SESSION["table"]))
		{
			$input = $_SESSION["players"];
			$table = $_SESSION["table"];

			$group = new Group($input);
			
			print('<div id="print" style="float:left;width:700px;">');
			
			$header = Info::createTableHeader($table);
			$body = Info::createTableBody($table,$group);
			
			Printer::printTable($header, $body);
			
			print('</div>');
		} 
	?>
	</div>
</body>
</html>