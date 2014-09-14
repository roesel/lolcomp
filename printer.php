<?php 
/* Fix for special characters */
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

class Printer
{
    
    function __construct()
    {

    }
	
	function printTable($table)
	{
		print("<table style=\"width:100%\">\n");
		foreach ($table as $row => $names)
		{
			print("\t<tr\n>");
			foreach ($names as $name => $value)
			{
				print("\t\t<td>".$value."</td>\n");
			}
			print("\t</tr\n>");
		}
		print("</table>");
	}
}
?>