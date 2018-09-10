<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\btg_events;
use App\btg_match_event_cards;
use App\btg_match_event_goalscorers;
use App\btg_match_event_lineups;
use App\btg_headtoheads;

class fetcheventdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:soccer-feed-for-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch event data from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       set_time_limit(0);
       $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
       $FromDate = date("Y-m-d");
       $date = strtotime($FromDate);
       $date = strtotime("+1day",$date);
       $ToDate = date("Y-m-d",$date);
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
         //$InsertEventQuery = btg_events::insert($EventData);
         $this->HeadToHeadTeamName($value1['match_hometeam_name'],$value1['match_awayteam_name'],$APIkey,$value1['match_id']);
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
           $CheckMatchIdForCard = btg_match_event_cards::where('match_id',$value1['match_id'])->where('time',$time)->where('home_fault',$value3['home_fault'])->where('card',$value3['card'])->where('away_fault',$value3['away_fault'])->get()->toArray();
           if(empty($CheckMatchIdForCard))
           {
             $InsertCardQuery = btg_match_event_cards::insert($MatchEventCardData);
           }else{
             $UpdateCardQuery = btg_match_event_cards::where('match_id',$value1['match_id'])->where('time',$time)->where('home_fault',$value3['home_fault'])->where('card',$value3['card'])->where('away_fault',$value3['away_fault'])->update($MatchEventCardData);
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
}
?>
