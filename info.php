<?php 
class Info
{
    
    function __construct()
    {

    }
	
	function getAvailableTables()
	{
		print(dibi::select('table_name, table_comment')
			->from('information_schema.tables')
			->where('table_schema = %s and table_name like stats\_%')
			);//->execute();
	}
}
?>