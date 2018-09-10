<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\btg_headtoheads;

class HeadToHeadController extends Controller
{
    public function GetHeadToHeadData(Request $request)
    {
        $MatchId = $request->input('MatchId');
        $HomeTeam = $request->input('HomeTeam');
        $AwayTeam = $request->input('AwayTeam');
        $LeagueId = $request->input('leagueId');
        $GetHeadToHeadData = btg_headtoheads::where('match_id',$MatchId)->get()->toArray();
        $HomeTeamResult = array();
        $AwayTeamResult = array();
        $HeadToHeadDetails = json_decode($GetHeadToHeadData[0]['details'], true);
		foreach($HeadToHeadDetails as $key=>$value)
		{
			if((($value['match_hometeam_name'] == $HomeTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $HomeTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])))
			{
				$Status = "W";
			}
			elseif((($value['match_hometeam_name'] == $HomeTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $HomeTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])))
			{
				$Status = "L";
			}
			elseif((($value['match_hometeam_name'] == $HomeTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $HomeTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])))
			{
				$Status = "D";
			}
			array_push($HomeTeamResult,$Status);
			if((($value['match_hometeam_name'] == $AwayTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $AwayTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])))
			{
				$Status = "W";
			}
			elseif((($value['match_hometeam_name'] == $AwayTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $AwayTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])))
			{
				$Status = "L";
			}
			elseif((($value['match_hometeam_name'] == $AwayTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $AwayTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])))
			{
				$Status = "D";
			}
			array_push($AwayTeamResult,$Status);
			$match_details =   [];
	        $match_details['country_name'] =   $value['country_name'];
	        $match_details['league_name']  =   $value['league_name'];
	        
	        $Matches[$value['league_id']] = $match_details;
	        $LeagueWiseMatch[$value['league_id']][$value['match_id']][] = $value;
		}
		//$HomeTeamStatus = implode("-",$HomeTeamResult);echo "<br>";
		//$AwayTeamStatus = implode("-",$AwayTeamResult);die;
		$HomeTeamWin = array_count_values($HomeTeamResult);
		$AwayTeamWin = array_count_values($AwayTeamResult);
		/*Hometeam details*/
		$HomeLastMatchResult = array();
		$HomeTeamLastDetails = json_decode($GetHeadToHeadData[0]['home_team_details'], true);
		foreach($HomeTeamLastDetails as $key=>$value)
		{
			if((($value['match_hometeam_name'] == $HomeTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $HomeTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])))
			{
				$Status = "W";
			}
			elseif((($value['match_hometeam_name'] == $HomeTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $HomeTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])))
			{
				$Status = "L";
			}
			elseif((($value['match_hometeam_name'] == $HomeTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $HomeTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])))
			{
				$Status = "D";
			}
			array_push($HomeLastMatchResult,$Status);
		}
		$HomeLastResult = implode("-",$HomeLastMatchResult);
		/*AwayTeam details*/
		$AwayLastMatchResult = array();
		$AwayTeamLastDetails = json_decode($GetHeadToHeadData[0]['away_team_details'], true);
		foreach($AwayTeamLastDetails as $key=>$value)
		{
			if((($value['match_hometeam_name'] == $AwayTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $AwayTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])))
			{
				$Status = "W";
			}
			elseif((($value['match_hometeam_name'] == $AwayTeam) && ($value['match_hometeam_score'] < $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $AwayTeam) && ($value['match_hometeam_score'] > $value['match_awayteam_score'])))
			{
				$Status = "L";
			}
			elseif((($value['match_hometeam_name'] == $AwayTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])) || (($value['match_awayteam_name'] == $AwayTeam) && ($value['match_hometeam_score'] == $value['match_awayteam_score'])))
			{
				$Status = "D";
			}
			array_push($AwayLastMatchResult,$Status);
		}
		$AwayLastResult = implode("-",$AwayLastMatchResult);
		$TeamStat = $this->getStandings($HomeTeam,$AwayTeam,$LeagueId);
		//aa($TeamStat);
		return view('BettingSections/HeadToHead',compact('HomeLastResult','AwayLastResult','HomeTeamWin','AwayTeamWin','HomeTeam','AwayTeam','Matches','LeagueWiseMatch','TeamStat'));
    }

    function getStandings($HomeTeam,$AwayTeam,$leagueId)
    {
    	$APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
        $url="https://apifootball.com/api/?action=get_standings&league_id=".$leagueId."&APIkey=".$APIkey;
        $GetStandingResult = GetRequestFromAPI($url);
        $TeamStat = array();
        foreach ($GetStandingResult as $key => $value) {
        	if($value['team_name'] == $HomeTeam){
				$MatchStat = array('team_name'=>$HomeTeam,
								   'matches'=> $value['overall_league_payed'],
								   'scored'=> $value['overall_league_GF'],
								   'conceeded'=> $value['overall_league_GA']
								  );
				array_push($TeamStat,$MatchStat);
			}elseif ($value['team_name'] == $AwayTeam) {
				$MatchStat = array('team_name'=>$AwayTeam,
								   'matches'=> $value['overall_league_payed'],
								   'scored'=> $value['overall_league_GF'],
								   'conceeded'=> $value['overall_league_GA']
								  );
				array_push($TeamStat,$MatchStat);
			}
        }
        return $TeamStat;
    }
}
?>