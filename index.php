<?php 
define('WEBSECURITY', 'ok');

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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41604637-2', 'auto');
  ga('send', 'pageview');

</script>
<body style="background:url(img/background.jpg);color:white;">
	<div id="wrapper" style="width:1700px;text-align:left;margin-left:10px;margin-right:auto;margin-top:20px;">
		<div id="form" style="float:left;width:300px;margin-left:20px;">
			<form action="./<?php Printer::printGetParameters(); ?>" method="post">
			<a href="<?php print(WEB_ROOT);?>"><img src="img/logo.png" style="width:220px;margin-top:-20px;margin-left:-8px;" /></a>
			<!--<p style="text-align:center;color:gray;font-size:0.8em;"><?php Printer::printVersion(); ?></p>-->
			<h3>Players:</h3>
			<textarea name="players" rows="20" cols="30" style="height:350px;"><?php Printer::printPlayers(); ?></textarea>
			<br/>
			<h3>Table:</h3>
			<select name="table">
				<?php
					// create list of tables to choose from
					Printer::printAvailableTables(
						Info::getAvailableTables()
					);
				?>
			</select>
			<br/><input type="submit" value="Submit" style="">
			</form>
			
		</div>
		<?php
		/*-- Create table of players, according to chosen type of game ---------------*/
			print('<div id="print" style="float:left;width:700px;">');
			
			if (isset($_SESSION["players"]) && isset($_SESSION["table"]))
			{
				$input = $_SESSION["players"];
				$table = $_SESSION["table"];

				$group = new Group($input);
				
				
				
				if ($group->isEmpty())
				{
					Printer::printIntro();
				} 
				else 
				{
					// elements of table - header and body
					$table_elements = Info::createTable($table,$group);
					
					// print whole table
					Printer::printTable($table_elements);
				}
				// print errors
				Printer::printErrors($group->getErrors());
				
			} 
			else 
			{
				Printer::printIntro();
			}
			
				
			
			
			print('</div>');
			
		?>
			
	</div><?php
			Printer::printFooter();
			?>
</body>
</html>