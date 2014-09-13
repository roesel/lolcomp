<?php 
/* Fix for special characters */
mb_internal_encoding("UTF-8");

class Group
{
    // Pole objektů Player naplněné hráči
    $players = array();
    
    public $status;
    
    function __construct($summoners_sorted_array)
    {
        $missing_players = $this->whoIsNotCached();
        
        $filled_missing_players = $this->loadFromAPI($missing_players);
        
        //check in db for every player
        //load ONLY unavailable players from API
        // --- db should be chill now
        //select * from db
        //call player objects
        
        
    }
    
    function whoIsNotCached($summoners_sorted_array) {
        //check every player in DB if he is there
        //return only those who are not in sorted array
        // TODO
        return $summoners_sorted_array;
    }
    
    
    /*
      
    */
    function loadFromAPI($summoners_sorted_array) {
        $players = array();
        
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
				
                $player_init_array = array(
                    "region"                => $region,
                    "id"                    => $id,
                    "profile_icon_id"       => $profile_icon_id,
                    "revision_date"         => $revision_date,
                    "summoner_level"        => $summoner_level,
                );
				$player = new Player($player_init_array);
                
                array_push($players, $player);
			}
		}

        return $players;
    }
    
    function saveIdsToDatabase($players_array) {
        if (!dibi::isConnected()) {
            print("Dibi is not connected. Exiting.");
            exit();
        }
        
        foreach ($players_array as $player) {
            dibi::insert('group', $player)
                ->on('DUPLICATE KEY UPDATE %a ', $player)    
                ->execute();
        }
    }
    
    function check($loop) {
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
}
?>