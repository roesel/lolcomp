<?php 
/*-- Security check -----------------------------------------*/
if(!defined('WEBSECURITY')) exit;
 
/*-- Class player, used to acquire stats about summoner ----------------------*/
class Player
{
    private $stats = array();
    
	// status returned from call
    private $status;
    
/*-- Constructor -------------------------------------------------------------*/
    function __construct($general)
    {
		$this->getGeneral($general);
		// $this->check(1);
		$this->getStats();
		// $this->check(2);
		
		// to do: ranked
		
        $this->loadRankedBasic();
        // $this->check(2);
        $this->loadRankedStats();
        // $this->check(3);
    }
	
/*-- Function to decide whether to call loadStats, depending on their date ---*/
	function getStats()
	{
		if (!$this->isInDatabaseStats())
		{
			$this->loadStats();
		}
		return $this->stats;
	}
    
/*-- Function to set general stats in database if not existent or old --------*/
	function getGeneral($general)
	{
		// dump($general);
		foreach ($general as $stat_name => $stat_value)
		{
			if ($stat_name == 'revision_date')
			{
				$this->stats["stats_general"][$stat_name] = $this->timeStampToNormal($stat_value/1000);
			}
			else
			{
				$this->stats["stats_general"][$stat_name] = $stat_value;
			}
		}
		$general_info = array();
		$this->stats["general"]["id"] = $this->stats["stats_general"]["id"];
		$this->stats["general"]["region"] = $this->stats["stats_general"]["region"];
		$this->stats["general"]["summoner_name"] = $this->stats["stats_general"]["summoner_name"];
		unset($this->stats["stats_general"]["summoner_name"]);

		if (!$this->isInDatabaseGeneral())
		{
			$stats_general = $this->stats["stats_general"];
			$general_help = $this->stats["general"];
			$this->addToDatabase('stats_general', $stats_general);
			$this->addToDatabase('general',$general_help);
		}
		else
		{
			// do nothing
		}
	}

/*-- Function to check if general stats in database are up to date -----------*/
// also works to check if general exists
	function isInDatabaseGeneral()
	{
		$table = "stats_general";
		
		// get date-time info from database
		$id = $this->stats["stats_general"]["id"];
		$region = $this->stats["stats_general"]["region"];
		$res = dibi::select('*')
			->from($table)
			->where('id = %i and region = %s', $id, $region)
			->execute();
		$result = $res->fetchAll();
		
		// check if data are already in database
		if (sizeof($result) == 0)
		{
			return false;
		}
		else
		{
			$date_general = strtotime($result[0]["revision_date"]);
		}
		
		// check if actual time is larger by MAIN_CACHE_TIME than date of general
		if (time() - $date_general > MAIN_CACHE_TIME)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
/*-- Function to check if stats in database are up to date -------------------*/
// also works to check if stats exist
	function isInDatabaseStats()
	{
		$table = "general";
		
		// get date-time info from database
		$id = $this->stats["stats_general"]["id"];
		$region = $this->stats["stats_general"]["region"];
		$res = dibi::select('*')
			->from($table)
			->where('id = %i and region = %s', $id, $region)
			->execute();
		$result = $res->fetchAll();
		$date_stats = strtotime($result[0]["date_stats"]);
		
		// check if actual time is larger by MAIN_CACHE_TIME than date of stats
		if (time() - $date_stats > MAIN_CACHE_TIME)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

/*-- Function to check if call to api did not return error -------------------*/
    function check($n_loop)
    {
        /* 
          404 - not found
          429 - too many requests
        */
        $status = $this->status;
        if ($status==404 && isset($this->id)){
            $status=404;
        }
        switch ($status) {
            case 404: throw new Exception($status); break;
            case 429: throw new Exception($status); break;
            case 4041: throw new Exception($status); break;
        }
    }	
	
/*-- Function to load game stats from api and save them into private stats ---*/
	function loadStats()
	{
		// get stats by ID - wins,loses,kills,... in a bunch of modes
		$id = $this->stats["stats_general"]["id"];
		$region = $this->stats["stats_general"]["region"];

		// get data from api
		$addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.3/stats/by-summoner/'.$id.'/summary?api_key='.API_KEY;
        $data = $this->getCallResult($addr);
		
        if ($this->status == 200)
        {
            $j = json_decode($data, True);
            // get playerStatSummaries from api, divide them into categories and save into private stats
            // each name convert from camelCase to snake_case, time convert from time-stamp to normal date-time
            foreach ($j["playerStatSummaries"] as $element)
            {
                foreach ($element as $summary_name => $summary_value)
                {
                    if ($summary_name == "playerStatSummaryType")
                    {
                        $name = $this->camelToSnakeCase($summary_value);
                        $this->stats[$name] = array();
                        $this->stats[$name]["id"] = $id;
                        $this->stats[$name]["region"] = $region;
                    }
                    else if ($summary_name == "aggregatedStats")
                    {
                        foreach ($summary_value as $stat_name => $stat_value)
                        {
                            $stat_name = $this->camelToSnakeCase($stat_name);
                            $this->stats[$name][$stat_name] = $stat_value;
                        }
                    }
                    else if ($summary_name == "modifyDate")
                    {
                        $summary_name = $this->camelToSnakeCase($summary_name);
                        $this->stats[$name][$summary_name] = $this->timeStampToNormal($summary_value/1000);
                    }
                    else
                    {
                        $summary_name = $this->camelToSnakeCase($summary_name);
                        $this->stats[$name][$summary_name] = $summary_value;
                    }
                }
            }
            
            // add time of creation of stats into stats["general"]
            $this->stats["general"]['date_stats'] = $this->timeStampToNormal(time());
            
            // add received stats into database
            $this->addStatsToDatabase();
        }
	}

/*-- Function to load ranked basic from api and save into private stats ------*/
// needs check before implementing
    function loadRankedBasic() 
	{
        // get ranked stats by ID - league, division name, ...
		$id = $this->stats["stats_general"]["id"];
		$region = $this->stats["stats_general"]["region"];
		$name = "ranked_basic";

		// get data from api
        $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v2.5/league/by-summoner/'.$id.'?api_key='.API_KEY;
        $data = $this->getCallResult($addr);
        
		if ($this->status == 200)
        {
			$j = json_decode($data, True);
			
			// dump($j[$id][0]);
			// exit;
			$this->stats[$name] = array();
			$this->stats[$name]["id"] = $id;
			$this->stats[$name]["region"] = $region;
			$this->stats[$name]["name"] = $j[$id][0]["name"];
			$this->stats[$name]["tier"] = $this->t2i($j[$id][0]["tier"]);

			foreach ($j[$id][0]["entries"] as $summary_name => $summary_value)
			{
				if($summary_value["playerOrTeamId"] == $id)
				{
					foreach($summary_value as $stat_name => $stat_value)
					{
						if ($stat_name == "division")
						{
							$stat_name = $this->camelToSnakeCase($stat_name);
							$stat_value = $this->r2a($stat_value);
							$this->stats[$name][$stat_name] = $stat_value;
						}
						else
						{
							$stat_name = $this->camelToSnakeCase($stat_name);
							$this->stats[$name][$stat_name] = $stat_value;
						}
					}
				}
			}
		
			// add time of creation of ranked_stats into stats["general"]
			$this->stats["general"]['date_ranked_basics'] = $this->timeStampToNormal(time());
			
			// add received ranked_stats into database
			$this->addRankedToDatabase();
		}
    }
    
/*-- Function to load ranked stats from api and save into private stats ------*/
// needs check before implementing
    function loadRankedStats() 
	{
        // get detailed ranked stats by ID
		$id = $this->stats["stats_general"]["id"];
		$region = $this->stats["stats_general"]["region"];
		$name = "ranked_stats";
        
		// get data from api
        $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.3/stats/by-summoner/'.$id.'/ranked?season=SEASON4&api_key='.API_KEY;    
        $data = $this->getCallResult($addr);
        
		if ($this->status == 200)
        {
			$j = json_decode($data, True);
			
			foreach ($j["champions"] as $champion)
			{
				if ($champion["id"]=="0")
				{
					$combined = $champion["stats"];
				}
			}
			
			$this->stats[$name] = array();
			$this->stats[$name]["id"] = $id;
			$this->stats[$name]["region"] = $region;
			
			foreach ($combined as $summary_name => $summary_value)
			{
				$summary_name = $this->camelToSnakeCase($summary_name);
				$this->stats[$name][$summary_name] = $summary_value;
			}
			
			$wins = $combined["totalSessionsWon"];
			$losses = $combined["totalSessionsLost"];
			$win_ratio = round(100*$wins/($wins+$losses),1);
			
			$this->stats[$name]["win_ratio"] = $win_ratio;
			
			// add time of creation of ranked_stats into stats["general"]
			$this->stats["general"]['date_ranked_stats'] = $this->timeStampToNormal(time());
			
			// add received ranked_stats into database
			$this->addRankedToDatabase();
		}
	}

/*-- Function to add into database -------------------------------------------*/
	function addToDatabase($name, $value)
	{
		dibi::insert($name, $value)
				->on('DUPLICATE KEY UPDATE %a ', $value)
				->execute();
	}
	
/*-- Function to add stats into database -------------------------------------*/
	function addStatsToDatabase()
	{
		foreach ($this->stats as $table_name => $table_value)
		{
			if($this->tableExists('stats_'.$table_name))				// check if table exists for stats_*
			{
				foreach($table_value as $stat_name => $stat_value)
				{
					if (!$this->rowExists('stats_'.$table_name, $stat_name))		// check if row exists
					{
						unset($table_value[$stat_name]);
					}
				}
				$this->addToDatabase('stats_'.$table_name, $table_value);
			}
			else if($this->tableExists($table_name))					// check else if table exists for general,...
			{
				foreach($table_value as $stat_name => $stat_value)
				{
					if (!$this->rowExists($table_name, $stat_name))		// check if row exists
					{
						unset($table_value[$stat_name]);
					}
				}
				$this->addToDatabase($table_name, $table_value);
			}
		}
	}
	
/*-- Function to add ranked into database ------------------------------------*/
	function addRankedToDatabase()
	{
		foreach ($this->stats as $table_name => $table_value)
		{
			if($this->tableExists('ranked_'.$table_name))						// check if table exists for stats_*
			{
				foreach($table_value as $stat_name => $stat_value)
				{
					if (!$this->rowExists('ranked_'.$table_name, $stat_name))	// check if row exists
					{
						unset($table_value[$stat_name]);
					}
				}
				$this->addToDatabase('ranked_'.$table_name, $table_value);
			}
			else if($this->tableExists($table_name))					// check else if table exists for general,...
			{
				foreach($table_value as $stat_name => $stat_value)
				{
					if (!$this->rowExists($table_name, $stat_name))		// check if row exists
					{
						unset($table_value[$stat_name]);
					}
				}
				$this->addToDatabase($table_name, $table_value);
			}
		}
	}
	
/*-- Function to decide whether the table in database exists -----------------*/
	function tableExists($table_name) 
	{
		$res =(dibi::select('count(*)')
			-> as('count')
			-> from('information_schema.tables')
			-> where('table_schema = %s', 'lolscores')
			-> and ('table_name = %s', $table_name)
			-> execute()
		);
			
		$result = $res->fetchAll();
		return $result[0]["count"];
	}
	
/*-- Function to decide whether row in table exists --------------------------*/
	function rowExists($table_name, $stat_name)
	{
		$res =(dibi::select('count(*)')
			-> as('count')
			-> from('information_schema.columns')
			-> where('table_schema = %s', 'lolscores')
			-> and ('table_name = %s', $table_name)
			-> and('column_name = %s', $stat_name)
			-> execute()
		);

		$result = $res->fetchAll();
		return $result[0]["count"];
	}
	   
/*-- Function to get data from api -------------------------------------------*/
    function getCallResult($url)
    {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        
        // Get the HTML or whatever is linked in $url
        // 429 - rate limit, 500 - internal error, 503 - service unavailable
        do
        {
            $response = curl_exec($handle);
            // Check for 404 (file not found)
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $this->status = $httpCode;
            //wait for next call
            usleep(API_REQUEST_WAIT);
        } while ($httpCode == 429);
        
        curl_close($handle);
        return $response;
    }
    
/*-- Function to convert division into integer -------------------------------*/
    function r2a($roman) 
	{
        switch ($roman) 
		{
            case "I": return 1;
            case "II": return 2;
            case "III": return 3;
            case "IV": return 4;
            case "V": return 5;
            default: return 0;
        }
    }
	
/*-- Function to convert tier into integer -----------------------------------*/
    function t2i($tier) 
	{
		$tier = strtolower($tier);
        switch ($tier) 
		{
            case "challenger": return 1;
            case "master": return 2;
            case "diamond": return 3;
            case "platina": return 4;
            case "gold": return 5;
			case "silver": return 6;
            case "bronze": return 7;
            default: return 0;
        }
    }

/*-- Function to convert timestamp into normal date-time ---------------------*/
	function timeStampToNormal($time_stamp)
	{
		$date_string = "Y-m-d H:i:s";						// form of date-time
		$create_date = date($date_string, $time_stamp);
		return $create_date;
	}
 
/*-- Function to convert camelCase to snake_case------------------------------*/
	function camelToSnakeCase($camel)
	{
		$camel = preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", $camel);
		$snake = strtolower($camel);
		return $snake;
	}
}
/*-- End ---------------------------------------------------------------------*/
?>