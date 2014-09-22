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
		<h3 style="margin-top:60px;margin-left:-30px;">&larr; 1. Input yourself and a few of your friends.</h3>
        <div id="example-wrapper">
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
		<div id="examples-info">
			<h2>Things to know:</h2>
				<p>This site is a work in progress. Please report any mistakes, ideas and/or errors to the <a href="http://redd.it/2h3afq">reddit thread</a>.</p>
				<p>Due to possible reddit hugs, this site can be unavailable. Sorry about that.</p>
				<p>The maximum amount of players you can view is '.MAX_NUM_PLAYERS.'.</p>
				<p>The maximum of new (not cached) players you can add per reload is '.MAX_NUM_CALLS.'.</p>
				<p>Some players are missing some statistics. This is caused by Riot and not us.</p>
		</div>
		</div>
		<h3 style="margin-left:-30px;margin-top:0px;">&larr; 2. Select the type of statistics you\'d like to compare.</h3>
		<h3 style="margin-top:35px;margin-left:-170px;">&larr; 3. Hit "Submit" and give us a few seconds.</h3>
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
	
	/*-- Static function to print the errors list ----------------------------*/
	static function printFooter()
	{
		print('<div id="footer">');
print('<p>Created by 
<strong>Shaterane</strong> (<a href="http://www.reddit.com/user/shaterane">/u/shaterane</a>, 
<a href="http://www.lolking.net/summoner/eune/21631229">Shaterane</a>@EUNE)
and
<strong>Erthy</strong> (<a href="https://twitter.com/erthylol">@ErthyLoL</a>, 
<a href="http://www.reddit.com/user/erthainel">/u/erthainel</a>, 
<a href="http://www.lolking.net/summoner/eune/26174422">Erthainel</a>@EUNE).</p>');
print('<p>This product is not endorsed, certified or otherwise approved in any way by Riot Games, Inc. or any of its affiliates.</p>');
print('<p>Background from <a href="http://www.lolskill.net">LoLSkill</a>, logo by <a href="#">Chalcedony</a>@EUNE.</p>');
print('<p>Also check out our <a href="http://broukej.cz/lol-signatures/">LoL Signature Maker</a>.');

		print('</div>');
		
	}
}
/*-- End ---------------------------------------------------------------------*/
?>