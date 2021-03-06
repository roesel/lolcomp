<?php
/*-- Security check -----------------------------------------*/
if(!defined('WEBSECURITY')) exit;

/*-- Static class info, used get informations from database -----------------*/ 
class Info
{
    
/*-- Constructor -------------------------------------------------------------*/
    function __construct()
    {
    }
	
/*-- Static function to get available tables from database -------------------*/
	static function getAvailableTables()
	{
		$result = dibi::select('table_name, table_comment')
		   ->from('information_schema.tables')
		   ->where('table_schema = %s', 'lolscores') 
		   ->and('table_name')->like('%s', 'stats\_%')
		   ->or('table_name')->like('%s', 'ranked\_%')
		   ->execute();

		$result = $result->fetchAll();
		return $result;
	}
	
/*-- Static function to create table -----------------------------------------*/
// both header and body
	static function createTable($table, $group)
	{
		// header
		$header = array();
		
		$res = dibi::select('COLUMN_COMMENT, COLUMN_NAME')
			->from('information_schema.COLUMNS')
			->where('(TABLE_NAME = %s AND COLUMN_NAME = %s)', 'general', 'name')
			->or('(TABLE_NAME = %s AND COLUMN_NAME = %s)', 'general', 'id')
			->or('(TABLE_NAME = %s)', $table)
			->execute();
		$header = $res->fetchAll();
		
		// Changing header so that it fits the JOINed select
		$header[1]['COLUMN_COMMENT'] = 'Summoner name';  
		$header[1]['COLUMN_NAME']    = 'summoner_name';
		
		// body
		$existing_players = $group->getExistingPlayers();
		
		$t1_select = dibi::select('summoner_name, id')
			->as('id_general')
			->from('general');
		$t2_select = dibi::select("*")
			->from($table);
		$res = dibi::select('*')
			->from($t1_select)
			->as('t1')
			->innerJoin($t2_select)
			->as('t2')
			->on('t1.id_general = t2.id')
			->where('( id, region) ')
			->in($existing_players);
			
		// create column names to check if table can be ordered
		$column_names = array();
		foreach ($header as $column)
		{
			array_push($column_names, $column["COLUMN_NAME"]);
		}

		// check if ordering is set and according to it, rearrange selection from database
		if (isset($_SESSION["orderby"]) && isset($_SESSION["way"]))
		{
			if (in_array($_SESSION["orderby"], $column_names))
			{
				$res=$res->orderBy($_SESSION["orderby"]);
				if ($_SESSION["way"]=="asc")
				{
					$res = $res->asc();
				} 
				else
				{
					$res = $res->desc();
				}
			}
		}

		$res = $res->execute();
		$body = $res->fetchAll();
		
		$table_elements = array($header, $body);
		return $table_elements;
	}
}
/*-- End ---------------------------------------------------------------------*/
?>