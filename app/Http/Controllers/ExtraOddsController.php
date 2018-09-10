<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\btg_odds;
use Session;
use DB;

class ExtraOddsController extends Controller
{
    public function GetExtraOdds()
    {
    	if(Session::get('user_id') == '')
	    {
	        return redirect(url('login'));
	    }else{
            return view('BettingSections/extra_odds');
	    }
    }
    
    public function CheckSessionForExtraOdds()
    {
        $GetSessionData = Session::get('BetSlip');
        return view('BettingSections/betslip_body_session_data',compact('GetSessionData'));
        //aa($GetSessionData);
    }
    
    public function CheckSessionForAccuBet()
    {
        $GetSessionData = Session::get('BetSlip');
        return view('BettingSections/betslip_body_session_accumulator',compact('GetSessionData'));
        //aa($GetSessionData);
    }
    
    public function GetDetailsAboutSingleBet()
    {
        $GetSessionData = Session::get('BetSlip');
        //aa($GetSessionData);
        if(!empty($GetSessionData))
        {
            foreach($GetSessionData as $SessionKey=>$SessionData)
            {
                $TotalStake += $SessionData['stake_amount'];
                $TotalPayout += ($SessionData['stake_amount'] * $SessionData['bet_odds']);
            }
            $data = array('Stake'=>$TotalStake,'Payout'=>$TotalPayout);
            //aa($data);
            header("Content-Type: application/json");
            echo json_encode($data);
        }
    }
    
    public function MoveToExtraOddPage($Match_id,$Bookmaker)
    {
		$GetDistinctBookmaker 	= 	btg_odds::where('match_id',$Match_id)->where('market','!=','Full time')->get();
    	//aa($GetDistinctBookmaker);
        $GetTopLeagueName = DB::select("SELECT * FROM `btg_top_leagues` LEFT JOIN `btg_leagues` ON btg_top_leagues.league_table_id = btg_leagues.id LIMIT 10");
        $GetTopLeagueList = json_decode(json_encode($GetTopLeagueName),true);
        $data	=	[];
    	if(count($GetDistinctBookmaker))
    	{
    		$bookmakers 			=	array_unique(array_pluck($GetDistinctBookmaker,'odd_bookmakers'));
    		$all_odds				=	[];
    		foreach ($GetDistinctBookmaker as $key => $odds) {
    			//check first bookmaker
    			if($odds->odd_bookmakers == $bookmakers[0]) {
    				$each_market	=	[];
    				$each_market['odds_name']	=	$odds->odds_name;
    				$each_market['odds_value']	=	$odds->odds_value;
    				$each_market['extra_value']	=	$odds->extra_value;
    				$all_odds[$odds->market][]	= $each_market;
    			}
    		}
	    	$data['bookmakers']	=	$bookmakers;
	    	$data['all_odds']	=	$all_odds;
	    	$data['match_info']	=	$GetDistinctBookmaker[0]->events_table;
            $data['GetTopLeagueList'] = $GetTopLeagueList;
    	}
        //aa($data);
    	return view('BettingSections/extra_odds',$data);
    }

    public function GetDataAccordingToBookmakerForExtraOdd(Request $request)
    {
        $BookmakerName = $request->input('BookmakerName');
        $Match_id = $request->input('MatchId');
        $GetDistinctBookmaker   =   btg_odds::where('match_id',$Match_id)->where('market','!=','Full time')->where('odd_bookmakers',$BookmakerName)->get();
        //$GetTopLeagueName = DB::select("SELECT * FROM `btg_top_leagues` LEFT JOIN `btg_leagues` ON btg_top_leagues.league_table_id = btg_leagues.id LIMIT 10");
        //$GetTopLeagueList = json_decode(json_encode($GetTopLeagueName),true);
        $data   =   [];
        if(count($GetDistinctBookmaker))
        {
            $bookmakers             =   $BookmakerName;
            $all_odds               =   [];
            foreach ($GetDistinctBookmaker as $key => $odds) {
                //check first bookmaker
                //if($odds->odd_bookmakers == $bookmakers[0]) {
                    $each_market    =   [];
                    $each_market['odds_name']   =   $odds->odds_name;
                    $each_market['odds_value']  =   $odds->odds_value;
                    $each_market['extra_value'] =   $odds->extra_value;
                    $all_odds[$odds->market][]  = $each_market;
                //}
            }
            $data['bookmakers'] =   $bookmakers;
            $data['all_odds']   =   $all_odds;
            $data['match_info'] =   $GetDistinctBookmaker[0]->events_table;
            $data['GetTopLeagueList'] = $GetTopLeagueList;
        } 
        //aa($data);
        return view('BettingSections/DataAccordingToBookmakerForExtraOdds',$data);
    }
}
?>