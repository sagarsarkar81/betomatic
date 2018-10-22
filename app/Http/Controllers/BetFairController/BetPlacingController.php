<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BetfairModels\btg_single_bet_conditions;
use App\Models\BetfairModels\btg_accumulator_bet_conditions;

class BetPlacingController extends Controller
{
    public function CheckOddsDetails(Request $request)
    {
        $data['UniqueId'] = $request->input('UniqueId');
        $data['MatchId'] = $request->input('MatchId');
        $data['BetFor'] = $request->input('BetFor');

        $details['OddsValue'] = $request->input('OddsValue');
        $details['homeTeam'] = $request->input('homeTeam');
        $details['awayTeam'] = $request->input('awayTeam');
        // $Bookmaker = $request->input('Bookmaker');
        // $MatchTime = $request->input('MatchTime');
        // $BetType = $request->input('BetType');
        // $Market = $request->input('Market');
        // $ExtraValue = $request->input('ExtraOdds');
        // if($BetType == 'Full time')
        // {
        //     $CheckOddsValue = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('btg_odds.match_id',$MatchId)->where('btg_odds.odd_bookmakers',$Bookmaker)->where('odds_name',$BetFor)->where('market','Full time')->get()->toArray();
        //     $BetOdds = $CheckOddsValue[0]['odds_value'];
        //     $this->PrepareBettingData($CheckOddsValue,$BetOdds,$MatchId,$UniqueId,$BetFor,$BetType,$ExtraValue);
        // }else{
        //     $CheckOddsValue = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('btg_odds.match_id',$MatchId)->where('btg_odds.odd_bookmakers',$Bookmaker)->where('market',$Market)->where('extra_value',$ExtraValue)->get()->toArray();
        //     $BetOdds = $CheckOddsValue[0]['odds_value'];
        //     $this->PrepareBettingData($CheckOddsValue,$BetOdds,$MatchId,$UniqueId,$BetFor,$BetType,$ExtraValue);
        // }
        return view('BetFairViews/betslip_body',$data,$details);
 
    }

    public function SingleBetInfo()
    {
        $GetSingleBetInfo = btg_single_bet_conditions::get()->toArray();
        //aa($GetSingleBetInfo);
        return view('BetFairViews/SingleBetInfo',compact('GetSingleBetInfo'));
    }

    public function AccumulatorBetInfo()
    {
        $GetAccumulatorBetInfo = btg_accumulator_bet_conditions::get()->toArray();
        return view('BetFairViews/AccumulatorBetInfo',compact('GetAccumulatorBetInfo'));
    }
}
