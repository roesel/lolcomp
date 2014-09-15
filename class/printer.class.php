<?php 

class Printer
{
    
    function __construct()
    {

    }
	
	static function printAvailableTables($available_tables) 
	{
		foreach ($available_tables as $table)
		{
			if (isset($_SESSION["table"]) && $_SESSION['table'] == $table['table_name'])
			{
				printf('<option value="%s" selected = "selected">%s</option>', $table['table_name'], $table['table_comment']);
			}
			else
			{
				printf('<option value="%s" >%s</option>', $table['table_name'], $table['table_comment']);
			}
		}
	}
	
	static function printTable($head,$table)
	{
		print('<table style=\"width:100%\" id="box-table-a">');
		print('<tr>');
		
		foreach ($head as $column => $names)		//header
		{
			$col_name = $names['COLUMN_COMMENT'];
			$col_id = $names['COLUMN_NAME'];
			if ($col_id != 'id') {  // asi existuje lepsi reseni, databaze by to mohla rovnou davat bez toho
				
				print('<th>'.$col_name);
				print('
						<a href="./?orderby='.$col_id.'&way=desc">&blacktriangledown;</a>
						<a href="./?orderby='.$col_id.'&way=asc"> &blacktriangle;  </a>
						</th>'
				);
					
				
			}
		}
		print("</tr>");
		
		foreach ($table as $row => $names)			//body
		{
			print("<tr>");
			foreach ($names as $name => $value)
			{
				if (($name != 'id') && ($name != 'id_general')) {  // asi existuje lepsi reseni, databaze by to mohla rovnou davat bez toho
					print("<td>".$value."</td>");
				}
			}
			print("</tr>");
		}
		print("</table>");
	}
	
	static function printGetParameters()
	{
		if (isset($_SESSION["orderby"]) && isset($_SESSION["way"])) {
			print("?orderby=".$_SESSION["orderby"]."&way=".$_SESSION["way"]);
		} else {
			print("");
		}
	}
	
	static function printPlayers()
	{
		if (isset($_SESSION["players"])) {
			print($_SESSION["players"]);
		} else {
			print("Erthainel, eune
Ruzgud, eune
TSM Bjergsen, na
Shaterane, eune");
		}
	}
}
?>