<html>
<body style="width:1700px;text-align:center;margin-left:auto;margin-right:auto;">

<div id="form" style="float:left;width:500px;">
	<form action="input.php" method="post">
	LoLCompare, version <strike>0.001</strike> rofl <br/>
	<textarea name="players" rows="20" cols="30">
Erthainel, eune
Ruzgud, eune
TSM Bjergsen, na
Shaterane, eune</textarea>
	<br/><input type="submit">
	</form>
</div>
<?php
	if (isset($_POST["players"])) {
		require('__init.php');
		
		$input = $_POST["players"];
		
		include_once("group.php");
		include_once("player.php");
		
		$group = new Group($input);
		
		print('<div id="print" style="float:left;width:700px;">');
		/* ----------------------------------- */
		$table = "stats_unranked";
		$existing_players = $group->getExistingPlayers();
		
		$res = dibi::select('*')
			->from($table)
			->where('( id, region) ')
			->in($existing_players)
			->execute();
		$result = $res->fetchAll();
		
		dump($result);
		/*
		$printer = new Printer();
		$printer->printTable($result);
		*/
		
		/* ----------------------------------- */
		print('</div>');
	} 
?>
</body>
</html>