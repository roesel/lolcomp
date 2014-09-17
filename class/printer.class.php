<?php 
/*-- Static class printer, used to print html code ---------------------------*/
class Printer
{
    
/*-- Constructor -------------------------------------------------------------*/
    function __construct()
    {
    }

/*-- Static function to print names of available tables into selection -------*/
	static function printAvailableTables($available_tables) 
	{
		foreach ($available_tables as $table)
		{
			if (isset($_SESSION["table"]) && $_SESSION['table'] == $table['table_name'])	// remember previous input
			{
				printf('<option value="%s" selected = "selected">%s</option>', $table['table_name'], $table['table_comment']);
			}
			else																			// print other table names
			{
				printf('<option value="%s" >%s</option>', $table['table_name'], $table['table_comment']);
			}
		}
	}

/*-- Static function to print table of parameters ----------------------------*/
	static function printTable($head,$table)
	{
		// beggining of table
		print('<table style=\"width:100%\" id="box-table-a">');
		
		// header of table
		print('<tr>');
		foreach ($head as $column => $names)		
		{
			$col_name = $names['COLUMN_COMMENT'];
			$col_id = $names['COLUMN_NAME'];
			if ($col_id != 'id') 
			{
				print('<th>'.$col_name);
				print('<br/>
						<a href="./?orderby='.$col_id.'&way=desc" class="arrd">&blacktriangledown;</a>
						<a href="./?orderby='.$col_id.'&way=asc" class="arru"> &blacktriangle;  </a>
						</th>'
				);
			}
		}
		print("</tr>");
		
		// body of table
		foreach ($table as $row => $names)
		{
			print("<tr>");
			foreach ($names as $name => $value)
			{
				if (($name != 'id') && ($name != 'id_general'))
				{
					print("<td>".$value."</td>");
				}
			}
			print("</tr>");
		}
		print("</table>");
	}
	
/*-- Static function to print ordering of table ------------------------------*/
	static function printGetParameters()
	{
		if (isset($_SESSION["orderby"]) && isset($_SESSION["way"]))
		{
			print("?orderby=".$_SESSION["orderby"]."&way=".$_SESSION["way"]);
		} 
		else
		{
			print("");
		}
	}

/*-- Static function to print predefined players into selection --------------*/
	static function printPlayers()
	{
		if (isset($_SESSION["players"])) 
		{
			print($_SESSION["players"]);
		} else 
		{
			print("TSM Bjergsen, na
Torrda, eune
Chalcedony, eune");
		}
	}
	
	static function printVersion() {
		print('version: <strike>0.003</strike> hihi');
	}
	
	/*-- Static function to print ordering of table ------------------------------*/
	static function printIntro()
	{
		print('
		<h1>How to start:</h1>
		<h3 style="margin-top:50px;">&larr; 1. Input yourself and a few of your friends.</h3>
		<h3 style="margin-top:400px;">&larr; 2. Select the type of statistics you\'d like to compare.</h3>
		<h3 style="margin-top:35px;margin-left:-140px;">&larr; 3. Hit "Submit" and give us a few seconds.</h3>
		');
	}
}
/*-- End ---------------------------------------------------------------------*/
?>