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
    
    private $stats = array();
    
    public $status;
    
    function __construct($general)
    {
		$this->setGeneral($general);
		$this->check(1);
        // $this->loadRankedBasic();
        // $this->check(2);
        
        // $this->loadRankedStats();
        // $this->check(3);
    }
	
	// function to decide whether to call or not, depending on stats, and return stats
	function getStats()
	{
		if (count($this->stats)== 1 )
		{
			$this->loadStats();
			$this->check(4);
		}
		return $this->stats;
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
	
	function setGeneral($general)
	{	
		$this->stats  = array(
			"general" 	=> 	$general,
			);

		// var_dump($this->stats["general"]);
		// exit;
	}
	
	function loadStats()
	{
		// get stats by ID - wins,loses,kills,... in a bunch of modes
		$id = $this->stats["general"]["id"];
		$region = $this->stats["general"]["region"];

        $addr = 'http://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.3/stats/by-summoner/'.$id.'/summary?api_key='.API_KEY;

        $data = $this->getData($addr);
		$j = json_decode($data, True);

		// var_dump($j);
		// exit();
		
		foreach ($j["playerStatSummaries"] as $element)
		{
			foreach ($element as $summary_name => $summary_value)
			{
				if ($summary_name == "playerStatSummaryType")
				{
					$name = $this->camelToSnakeCase($summary_value);
					$this->stats[$name] = array();
				}
				else if ($summary_name == "aggregatedStats")
				{
					foreach ($summary_value as $stat_name => $stat_value)
					{
						$stat_name = $this->camelToSnakeCase($stat_name);
						// array_push($this->stats[$name], array($stat_name, $stat_value));
						$this->stats[$name][$stat_name] = $stat_value;
					}
				}
				else
				{
					$summary_name = $this->camelToSnakeCase($summary_name);
					// array_push($this->stats[$name], array($summary_name, $summary_value));
					$this->stats[$name][$summary_name] = $summary_value;
				}
			}
		}
		//var_dump($this->stats);
		//exit();
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
	
	function camelToSnakeCase($camel)
	{
		$camel = preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", $camel);
		$snake = strtolower($camel);
		return $snake;
	}
}
?>