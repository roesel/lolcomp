<?php 
/*-- Including init (required files) -----------------------------------------*/
// require('../__init.php');
 
/*-- Class player, used to acquire stats about summoner ----------------------*/
class Player
{
    private $stats = array();
    
	// status returned from call
    public $status;
    
/*-- Constructor -------------------------------------------------------------*/
    function __construct($general)
    {
		$this->getGeneral($general);
		$this->check(1);
		$this->getStats();
		$this->check(2);
		
		// to do: ranked
		
        // $this->loadRankedBasic();
        // $this->check(2);
        // $this->loadRankedStats();
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
				$this->stats["general"][$stat_name] = $this->timeStampToNormal($stat_value/1000);
			}
			else
			{
				$this->stats["general"][$stat_name] = $stat_value;
			}
		}

		if (!$this->isInDatabaseGeneral())
		{
			$this->addGeneralToDatabase();
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
		// $table = "general";
		
		// get number of entries from database
		// $id = $this->stats["general"]["id"];
		// $region = $this->stats["general"]["region"];
		// $res = dibi::select('*')
			// ->from($table)
			// ->where('id = %i and region = %s', $id, $region)
			// ->execute();
		// $result = $res->fetchAll();
		// $returned_rows = sizeof($result);
		
		// check if entry already exists (number of rows is 1 or 0)
		// if ($returned_rows == 0) 
		// {
			// return false;
		// } 
		// else 
		// {
			// return true;
		// }
		$table = "general";
		
		// get date-time info from database
		$id = $this->stats["general"]["id"];
		$region = $this->stats["general"]["region"];
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
		$id = $this->stats["general"]["id"];
		$region = $this->stats["general"]["region"];
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
		$id = $this->stats["general"]["id"];
		$region = $this->stats["general"]["region"];

		// get data from api
		$addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.3/stats/by-summoner/'.$id.'/summary?api_key='.API_KEY;
        $data = $this->getCallResult($addr);//getData($addr);
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

/*-- Function to load ranked basic from api and save into private stats ------*/
// needs check before implementing
    function loadRankedBasic() 
	{
        // get ranked stats by ID - league, division name, ...
		$id = $this->stats["general"]["id"];
		$region = $this->stats["general"]["region"];

		// get data from api
        $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v2.4/league/by-summoner/'.$id.'?api_key='.API_KEY;
        $data = $this->getCallResult($addr);//getData($addr);
        $j = json_decode($data, True);
        
		$this->stats["ranked_basic"] = array();
        $this->stats["ranked_basic"]["league"] = $j[$id][0]["name"];
        $this->stats["ranked_basic"]["tier"] = $j[$id][0]["tier"];
        $this->stats["ranked_basic"]["rank_roman"] = 0;
        $this->stats["ranked_basic"]["lp"] = 0;
        
        foreach($j[$id][0]["entries"] as $num) 
		{
            if ($num["playerOrTeamId"]==$id)
			{
                $this->stats["ranked_basic"]["rank_roman"] = $num["division"];
                $this->stats["ranked_basic"]["lp"] = $num["leaguePoints"];
				$this->stats["ranked_basic"]["rank"] = $this->r2a($this->stats["ranked_basic"]["rank_roman"]);
            }
        }
    }
    
/*-- Function to load ranked stats from api and save into private stats ------*/
// needs check before implementing
    function loadRankedStats() 
	{
        // get detailed ranked stats by ID
		$id = $this->stats["general"]["id"];
		$region = $this->stats["general"]["region"];
        
		// get data from api
        $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.3/stats/by-summoner/'.$id.'/ranked?season=SEASON4&api_key='.API_KEY;    
        $data = $this->getCallResult($addr);//getData($addr);
        $j = json_decode($data, True);
        
		foreach ($j["champions"] as $champion)
		{
			if ($champion["id"]=="0")
			{
				$combined = $champion;
			}
		}
		
        $s = $combined["stats"];
        
		$this->stats["ranked_stats"] = array();
        
        $wins = $s["totalSessionsWon"];
        $losses = $s["totalSessionsLost"];
		
        $wratio = round(100*$wins/($wins+$losses),1);
        
        $this->stats["ranked_stats"]["Pentas"] = $s["totalPentaKills"];
        $this->stats["ranked_stats"]["Win ratio"] = $wratio." %";
        $this->stats["ranked_stats"]["Kills"] = $s["totalChampionKills"];
        $this->stats["ranked_stats"]["Assists"] = $s["totalAssists"];
        $this->stats["ranked_stats"]["Max Spree"] = $s["maxLargestKillingSpree"];
	}

/*-- Function to add general into database -----------------------------------*/
	function addGeneralToDatabase()
	{
		$name = "general";
		$value = $this->stats["general"];
		
		dibi::insert($name, $value)
				->on('DUPLICATE KEY UPDATE %a ', $value)
				->execute();
	}
	
/*-- Function to add stats into database -------------------------------------*/
	function addStatsToDatabase()
	{
		foreach ($this->stats as $stat_name => $stat_value)
		{
			if($this->tableExists('stats_'.$stat_name))				// check if table exists for stats_*
			{
				dibi::insert('stats_'.$stat_name, $stat_value)
					->on('DUPLICATE KEY UPDATE %a ', $stat_value)
					->execute();
			}
			else if($this->tableExists($stat_name))					// check else if table exists for general,...
			{
				dibi::insert($stat_name, $stat_value)
					->on('DUPLICATE KEY UPDATE %a ', $stat_value)
					->execute();
			}
		}
	}
	
/*-- Function to add ranked into database ------------------------------------*/
	function addRankedToDatabase()
	{
		foreach ($this->stats as $stat_name => $stat_value)
		{
			if($this->tableExists('ranked_'.$stat_name))			// check if table exists for ranked_*
			{
				dibi::insert('ranked_'.$stat_name, $stat_value)
					->on('DUPLICATE KEY UPDATE %a ', $stat_value)
					->execute();
			}
			else if($this->tableExists($stat_name))					// check else if table exists for general,...
			{
				dibi::insert($stat_name, $stat_value)
					->on('DUPLICATE KEY UPDATE %a ', $stat_value)
					->execute();
			}
		}
	}
	
/*-- Function to decide whether the table in database exists -----------------*/
	function tableExists($tablename, $database = false) 
	{
		if(!$database)
		{
			$res = mysql_query("SELECT DATABASE()");
			$database = mysql_result($res, 0);
		}
	 
		$res = mysql_query("
			SELECT COUNT(*) AS count
			FROM information_schema.tables 
			WHERE table_schema = '$database'
			AND table_name = '$tablename'
		");
	 
		return mysql_result($res, 0) == 1;
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
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
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