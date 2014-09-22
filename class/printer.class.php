<?php 
/*-- Security check -----------------------------------------*/
if(!defined('WEBSECURITY')) exit;

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
	static function printTable($table)
	{
		$head = $table[0];		// header of table
		$body = $table[1];		// body of table
		
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
		foreach ($body as $row => $names)
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
		print("</body>");
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
			print("");
		}
	}
	
	static function printVersion() {
		print('version: <strike>0.003</strike> hihi');
	}
	
	/*-- Static function to print the basic usage of the app -----------------*/
	static function printIntro()
	{
		print('
		<h1>How to start:</h1>
		<h3 style="margin-top:85px;margin-left:-50px;">&larr; 1. Input yourself and a few of your friends.</h3>
        <div id="examples">
            <h2>For example:</h2>
                <p>
SKT T1 Faker, kr<br/>
KvotheKelsier, kr<br/>
Fnatic xMid, kr<br/>
S4WC FNC Rekkles, kr<br/>
EunjiSuzy, kr<br/>
Alliance Froggen, kr<br/>
YuNg TuRtLe, kr<br/>
C9 Sneaker, kr<br/>
Ding12, kr<br/>
Faded Sound, kr<br/>
MMMMMMor, kr<br/>
Alliance Nyph, kr<br/>
ice cold water, kr<br/>
Alliance Shook, kr<br/>
넌나한태오빠야, kr<br/>
WOW 150 PING, kr<br/>
roro1, kr<br/>
SK Jungler, kr<br/>
SK Jesiz, kr<br/>
Alliance Wickd, kr<br/>
                </p>
        </div>
		<h3 style="margin-left:-50px;">&larr; 2. Select the type of statistics you\'d like to compare.</h3>
		<h3 style="margin-top:35px;margin-left:-190px;">&larr; 3. Hit "Submit" and give us a few seconds.</h3>
		');
	}
	
	/*-- Static function to print the errors list ----------------------------*/
	static function printErrors($errors)
	{
		if ($errors!="") {
			print('<div class="errorbox"><p><strong>Errors:</strong></p><p style="padding-left:15px;">');
			print($errors);
			print('</p></div>');
		}
	}
}
/*-- End ---------------------------------------------------------------------*/
?>