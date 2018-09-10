<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

use App\news_feeds;
use App\news_feed_likes;
use App\news_feed_comments;
use App\user_profiles;
use App\btg_countries;
use App\btg_leagues;
use App\follow_users;
use App\btg_league_standings;
use App\btg_odds;
use App\ btg_events;
use App\btg_match_event_goalscorers;
use App\btg_match_event_cards;
use App\btg_match_event_lineups;
use App\btg_headtoheads;


class SoccerController extends Controller
{
  /**
   * Odds table generate for upcoming seven days from API response
   */
    public function GetOddData()
    {
        set_time_limit(0);
        //ini_set('memory_limit','1024M');
        $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
        $FromDate = date("Y-m-d");
        $date = strtotime($FromDate);
        $date = strtotime("+1day",$date);
        $ToDate = date("Y-m-d",$date);
        $url="https://apifootball.com/api/?action=get_odds&from=".$FromDate."&to=".$FromDate."&odd_bookmakers='Interwetten.es'&APIkey=".$APIkey;
        $OddsResult = GetRequestFromAPI($url);
        //aa($OddsResult);
        //aa(count($OddsResult[0]));
        foreach($OddsResult as $OddsKey=>$OddsValue)
        {
          $GetOdds = $this->GetOddInfo($OddsValue);
          //aa($GetOdds);
          //$insert = btg_odds::insert($GetOdds);
          foreach($GetOdds as $keyodds=>$valueodds)
          {
            $CheckMatchId = btg_odds::select('id')->where('match_id',$valueodds['match_id'])->where('odd_bookmakers',$valueodds['odd_bookmakers'])->where('odd_date',$valueodds['odd_date'])->where('market',$valueodds['market'])->where('odds_name',$valueodds['odds_name'])->where('odds_value',$valueodds['odds_value'])->where('extra_value',$valueodds['extra_value'])->get()->toArray();
            if(empty($CheckMatchId[0]['id']))
            {
              $insert = btg_odds::insert($valueodds);
            }else{
              $update = btg_odds::where('id',$CheckMatchId[0]['id'])->where('match_id',$valueodds['match_id'])->where('odd_bookmakers',$valueodds['odd_bookmakers'])->where('odd_date',$valueodds['odd_date'])->where('market',$valueodds['market'])->where('odds_name',$valueodds['odds_name'])->where('odds_value',$valueodds['odds_value'])->where('extra_value',$valueodds['extra_value'])->update($valueodds);
            }
          }
        }
    }
  /**
   * Country table generate from API response
   */
  public function GetCountryData()
  {
    $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
    $url="https://apifootball.com/api/?action=get_countries&APIkey=".$APIkey;
    $CountryResult = GetRequestFromAPI($url);
    foreach($CountryResult as $CountryKey=>$CountryValue)
    {
        $data = array('country_id'=>$CountryValue['country_id'],
                      'country_name'=>$CountryValue['country_name'],
                      'updation_date'=>date("Y-m-d H:i:s")
                      );
        $CheckCountryExist = btg_countries::where('country_id',$CountryValue['country_id'])->get()->toArray();
        if(empty($CheckCountryExist))
        {
            $InsertQuery = btg_countries::insert($data);
        }else{
             $UpdateTable = btg_countries::where('country_id',$CountryValue['country_id'])->update($data);
        }
    }
  }
  /**
   * League table generate from API response
   */
  public function GetCompetitionData()
  {
    $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
    $url="https://apifootball.com/api/?action=get_leagues&APIkey=".$APIkey;
    $LeagueResult = GetRequestFromAPI($url);
    foreach($LeagueResult as $LeagueKey=>$LeagueValue)
    {
        $LeagueData = array('country_id'=>$LeagueValue['country_id'],
                            'country_name'=>$LeagueValue['country_name'],
                            'league_id'=>$LeagueValue['league_id'],
                            'league_name'=>$LeagueValue['league_name'],
                            'updation_date'=>date("Y-m-d H:i:s")
                          );
        $CheckLeagueExist = btg_leagues::where('country_id',$LeagueValue['country_id'])->get()->toArray();
        if(empty($CheckLeagueExist))
        {
            $InsertQuery = btg_leagues::insert($LeagueData);
        }else{
            $UpdateTable = btg_leagues::where('country_id',$LeagueValue['country_id'])->update($LeagueData);
        }
    }
  }
  /**
   * Standing table generate from API response
   */
  public function GetStandingsData()
  {
    $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
    $GetDistinctLeagueId = btg_leagues::distinct()->get(['league_id'])->toArray();
    foreach($GetDistinctLeagueId as $key=>$value)
    {
      if(!empty($value['league_id']))
      {
        $url="https://apifootball.com/api/?action=get_standings&league_id=".$value['league_id']."&APIkey=".$APIkey;
        $StandingResult = GetRequestFromAPI($url);
        if($StandingResult['error'] != 404)
        {
          foreach($StandingResult as $StandingKey=>$StandingValue)
          {
              $StandingData = array('country_name'=>$StandingValue['country_name'],
                                      'league_id'=>$StandingValue['league_id'],
                                      'league_name'=>$StandingValue['league_name'],
                                      'team_name'=>$StandingValue['team_name'],
                                      'overall_league_position'=>$StandingValue['overall_league_position'],
                                      'overall_league_payed'=>$StandingValue['overall_league_payed'],
                                      'overall_league_W'=>$StandingValue['overall_league_W'],
                                      'overall_league_D'=>$StandingValue['overall_league_D'],
                                      'overall_league_L'=>$StandingValue['overall_league_L'],
                                      'overall_league_GF'=>$StandingValue['overall_league_GF'],
                                      'overall_league_GA'=>$StandingValue['overall_league_GA'],
                                      'overall_league_PTS'=>$StandingValue['overall_league_PTS'],
                                      'home_league_position'=>$StandingValue['home_league_position'],
                                      'home_league_payed'=>$StandingValue['home_league_payed'],
                                      'home_league_W'=>$StandingValue['home_league_W'],
                                      'home_league_D'=>$StandingValue['home_league_D'],
                                      'home_league_L'=>$StandingValue['home_league_L'],
                                      'home_league_GF'=>$StandingValue['home_league_GF'],
                                      'home_league_GA'=>$StandingValue['home_league_GA'],
                                      'home_league_PTS'=>$StandingValue['home_league_PTS'],
                                      'away_league_position'=>$StandingValue['away_league_position'],
                                      'away_league_payed'=>$StandingValue['away_league_payed'],
                                      'away_league_W'=>$StandingValue['away_league_W'],
                                      'away_league_D'=>$StandingValue['away_league_D'],
                                      'away_league_L'=>$StandingValue['away_league_L'],
                                      'away_league_GF'=>$StandingValue['away_league_GF'],
                                      'away_league_GA'=>$StandingValue['away_league_GA'],
                                      'away_league_PTS'=>$StandingValue['away_league_PTS'],
                                      'updation_date'=>date("Y-m-d H:i:s")
                                    );
            $CheckStandingExist = btg_league_standings::where('league_id',$StandingValue['league_id'])->get()->toArray();
            if(empty($CheckStandingExist))
            {
              $InsertQuery = btg_league_standings::insert($StandingData);
            }else{
              $UpdateTable = btg_league_standings::where('league_id',$StandingValue['league_id'])->update($StandingData);
            }
          }
        }
      }
    }
  }
  public function GetOddInfo($oddsInfo)
  {
      //aa($oddsInfo);
      $matchId = $oddsInfo['match_id'];
      $odd_date = $oddsInfo['odd_date'];
      $odd_bookmaker = $oddsInfo['odd_bookmakers'];
      unset($oddsInfo['match_id'],$oddsInfo['odd_date'],$oddsInfo['odd_bookmakers']);
      $TotalArray = array();
      foreach($oddsInfo as $key=>$value)
      {
          if (strpos($key,'odd')!==false) 
          {
            $explode = explode("_",$key);
            $market = 'Full time';
            if($explode[1] == '1')
            {
                $odds_name = 'Home';
                $extra_odds = '-';
                $odds_value = $value;
            }elseif($explode[1] == 'x'){
                $odds_name = 'Draw';
                $extra_odds = '-';
                $odds_value = $value;
            }elseif($explode[1] == '2'){
                $odds_name = 'Away';
                $extra_odds = '-';
                $odds_value = $value;
            }elseif((strpos($key,'1x')!==false)||(strpos($key,'12')!==false)||(strpos($key,'x2')!==false)) {
                $market = 'Double chance';
                $explodedKey = explode("_",$key);
                if($explodedKey[1] == '1x'){
                    $odds_name = 'Home/Draw';
                    $extra_odds = '-';
                    $odds_value = $value;
                }elseif($explodedKey[1] == '12'){
                    $odds_name = 'Home/Away';
                    $extra_odds = '-';
                    $odds_value = $value;
                }elseif($explodedKey[1] == 'x2'){
                    $odds_name = 'Draw/Away';
                    $extra_odds = '-';
                    $odds_value = $value;
                }
             }
             $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
             array_push($TotalArray,$array);
          }elseif (strpos($key,'ah')!==false) {
             $market = 'Asian handicap';
             $x = explode("_",$key);
             if($x[1] == '1'){
                $odds_name = 'Home';
                if(strpos($x[0],'-') !== false){
                    $y = explode("-",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '-'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'+') !== false){
                    $y = explode("+",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '+'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'0') !== false){
                    $extra_odds = 0;
                    $odds_value = $value;
                }
                $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
                array_push($TotalArray,$array);
             }elseif($x[1] == '2'){
                $odds_name = 'Away';
                if(strpos($x[0],'-') !== false){
                    $y = explode("-",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '-'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'+') !== false){
                    $y = explode("+",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '+'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'0') !== false){
                    $extra_odds = 0;
                    $odds_value = $value;
                }
                $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
                array_push($TotalArray,$array);
             }  
          }elseif (strpos($key,'o+')!==false) {
             $market = 'Over';
             $x = explode("+",$key);
             $odds_name = '-';
             $extra_odds = $x[1];
             $odds_value = $value;
             $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
             array_push($TotalArray,$array);
          }elseif (strpos($key,'u+')!==false) {
             $market = 'Under';
             $x = explode("+",$key);
             $odds_name = '-';
             $extra_odds = $x[1];
             $odds_value = $value;
             $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
             array_push($TotalArray,$array);
          }elseif (strpos($key,'bts')!==false) {
             $market = 'BTS';
             $x = explode("_",$key);
             if($x[1] == 'yes'){
                $odds_name = 'yes';
                $extra_odds = '-';
                $odds_value = $value;
                $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
                array_push($TotalArray,$array);
            }else{
              $odds_name = 'no';
              $extra_odds = '-';
              $odds_value = $value;
              $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
              array_push($TotalArray,$array);
            }
          }
      }
      return $TotalArray;
  }
  
  function HeadToHeadTeamName($HomeTeam,$AwayTeam,$APIkey,$MatchId)
  {
    $url="https://apifootball.com/api/?action=get_H2H&firstTeam=".$HomeTeam."&secondTeam=".$AwayTeam."&APIkey=".$APIkey;
    $Head2HeadResult = GetRequestFromAPI($url);
    $Details = json_encode($Head2HeadResult['firstTeam_VS_secondTeam']);
    $HomeTeamDetails = json_encode($Head2HeadResult['firstTeam_lastResults']);
    $AwayTeamDetails = json_encode($Head2HeadResult['secondTeam_lastResults']);   
    $Head2HeadData = array('match_id'=>$MatchId,
                           'details'=>$Details,
                           'home_team_details'=>$HomeTeamDetails,
                           'away_team_details'=>$AwayTeamDetails,
                           'creation_date'=>date("Y-m-d H:i:s")
                          );
    //aa($Head2HeadData);
    $CheckMatchId = btg_headtoheads::where('match_id',$MatchId)->get()->toArray();
    if(empty($CheckMatchId))
    {
        $InsertIntoTable = btg_headtoheads::insert($Head2HeadData); 
    }else{
        $UpdateTable = btg_headtoheads::where('match_id',$MatchId)->update($Head2HeadData);
    }
    
  }
  
  public function GetEventData()
  {
    set_time_limit(0);
    $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
    $FromDate = date("Y-m-d");
    $date = strtotime($FromDate);
    $date = strtotime("+1day",$date);
    $ToDate = date("Y-m-d");
    $url="https://apifootball.com/api/?action=get_events&from=".$FromDate."&to=".$ToDate."&APIkey=".$APIkey;
    $EventResult = GetRequestFromAPI($url);
    foreach($EventResult as $key1=>$value1)
    {
      $EventData = array('match_id'=>$value1['match_id'],
                         'country_id'=>$value1['country_id'],
                         'country_name'=>$value1['country_name'],
                         'league_id'=>$value1['league_id'],
                         'league_name'=>$value1['league_name'],
                         'match_date'=>date("Y-m-d",strtotime($value1['match_date'])),
                         'match_status'=>$value1['match_status'],
                         'match_time'=>date("Y-m-d H:i:s",strtotime($value1['match_time'])),
                         'match_hometeam_name'=>$value1['match_hometeam_name'],
                         'match_hometeam_score'=>$value1['match_hometeam_score'],
                         'match_awayteam_name'=>$value1['match_awayteam_name'],
                         'match_awayteam_score'=>$value1['match_awayteam_score'],
                         'match_hometeam_halftime_score'=>$value1['match_hometeam_halftime_score'],
                         'match_awayteam_halftime_score'=>$value1['match_awayteam_halftime_score'],
                         'match_live'=>$value1['match_live'],
                         'updation_date'=>date("Y-m-d H:i:s")
                          );
      $this->HeadToHeadTeamName($value1['match_hometeam_name'],$value1['match_awayteam_name'],$APIkey,$value1['match_id']);
      $InsertEventQuery = btg_events::insert($EventData);
      $CheckMatchId = btg_events::where('match_id',$value1['match_id'])->get()->toArray();
      if(empty($CheckMatchId))
      {
        $InsertEventQuery = btg_events::insert($EventData);
      }else{
        $UpdateEventQuery = btg_events::where('match_id',$value1['match_id'])->update($EventData);
      }

      foreach($value1['goalscorer'] as $key2=>$value2)
      {
        $time = intval(preg_replace('/[^0-9]+/', '', $value2['time']), 10);
        $GoalScorerData = array('match_id'=>$value1['match_id'],
                                'time'=>$time,
                                'home_scorer'=>$value2['home_scorer'],
                                'score'=>$value2['score'],
                                'away_scorer'=>$value2['away_scorer'],
                                'updation_date'=>date("Y-m-d H:i:s")
                                );
        $CheckMatchIdForGoalScorer = btg_match_event_goalscorers::where('match_id',$value1['match_id'])->where('time',$time)->where('home_scorer',$value2['home_scorer'])->where('score',$value2['score'])->where('away_scorer',$value2['away_scorer'])->get()->toArray();
        if(empty($CheckMatchIdForGoalScorer))
        {
          $InsertGoalScorerQuery = btg_match_event_goalscorers::insert($GoalScorerData);
        }else{
          $UpdateGoalScorerQuery = btg_match_event_goalscorers::where('match_id',$value1['match_id'])->where('time',$time)->where('home_scorer',$value2['home_scorer'])->where('score',$value2['score'])->where('away_scorer',$value2['away_scorer'])->update($GoalScorerData);
        }
      }
      foreach($value1['cards'] as $key3=>$value3)
      {
        $CardTime = intval(preg_replace('/[^0-9]+/', '', $value3['time']), 10);
        $MatchEventCardData = array('match_id'=>$value1['match_id'],
                                    'time'=>$CardTime,
                                    'home_fault'=>$value3['home_fault'],
                                    'card'=>$value3['card'],
                                    'away_fault'=>$value3['away_fault'],
                                    'updation_date'=>date("Y-m-d H:i:s")
                                  );
        $CheckMatchIdForCard = btg_match_event_cards::where('match_id',$value1['match_id'])->where('time',$CardTime)->where('home_fault',$value3['home_fault'])->where('card',$value3['card'])->where('away_fault',$value3['away_fault'])->get()->toArray();
        if(empty($CheckMatchIdForCard))
        {
           $InsertCardQuery = btg_match_event_cards::insert($MatchEventCardData);
        }else{
           $UpdateCardQuery = btg_match_event_cards::where('match_id',$value1['match_id'])->where('time',$CardTime)->where('home_fault',$value3['home_fault'])->where('card',$value3['card'])->where('away_fault',$value3['away_fault'])->update($MatchEventCardData);
        }
      }

     foreach($value1['lineup'] as $key4=>$value4)
     {
       if($key4 == 'home')
       {
         $team = 'Home';
       }else{
         $team = 'Away';
       }
       $lineupArray = array('match_id'=>$value1['match_id'],
                            'team'=>$team,
                            'starting_lineups'=>json_encode($value4['starting_lineups']),
                            'substitutes'=>json_encode($value4['substitutes']),
                            'coach'=>json_encode($value4['coach']),
                            'substitutions'=>json_encode($value4['substitutions']),
                            'updation_date'=>date("Y-m-d H:i:s")
                            );
       $CheckMatchIdForLineUp = btg_match_event_lineups::where('match_id',$value1['match_id'])->where('team',$team)->get()->toArray();
       if(empty($CheckMatchIdForLineUp))
       {
         $InsertLineUpQuery = btg_match_event_lineups::insert($lineupArray);
       }else{
        $UpdateLineUpQuery = btg_match_event_lineups::where('match_id',$value1['match_id'])->where('team',$team)->where('starting_lineups',json_encode($value4['starting_lineups']))->update($lineupArray);
       }
     }
    }
  }
  
  public function RenderViewPage()
  {
    return view('testing');
  }
  /**
   * DisplayCountry name from btg_country table
  */
  public function DisplayCountry()
  {
    $CountryList = btg_countries::select('*')->get();
  }
  /**
   * DisplayLeague name from btg_league table
  */
  public function DisplayLeague(Request $request)
  {
    //$DisplayLeagueByCountry = btg_countries::select('country_id','country_name','')->leftJoin('btg_leagues', 'btg_leagues.country_id', '=', 'btg_countries.posted_user_id')->where('posted_user_id',$user_id)->get()->toArray();
    //$GetCountryId =  240; //$request->input('countryId');
    $LeagueList = btg_leagues::select('*')->get();
    aa($LeagueList);
  }

  public function DisplayEvents(Request $request)
  {
    $GetCountryId =  240; //$request->input('countryId');
    $GetLeagueId = 650; //$request->input('league_id');
    $EventList = btg_events::where('country_id',$GetCountryId)->where('league_id',$GetLeagueId)->get();
    aa($EventList);
  }

}
?>
