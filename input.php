<html>
<body style="width:1700px;text-align:left;margin-left:auto;margin-right:auto;">

<div id="form" style="float:left;width:300px;margin-left:150px;">
	<form action="input.php" method="post">
	LoLCompare, version <strike>0.001</strike> rofl <br/>
	<textarea name="players" rows="20" cols="30">
Erthainel, eune
Ruzgud, eune
TSM Bjergsen, na
Shaterane, eune</textarea>
	<br/>
	Table:
	<select name="table">
		<option value="stats_unranked" selected="selected">stats_unranked</option>
		<option value="stats_ascension" >stats_ascension</option>
	</select>
	<br/><input type="submit">
	</form>
</div>
<?php
	if (isset($_POST["players"]) && isset($_POST["table"])) {
		require('__init.php');
		
		$input = $_POST["players"];
		
		include_once("group.php");
		include_once("player.php");
		
		$group = new Group($input);
		
		print('<div id="print" style="float:left;width:700px;">');
		/* ----------------------------------- */
		$table = $_POST["table"];
		$existing_players = $group->getExistingPlayers();
		
		$res = dibi::select('*')
			->from($table)
			->where('( id, region) ')
			->in($existing_players)
			->execute();
		$result = $res->fetchAll();
		
		$comments = array();
		$res = dibi::select('COLUMN_COMMENT')
			->from('information_schema.COLUMNS')
			->where('TABLE_NAME = %s', $table)
			->execute();
		$comments = $res->fetchAll();

		$printer = new Printer();
		$printer->printTable($comments, $result);
		
		/* ----------------------------------- */
		print('</div>');
	} 
?>
</body>
</html>