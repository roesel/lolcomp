<?php 
/*-- Security check -----------------------------------------*/
if(!defined('WEBSECURITY')) exit;

/*-- Class group, used to sort and acquire general stats about summoners -----*/
class Group
{
    // array of players (filled with players)
    public $players = array();
	
	private $errors_player = array();
	private $existing_players = array();
    
	// status returned from call
    private $status;
    
/*-- Constructor -------------------------------------------------------------*/
    function __construct($string_input)
	{
        $missing_players = $this->smartParse($string_input);
        if (count($missing_players) != 0 )
        {
            $this->loadFromAPI($missing_players);
        }
    }
	
	function isEmpty() {
		if (count($this->existing_players)==0) {
			return True;
		} else {
			return False;
		}
	}
	
/*-- Function to parse input names and regions -------------------------------*/
	function smartParse($string_input)
	{
		// Strip spaces (API ignores them anyway)
		$input = str_replace(' ', '', $string_input);   // remove spaces
		$input = str_replace("\r\n", "\n", $input);
	    
		// Explode by line-ends (every line = one summoner)
		$summoners_array = explode("\n", $input);
		
		// Empty array for sorted summoners
		$summoners_sorted_array = array();
		
		// Cycle that will go through all summoners and sort them into their regions
		foreach ($summoners_array as $summoner_and_region) {  // For each summoner
			$explode = explode(",", $summoner_and_region);  // Explode by "," (separate summoner and region)
			if (isset($explode[0]) && isset($explode[1])) {
				// Properly name variables for future use
				$summoner = strtolower(preg_replace('/\s+/', '', $explode[0])); // remove all whitespace characters and convert to lowercase
				$region = strtolower($explode[1]);
				
				// If the player doesn't exist in the database (and data is fresh!)
				if (!$this->isInDatabase($summoner, $region)) {
					// If that region does not exist yet, create it
					if(!isset($summoners_sorted_array[$region])) {
						$summoners_sorted_array[$region] = array();
					} 
					
					// Push into region (has to exist due to previous if)
					array_push($summoners_sorted_array[$region], $summoner);
				}
			}
		}
		return $summoners_sorted_array;
	}
	
/*-- Function to check if summoner from is in database and if needs update ---*/
	function isInDatabase($codename, $region)
	{
		$table = "group";
		$res = dibi::select('id')
			->from($table)
			->where('codename = %s and region = %s', $codename, $region)
			->execute();
		$result_1 = $res->fetchAll();
		$row_exists = count($result_1);

		// if is in database
		if ($row_exists) 
		{
			$inner_select = dibi::select('last_updated')
				->from($table)
				->where('codename = %s and region = %s', $codename, $region);
			$main_select = dibi::select('time_to_sec(timediff(current_timestamp, ('.$inner_select.') ))')
				->as('diff')
				->execute();
			$result = $main_select->fetchAll();
			$diff = $result[0]["diff"];
			
			// if needs update
			if ($diff<MAIN_CACHE_TIME) {
				$id = $result_1[0]["id"];
				$this->addIdRegion($id, $region);	// adds id and region of existing player into array existing_players
				return True;
			}
		} 
		return False;
	}
    
/*-- Function to load general stats from api and save them into players array */
// also decides if player from region exists - failures in errors_player array
    function loadFromAPI($summoners_sorted_array) 
	{
        $players = array();
		$responded_names = array();
        
		// take summoners for each region
        foreach ($summoners_sorted_array as $region => $summoner_array)
		{
            $comma_separated_summoners = "";

            // separate summoners with coma and space
			// spaces changed to %20 - curl doesn't like spaces
			foreach ($summoner_array as $summoner_name)
			{
                $comma_separated_summoners = $comma_separated_summoners.$summoner_name.",%20"; 
            }
			
            // get data from api
			$addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.4/summoner/by-name/'.$comma_separated_summoners.'?api_key='.API_KEY;
			$data = $this->getCallResult($addr);
            if ($this->status == 200)
            {
                $response = json_decode($data, True);
             
                foreach ($response as $summoner_name => $info_array)
                {	
                    // $region already properly set
                    $id = $info_array["id"];
                    $name = $info_array["name"];
                    $profile_icon_id = $info_array["profileIconId"];
                    $revision_date = $info_array["revisionDate"];
                    $summoner_level = $info_array["summonerLevel"];
                    
                    // create group in database
                    $this->insertIntoDatabase($id, $name, $region);
                    
                    $player_init_array = array(
                        "summoner_name"			=> $name,
                        "region"                => $region,
                        "id"                    => $id,
                        "profile_icon_id"       => $profile_icon_id,
                        "revision_date"         => $revision_date,
                        "summoner_level"        => $summoner_level,
                    );
                    $player = new Player($player_init_array);		// creates instance player with set informations
                    $this->addIdRegion($id, $region);				// adds id and region of created player into array existing_players
                    
                    array_push($players, $player);
                    array_push($responded_names, $summoner_name);
                }
                $this->errors_player[$region] = array_diff($summoner_array, $responded_names);		// add to error input
            }
            else
            {
                $this->errors_player[$region] = $summoner_array;
            }
		}
        return $players;
    }
	
/*-- Function to insert group into database ----------------------------------*/
	function insertIntoDatabase($id, $name, $region)
	{
		$codename = strtolower(preg_replace('/\s+/', '', $name));	// player name
		
		$row = array(
			"codename" 		=> $codename,
			"id"       		=> $id,
			"region"  	 	=> $region,
			"last_updated" 	=> NULL,
		);
		
		$table = "group";
		dibi::insert($table, $row)
			->on('DUPLICATE KEY UPDATE %a ', $row)
			->execute();	
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
	
/*-- Function to get errors (wrong input, etc ...) -------------------------*/
	function getErrors()
	{
		$errors = "";
		if (count($this->errors_player) != 0)
		{
			foreach ($this->errors_player as $region_name => $region_value)
			{
				foreach ($region_value as $summoner_name)
				{
					$errors = $errors."Failed to find player ".$summoner_name." from region ".$region_name.".<br />";
				}
			}
		}
		return $errors;
	}
	
/*-- Function to print existing palyers --------------------------------------*/
	function getExistingPlayers()
	{
		return $this->existing_players;
	}
	
/*-- Function to add ID and region into array of existing players ------------*/
	function addIdRegion($id, $region)
	{
		array_push($this->existing_players, array('(%i, %s)', $id, $region));
	}
}
/*-- End ---------------------------------------------------------------------*/
?>