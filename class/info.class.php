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
		$res = dibi::select('COLUMN_COMMENT, COLUMN_NAME')
			->from('information_schema.COLUMNS')
			->where('TABLE_NAME = %s', $table)
			->execute();
		$header = $res->fetchAll();
		return $header;
	}
	
	static function createTableBody($table, $group)
	{
		$existing_players = $group->getExistingPlayers();
		$res = dibi::select('*')
			->from($table)
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