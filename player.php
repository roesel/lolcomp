<?php 
/* Fix for special characters */
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

class Player		// test commit
{
    public $id;
    public $name;
    public $region;
	
	public $profile_icon_id;
	public $revision_date;
	public $summoner_level;
    
    public $rank;
    public $rank_roman;
    public $lp;
    public $league;
    public $tier;
    
    public $stats = array();
    
    public $status;
    
    function __construct($general)
    {
		$this->setPlayer($general);
		$this->loadStats();
		$this->check(1);
        // $this->loadRankedBasic();
        // $this->check(2);
        
        // $this->loadRankedStats();
        // $this->check(3);
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
    
    /*
      Gets the proper name and ID of a player under a specified name.
    */
	
	function setPlayer($general)
	{
		$this->id = $id;
		$this->region = $region;
		
		// $stats = array(	"general" 	=> 	array("region", "id", "name", "profile_icon_id", "revision_date", "summoner_level"),
						// "rank5v5" 	=> 	array("wins", "loses", "kills", "deaths", "assists", "minions", "turrets", "modify_date"),
						// "clas5v5" 	=> 	array("wins", "kills", "assists", "minions", "turrets", "modify_date"),
						// "aram" 		=>	array("wins", "kills", "assists", "turrets", "modify_date")
					  // );
		
		$stats  = array(	"general" 	=> 	array(),
							"rank5v5" 	=>	array(),
							"clas5v5" 	=> 	array(),
							"aram" 		=>	array(),
						);

		foreach ($stats["general"] as $general_name => $general_value)
		{
			$general_name = $general_value;
			$stats["general"][$general_name] = $stats["general"][$general_value];
		}
		
	}
	
	function loadStats()
	{
		// get stats by ID - wins,loses,kills,... in a bunch of modes
		$id = $this->id;
		$region = $this->region;

        $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.3/stats/by-summoner/'.$id.'/summary?api_key='.API_KEY;
		print($addr);
		print("\n");
        $data = $this->getData($addr);
		$j = json_decode($data, True);

		var_dump($j);
		exit();
		
		// foreach ($s as $stat_name => $stat_value)
		// {
			// statistics["ranked5v5"][$stat_name] = $stat_value;
		// }
		
	}
	
    
    function loadRankedBasic() {
        // get ranked stats by ID - league, division name, ...
        $id = $this->id;
        $addr = 'http://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v2.4/league/by-summoner/'.$id.'?api_key='.API_KEY;
        
        $data = $this->getData($addr);
        
        $j = json_decode($data, True);
        
        $this->league = $j[$id][0]["name"];
        $this->tier = $j[$id][0]["tier"];
        $this->rank_roman = 0;
        $this->lp = 0;
        
        foreach($j[$id][0]["entries"] as $num) {
            if ($num["playerOrTeamId"]==$id){
                $this->rank_roman = $num["division"];
                $this->lp = $num["leaguePoints"];
				$this->rank = $this->r2a($this->rank_roman);
            }
        }
        
        
    }
    
    function loadRankedStats() {
        $id = $this->id;
        
        // get detailed ranked stats by ID
        $addr = 'http://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v1.3/stats/by-summoner/'.$id.'/ranked?season=SEASON4&api_key='.API_KEY;
        
        $data = $this->getData($addr);
        
        $j = json_decode($data, True);
        
		foreach ($j["champions"] as $champion) {
			if ($champion["id"]=="0") {
				$combined = $champion;
			}
		}        
        
        $s = $combined["stats"];
        
        $stats = array();
        
        $wins = $s["totalSessionsWon"];
        $losses = $s["totalSessionsLost"];
                
        $wratio = round(100*$wins/($wins+$losses),1);
        
        array_push($stats, array("Pentas", $s["totalPentaKills"]));  
        array_push($stats, array("Win ratio", $wratio." %"));
        array_push($stats, array("Kills", $s["totalChampionKills"]));
        array_push($stats, array("Assists", $s["totalAssists"]));   
        array_push($stats, array("Max Spree", $s["maxLargestKillingSpree"]));
        
        $this->stats = $stats;    
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
    
    function r2a($roman) {
        switch ($roman) {
            case "I": return 1;
            case "II": return 2;
            case "III": return 3;
            case "IV": return 4;
            case "V": return 5;
            default: return 0;
        }
    } 
}
?>