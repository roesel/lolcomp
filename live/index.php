<?php require('../__init.php'); ?>

<html>
<head>
	<title>LoLCompare version rofl</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="width:1700px;text-align:left;margin-left:auto;margin-right:auto;">

<div id="form" style="float:left;width:300px;margin-left:150px;">
	<form action="./" method="post">
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
	if (isset($_POST["players"]) && isset($_POST["table"])) {
		
		$input = $_POST["players"];
		$table = $_POST["table"];

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