<?php 
class Info
{
    
    function __construct()
    {

    }
	
	static function getAvailableTables()
	{
		$result = dibi::select('table_name, table_comment')
			->from('information_schema.tables')
			->where('table_schema = %s and table_name', 'lolcompare')
			->like('%s', 'stats\_%')
			->execute();
		$result = $result->fetchAll();
		return $result;
	}
	
	static function createTableHeader($table)
	{
		$header = array();
		/*
		SELECT COLUMN_COMMENT, COLUMN_NAME FROM `information_schema`.`COLUMNS` 
		WHERE (TABLE_NAME = 'general' AND COLUMN_NAME = 'name') 
			OR  (TABLE_NAME = 'general' AND  COLUMN_NAME = 'id')
			 OR TABLE_NAME = 'stats_aram_unranked5x5';
		*/
		$res = dibi::select('COLUMN_COMMENT, COLUMN_NAME')
			->from('information_schema.COLUMNS')
			->where('(TABLE_NAME = %s AND COLUMN_NAME = %s)', 'general', 'name')
			->or('(TABLE_NAME = %s AND COLUMN_NAME = %s)', 'general', 'id')
			->or('(TABLE_NAME = %s)', $table)
			->execute();
		$header = $res->fetchAll();
		return $header;
	}
	
	static function createTableBody($table, $group)
	{
		$existing_players = $group->getExistingPlayers();
		
		$t1_select = dibi::select("name, id")
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
		
		if (isset($_SESSION["orderby"]) && isset($_SESSION["way"])) {
			$res=$res->orderBy($_SESSION["orderby"]);
			if ($_SESSION["way"]=="asc") {
			    $res = $res->asc();
			} else {
				$res = $res->desc();
			}
		}
		
		$res = $res->execute();
		$body = $res->fetchAll();
		
		return $body;
	}
}
?>