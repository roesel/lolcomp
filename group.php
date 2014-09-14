<?php 
/* Fix for special characters */
mb_internal_encoding("UTF-8");

class Group
{
    // Pole objektů Player naplněné hráči
    public $players = array();
	
	private $errors = array();
	private $existing_players = array();
    
    public $status;
    
    function __construct($string_input) {
        $missing_players = $this->smartParse($string_input);
		$this->loadFromAPI($missing_players);
    }
	
	function smartParse($string_input) {
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
			
			// Properly name variables for future use
			$summoner = strtolower(preg_replace('/\s+/', '', $explode[0])); // remove all whitespace characters and convert to lowercase
			$region = $explode[1];
			
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
		return $summoners_sorted_array;
	}
	
	function isInDatabase($codename, $region) {
		$table = "group";
		$res = dibi::select('id')
			->from($table)
			->where('codename = %s and region = %s', $codename, $region)
			->execute();
		$result = $res->fetchAll();
		$row_exists = count($result);

		if ($row_exists) {
			$inner_select = dibi::select('last_updated')
				->from($table)
				->where('codename = %s and region = %s', $codename, $region);
			$main_select = dibi::select('time_to_sec(timediff(current_timestamp, ('.$inner_select.') ))')
				->as('diff')
				->execute();
			$result = $main_select->fetchAll();
			$diff = $result[0]["diff"];
			
			if ($diff<MAIN_CACHE_TIME) {
				$id = $result[0]["id"];
				$this->addIdRegion($id, $region);	// adds id and region of existing player into array existing_players
				return True;
			}
		} 
		return False;
	}
    
    function loadFromAPI($summoners_sorted_array) {
        $players = array();
		$responded_names = array();
        
        foreach ($summoners_sorted_array as $region => $summoner_array) {
            $comma_separated_summoners = "";

            foreach ($summoner_array as $summoner_name) {
                $comma_separated_summoners = $comma_separated_summoners.$summoner_name.",%20";  // Spaces changed to %20 - curl doesn't like spaces
            }
            $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.4/summoner/by-name/'.$comma_separated_summoners.'?api_key='.API_KEY;
            
            $data = $this->getData($addr);
            
			$response = json_decode($data, True);

			foreach ($response as $summoner_name => $info_array) {
				
				// $region already properly set
				$id = $info_array["id"];
				$name = $info_array["name"];
				$profile_icon_id = $info_array["profileIconId"];
				$revision_date = $info_array["revisionDate"];
				$summoner_level = $info_array["summonerLevel"];
				
				$this->insertIntoDatabase($id, $name, $region);
				
                $player_init_array = array(
                    "name"					=> $name,
					"region"                => $region,
                    "id"                    => $id,
                    "profile_icon_id"       => $profile_icon_id,
                    "revision_date"         => $revision_date,
                    "summoner_level"        => $summoner_level,
                );
				$player = new Player($player_init_array);
				$this->addIdRegion($id, $region);		// adds id and region of created player into array existing_players
                
                array_push($players, $player);
				array_push($responded_names, $summoner_name);
			}
			$this->errors[$region] = array_diff($summoner_array, $responded_names);
		}
        return $players;
    }
	
	function insertIntoDatabase($id, $name, $region) {
		$codename = strtolower(preg_replace('/\s+/', '', $name));
		
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
    
    function getData($url) {
        
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        
        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);
        
        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        
        $this->status = $httpCode;
        
        curl_close($handle);
        
        return $response;
    }
	
	function getErrors()					// print array errors
	{
		dump($this->errors);
	}
	
	function getExistingPlayers()			// print array existing_players
	{
		dump($this->existing_players);
	}
	
	function addIdRegion($id, $region)		// adds id and region of players into array existing_players
	{
		array_push($this->existing_players, array('(%i, %s)', $id, $region));
	}
}
?>