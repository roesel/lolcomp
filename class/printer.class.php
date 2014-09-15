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
			if (isset($_POST["table"]) && $_POST['table'] == $table['table_name'])
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
			foreach ($names as $name => $value)
			{
				print("<th>".$value."</th>");
			}
		}
		print("</tr>");
		
		foreach ($table as $row => $names)			//body
		{
			print("<tr>");
			foreach ($names as $name => $value)
			{
				print("<td>".$value."</td>");
			}
			print("</tr>");
		}
		print("</table>");
	}
}
?>