<?php require('../__init.php'); ?>

<html>
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
		$group = new Group($input);
		
		print('<div id="print" style="float:left;width:700px;">');
		/* ----------------------------------- */
		$table = $_POST["table"];
		
		$header = Info::createTableHeader($table);
		$body = Info::createTableBody($table,$group);
		
		$printer = new Printer();
		$printer->printTable($header, $body);
		
		/* ----------------------------------- */
		print('</div>');
	} 
?>
</body>
</html>