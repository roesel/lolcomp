<?php 
// Including init (required files)
require('../__init.php'); 

// If there is POST data, save it into SESSION data
if (isset($_POST["players"]) && isset($_POST["table"])) {
		$_SESSION["players"] = $_POST["players"];
		$_SESSION["table"] = $_POST["table"];
}

if (isset($_GET["orderby"]) && isset($_GET["way"])) {
	$_SESSION["orderby"] = $_GET["orderby"];
	$_SESSION["way"] = $_GET["way"];
}

?>
<html>
<head>
	<title>LoLCompare version rofl</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="width:1700px;text-align:left;margin-left:auto;margin-right:auto;">

<div id="form" style="float:left;width:300px;margin-left:150px;">
	<form action="./<?php Printer::printGetParameters(); ?>" method="post">
	LoLCompare, version <strike>0.001</strike> rofl <br/>
	<textarea name="players" rows="20" cols="30">
Erthainel, eune
Ruzgud, eune
TSM Bjergsen, na
Shaterane, eune</textarea>
	<br/>
	Table:
	<select name="table">
		<?php 
			Printer::printAvailableTables(
				Info::getAvailableTables()
			);
		?>
	</select>
	<br/><input type="submit">
	</form>
</div>
<?php
	if (isset($_SESSION["players"]) && isset($_SESSION["table"])) {
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
</body>
</html>