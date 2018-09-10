<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\btg_top_leagues;
use App\btg_events;
use App\btg_featured_matches;

class AdminSaveTopLeagueController extends Controller
{
    public function SaveTopLeague(Request $request)
    {
        $LeagueId = $request->input('TopLeagueId');
        $array = array();
        foreach($LeagueId as $key=>$value)
        {
          $data = array('league_table_id'=>$value,'updation_date'=>date("Y-m-d H:i:s"));
          $CheckLeagueId = btg_top_leagues::where('league_table_id',$value)->get()->toArray();
          if(empty($CheckLeagueId[0]))
          {
            $InsertQuery = btg_top_leagues::insert($data);
          }
        }
    }
    
    public function SaveFeaturedMatch(Request $request)
    {
        $EventId = $request->input('EventId');
        $GetEventDetails = btg_events::select('id','match_id','match_hometeam_name','match_awayteam_name','match_time')->where('id',$EventId[0])->get()->toArray();
        $CheckEventIdExist = btg_featured_matches::where('event_id',$EventId[0])->get()->toArray();
        $data = array('event_id'=>$EventId[0],
                      'match_id'=>$GetEventDetails[0]['match_id'],
                      'home_team'=>$GetEventDetails[0]['match_hometeam_name'],
                      'away_team'=>$GetEventDetails[0]['match_awayteam_name'],
                      'match_time'=>date("Y-m-d H:i:s",strtotime($GetEventDetails[0]['match_time'])),
                      'creation_date'=>date("Y-m-d H:i:s")
                     );
        if(empty($CheckEventIdExist))
        {
            $InsertQuery = btg_featured_matches::insert($data);
        }
        //aa($GetEventDetails); 
    }
}
?>