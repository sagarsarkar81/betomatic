<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BetfairModels\btg_single_bet_conditions;
use App\Models\BetfairModels\btg_accumulator_bet_conditions;
use Session;

class BetPlacingController extends Controller
{
    function PrepareBettingData($data, $details)
    {
        $BetPlaceData = array('betslip_id'=>$data['UniqueId'],
                                'user_id'=>Session::get('user_id'),
                                //'league_id'=>$CheckOddsValue[0]['league_id'],
                                'match_id'=>$data['MatchId'],
                                'sports_type'=>'soccer',
                                //'match_half'=>'Full time',
                                'Odds_type'=>$data['BetFor'],
                                'market'=>$details['BetType'],
                                'home_team'=>$details['homeTeam'],
                                'away_team'=>$details['awayTeam'],
                                'bet_odds'=>$details['OddsValue'],
                                //'bookmaker'=>$CheckOddsValue[0]['odd_bookmakers'],
                                //'odds_extra_value'=>$ExtraValue,
                                //'match_time'=>$CheckOddsValue[0]['match_time']
                                );
        // $BetSlipData = $MatchId.'-'.$BetType.'-'.$BetFor;
                                
        // // if(Session::get('BetSlipExtraData'))
        // // {
        // //     $SlipData = Session::get('BetSlipExtraData');
        // //     array_push($SlipData,$BetSlipData);
        // //     $SessionBetSlipExtraData = Session::put('BetSlipExtraData', $SlipData);Session::save();
        // // }else{
        // //     $SlipData = array();
        // //     array_push($SlipData,$BetSlipData);
        // //     $SessionBetSlipData = Session::put('BetSlipExtraData', $SlipData);Session::save();
        // // }
        
        if(Session::get('BetSlip'))
        {
            $MatchData = Session::get('BetSlip');
            array_push($MatchData,$BetPlaceData);
            $SessionBetSlipData = Session::put('BetSlip', $MatchData);Session::save();
        }
        else{
            $MatchData = array();
            array_push($MatchData,$BetPlaceData);
            $SessionBetSlipData = Session::put('BetSlip', $MatchData);Session::save();
        }   
        
    }
    
    
    public function CheckOddsDetails(Request $request)
    {
        $data['UniqueId'] = $request->input('UniqueId');
        $data['MatchId'] = $request->input('MatchId');
        $data['BetFor'] = $request->input('BetFor');

        $details['OddsValue'] = $request->input('OddsValue');
        $details['homeTeam'] = $request->input('homeTeam');
        $details['awayTeam'] = $request->input('awayTeam');

        $details['BetType'] = $request->input('BetType');
        if($BetType == 'Full time')
        {
            $this->PrepareBettingData($data, $details);
        }else{
            $this->PrepareBettingData($data, $details);
        }
        
        return view('BetFairViews/betslip_body',$data,$details);
 
    }

    public function SingleBetInfo()
    {
        $GetSingleBetInfo = btg_single_bet_conditions::get()->toArray();
        return view('BetFairViews/SingleBetInfo',compact('GetSingleBetInfo'));
    }

    public function AccumulatorBetInfo()
    {
        $GetAccumulatorBetInfo = btg_accumulator_bet_conditions::get()->toArray();
        return view('BetFairViews/AccumulatorBetInfo',compact('GetAccumulatorBetInfo'));
    }

    public function InputStakeValue(Request $request)
    {
        $BetSlipId = $request->input('UniqueId');
        $Odds_type = $request->input('OddsType');
        $OddsValue = $request->input('OddsValue');
        $StakeAmount = $request->input('StakeAmount');
        $GetSessionSlipData = Session::get('BetSlip');
        foreach($GetSessionSlipData as $key=>$value)
        {
            if($GetSessionSlipData[$key]['betslip_id'] == $BetSlipId)
            {
                //$value['stake_amount'] = $StakeAmount;
                $GetSessionSlipData[$key]['stake_amount'] = $StakeAmount;
                Session::put('BetSlip', $GetSessionSlipData);session::save();
            }
        }

        //aa(Session::get('BetSlip'));
        //echo "<pre>";
        //print_r(Session::get('BetSlip'));
    }


    public function BetPlaceData(Request $request)
    {
        $GetSessionBetSlipData = Session::get('BetSlip');
        aa($GetSessionBetSlipData);
        $BetComments = $request->input('BetComments');
        $PrivacySettings = $request->input('PrivacySettings');
        foreach($GetSessionBetSlipData as $key=>$value)
        {
            /****deduct amount from user balance******/
            $GetBalance = btg_user_betting_accounts::select('amount')->where('user_id',Session::get('user_id'))->get()->toArray();
            $DeductBalance = ($GetBalance[0]['amount'] - $value['stake_amount']);
            $BalanceData = array('amount'=>$DeductBalance,'updation_date'=>date("Y-m-d H:i:s"));
            $UpdateBalanace = btg_user_betting_accounts::where('user_id',Session::get('user_id'))->update($BalanceData);

            /****deduct amount from user balance******/
            $TicketGenerate = rand(1000,10000);
            $BetId = 'BTG'.$TicketGenerate;
            $GetSessionBetSlipData[$key]['user_id'] = Session::get('user_id');
            $PaymentReturn = ($value['bet_odds'] * $value['stake_amount']);
            $GetSessionBetSlipData[$key]['total_return'] = number_format( $PaymentReturn, 2, '.', '' );
            $GetSessionBetSlipData[$key]['odds_extra_value'] = $value['odds_extra_value'];
            $GetSessionBetSlipData[$key]['status'] = 0;
            $GetSessionBetSlipData[$key]['bet_id'] = $BetId;
            $GetSessionBetSlipData[$key]['bet_text'] = $BetComments;
            $GetSessionBetSlipData[$key]['bet_type'] = 'Single';
            $GetSessionBetSlipData[$key]['bet_place_date'] = date("Y-m-d H:i:s");
            /****************Insert Data into News Feed Table**************************/
            $data = array('user_id'=>$GetSessionBetSlipData[$key]['user_id'],
                          'match_id'=>$GetSessionBetSlipData[$key]['match_id'],
                          'bet_id'=>$BetId,
                          'home_team'=>$GetSessionBetSlipData[$key]['home_team'],
                          'away_team'=>$GetSessionBetSlipData[$key]['away_team'],
                          'Odds_type'=>$GetSessionBetSlipData[$key]['Odds_type'],
                          'odds_value'=>$GetSessionBetSlipData[$key]['bet_odds'],
                          'stake_value'=>$GetSessionBetSlipData[$key]['stake_amount'],
                          'total_return'=>$GetSessionBetSlipData[$key]['total_return'],
                          'bet_type'=>$GetSessionBetSlipData[$key]['bet_type'],
                          'likes'=>0,
                          'status'=>1,
                          'copied_post_id'=>$GetSessionBetSlipData[$key]['copied_post_id'],
                          'match_betting_date'=>$GetSessionBetSlipData[$key]['match_time'],
                          'privacy_status'=>$PrivacySettings,
                          'bet_text'=>$BetComments,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date'=>date("Y-m-d H:i:s")
                          );
            $InsertNewsFeed = news_feeds::insert($data);
            /**************************************************************************/
            unset($GetSessionBetSlipData[$key]['copied_post_id']);
            Session::put('BetSlip', $GetSessionBetSlipData);
        }
        //aa($GetSessionBetSlipData);
        $InserBetPlaceHistory = bet_place_histories::insert($GetSessionBetSlipData);
        if($InserBetPlaceHistory == true)
        {
            Session::forget('BetSlip');
            echo "success";
        }
    }

    public function RemoveOddsFromSession(Request $request)
    {
        $BetSlipId = $request->input('BetSlipId');
        $GetSessionBetSlipData = Session::get('BetSlip');
        foreach($GetSessionBetSlipData as $key=>$value)
        {
            if($value['betslip_id'] == $BetSlipId)
            {
                unset($GetSessionBetSlipData[$key]);
                $PostId = $value['copied_post_id'];
                Session::put('BetSlip', $GetSessionBetSlipData);Session::save();
            }
        }
        aa(Session::get('BetSlip'));
        //echo $PostId;
        //echo "<pre>";
        //print_r($GetSessionBetSlipData);
    }
}

?>